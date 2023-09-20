<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Carbon\Carbon;
use DB;

class FeeBill extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'fee_bills';
    //  protected $fillable = ['course_id', 'std_type_id', 'bill_date', 'install_id', 'concession_id', 'adm_no', 'fee_type', 'fee_amt',
    //    'fine', 'fine_remarks', 'due_date', 'remarks'];
    protected $guarded = ['id'];
    protected $connection = 'yearly_db';

    public function setBillDateAttribute($date)
    {
        $this->attributes['bill_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getBillDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function setDueDateAttribute($date)
    {
        $this->attributes['due_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getDueDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function feeRcpt()
    {
        return $this->hasOne(FeeRcpt::class, 'fee_bill_id', 'id');
    }

    public function feeBillDets()
    {
        return $this->hasMany(FeeBillDet::class, 'fee_bill_id', 'id');
    }

    public function concession()
    {
        return $this->belongsTo(Concession::class, 'concession_id', 'id');
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class, 'install_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function stdType()
    {
        return $this->belongsTo(StudentType::class, 'std_type_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }

    public function outsider()
    {
        return $this->belongsTo(Outsider::class, 'outsider_id', 'id');
    }

    public function admform()
    {
        return $this->hasOne(AdmissionForm::class, 'std_id', 'std_id');
    }

    public function amt_paid()
    {
        return $this->hasOne(FeeBillDet::class, 'fee_bill_id', 'id')
            ->join('fee_rcpt_dets', 'fee_bill_dets.id', '=', 'fee_rcpt_dets.fee_bill_dets_id')
            ->select(['fee_bill_dets.fee_bill_id', DB::raw('sum(fee_rcpt_dets.amount - fee_rcpt_dets.concession) as amt_paid')])
            ->groupBy('fee_bill_dets.fee_bill_id');
    }

    public function scopeNormal($q)
    {
        return $q->where('cancelled', '=', 'N');
    }

    public function getPeriod()
    {
        $mthdata = $this->feeBillDets()->select(DB::raw("monthname(min(due_date)) as mthfr,monthname(max(date_add(due_date,interval months-1 month))) as mthto,year(min(due_date)) as yr"))->where("months", "<>", 12)->first();
        return $mthdata->mthfr . '-' . $mthdata->mthto . ' ' . $mthdata->yr;
    }

    public function balReceiptsCount()
    {
        if ($this->bill_amt - $this->amt_rec == 0) {
            return 0;
        }
        return $this->balReceipts()->count();
    }

    public function balReceipts()
    {
        $rcpt_id = $this->feeRcpt ? intval($this->feeRcpt->id) : 0;
        return static::join('fee_bill_dets', 'fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
            ->join('fee_rcpt_dets', function ($q) use ($rcpt_id) {
                $q->on('fee_bill_dets.id', '=', 'fee_rcpt_dets.fee_bill_dets_id')
                    ->where('fee_rcpt_dets.fee_rcpt_id', '!=', $rcpt_id);
            })
            ->where('fee_bills.id', '=', $this->id)
            ->select('fee_rcpt_dets.*')
            ->get();
    }

    public function isLastBill()
    {
        return static::whereStdId($this->std_id)->where('id', '>', $this->id)->count() == 0;
    }

    public function isCancellable()
    {
        $msg = '';
        if ($msg == '' && $this->balReceiptsCount() > 0) {
            $msg .= "There are receivings against this bill so it can\'t be cancelled!!";
        }
        //    if ($msg == '' && !$this->isLastBill()) {
        //      $msg .= "More bills are generated for the student so this bill can\'t be cancelled!!";
        //    }
        return $msg;
    }
}
