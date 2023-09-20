<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Course;
use App\State;

class PreRegistration extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'pre_registration';
    protected $connection = 'yearly_db';
    protected $fillable =['name','father_name','course_id','mobile_no','add','email','city','state_id','hostel'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}
