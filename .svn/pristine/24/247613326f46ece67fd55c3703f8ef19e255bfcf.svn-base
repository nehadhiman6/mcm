<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class InvReturnDet extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'return_dets';
    protected $fillable = ['item_id', 'qty','item_desc','damage_id'];
    protected $connection = 'mysql';

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
