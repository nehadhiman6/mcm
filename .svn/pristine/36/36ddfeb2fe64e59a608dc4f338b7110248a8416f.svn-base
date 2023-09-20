<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class SubjectGroup extends Model {

   use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  //
  protected $table = 'subject_group';
  protected $fillable = ['s_no', 'group_name', 'type'];
  protected $connection = 'yearly_db';

  public function course() {
    return $this->belongsTo('App\Course', 'course_id', 'id');
  }

  public function subjects() {
    return $this->hasMany(SubjectGrpDetail::class, 'sub_group_id', 'id');
  }

}
