<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class ItemCategory extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'item_categories';
    protected $fillable = ['category'];
    protected $connection = 'mysql';
}
