<?php

namespace App;
use Carbon\Carbon;
use App\Traits;

use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'attendance_daily';
    protected $fillable = ['attendance_date', 'course_id', 'subject_id','teacher_id',
    'sub_sec_id','sub_subject_sec_id','period_no','remarks'];
    protected $connection = 'yearly_db';


    public function attendance_details (){
        return $this->hasMany(DailyAttendanceDetail::class,'daily_attendance_id','id');
    }

    public function subject (){
        return $this->belongsTo(Subject::class,'subject_id','id');
    }
}
