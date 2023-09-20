<?php

namespace App\Models\StudentRefund;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Student;
use Carbon\Carbon;
use App\Models\StudentRefund\StudentRefund;

class StudentRefundRequset extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'student_refund_requests';
    protected $connection = 'yearly_db';
    protected $fillable =['std_id','request_date','fund_type','bank_name','ifsc_code','bank_ac_no','account_holder_name','amount','reason_of_refund','approval','approval_remarks','approved_by','approval_date','fee_deposite_date'];

    public function setRequestDateAttribute($date)
    {
        $this->attributes['request_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getRequestDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function setApprovalDateAttribute($date)
    {
        $this->attributes['approval_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getApprovalDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function setFeeDepositeDateAttribute($date)
    {
        $this->attributes['fee_deposite_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getFeeDepositeDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }

    public function student_refund()
    {
        return $this->belongsTo(StudentRefund::class, 'id', 'std_ref_req_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(\App\User::class, 'approved_by', 'id');
    }

}
