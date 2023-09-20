<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Carbon\Carbon;
use DB;

class FeeRcpt extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'fee_rcpts';
    protected $guarded = ['id'];
    //  protected $fillable = ['fee_bill_id','concession_id','fee_type' ,'adm_no', 'rcpt_date', 'pay_type', 'pay_mode', 'chqno', 'details'];
    protected $connection = 'yearly_db';

    public function setRcptDateAttribute($date)
    {
        $this->attributes['rcpt_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getRcptDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function feeBill()
    {
        return $this->belongsTo(FeeBill::class, 'fee_bill_id', 'id');
    }

    public function feeRcptDets()
    {
        return $this->hasMany(FeeRcptDet::class, 'fee_rcpt_id', 'id');
    }

    public function concession()
    {
        return $this->belongsTo(Concession::class, 'concession_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }

    public function outsider()
    {
        return $this->belongsTo(Outsider::class, 'outsider_id', 'id');
    }

    public function billRcptDets()
    {
        return $this->hasMany(FeeRcptDet::class, 'fee_rcpt_id', 'id')
            ->select('feehead_id', DB::raw('sum(amount) as amount'))
            ->groupBy('feehead_id');
    }

    public function online_trn()
    {
        return $this->hasOne(Payment::class, 'fee_rcpt_id', 'id');
    }

    public function isEditable()
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }
        if (Carbon::today()->diffInDays(Carbon::createFromFormat('d-m-Y', $this->rcpt_date)->setTime(0, 0, 0)) == 0) {
            return true;
        } else {
            return false;
        }
    }
}
