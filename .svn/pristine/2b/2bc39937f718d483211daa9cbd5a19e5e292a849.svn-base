<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;
use App\Designation;
use App\Traits;

class StaffPromotion extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'staff_promotion';
    protected $fillable = [
        'staff_id',
        'promotion_date',
        'new_desig_id',
        'old_desig_id',
    ];

    public function old_desig()
    {
        return $this->belongsTo(Designation::class, 'old_desig_id', 'id');
    }

    public function new_desig()
    {
        return $this->belongsTo(Designation::class, 'new_desig_id', 'id');
    }

    public function setPromotionDateAttribute($date)
    {
        $this->attributes['promotion_date'] = setDateAttribute($date); 
    }

    public function getPromotionDateAttribute($date)
    {
        return getDateAttribute($date);
    }

}
