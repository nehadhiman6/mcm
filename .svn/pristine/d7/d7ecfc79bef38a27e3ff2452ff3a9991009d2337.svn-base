<?php

namespace App\Models\Hostel;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class HostelAttendence extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'hostel_attendence';
    protected $connection = 'yearly_db';
    protected $fillable = ['attendance_date',  'course_id' ,   'roll_no',    'status'];

}

