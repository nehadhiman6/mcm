<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;

class HostelOutsiderRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    if (!$this->ajax()) {
      return [];
    }
    $rules = [
        'student_det.institute' => 'required|in:1,2|integer',
        'student_det.std_type_id' => 'required|numeric|min:1',
        'student_det.name' => 'required',
        'student_det.father_name' => 'required',
        'student_det.course_name' => 'required',
        'student_det.roll_no' => 'required|unique:' . getYearlyDbConn() . '.outsiders,roll_no,' . $this->input('student_det.id') . ',id,institute,' . $this->input('institute', 0),
    ];

    if (!$this->input('fee_str'))
      return $rules;

    $rules['formdata.receipt_date'] = 'required|date_format:d-m-Y|after:' . yesterday() . '|before:' . tomorrow();
    foreach ($this->fee_str as $fee_head => $subheads) {
      foreach ($subheads as $key => $sh) {
        if ($sh['optional'] == 'N' || ($sh['optional'] == 'Y' && $sh['charge'] == 'Y')) {
          if (floatval($sh['amount']) < (floatval($sh['concession']) + floatval($sh['amt_rec']))) {
            if (floatval($sh['concession']) > 0)
              $rules += ["fee_str.$fee_head.$key.concession" => 'max:' . (floatval($sh['amount']) - floatval($sh['amt_rec']))];
            if (floatval($sh['amt_rec']) > 0)
              $rules += ["fee_str.$fee_head.$key.amt_rec" => 'max:' . (floatval($sh['amount']) - floatval($sh['concession']))];
          }
        }
      }
    }
    $amt_recv = 0;
    foreach ($this->fee_str as $fees) {
      foreach ($fees as $fee) {
        $amt_recv += $fee['amt_rec'];
        if ($fee['amt_rec'] > $fee['amount'])
          $rules['amtrec'] = 'sometimes|numeric|max:' . $ins['amount'];
      }
    }
    return $rules;
  }

  public function messages() {
    $messages = [
        'formdata.receipt_date.required' => 'Receipt date is missing, please enter Receipt date!',
        'fee_str.amt_rec.required' => 'Receiving Amount Should not be Zero.',
        //  'formdata.pay_type.required' => 'Payment mode should not left empty'
    ];
    return $messages;
  }

  public function save() {
    $bill_amt = 0;
    $amt_rec = 0;
    $fee_amt = 0;
    $concession = 0;
    $index_no = 1;
    $feebilldets = new \Illuminate\Database\Eloquent\Collection();
    $feerecdets = new \Illuminate\Database\Eloquent\Collection();
    foreach ($this['fee_str'] as $feestr) {
      foreach ($feestr as $det) {
        $feebilldet = new \App\FeeBillDet();
        $feebilldet->fill(['feehead_id' => $det['feehead_id'], 'subhead_id' => $det['subhead_id'], 'amount' => $det['amount'],
            'concession' => $det['concession'], 'index_no' => $index_no]);
        $feebilldets->add($feebilldet);
        if ($det['optional'] == 'N' || $det['charge'] == 'Y') {
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

    $this->student = new \App\Outsider();
    $this->student->fill($this->input('student_det'));
    $this->student->adm_date = $this['formdata']['receipt_date'];
    $feebill = new \App\FeeBill();
    $feebill->fill(['std_type_id' => $this['formdata']['std_type_id'],
        'bill_date' => $this['formdata']['receipt_date'],
        'install_id' => floatval($this['formdata']['installment_id']),
        'concession_id' => $this['formdata']['concession_id'],
        'fee_type' => 'Admission_Hostel_Outsider', 'fund_type'=>'H','fee_amt' => $fee_amt, 'bill_amt' => $bill_amt, 'amt_rec' => $amt_rec, 'concession' => $concession, 'remarks' => $this['formdata']['remarks']
    ]);

    DB::beginTransaction();
    DB::connection(getYearlyDbConn())->beginTransaction();
    $this->student->save();
    $feebill->outsider_id = $this->student->id;
    $feebill->std_type_id = $this->student->std_type_id;
    if ($amt_rec > 0) {
      $feercpt = new \App\FeeRcpt();
      $feercpt->fill([
          'rcpt_date' => $this['formdata']['receipt_date'],
          // 'chqno' => trim($this['formdata']['chqno']),
          'concession_id' => $this['formdata']['concession_id'],
          'fee_type' => 'Admission_Hostel_Outsider', 'fund_type'=>'H','details' => $this['formdata']['remarks'], 'amount' => $amt_rec
      ]);
      $feercpt->outsider_id = $this->student->id;

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
    }
    DB::connection(getYearlyDbConn())->commit();
    DB::commit();

    $this->response = [
        'fee_bill_id' => $feebill->id,
        'fee_rec_id' => $feercpt->id
    ];
  }

  public function redirect() {
    if ($this->ajax()) {
      if (!$this->errors) {
        $this->response['success'] = "Outsider admitted Successfully";
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
