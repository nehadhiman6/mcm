<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class CourseSubject extends Model
{
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    //
    protected $table = 'course_subject';
    protected $fillable = ['course_id', 'subject_id','semester', 'sub_type','uni_code','practical','honours','honours_sub_id'];
    protected $connection = 'yearly_db';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    
    public function mainSubject()
    {
        return $this->belongsTo(CourseSubject::class, 'honours_sub_id', 'id');
    }
}
