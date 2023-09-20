<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumniMeetStudent extends Model
{
    protected $table = 'alumni_meet_students';
    protected $fillable = ['alumni_stu_id','meet_id','attending_meet'];
    protected $connection = 'mysql';

    public function meet()
    {
        return $this->belongsTo(AlumniMeet::class, 'meet_id', 'id');
    }

    public function almstudent()
    {
        return $this->belongsTo(AlumniStudent::class, 'alumni_stu_id', 'id');
    }
}
