<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class StudentSubs extends Model
{
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    protected $table = 'student_subs';
    protected $fillable = ['student_id', 'sub_group_id', 'ele_group_id', 'subject_id'];
    protected $connection = 'yearly_db';
    // protected $connection = "prv_year_db";
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function electiveGroup()
    {
        return $this->belongsTo(ElectiveGroup::class, 'ele_group_id', 'id');
    }

    public function subjectGroup()
    {
        return $this->belongsTo(SubjectGroup::class, 'sub_group_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
