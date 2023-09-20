<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Elective extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    
    protected $table = 'electives';
    protected $fillable = ['course_id', 'name'];
    protected $connection = 'yearly_db';

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function electiveSubjects()
    {
        return $this->hasMany(ElectiveSubject::class, 'ele_id', 'id');
    }
    public function groups()
    {
        return $this->hasMany(ElectiveGroup::class, 'ele_id', 'id');
    }
}
