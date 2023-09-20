<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;
use App\Traits;


class TemporaryStaff extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'temporary_staff';
    protected $fillable = [
        'staff_id',
        'desig_id',
        'mcm_joining_date',
        'left_date',
        'left_status',
        'remarks'
    ];

    public function setMcmJoiningDateAttribute($date)
    {
        $this->attributes['mcm_joining_date'] = setDateAttribute($date); 
    }

    public function getMcmJoiningDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setLeftDateAttribute($date)
    {
        $this->attributes['left_date'] = setDateAttribute($date); 
    }

    public function getLeftDateAttribute($date)
    {
        return getDateAttribute($date);
    }
}
