<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class ElectiveGroup extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    
    protected $table = 'elective_group';
    protected $fillable = ['ele_id', 'course_id','s_no','group_name','type'];
    protected $connection = 'yearly_db';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function elective()
    {
        return $this->belongsTo(Elective::class, 'ele_id');
    }
    
    public function details()
    {
        return $this->hasMany(ElectiveGroupDetail::class, 'ele_group_id', 'id');
    }
}
