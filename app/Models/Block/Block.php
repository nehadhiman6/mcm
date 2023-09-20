<?php

namespace App\Models\Block;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $connection = 'mysql';
    protected $table = 'blocks';
    protected $fillable = ['name'];
}
