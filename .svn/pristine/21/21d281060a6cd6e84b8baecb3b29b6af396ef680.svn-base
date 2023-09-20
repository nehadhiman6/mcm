<?php

namespace App\Models\Examination;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class PuExamStudent extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $connection = 'yearly_db';
    protected $table = 'pu_exam_students';
    protected $fillable = [
        'pu_exam_id',
        'std_id',
        'uni_agregate',
        'remarks',
        'fail',
    ];
}
