<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentMarks extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'marks';
    protected $fillable = ['exam_det_id','std_id','sub_sec_id','marks','status','mail_send'];
    protected $connection = 'yearly_db';

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }

    public function examdetail()
    {
        return $this->belongsTo(ExamDetails::class, 'exam_det_id', 'id');
    }

    public function subPapersMarks()
    {
        return $this->hasMany(MarksSubjectSub::class, 'marks_id', 'id');
    }

    public function subject_section() {
        return $this->belongsTo(SubjectSection::class, 'sub_sec_id', 'id');
    }

    
}
