<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class AddOnCourse extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'addon_courses';
    protected $fillable = ['course_name', 'short_name'];
    protected $connection = 'yearly_db';
}

    //
 

  //
      