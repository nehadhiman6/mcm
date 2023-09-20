<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class AdmissionRequest extends FormRequest
{
    protected $data = [];
    protected $admform = null;
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
        $this->admform = \App\AdmissionForm::whereId($this['formdata']['form_no'])->first();
        // dd($this->admform->status);
        if ($this->admform->std_id > 0 && $this->admform->status == 'A') {
            $rules['admitted'] = 'required';
            return $rules;
        }
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
            //        'formdata.bill_date' => 'required|date_format:d-m-Y|after:' . yesterday(),
            ''
        ];
        $amt_recv = 0;
        foreach ($this->fee_str as $fees) {
            foreach ($fees as $fee) {
                $amt_recv += $fee['amt_rec'];
                //        if ($fee['amt_rec'] == 0) {
                //          $rules['amtrec'] = 'required';
                //        }
                if ($fee['amt_rec'] > $fee['amount']) {
                    $rules['amtrec'] = 'sometimes|numeric|max:' . $ins['amount'];
                }
            }
        }
        //    if ($amt_recv > 0) {
        //      $rules['formdata.pay_type'] = 'required';
        //    }
        //     if ($amt_recv == 0) {
        //      $rules['amt_rec'] = 'required';
        //    }
        //    $rules += ['not_done' => 'required'];
        return $rules;
    }

    public function messages()
    {
        $this->admform = \App\AdmissionForm::whereId($this['formdata']['form_no'])->first();
        if ($this->admform->std_id > 0 && $this->admform->status == 'A') {
            $messages['admitted.required'] = 'This Student is already admitted!!';
            return $messages;
        }
        $messages = [
            'formdata.receipt_date.required' => 'Receipt date is missing, please fill Receipt date!',
            'fee_str.amt_rec.required' => 'Receiving Amount Should not be Zero.',
            //  'formdata.pay_type.required' => 'Payment mode should not left empty'
        ];
        return $messages;
    }

    public function save()
    {

        //      course_id, std_type_id, bill_date, install_id, concession_id, adm_no, fee_type, fee_amt, fine, fine_remarks, due_date, remarks
        //      id, fee_bill_id, feehead_id, subhead_id, amount, concession, created_by, updated_by, created_at, updated_at
        //      id, fee_bill_id, concession_id, fee_type, adm_no, rcpt_date, pay_type, pay_mode, chqno, details, created_by, updated_by, created_at, updated_at
        //      id, fee_rcpt_id, feehead_id, subhead_id, amount, concession, created_by, updated_by, created_at, updated_at

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
        //  dd($this['formdata']['form_no']);
        $this->admform = \App\AdmissionForm::whereId($this['formdata']['form_no'])->first();
        if (floatval($this->admform->std_id) == 0) {
            $this->student = new \App\Student();
            $this->student->fill($this->admform->attributesToArray());
            //  $this->student->adm_no = next_admno();
            $this->student->admission_id = $this->admform->id;
            $this->student->std_type_id = $this['formdata']['std_type_id'];
            $this->student->roll_no = $this->admform->lastyr_rollno;
            $this->student->religion = trim($this->admform->religion);
        } else {
            $this->std_id = $this->admform->std_id;
            $this->student = \App\Student::find($this->admform->std_id);
            $this->student->fill($this->admform->attributesToArray());
            $this->student->adm_cancelled = 'N';
        }
        $this->student->adm_date = $this['formdata']['receipt_date'];
        $this->student->adm_source = 'offline';
        $this->student->loc_cat = $this->admform->loc_cat ? $this->admform->loc_cat : 'General';
        try {
            DB::beginTransaction();
            DB::connection(getYearlyDbConn())->beginTransaction();
            $this->student->save();
            $this->admform->status = 'A';
            $this->admform->std_id = $this->student->id;
            //      dd($this->admform->admSubs);
            $old_sub_ids = $this->student->stdSubs->pluck('id')->toArray();
            $std_subs = new \Illuminate\Database\Eloquent\Collection();
            foreach ($this->admform->admSubs as $subs) {
                $arr = ['subject_id' => $subs->subject_id, 'sub_group_id' => $subs->sub_group_id, 'student_id' => $this->student->id];
                $subject = \App\StudentSubs::firstOrNew($arr, $arr);
                //        dd($subject);
                //        $subject->student_id = $this->student->id;
                //        $subject->subject_id = $subs['subject_id'];
                //        $subject->sub_group_id = $subs['sub_group_id'];
                $subject->save();
                $std_subs->add($subject);
            }
            if (count($old_sub_ids) > 0) {
                $new_sub_ids = $std_subs->pluck('id')->toArray();
                $to_be_removed = array_diff($old_sub_ids, $new_sub_ids);
                $this->student->stdSubs()->whereIn('id', $to_be_removed)->delete();
            }
            //      dd($to_be_removed);
            $feebill = new \App\FeeBill();
            $feebill->fill([
                'course_id' => $this['student_det']['course_id'], 'std_type_id' => $this['formdata']['std_type_id'],
                'bill_date' => $this['formdata']['receipt_date'],
                'install_id' => floatval($this['formdata']['installment_id']),
                'concession_id' => $this['formdata']['concession_id'],
                'fee_type' => 'Admission', 'fund_type' => 'C', 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt, 'amt_rec' => $amt_rec, 'concession' => $concession, 'remarks' => $this['formdata']['remarks']
            ]);
            $feebill->std_id = $this->student->id;
            if ($amt_rec > 0) {
                $feercpt = new \App\FeeRcpt();
                $feercpt->fill([
                    'rcpt_date' => $this['formdata']['receipt_date'],
                    // 'chqno' => trim($this['formdata']['chqno']),
                    'concession_id' => $this['formdata']['concession_id'],
                    'fee_type' => 'Admission', 'fund_type' => 'C', 'details' => $this['formdata']['remarks'], 'amount' => $amt_rec
                ]);
                $feercpt->std_id = $this->student->id;
            }
            $feebill->save();
            $feebill->feeBillDets()->saveMany($feebilldets);
            if ($amt_rec != 0) {
                $feercpt->fee_bill_id = $feebill->id;
                $feercpt->save();
                //$feerecdets->fee_bill_dets_id = $feebilldet->id;
                $feercpt->feeRcptDets()->saveMany($feerecdets);
                DB::connection(getYearlyDbConn())->table('fee_rcpt_dets')
                    ->join('fee_bill_dets', 'fee_rcpt_dets.index_no', '=', 'fee_bill_dets.index_no')
                    ->where('fee_bill_dets.fee_bill_id', '=', $feebill->id)
                    ->where('fee_rcpt_dets.fee_rcpt_id', '=', $feercpt->id)
                    ->update(['fee_rcpt_dets.fee_bill_dets_id' => DB::raw('fee_bill_dets.id')]);
            }

            $this->admform->save();
            DB::connection(getYearlyDbConn())->commit();
            DB::commit();

            $this->response = [
                'fee_bill_id' => $feebill->id,
                'fee_rec_id' => $amt_rec > 0 ? $feercpt->id : 0
            ];
        } catch (\Exception $ex) {
            //      dd($ex);
            $this->errors = new \Illuminate\Support\MessageBag();
            $this->errors->add('rollno', $ex->getMessage());
        }
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

//      id, fee_bill_id, concession_id, fee_type, adm_no, rcpt_date, pay_type, pay_mode, chqno, details, created_by, updated_by, created_at, updated_at
