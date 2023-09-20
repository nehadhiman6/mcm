<?php

namespace App\Models\Examination;

use App\Student;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class PuMarks extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $connection = 'yearly_db';
    protected $table = 'pu_marks';
    protected $fillable = [
        'pu_exam_det_id',
        'std_id',
        'marks',
        'compartment',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }
}
