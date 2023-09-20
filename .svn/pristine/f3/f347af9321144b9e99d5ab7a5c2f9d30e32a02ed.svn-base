<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

    protected $table = 'departments';
    protected $fillable = ['name', 'faculty_id'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }
}
