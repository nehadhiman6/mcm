<?php

namespace App\Models\Placement;

use App\Staff;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Models\Placement\Company;
use App\Models\Resource\Resource;

class Placement extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'placements';
    protected $connection = 'yearly_db';
    protected $fillable =['drive_date','type','nature','comp_id','hr_personnel','contact_no','email','staff_id','job_profile','stu_reg','stu_appear','min_salary','max_salary','round_no'];
    
    
    public function setDriveDateAttribute($date)
    {
        $this->attributes['drive_date'] = setDateAttribute($date); 
    }

    public function getDriveDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function placement_students()
    {
        return $this->hasMany(PlacementStudent::class, 'placement_id', 'id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'comp_id');
    }

    public function resources()
    {
        return $this->belongsTo(Resource::class, 'id','resourceable_id')->where('resourceable_type', Placement::class);
    }

    
}
