<?php

namespace App\Models\SeatingPlan;
use App\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExamLocation\ExamLocation;
use App\Models\DateSheet\DateSheet;
use App\SubjectSection;
use Carbon\Carbon;

class SeatingPlan extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'seating_plans';
    protected $connection = 'yearly_db';
    protected $fillable = [
        'date_sheet_id',
        'date',
        'session',
        'exam_loc_id',
        'sub_sec_id',
        'total_seats',
        'occupied_seats',
        'gap_seats',
    ];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = setDateAttribute($date);
    }

    public function getDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function seating_plan_details(){
        return $this->hasMany(SeatingPlanDetail::class,'seating_plan_id','id');
    }

    public function seating_plan_staff(){
        return $this->hasMany(SeatingPlanStaff::class,'seating_plan_id','id');
    }

    public function exam_location(){
        return $this->belongsTo(ExamLocation::class,'exam_loc_id');
    }

    public function date_sheet(){
        return $this->belongsTo(DateSheet::class,'exam_loc_id');
        
    }
    public function subject_section(){
        return $this->belongsTo(SubjectSection::class,'sub_sec_id');
    }
}
