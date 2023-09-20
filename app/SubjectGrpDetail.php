<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class SubjectGrpDetail extends Model
{
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    //
    protected $table = 'subject_group_det';
    protected $fillable = ['sub_group_id', 'subject_id', 'course_sub_id'];
    protected $connection = 'yearly_db';

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function subjectGroup()
    {
        return $this->belongsTo(SubjectGroup::class, 'sub_group_id', 'id');
    }
}
