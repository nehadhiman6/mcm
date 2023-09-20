<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class StaffQualification extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'staff_qualification';
    protected $fillable = [
        'staff_id',
        'exam',
        'other_exam',
        'institute_id',
        'other_institute',
        'year',
        'percentage',
        'division',
        'distinction',
        'pg_subject',
        'pr_cgpa'
    ];
}
