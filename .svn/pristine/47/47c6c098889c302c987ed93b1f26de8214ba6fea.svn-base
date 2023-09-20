<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Location;

class Damage extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'damages';
    protected $fillable = ['trans_dt', 'remarks','store_id'];
    protected $connection = 'mysql';

    public function setTransDtAttribute($date)
    {
        $this->attributes['trans_dt'] = setDateAttribute($date);
    }

    public function getTransDtAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function damage_dets()
    {
        return $this->hasMany(DamageDet::class, 'damage_id', 'id');
    }

    public function storelocations()
    {
        return $this->belongsTo(Location::class, 'store_id', 'id');
    }
}
