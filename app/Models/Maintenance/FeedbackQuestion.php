<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Models\Online\StudentFeedback;

class FeedbackQuestion extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'feedback_questions';
    protected $connection = 'yearly_db';
    protected $fillable = ['question', 'sno', 'section_id'];

    public function feedback_section()
    {
        return $this->hasOne(FeedbackSection::class, 'id', 'section_id');
    }

    public function student_feedback()
    {
        return $this->hasMany(StudentFeedback::class, 'question_id', 'id');
    }
}
