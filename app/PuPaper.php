<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuPaper extends Model
{
    protected $table = "pu_papers";
    protected $connection = 'yearly_db';

    public $timestamps = false;
    protected $primaryKey = "college_roll";
}
