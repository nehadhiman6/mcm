<?php

namespace App\Inventory;

use App\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Department;

class Reqest extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'requests';
    protected $fillable = ['department_id', 'person', 'trans_dt','remarks'];
    protected $connection = 'mysql';

    public function setTransDtAttribute($date)
    {
        $this->attributes['trans_dt'] = setDateAttribute($date);
    }

    public function getTransDtAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function departement()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function reqst_dets()
    {
        return $this->hasMany(RequestDet::class, 'request_id', 'id');
    }
}
