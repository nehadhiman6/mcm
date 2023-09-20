<?php

namespace App\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Location;
use App\Traits;
use App\Staff;

class Issue extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'issues';
    protected $fillable = ['loc_id', 'person', 'issue_dt','remarks', 'request_no','store_id','staff_id'];
    protected $connection = 'mysql';

    public function setIssueDtAttribute($date)
    {
        $this->attributes['issue_dt'] = setDateAttribute($date);
    }

    public function getIssueDtAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'loc_id', 'id');
    }

    public function storelocation()
    {
        return $this->belongsTo(Location::class, 'store_id', 'id');
    }

    public function issue_dets()
    {
        return $this->hasMany(IssueDet::class, 'issue_id', 'id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }
}
