<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'faculty';
    protected $fillable = ['faculty'];
}
