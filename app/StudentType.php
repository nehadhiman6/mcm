<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class StudentType extends Model {

  //
 use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'student_types';
  protected $fillable = ['name'];
  protected $connection = 'yearly_db';

}
