<?php

namespace App;
use App\Traits;


use Illuminate\Database\Eloquent\Model;

class DailyAttendanceDetail extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'attendance_daily_dets';
    protected $fillable = ['daily_attendance_id', 'std_id', 'attendance_status','remarks'];
    protected $connection = 'yearly_db';
 

    public function student(){
        return $this->belongsTo(Student::class,'std_id','id');
    }
}
