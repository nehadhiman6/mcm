<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class BoardUniv extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'boards';
  protected $fillable = ['board', 'name', 'migration'];
  protected $connection = 'mysql';

}
