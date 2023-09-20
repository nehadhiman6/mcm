<?php

namespace App\Http\Requests;

use App\Jobs\SendSms;
use App\Mail\SendMail;
use App\StudentUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HostelRequest extends FormRequest
{
    protected $data = [];
    protected $response = [];
    protected $student = null;
    protected $errors = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        //    dd($this->all());
        $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        //    if ($this->admform->std_id > 0 || $this->admform->status == 'A') {
        //      $rules['admitted'] = 'required';
        //      return $rules;
        //    }
        if ($this->fee_bill_id == 0) {
            $rules['formdata.receipt_date'] = 'required|date_format:d-m-Y|after:' . yesterday() . '|before:' . tomorrow();
        } else {
            $rules['formdata.receipt_date'] = 'required|date_format:d-m-Y';
        }
        foreach ($this->fee_str as $fee_head => $subheads) {
            foreach ($subheads as $key => $sh) {
                if ($sh['optional'] == 'N' || ($sh['optional'] == 'Y' && $sh['charge'] == 'Y')) {
                    if (floatval($sh['amount']) < (floatval($sh['concession']) + floatval($sh['amt_rec']))) {
                        if (floatval($sh['concession']) > 0) {
                            $rules += ["fee_str.$fee_head.$key.concession" => 'max:' . (floatval($sh['amount']) - floatval($sh['amt_rec']))];
                        }
                        if (floatval($sh['amt_rec']) > 0) {
                            $rules += ["fee_str.$fee_head.$key.amt_rec" => 'max:' . (floatval($sh['amount']) - floatval($sh['concession']))];
                        }
                    }
                }
            }
        }
        $rules += [
      'student_det.id' => 'required|unique:' . getYearlyDbConn() . '.fee_bills,std_id,null,id,fee_type,Admission_Hostel,cancelled,N'
      //        'formdata.bill_date' => 'required|date_format:d-m-Y|after:' . yesterday(),
    ];
        $amt_recv = 0;
        foreach ($this->fee_str as $fees) {
            foreach ($fees as $fee) {
                $amt_recv += $fee['amt_rec'];
                if ($fee['amt_rec'] > $fee['amount']) {
                    $rules['amtrec'] = 'sometimes|numeric|max:' . $ins['amount'];
                }
            }
        }
        return $rules;
    }

    public function messages()
    {
        $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        //    if ($this->admform->std_id > 0 || $this->admform->status == 'A') {
        //      $messages['admitted.required'] = 'This Student is already admitted!!';
        //      return $messages;
        //    }
        $messages = [
      'formdata.receipt_date.required' => 'Receipt date is missing, please fill Receipt date!',
      'fee_str.amt_rec.required' => 'Receiving Amount Should not be Zero.',
      'student_det.id.unique' => 'Student has been admitted already!!',
      //  'formdata.pay_type.required' => 'Payment mode should not left empty'
    ];
        return $messages;
    }

    public function save()
    {
        //    dd($this->all());
        $bill_amt = 0;
        $amt_rec = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $feebilldets = new \Illuminate\Database\Eloquent\Collection();
        $feerecdets = new \Illuminate\Database\Eloquent\Collection();
        foreach ($this['fee_str'] as $feestr) {
            foreach ($feestr as $det) {
                if ($det['optional'] == 'N' || $det['charge'] == 'Y') {
                    $feebilldet = new \App\FeeBillDet();
                    $feebilldet->fill([
                      'feehead_id' => $det['feehead_id'], 'subhead_id' => $det['subhead_id'], 'amount' => $det['amount'],
                      'concession' => $det['concession'], 'index_no' => $index_no
                    ]);
                    $feebilldets->add($feebilldet);
                    $fee_amt += floatval($det['amount']);
                    $concession += floatval($det['concession']);
                    $amt_rec += floatval($det['amt_rec']);
                    if ($det['amt_rec'] > 0) {
                        $feerecdet = new \App\FeeRcptDet();
                        $feerecdet->fill(['feehead_id' => $det['feehead_id'], 'subhead_id' => $det['subhead_id'], 'amount' => $det['amt_rec'], 'index_no' => $index_no]);
                        $feerecdets->add($feerecdet);
                    }
                }
                $index_no++;
            }
        }
        $bill_amt += $fee_amt - $concession;
        $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        
        DB::beginTransaction();
        DB::connection(getYearlyDbConn())->beginTransaction();
        $feebill = new \App\FeeBill();
        $feebill->fill([
          'course_id' => $this['student_det']['course_id'], 'std_type_id' => $this['formdata']['std_type_id'],
          'bill_date' => $this['formdata']['receipt_date'],
          'install_id' => floatval($this['formdata']['installment_id']),
          'concession_id' => $this['formdata']['concession_id'],
          'fee_type' => 'Admission_Hostel', 'fund_type' => 'H', 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt, 'amt_rec' => $amt_rec, 'concession' => $concession, 'remarks' => $this['formdata']['remarks']
        ]);
        $feebill->std_id = $this->student->id;
        $feebill->std_type_id = $this->student->std_type_id;
        if ($amt_rec > 0) {
            $feercpt = new \App\FeeRcpt();
            $feercpt->fill([
              'rcpt_date' => $this['formdata']['receipt_date'],
              // 'chqno' => trim($this['formdata']['chqno']),
              'concession_id' => $this['formdata']['concession_id'],
              'fee_type' => 'Admission_Hostel', 'fund_type' => 'H', 'details' => $this['formdata']['remarks'], 'amount' => $amt_rec
            ]);
            $feercpt->std_id = $this->student->id;
        }

        $feebill->save();
        $feebill->feeBillDets()->saveMany($feebilldets);
        if ($amt_rec != 0) {
            $feercpt->fee_bill_id = $feebill->id;
            $feercpt->save();
            $feercpt->feeRcptDets()->saveMany($feerecdets);
            DB::connection(getYearlyDbConn())->table('fee_rcpt_dets')
              ->join('fee_bill_dets', 'fee_rcpt_dets.index_no', '=', 'fee_bill_dets.index_no')
              ->where('fee_bill_dets.fee_bill_id', '=', $feebill->id)
              ->where('fee_rcpt_dets.fee_rcpt_id', '=', $feercpt->id)
              ->update(['fee_rcpt_dets.fee_bill_dets_id' => DB::raw('fee_bill_dets.id')]);
        }

        $std_user= StudentUser::find($this->student->std_user_id);
        $subj = 'Hostel Approved';
        // $msg = "Dear student, we have allotted you Hostel you applied for. Your Online Form No is ".$this->student->admission_id .". Pay your Hostel Fee using " .'"Pay Hostel Dues "'. "into the Students' Portal on https://admissions.mcmdav.com/stulogin within 24 hours for further processing -MCMDAVCW";
        $mail_msg = "Dear Applicant
        Your hostel seat has been approved. To confirm the seat, please pay the hostel fee by logging in to https://admissions.mcmdav.com/stulogin and clicking the option 'Pay Hostel dues' in the left pane and click the 'Show' button to proceed.";
        // After paying the hostel fee, students can join the hostel from 22 August 2022 onwards from 9:30 am to 4:30 pm.";
        
        $sms_msg = "Dear Applicant, kindly pay your Hostel Admission Fee online till 12:00 noon " . tomorrow() ."by opening the url https://admissions.mcmdav.com/stulogin using your login credentials and then clicking Pay Hostel Dues option on the dashboard- MCMDAVCHD";
        $template_id = '1207166106393243185';
        dispatch(new SendSms($sms_msg, $std_user->mobile, $template_id));
        Mail::to($std_user->email)->send(new SendMail($subj,$mail_msg));
        DB::connection(getYearlyDbConn())->commit();
        DB::commit();

        $this->response = [
      'fee_bill_id' => $feebill->id,
      'fee_rec_id' => $amt_rec > 0 ? $feercpt->id : 0
    ];
    }

    public function redirect()
    {
        if ($this->ajax()) {
            if (!$this->errors) {
                $this->response['success'] = "Student admitted Successfully";
                return response()
          ->json($this->response, 200, ['app-status' => 'success']);
            } else {
                $this->response['error'] = "There was an error";
                return response()
          ->json($this->errors, 422, ['app-status' => 'error']);
            }
        }
    }
}
