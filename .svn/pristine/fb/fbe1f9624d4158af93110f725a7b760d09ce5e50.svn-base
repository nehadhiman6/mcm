<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Illuminate\Support\Facades\DB;

class Installment extends Model {

   use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    protected $table = 'installments';
    protected $fillable = ['name', 'head_type','inst_type'];
    protected $connection = 'yearly_db';

}
