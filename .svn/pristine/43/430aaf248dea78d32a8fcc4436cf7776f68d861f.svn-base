<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class StaffCourse extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'staff_courses';
    protected $fillable = [
        'staff_id',
        'courses',
        'topic',
        'begin_date',
        'end_date',
        'university_id',
        'other_university',
        'other_course',
        'level',
        'duration_days',
        'org_by',
        'sponsored_by',
        'other_sponsor',
        'collaboration_with',
        'aegis_of',
        'participate_as',
        'affi_inst',
        'mode',
        'certificate',
        'remarks',
      
    ];

    public function setBeginDateAttribute($date)
    {
        $this->attributes['begin_date'] = setDateAttribute($date); 
    }

    public function getBeginDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setEndDateAttribute($date)
    {
        $this->attributes['end_date'] = setDateAttribute($date); 
    }

    public function getEndDateAttribute($date)
    {
        return getDateAttribute($date);
    }
}
