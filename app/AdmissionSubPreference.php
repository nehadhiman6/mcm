<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class AdmissionSubPreference extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'admission_sub_prefs';
    protected $fillable = ['sub_group_id', 'preference_no', 'ele_group_id', 'subject_id'];
    protected $connection = 'yearly_db';

    public function student()
    {
        return $this->belongsTo(AdmissionForm::class, 'admission_id', 'id');
    }

    public function subjectGroup()
    {
        return $this->belongsTo(SubjectGroup::class, 'sub_group_id', 'id');
    }

    public function electiveGroup()
    {
        return $this->belongsTo(ElectiveGroup::class, 'ele_group_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function course_subject()
    {
        return $this->hasOne(CourseSubject::class, 'subject_id', 'subject_id');
    }
}
