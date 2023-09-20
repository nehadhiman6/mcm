<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class SubjectSection extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

//
    protected $table = 'subject_sections';
    protected $fillable = ['course_id', 'subject_id', 'section_id', 'teacher_id','students','scheme','has_sub_subjects'];
    protected $connection = 'yearly_db';

    public function subSecStudents()
    {
        return $this->hasMany(SubSectionStudent::class, 'sub_sec_id', 'id');
    }

    public function sub_sec_details()
    {
        return $this->hasMany(SubSectionDetail::class, 'sub_sec_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id', 'id');
    }

    public function marks(){
        return $this->hasMany(StudentMarks::class, 'sub_sec_id', 'id');
    }
}
