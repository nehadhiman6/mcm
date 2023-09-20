<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ExamDetails;

class Exam extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'exams';
    protected $fillable = ['exam_name','semester','exam_type'];
    protected $connection = 'yearly_db';

    public function examDet()
    {
        return $this->hasOne(ExamDetails::class, 'exam_id', 'id');
    }
}
