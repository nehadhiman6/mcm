<?php

namespace App\Models\RegionalCentre;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Course;

class RegionalCentre extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'regional_centres';
    protected $connection = 'yearly_db';
    protected $fillable =['stu_id','name','father_name','pupin_no','roll_no','app_no','course_id','semester','mobile_no','add','email','regional_centre','centre1','centre2'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

}
