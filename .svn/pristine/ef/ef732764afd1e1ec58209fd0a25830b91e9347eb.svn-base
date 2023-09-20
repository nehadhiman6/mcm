<?php

namespace App\Models\Placement;

use App\Category;
use App\Course;
use App\Models\Resource\Resource;
use App\Student;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class PlacementStudent extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'placement_students';
    protected $connection = 'yearly_db';
    protected $fillable =['placement_id','std_id','email','job_profile','remarks','status','pay_package','letter_type',
                            'session','roll_no','name','father_name','mother_name','course_id','cat_id','phone'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'std_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }

    public function resource()
    {
        return $this->hasMany(Resource::class, 'resourceable_id','id')->where('resourceable_type', PlacementStudent::class);
    }
}
