<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Illuminate\Support\Facades\DB;

class Designation extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'desigs';
    protected $fillable = ['name'];
}
