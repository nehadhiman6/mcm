<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Category extends Model {

  use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  //
  protected $table = 'categories';
  protected $fillable = ['name','s_no'];
  protected $connection = 'mysql';

}
