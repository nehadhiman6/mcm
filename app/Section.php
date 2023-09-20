<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'sections';
    protected $fillable = ['section'];
    protected $connection = 'yearly_db';
}
