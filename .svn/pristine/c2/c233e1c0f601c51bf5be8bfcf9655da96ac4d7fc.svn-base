<?php

namespace App\Models\StudentRefund;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Student;
use Carbon\Carbon;

class StudentRefund extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'student_refunds';
    protected $connection = 'yearly_db';
    protected $fillable =['std_id','std_ref_req_id','release_date','release_remarks','release_amt','released_by'];

    public function setReleaseDateAttribute($date)
    {
        $this->attributes['release_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getRequestDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function released_by()
    {
        return $this->belongsTo(\App\User::class, 'released_by', 'id');
    }
}
