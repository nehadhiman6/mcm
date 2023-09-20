<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits;

class AdmissionFormHostel extends Model
{
    //
    use Traits\ModelUtilities,
    Traits\AutoUpdateUserColumns;

//
    protected $table = 'admission_form_hostel';
    protected $fillable = ['admission_id', 'room_mate','serious_ailment', 'prv_hostel_block','prv_room_no','prv_class','prv_roll_no','schedule_backward_tribe',
                            'guardian_name','guardian_phone','guardian_mobile','guardian_email','guardian_address','g_office_addr','guardian_relationship','ac_room'
                            ];
    protected $connection = 'yearly_db';

    public function adm_form()
    {
        return $this->belongsTo('App\AdmissionForm', 'admission_id', 'id');
    }

    public function feesPaid()
    {
//    dd($this->admEntry->exists);
        if ($this->fee_paid == 'Y') {
            return true;
        } else {
            $paid = $this->adm_form->std_user->payments()->whereTrnType('prospectus_fee_hostel')->where('ourstatus', '=', 'OK')->count() > 0;
            if ($paid) {
                $this->fee_paid = 'Y';
                $this->update();
                return true;
            } else {
                return false;
            }
        }
    }
}
