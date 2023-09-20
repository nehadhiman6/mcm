<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'attendance_det';
    protected $fillable = ['attendance_id','std_id','attended'];
    protected $connection = 'yearly_db';
}
