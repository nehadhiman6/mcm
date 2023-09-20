<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelUtilities;

class NoGenerator extends Model {

  use ModelUtilities;

  protected $table = 'no_generator';
  protected $fillable = ['idname', 'no', 'prefix'];

}
