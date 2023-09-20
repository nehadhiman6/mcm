<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Models\Activity\Orgnization;

class ActivityCollaboration extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'activity_collaboration';
    protected $connection = 'mysql';
    protected $fillable =['act_id','colloboration_with_id','agency_id','agency_name'];

    public function orgnization()
    {
        return $this->belongsTo(Orgnization::class, 'agency_id', 'id');
    }

    public function collo_organization()
    {
        return $this->belongsTo(AgencyType::class, 'colloboration_with_id', 'id');
    }

    

}
