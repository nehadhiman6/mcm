<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Department;
use App\Models\Activity\AgencyType;


class Orgnization extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'orgnization';
    protected $connection = 'mysql';
    protected $fillable =['name','external_agency','agency_type_id','dept_id'];


    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }

    public function agency()
    {
        return $this->belongsTo(AgencyType::class, 'agency_type_id', 'id');
    }
}
