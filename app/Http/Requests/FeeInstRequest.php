<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;


class FeeInstRequest extends FormRequest
{
  protected $data = [];
  protected $response = [];
  protected $student = null;
  protected $errors = null;

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
    $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
    $feebill = \App\FeeBill::whereStdId($this->student->id)
      ->whereInstallId($this['formdata']['installment_id'])
      ->whereCancelled('N')
      ->first();
    if ($feebill)
      $rules['inst'] = "required";

    if ($this->fee_bill_id == 0) {
      $rules['formdata.receipt_date'] = 'required|date_format:d-m-Y|after:' . yesterday() . '|before:' . tomorrow();
    } else {
      $rules['formdata.receipt_date'] = 'required|date_format:d-m-Y';
    }
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
        if ($fee['amt_rec'] > $fee['amount'])
          $rules['amtrec'] = 'sometimes|numeric|max:' . $ins['amount'];
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
    return [
      'inst.required' => 'Installment Already Received!'
    ];
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
    try {
      DB::beginTransaction();
      DB::connection(getYearlyDbConn())->beginTransaction();
      //      dd($this->admform->admSubs);
      //      dd($to_be_removed);
      $feebill = new \App\FeeBill();
      $feebill->fill([
        'course_id' => $this['student_det']['course_id'], 'std_type_id' => $this->student->std_type_id,
        'bill_date' => $this['formdata']['receipt_date'],
        'install_id' => floatval($this['formdata']['installment_id']),
        'concession_id' => $this['formdata']['concession_id'],
        'fee_type' => 'College-Installment', 'fund_type' => $this->fund, 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt, 'amt_rec' => $amt_rec, 'concession' => $concession, 'remarks' => $this['formdata']['remarks']
      ]);
      $feebill->std_id = $this->student->id;
      $feebill->save();
      $feebill->feeBillDets()->saveMany($feebilldets);
      $this->response['fee_bill_id'] = $feebill->id;

      if ($amt_rec > 0) {
        $feercpt = new \App\FeeRcpt();
        $feercpt->fill([
          'rcpt_date' => $this['formdata']['receipt_date'],
          // 'chqno' => trim($this['formdata']['chqno']),
          'concession_id' => $this['formdata']['concession_id'],
          'fee_type' => 'College-Installment', 'fund_type' => $this->fund, 'details' => $this['formdata']['remarks'], 'amount' => $amt_rec
        ]);
        $feercpt->std_id = $this->student->id;

        $feercpt->fee_bill_id = $feebill->id;
        $feercpt->save();
        //$feerecdets->fee_bill_dets_id = $feebilldet->id;
        $feercpt->feeRcptDets()->saveMany($feerecdets);
        DB::connection(getYearlyDbConn())->table('fee_rcpt_dets')
          ->join('fee_bill_dets', 'fee_rcpt_dets.index_no', '=', 'fee_bill_dets.index_no')
          ->where('fee_bill_dets.fee_bill_id', '=', $feebill->id)
          ->where('fee_rcpt_dets.fee_rcpt_id', '=', $feercpt->id)
          ->update(['fee_rcpt_dets.fee_bill_dets_id' => DB::raw('fee_bill_dets.id')]);
        $this->response['fee_rec_id'] = $feercpt->id;
      }

      DB::connection(getYearlyDbConn())->commit();
      DB::commit();
    } catch (\Exception $ex) {
      //      dd($ex->getMessage());
      $this->errors = new \Illuminate\Support\MessageBag();
      $this->errors->add('rollno', $ex->getMessage());
    }
  }

  public function redirect()
  {
    if ($this->ajax()) {
      if (!$this->errors) {
        $this->response['success'] = "Installment Debited/Received Successfully";
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
