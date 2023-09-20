<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Location;
use App\Inventory\Item;
use App\Staff;

class StockLedger extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'stock_ledger';
    protected $fillable = ['trans_type', 'trans_id', 'trans_det_id', 'trans_date', 'item_id', 'loc_id', 'r_qty', 'i_qty', 'store_id','part','staff_id'];
    protected $connection = 'mysql';

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    public function setTransDateAttribute($date)
    {
        $this->attributes['trans_date'] = setDateAttribute($date);
    }

    public function getTransDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function storelocations()
    {
        return $this->belongsTo(Location::class, 'store_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
