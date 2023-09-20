<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class BechelorDegreeDetails extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

//
      protected $table = 'bechelor_degree_details';
      protected $fillable = ['admission_id', 'bechelor_degree','subjects', 'marks_obtained','total_marks','percentage','honour_subject','honour_marks','honour_total_marks','honour_percentage',
                            'elective_subject','ele_obtained_marks','ele_total_marks','ele_percentage','pg_sem1_subject','pg_sem1_obtained_marks','pg_sem1_total_marks',
                            'pg_sem1_percentage','pg_sem2_subject','pg_sem2_obtained_marks','pg_sem2_total_marks','pg_sem2_result','pg_sem2_percentage'
                            ];
      protected $connection = 'yearly_db';

      public function student() {
          return $this->belongsTo('App\AdmissionForm', 'admission_id', 'id');
      }
}
