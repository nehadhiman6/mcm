<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class RemovedStudent extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'removed_students';
  protected $fillable = ['std_id', 'remarks'];
  protected $connection = 'yearly_db';

  public function student() {
    return $this->belongsTo(RemovedStudent::class, 'std_id', 'id');
  }

}
