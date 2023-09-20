<?php

namespace App\Models\Online;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Student;

class StudentFeedback extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'student_feedback';
    protected $connection = 'yearly_db';
    protected $fillable = ['std_id', 'under_section_id', 'section_id','question_id','rating'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }
}
