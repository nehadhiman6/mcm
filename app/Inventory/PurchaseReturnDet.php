<?php

namespace App\Inventory;

use App\Traits;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDet extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'pur_return_det';
    protected $fillable = ['item_id', 'qty','item_desc','pur_ret_id','rate'];
    protected $connection = 'mysql';

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
