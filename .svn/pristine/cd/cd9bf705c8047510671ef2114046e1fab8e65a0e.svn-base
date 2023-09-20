<?php

namespace App\Models\SeatingPlan;
use App\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExamLocation\ExamLocation;
use App\Models\DateSheet\DateSheet;
use Carbon\Carbon;
use App\Staff;


class SeatingPlanStaff extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'seating_plan_staff';
    protected $connection = 'yearly_db';
    protected $fillable = [
        'date_sheet_id',
        'date',
        'session',
        'exam_name',
        'staff_id',
        'exam_loc_id',
        'seating_plan_id'
    ];
    
    public function setDateAttribute($date)
    {
        $this->attributes['date'] = setDateAttribute($date);
    }

    public function getDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function staff(){
        return $this->belongsTo(Staff::class,'staff_id','id');
    }

    public function exam_location(){
        return $this->belongsTo(ExamLocation::class,'exam_loc_id','id');
    }

    public function date_sheet(){
        return $this->belongsTo(DateSheet::class,'date_sheet_id','id');
    }
}
