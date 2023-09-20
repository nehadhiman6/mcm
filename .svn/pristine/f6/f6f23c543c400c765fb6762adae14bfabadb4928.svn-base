<?php

namespace App\Models\Maintenance;

use Illuminate\Database\Eloquent\Model;
use App\Models\Online\StudentFeedback;

// use App\Traits;

class FeedbackSection extends Model
{
    // use Traits\ModelUtilities,
    // Traits\AutoUpdateUserColumns;

    protected $table = 'feedback_sections';
    protected $connection = 'yearly_db';
    protected $fillable = ['name', 'sno', 'under_section_id'];

    public function sub_sections()
    {
        return $this->hasMany(FeedbackSection::class, 'under_section_id', 'id')
            ->orderBy('sno');
    }

    public function feedback_section()
    {
        return $this->belongsTo(FeedbackSection::class, 'under_section_id', 'id');
    }

    public function feedback_under_section()
    {
        return $this->belongsToOne(FeedbackSection::class, 'under_section_id', 'id');
    }

    public function feedback_question()
    {
        return $this->hasMany(FeedbackQuestion::class, 'section_id', 'id')->orderBy('sno');
    }
}
