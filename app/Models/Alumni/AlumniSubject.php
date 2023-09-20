<?php

namespace App\Models\Alumni;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class AlumniSubject extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'alumni_subjects';
    protected $fillable = [];
}
