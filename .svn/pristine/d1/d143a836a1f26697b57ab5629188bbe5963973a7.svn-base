<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Concession extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'concessions';
  protected $fillable = ['name'];
  protected $connection = 'yearly_db';

}
