<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelUtilities;

class AdmissionEntry extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'admission_entries';
    protected $fillable = [
        'admission_id', 'std_type_id', 'valid_till', 'dhe_form_no', 'manual_formno', 'centralized', 'adm_rec_no', 'rcpt_date', 'amount',
        'addon_course_id', 'honour_sub_id'
    ];
    protected $connection = 'yearly_db';

    public function setRcptDateAttribute($date)
    {
        $this->attributes['rcpt_date'] = setDateAttribute($date);
    }

    public function getRcptDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setValidTillAttribute($date)
    {
        $this->attributes['valid_till'] = setDateAttribute($date);
    }

    public function getValidTillAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function admForm()
    {
        return $this->belongsTo(AdmissionForm::class, 'admission_id', 'id');
    }

    public function stdType()
    {
        return $this->belongsTo(StudentType::class, 'std_type_id', 'id');
    }

    public function honour_sub()
    {
        return $this->belongsTo(Subject::class, 'honour_sub_id', 'id');
    }

    public function add_on_course()
    {
        return $this->belongsTo(AddOnCourse::class, 'addon_course_id', 'id');
    }

    public function getCreatedAtAttribute($date)
    {
        return getDateAttribute($date);
    }
}
