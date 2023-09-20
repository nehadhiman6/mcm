<?php

namespace App\Models\Examination;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class PuExamMasterDetail extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $connection = 'yearly_db';
    protected $table = 'pu_exam_dets';
    protected $fillable = [
        'pu_exam_id',
        'subject_id',
        'min_marks',
        'max_marks'
    ];
}
