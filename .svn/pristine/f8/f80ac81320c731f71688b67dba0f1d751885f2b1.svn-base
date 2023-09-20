<?php

namespace App\Models\Discrepancy;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class AdmissionFormDiscrepancy extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;
    protected $table = 'admission_form_discrepancies';
    protected $fillable = ['admission_id', 'opt_name','opt_value', 'remarks',];
    protected $connection = 'yearly_db';

    public function adm_form()
    {
        return $this->belongsTo('App\AdmissionForm', 'admission_id', 'id');
    }
}
