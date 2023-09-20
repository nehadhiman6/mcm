<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ReceiptRequest extends FormRequest
{
    protected $data = [];
    protected $student = null;
    protected $ret_data = [];

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
        //dd($this->all());
        $has_concession = false;
        if ($this->outsider == 'Y') {
            $this->student = \App\Outsider::whereAdmNo($this['formdata']['adm_no'])->first();
        } else {
            $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        }
        //dd($this->student);
        $rules = [];
        $recamt = 0;
        foreach ($this->pend_bal as $fee_head => $subheads) {
            foreach ($subheads as $key => $sh) {
                if (floatval($sh['concession']) > 0) {
                    $has_concession = true;
                    $rules += ["pend_bal.$fee_head.$key.concession" => 'numeric|max:' . (floatval($sh['amount']) - floatval($sh['amt_rec']))];
                }
                if (floatval($sh['amt_rec']) > 0) {
                    $rules += ["pend_bal.$fee_head.$key.amt_rec" => 'numeric|max:' . (floatval($sh['amount']) - floatval($sh['concession']))];
                }
                if (floatval($sh['amount']) < (floatval($sh['concession']) + floatval($sh['amt_rec']))) {
                }
                $recamt += floatval($sh['concession']) + floatval($sh['amt_rec']);
            }
        }
        if ($has_concession) {
            $rules['formdata.concession_id'] = 'required|integer|exists:'.getYearlyDbConn().'.concessions,id';
        }
        if ($recamt == 0) {
            $rules['recamt'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        if ($this->outsider == 'Y') {
            $this->student = \App\Outsider::whereAdmNo($this['formdata']['adm_no'])->first();
        } else {
            $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        }
        $messages = [
            'formdata.receipt_date.required' => 'Receipt date is missing, please fill Receipt date!',
            'pend_bal.amt_rec.required' => 'Receiving Amount Should not be Zero.',
            'recamt.required' => 'Amount cannot be 0',
        ];
        return $messages;
    }

    public function save($fund_type)
    {
        $fee_type = 'Receipt';
        if ($fund_type == 'H') {
            $fee_type = $this->outsider == 'Y' ? 'Receipt_Hostel_Outsider' : 'Receipt_Hostel';
        }
        $bill_amt = 0;
        $amt_rec = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $feerecdets = new \Illuminate\Database\Eloquent\Collection();
        foreach ($this['pend_bal'] as $balance) {
            foreach ($balance as $det) {
                $fee_amt += floatval($det['amount']);
                $concession += floatval($det['concession']);
                $amt_rec += floatval($det['amt_rec']);
                if (floatval($det['amt_rec']) + floatval($det['concession']) > 0) {
                    $feerecdet = new \App\FeeRcptDet();
                    $feerecdet->fill(['fee_bill_dets_id' => $det['id'], 'feehead_id' => $det['feehead_id'], 'subhead_id' => $det['subhead_id'], 'amount' => $det['amt_rec'],'concession' => $det['concession'], 'index_no' => $index_no]);
                    $feerecdets->add($feerecdet);
                }
                $index_no++;
            }
        }
        $bill_amt += $fee_amt - $concession;
        if ($this->outsider == 'Y') {
            $this->student = \App\Outsider::whereAdmNo($this['formdata']['adm_no'])->first();
        } else {
            $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        }
        if ($amt_rec+$concession > 0) {
            $feercpt = new \App\FeeRcpt();
            $feercpt->fill([
            'rcpt_date' => $this['formdata']['receipt_date'],
            'concession_id' => $this['formdata']['concession_id'],
            'fee_type' => $fee_type, 'fund_type' => $fund_type, 'details' => $this['formdata']['remarks'],
            'amount' => $amt_rec,'concession' => $concession]);
            if ($this->outsider == 'Y') {
                $feercpt->outsider_id = $this->student->id;
            } else {
                $feercpt->std_id = $this->student->id;
            }
            DB::beginTransaction();
            DB::connection(getYearlyDbConn())->beginTransaction();
            if ($amt_rec+$concession != 0) {
                $feercpt->save();
                $feercpt->feeRcptDets()->saveMany($feerecdets);
            }
            DB::connection(getYearlyDbConn())->commit();
            DB::commit();
            $this->ret_data = ['fee_rec_id' => $feercpt->id];
        }
    }

    public function redirect()
    {
        if ($this->ajax()) {
            $this->ret_data['success'] = "Success";
            return response()
                ->json($this->ret_data, 200, ['app-status' => 'success']);
        }
    }
}
