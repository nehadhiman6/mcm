<?php

namespace App\Models\StudentTimeTable;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Student;

class StudentTimeTable extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'students_timetable';
    protected $connection = 'yearly_db';
    protected $fillable = [
        'roll_no', 'std_id', 'subjects', 'honours', 'add_on', 'period_0', 'period_1', 'period_2', 'period_3', 'period_4', 'period_5', 'period_6', 'period_7', 'period_8', 'period_9', 'period_10', 'location'
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'id', 'std_id');
    }
}
