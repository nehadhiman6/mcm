<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Department;
use App\Location;
use App\Staff;

class InvReturn extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'returns';
    protected $fillable = ['trans_dt','loc_id', 'remarks','store_id','staff_id'];
    protected $connection = 'mysql';

    public function setTransDtAttribute($date)
    {
        $this->attributes['trans_dt'] = setDateAttribute($date);
    }

    public function getTransDtAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function ret_dets()
    {
        return $this->hasMany(InvReturnDet::class, 'ret_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'loc_id', 'id');
    }

    public function storelocation()
    {
        return $this->belongsTo(Location::class, 'store_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
