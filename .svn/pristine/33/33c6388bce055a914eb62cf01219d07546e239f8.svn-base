<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Alumani extends Model
{
    //
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;

  //
        protected $table = 'alumani';
        protected $fillable = ['admission_id', 'name', 'passing_year','occupation','designation','contact','email','other'];
        protected $connection = 'yearly_db';

        public function student() {
            return $this->belongsTo('App\AdmissionForm', 'admission_id', 'id');
        }
}
