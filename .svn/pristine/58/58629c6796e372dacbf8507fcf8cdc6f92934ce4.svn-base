<?php

namespace App;
use App\Traits;

use Illuminate\Database\Eloquent\Model;

class AddmissionConsent extends Model
{
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;
    //

    protected $table = 'adm_consent';
    protected $fillable = [
        'admission_id',
        'preference_no',
        'honour_sub_id',
        'ask_student',
        'student_answer',
        'upgrade_later',
        'user_id',
    ];

    protected $connection = 'yearly_db';

    public function admission_form(){
        return $this->belongsTo(\App\AdmissionForm::class,'admission_id');
    }

    public function honour_assigned(){
        return $this->belongsTo(\App\AdmissionHonourSubject::class,'honour_sub_id','id');
    }

    public function subject_selected_preferences(){
        return $this->hasMany(\App\AdmissionSubs::class,'admission_id','admission_id');
    }

    public function user(){
        return $this->belongsTo(\App\User::class,'user_id','id');
    }
}
