<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pupin extends Model
{
    protected $table = 'pupin';
    protected $guarded = ['rollno'];
    protected $connection = 'prv_year_db';

    protected $primaryKey = 'rollno';

    public function setDobAttribute($date)
    {
        $this->attributes['dob'] = setDateAttribute($date);
    }

    public function getDobAttribute($date)
    {
        $date = getDateAttribute($date);
        return $date;
    }
    
    public function setEnrollDateAttribute($date)
    {
        $this->attributes['enroll_date'] = setDateAttribute($date);
    }

    public function getEnrollDateAttribute($date)
    {
        $date = getDateAttribute($date);
        return $date;
    }

}
