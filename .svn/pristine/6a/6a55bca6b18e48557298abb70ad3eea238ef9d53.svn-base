<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'attendance';
    protected $fillable = ['sub_sec_id','month','year','teacher_id','lectures'];
    protected $connection = 'yearly_db';
}
