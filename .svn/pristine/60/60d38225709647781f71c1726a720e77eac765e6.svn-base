<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class AdmissionHonourSubject extends Model
{
    use Traits\ModelUtilities,
      Traits\AutoUpdateUserColumns;
    
    protected $table = 'admission_honours_subs';
    protected $fillable = ['admission_id', 'subject_id', 'preference'];
    protected $connection = 'yearly_db';

    public function student()
    {
        return $this->belongsTo('App\AdmissionForm', 'admission_id', 'id');
    }
    
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }
}
