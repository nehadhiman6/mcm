<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DB;

class MiscInstRequest extends FormRequest
{
    protected $data = [];
    protected $student = null;
    protected $misc_charges = [];
    protected $receipts = [];
    protected $_resp = [];

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
//    dd($this->misc_fees);
        $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        $rules = [];

        //Misc charges
        $charges_amt = 0;
        $charges_recd = 0;
        foreach ($this->misc_fees as $key => $fees) {
            $amt = floatval($fees['amount']);
            $amt_rec = floatval($fees['amt_rec']);
            if ($amt > 0 || $amt_rec > 0) {
                $charges_amt += $amt;
                $charges_recd += $amt_rec;
                if ($amt < $amt_rec) {
                    if (floatval($fees['amt_rec']) > 0) {
                        $rules["misc_fees.$key.subhead_id"] = 'integer|exists:' . getYearlyDbConn() . '.sub_heads,id';
                        $rules["misc_fees.$key.amount"] = 'numeric';
                        $rules["misc_fees.$key.amt_rec"] = 'numeric|max:' . $amt;
                    }
                }
            }
        }
        if ($charges_amt == 0) {
            $rules['amt_charged'] = 'required|min:1';
        }

        //Prvious dues received
        foreach ($this->pend_bal as $fee_head => $subheads) {
            foreach ($subheads as $key => $sh) {
                $amt = floatval($sh['amount']);
                $amt_rec = floatval($sh['amt_rec']);
                if ($amt < $amt_rec) {
                    $rules["pend_bal.$fee_head.$key.amt_rec"] = 'numeric|max:' . $amt;
                }
            }
        }
        $amt_recv = 0;
        foreach ($this->pend_bal as $fees) {
            foreach ($fees as $fee) {
                $amt_recv += $fee['amt_rec'];
                if ($fee['amt_rec'] > $fee['amount']) {
                    $rules['amtrec'] = 'sometimes|numeric|max:' . $ins['amount'];
                }
            }
        }
//    dd($rules);
        return $rules;
    }

    public function messages()
    {
        $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        $messages = [
        'formdata.receipt_date.required' => 'Receipt date is missing, please fill Receipt date!',
        'pend_bal.amt_rec.required' => 'Receiving Amount Should not be Zero.',
    ];
        return $messages;
    }

    public function save($fund_type)
    {
        // dd($this->all());
        //dd($fund_type);
        $fee_type = 'Misc-Receipt';
        $bill_amt = 0;
        $amt_rec = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $feebilldets = new \Illuminate\Database\Eloquent\Collection();
        $feerecdets = new \Illuminate\Database\Eloquent\Collection();
        foreach ($this->misc_fees as $fees) {
            if ($fees['amount'] > 0) {
                $feebilldet = new \App\FeeBillDet();
                $feebilldet->fill(['feehead_id' => $fees['feehead_id'], 'subhead_id' => $fees['subhead_id'],
                  'amount' => $fees['amount'], 'concession' => 0, 'index_no' => $index_no]);
                $feebilldets->add($feebilldet);
                $fee_amt += floatval($fees['amount']);
                $amt_rec += floatval($fees['amt_rec']);
                if ($fees['amt_rec'] > 0) {
                    $feerecdet = new \App\FeeRcptDet();
                    $feerecdet->fill(['feehead_id' => $fees['feehead_id'], 'subhead_id' => $fees['subhead_id'],
                      'amount' => $fees['amt_rec'], 'concession' => 0, 'index_no' => $index_no]);
                    $feerecdets->add($feerecdet);
                }
                $index_no++;
            }
        }

        foreach ($this['pend_bal'] as $balance) {
            foreach ($balance as $det) {
                $concession += floatval($det['concession']);
                $amt_rec += floatval($det['amt_rec']);
                if ($det['amt_rec'] > 0) {
                    $feerecdet = new \App\FeeRcptDet();
                    $feerecdet->fill(['fee_bill_dets_id' => $det['id'], 'feehead_id' => $det['feehead_id'], 'subhead_id' => $det['subhead_id'], 'amount' => $det['amt_rec'], 'index_no' => $det['index_no']]);
                    $feerecdets->add($feerecdet);
                }
            }
        }

        $bill_amt += $fee_amt - $concession;
        $this->student = \App\Student::whereAdmNo($this['formdata']['adm_no'])->first();
        if ($fee_amt > 0) {
            $feebill = new \App\FeeBill();
            $feebill->fill(['course_id' => $this->student->course_id, 'std_type_id' => $this->student->std_type_id,
                'bill_date' => $this['formdata']['receipt_date'],
                'install_id' => 0,
                'concession_id' => 0,
                'fee_type' => $fee_type, 'fund_type' => $fund_type, 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt, 'amt_rec' => $amt_rec, 'concession' => $concession, 'remarks' => $this['formdata']['remarks']
            ]);
            $feebill->std_id = $this->student->id;
            if ($amt_rec != 0) {
                $feercpt = new \App\FeeRcpt();
                $feercpt->fill([
                    'rcpt_date' => $this['formdata']['receipt_date'],
                    'concession_id' => 0,
                    'fee_type' => $fee_type, 'fund_type' => $fund_type, 'details' => $this['formdata']['remarks'], 'amount' => $amt_rec
                ]);
            }
            $feercpt->std_id = $this->student->id;
            DB::beginTransaction();
            DB::connection(getYearlyDbConn())->beginTransaction();
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
                  ->whereRaw('ifnull(fee_rcpt_dets.fee_bill_dets_id, 0) = 0')
                  ->where('fee_rcpt_dets.fee_rcpt_id', '!=', 0)
                  ->update(['fee_rcpt_dets.fee_bill_dets_id' => DB::raw('fee_bill_dets.id')]);
            }
            DB::connection(getYearlyDbConn())->commit();
            DB::commit();

            $this->_resp = [
                'fee_rec_id' => $feercpt->id
            ];
        }
    }

    public function redirect()
    {
        if ($this->ajax()) {
            $this->_resp['success'] = "Success";
            return response()
              ->json($this->_resp, 200, ['app-status' => 'success']);
        }
    }
}
