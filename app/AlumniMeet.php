<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumniMeet extends Model
{
    protected $table = 'alumni_meet';
    protected $fillable = ['meet_date','meet_time','meet_venue','remarks'];
    protected $connection = 'mysql';

    public function setMeetDateAttribute($date)
    {
        $this->attributes['meet_date'] =  \Carbon\Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getMeetDateAttribute($date)
    {
        $date =  \Carbon\Carbon::parse($date)->format('d-m-Y');
        return $date;
    }
}
