<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamDetails extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'exam_details';
    protected $fillable = ['exam_id','course_id','subject_id', 'have_sub_papers','min_marks','max_marks','paper_code'];
    protected $connection = 'yearly_db';

    public function examSubs()
    {
        return $this->hasMany(ExamSubjectSub::class, 'exam_det_id', 'id');
    }

    public function marks(){
        return $this->hasMany(StudentMarks::class, 'exam_det_id', 'id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function exams(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
