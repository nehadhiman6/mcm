<?php

namespace App\Models\SubCombination;

use App\Course;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class SubjectCombination extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'sub_combination';
    protected $connection = 'yearly_db';
    protected $fillable =['course_id','combination','code'];

    public function details()
    {
        return $this->hasMany(SubjectCombinationDetail::class, 'sub_combination_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
