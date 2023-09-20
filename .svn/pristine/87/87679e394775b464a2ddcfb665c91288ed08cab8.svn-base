<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarksSubjectSub extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'marks_subject_sub';
    protected $fillable = ['marks_id','exam_sub_id','std_id','marks','status'];
    protected $connection = 'yearly_db';

    public function examdetail()
    {
        return $this->belongsTo(ExamSubjectSub::class, 'exam_sub_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }
}
