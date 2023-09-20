<?php

namespace App\Models\DateSheet;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits;
use App\Course;
use App\SubjectSection;
use App\Subject;

class DateSheet extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $connection = 'yearly_db';
    protected $table = 'date_sheets';
    protected $fillable = ['course_subject_id',
    'subject_id',
    'course_id',
    'date',
    'session',
    'exam_name'];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = setDateAttribute($date);
    }

    public function getDateAttribute($date)
    {
        return getDateAttribute($date);
    }


    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
