<?php

namespace App\Inventory;

use App\Traits;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'items';
    protected $fillable = ['item', 'it_cat_id','unit','it_sub_cat_id','item_code','remarks','consumable'];
    protected $connection = 'mysql';

    public function item_category()
    {
        return $this->belongsTo(ItemCategory::class, 'it_cat_id', 'id');
    }

    public function item_sub_category()
    {
        return $this->belongsTo(ItemSubCategory::class, 'it_sub_cat_id', 'id');
    }
}
