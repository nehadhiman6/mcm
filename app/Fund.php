<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelUtilities;

class Fund extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  protected $table = 'funds';
  protected $fillable = ['name', 'description'];
  protected $connection = 'yearly_db';

}
