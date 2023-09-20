<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class PurchaseDet extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'purchase_dets';
    protected $fillable = ['item_id', 'qty','item_desc','pur_id','rate'];
    protected $connection = 'mysql';

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
