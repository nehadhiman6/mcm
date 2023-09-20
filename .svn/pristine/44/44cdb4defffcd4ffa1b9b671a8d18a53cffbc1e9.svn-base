<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Subject extends Model
{
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

    //
    protected $table = 'subjects';
    protected $fillable = ['subject', 'description','dept_id', 'practical', 'uni_code'];
    protected $connection = 'mysql';

    public function department() {
      return $this->belongsTo(Department::class, 'dept_id', 'id');
    }
}
