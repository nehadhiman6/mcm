<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Location;

class PurchaseReturn extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'pur_return';
    protected $fillable = ['bill_no', 'bill_dt', 'trans_dt','trans_id','vendor_id', 'total_amount','store_id'];
    protected $connection = 'mysql';
   
    public function setTransDtAttribute($date)
    {
        $this->attributes['trans_dt'] = setDateAttribute($date);
    }

    public function getTransDtAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setBillDtAttribute($date)
    {
        $this->attributes['bill_dt'] = setDateAttribute($date);
    }

    public function getBillDtAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function purchase_dets()
    {
        return $this->hasMany(PurchaseReturnDet::class, 'pur_ret_id', 'id');
    }

    public function storelocations()
    {
        return $this->belongsTo(Location::class, 'store_id', 'id');
    }
}
