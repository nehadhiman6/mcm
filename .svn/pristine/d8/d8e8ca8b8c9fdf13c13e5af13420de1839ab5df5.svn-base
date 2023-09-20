<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AlumniExperience extends Model
{
    protected $table = 'alumni_experience';
    protected $fillable = ['emp_type','alumni_stu_id','category','org_name','org_address','num_of_employees',
                            'start_date','end_date','currently_working','area_of_work','designation'
                        ];
    protected $connection = 'mysql';


    public function setStartDateAttribute($date)
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getStartDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }


    public function setEndDateAttribute($date)
    {
        if($date != null || $date != ''){
            $this->attributes['end_date'] = Carbon::createFromFormat('d-m-Y', $date);
        }
        else{
             $this->attributes['end_date'] =  null;
        }
    }

    public function getEndDateAttribute($date)
    {
        if($date != null){
            $date = Carbon::parse($date)->format('d-m-Y');
            return $date;
        }
    }
}
