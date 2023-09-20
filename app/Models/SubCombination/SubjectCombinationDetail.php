<?php

namespace App\Models\SubCombination;

use App\Subject;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class SubjectCombinationDetail extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'sub_combination_dets';
    protected $connection = 'yearly_db';
    protected $fillable =['sub_combination_id','subject_id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
