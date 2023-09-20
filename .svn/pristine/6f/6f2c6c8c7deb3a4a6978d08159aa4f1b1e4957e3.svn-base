<?php

namespace App\Models\Activity;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class ActivityGuest extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    protected $table = 'activity_guests';
    protected $connection = 'mysql';
    protected $fillable =['act_id','order_no','guest_name','guest_designation','guest_affiliation','address'];


}
