<?php

namespace App\Models\SeatingPlan;
use App\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Student;

class SeatingPlanDetail extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'seating_plan_dets';
    protected $connection = 'yearly_db';
    protected $fillable = [
        'seating_plan_id',
        'std_id',
        'seat_no',
        'row_no',
    ];

    public function student(){
        return $this->belongsTo(Student::class,'std_id');
    }

    public function seating_plan(){
        return $this->belongsTo(SeatingPlan::class,'seating_plan_id');
    }
}
