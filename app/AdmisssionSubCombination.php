<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubCombination\SubjectCombination;

class AdmisssionSubCombination extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'admission_sub_combination';
    protected $fillable = ['admission_id', 'preference_no', 'sub_combination_id'];
    protected $connection = 'yearly_db';

    public function sub_comb()
    {
        return $this->belongsTo(SubjectCombination::class, 'sub_combination_id','id');
    }
}
