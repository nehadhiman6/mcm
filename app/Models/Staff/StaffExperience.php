<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class StaffExperience extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'staff_experiences';
    protected $fillable = [
        'staff_id',
        'area_of_experience',
        'days',
        'months',
        'years',
    ];
}
