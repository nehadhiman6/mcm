<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class ElectiveSubject extends Model
{
    //
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    //
    protected $table = 'elective_subject';
    protected $fillable = ['course_id', 'ele_id', 'course_id','subject_id','course_sub_id','sub_type'];
    protected $connection = 'yearly_db';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    public function coursesubject()
    {
        return $this->belongsTo(CourseSubject::class, 'course_sub_id', 'id');
    }
    public function elective()
    {
        return $this->belongsTo(Elective::class, 'ele_id', 'id');
    }

}
