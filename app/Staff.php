<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Staff\StaffQualification;
use App\Models\Staff\StaffExperience;
use App\Research;
use App\Models\Staff\StaffPromotion;
use App\Models\Staff\StaffCourse;


class Staff extends Model
{
    //
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'staff';
    protected $fillable = [
        'salutation', 'middle_name', 'last_name', 'faculty_id', 'address_res', 'area_of_specialization',
        'other_specialization', 'mcm_joining_date', 'teaching_exp', 'user_id', 'type', 'source', 'name', 'subject_id',
        'desig_id', 'dept_id', 'mobile', 'email', 'address', 'father_name', 'dob', 'mobile2', 'cat_id', 'aadhar_no', 'pan_no',
        'emergency_contact', 'emergency_relation', 'emergency_contact2', 'emergency_relation2',
        'remarks', 'gender', 'qualification', 'library_code', 'blood_group', 'disclaimer', 'sub_faculty_id', 'left_date', 'confirmation_date', 'retire_date', 'pay_scale'
    ];
    protected $appends = ['full_name'];
    protected $connection = 'mysql';

    public function desig()
    {
        return $this->belongsTo(Designation::class, 'desig_id', 'id');
    }

    public function dept()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function setMcmJoiningDateAttribute($date)
    {
        $this->attributes['mcm_joining_date'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getMcmJoiningDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function setLeftDateAttribute($date)
    {
        $this->attributes['left_date'] = setDateAttribute($date);
    }

    public function getLeftDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setConfirmationDateAttribute($date)
    {
        if ($date != null || $date != '') {
            $this->attributes['confirmation_date'] = Carbon::createFromFormat('d-m-Y', $date);
        } else {
            $this->attributes['confirmation_date'] =  null;
        }
    }


    public function getConfirmationDateAttribute($date)
    {
        if ($date != null) {
            $date = Carbon::parse($date)->format('d-m-Y');
            return $date;
        }
    }

    public function setDobAttribute($date)
    {
        $this->attributes['dob'] = setDateAttribute($date);
    }

    public function getDobAttribute($date)
    {
        $date = getDateAttribute($date);
        return $date;
    }

    public function setRetireDateAttribute($date)
    {
        if ($date != null || $date != '') {
            $this->attributes['retire_date'] = Carbon::createFromFormat('d-m-Y', $date);
        } else {
            $this->attributes['retire_date'] =  null;
        }
    }

    public function getRetireDateAttribute($date)
    {
        if ($date != null) {
            $date = Carbon::parse($date)->format('d-m-Y');
            return $date;
        }
    }

    public function qualifications()
    {
        return $this->hasMany(StaffQualification::class, 'staff_id', 'id');
    }

    public function experiences()
    {
        return $this->hasMany(StaffExperience::class, 'staff_id', 'id');
    }

    public function researches()
    {
        return $this->hasMany(Research::class, 'staff_id', 'id');
    }

    public function promotions()
    {
        return $this->hasMany(StaffPromotion::class, 'staff_id', 'id');
    }

    public function first_designation()
    {
        return $this->hasOne(StaffPromotion::class, 'staff_id', 'id')->oldest();
    }

    public function courses()
    {
        return $this->hasMany(StaffCourse::class, 'staff_id', 'id');
    }



    public function getFullNameAttribute()
    {
        $name = $this->name;
        $name .= $this->middle_name ? ' ' . $this->middle_name : '';
        $name .= $this->last_name ? ' ' . $this->last_name : '';
        $name = $this->salutation ? $this->salutation . ' ' . $name : $name;
        return $name;
    }
}
