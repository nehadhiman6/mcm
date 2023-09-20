<?php

namespace App\Models\Online;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Student;

class StudentFeedbackSuggestion extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'student_feedback_suggestion';
    protected $connection = 'yearly_db';
    protected $fillable = ['std_id', 'suggestion'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }
}
