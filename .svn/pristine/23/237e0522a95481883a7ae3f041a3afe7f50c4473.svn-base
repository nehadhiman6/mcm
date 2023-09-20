<?php

namespace App\Models\Examination;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Models\Examination\PuExamMasterDetail;
use App\Course;

class PuExamMaster extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $connection = 'yearly_db';
    protected $table = 'pu_exams';
    protected $fillable = [
        'course_id',
        'exam_name',
        'semester',
    ];

    public function pu_exam_dets(){
        return $this->hasMany(PuExamMasterDetail::class,'pu_exam_id','id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

}
