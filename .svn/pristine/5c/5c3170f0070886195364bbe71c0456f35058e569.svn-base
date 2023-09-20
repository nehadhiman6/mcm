<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Outsider extends Model
{
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    protected $table = 'outsiders';
    protected $fillable = ['institute', 'std_type_id', 'name', 'father_name', 'course_name', 'roll_no', 'mobile', 'email'];
    protected $connection = 'yearly_db';

    public function setAdmDateAttribute($date)
    {
        $this->attributes['adm_date'] = getDateFormat($this->adm_date, 'ymd');
    }

    public function getAdmDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function stdType()
    {
        return $this->belongsTo(StudentType::class, 'std_type_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
  
    public function saveAttributes()
    {
        $this->adm_no = next_outsider_no();
    }

    public function scopeExisting($q)
    {
        return $q->where('outsiders.adm_cancelled', '=', 'N');
    }


    public function getPendingFeeDetails($fund_type = 'H', $group = true, $last_fbid = 0)
    {
        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
          ->groupBy(DB::raw('1,2,3'))
          ->select('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id', 'fee_rcpt_dets.subhead_id', DB::raw('sum(fee_rcpt_dets.amount) as amt_rec'))
          ->where('fee_rcpts.cancelled', '=', 'N');
        $pend_bal = \App\FeeBillDet::join('fee_bills', 'fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
            ->leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), function ($q) {
                $q->on('receipts.fee_bill_dets_id', '=', 'fee_bill_dets.id')
              ->on('receipts.feehead_id', '=', 'fee_bill_dets.feehead_id')
              ->on('receipts.subhead_id', '=', 'fee_bill_dets.subhead_id');
            })->mergeBindings($fee_rcpt_dets->getQuery())
            ->where('fee_bills.fund_type', '=', $fund_type)
            ->where('fee_bills.outsider_id', '=', $this->id)
            ->where('fee_bills.cancelled', '=', 'N')
            ->whereRaw('fee_bill_dets.amount-ifnull(fee_bill_dets.concession,0)-ifnull(receipts.amt_rec,0) > 0')
            ->select('fee_bill_dets.id', 'fee_bill_dets.index_no', 'fee_bill_dets.feehead_id', 'fee_bill_dets.subhead_id', DB::raw('fee_bill_dets.amount-ifnull(fee_bill_dets.concession,0)-ifnull(receipts.amt_rec,0) as amount'), DB::raw('0 as concession'), DB::raw('fee_bill_dets.amount-ifnull(fee_bill_dets.concession,0)-ifnull(receipts.amt_rec,0) as amt_rec'))
        ;
        if ($last_fbid > 0) {
            $pend_bal = $pend_bal->where('fee_bills.id', '<=', $last_fbid);
        }
        $pend_bal = $pend_bal->get();

        if ($group) {
            $pend_bal = $pend_bal->groupBy(function ($item, $key) {
                return $item['subhead']['feehead']['name'];
            });
        }

        return $pend_bal;
    }

    public function receivePayment($fund_type = 'H', $last_fbid = 0)
    {
        $fee_type = 'Receipt';
        if ($fund_type == 'H') {
            $fee_type = 'Receipt_Hostel_Outsider';
        }
        $bill_amt = 0;
        $amt_rec = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $pend_bal = $this->getPendingFeeDetails($fund_type, false, $last_fbid);
        $feerecdets = new \Illuminate\Database\Eloquent\Collection();
        foreach ($pend_bal as $det) {
            $fee_amt += floatval($det['amount']);
            $concession += floatval($det['concession']);
            $amt_rec += floatval($det['amt_rec']);
            if ($det['amt_rec'] > 0) {
                $feerecdet = new \App\FeeRcptDet();
                $feerecdet->fill(['fee_bill_dets_id' => $det['id'], 'feehead_id' => $det['feehead_id'], 'subhead_id' => $det['subhead_id'], 'amount' => $det['amt_rec'], 'index_no' => $index_no]);
                $feerecdets->add($feerecdet);
            }
            $index_no++;
        }
        $bill_amt += $fee_amt - $concession;
        if ($amt_rec > 0) {
            $feercpt = new \App\FeeRcpt();
            $feercpt->fill([
                    'rcpt_date' => today(),
                    'concession_id' => 0, 'outsider_id' => $this->id,
                    'fee_type' => $fee_type, 'fund_type' => $fund_type, 'details' => 'Online', 'amount' => $amt_rec
                ]);
            DB::beginTransaction();
            DB::connection(getYearlyDbConn())->beginTransaction();
            if ($amt_rec != 0) {
                $feercpt->save();
                $feercpt->feeRcptDets()->saveMany($feerecdets);
            }
            DB::connection(getYearlyDbConn())->commit();
            DB::commit();
        }
        return $feercpt->id;
    }
}
