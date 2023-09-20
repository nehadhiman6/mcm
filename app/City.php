<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class City extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'cities';
  protected $fillable = ['city', 'state_id'];

  public function state() {
    return $this->belongsTo('App\State', 'state_id', 'id');
  }

}
