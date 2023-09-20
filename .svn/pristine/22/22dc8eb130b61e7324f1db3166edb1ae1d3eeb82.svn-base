<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class ElectiveGroupDetail extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'elective_group_det';
    protected $fillable = ['ele_group_id', 'subject_id','course_sub_id'];
    protected $connection = 'yearly_db';

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
    
    public function coursesubject()
    {
        return $this->belongsTo(CourseSubject::class, 'course_sub_id', 'id');
    }
}
