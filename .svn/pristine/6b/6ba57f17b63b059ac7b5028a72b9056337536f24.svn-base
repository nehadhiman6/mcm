<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AlumniQualification;
use Carbon\Carbon;

class AlumniStudent extends Model
{
    protected $table = 'alumni_students';
    protected $fillable = [
        'alumni_user_id', 'name', 'gender', 'father_name', 'mother_name', 'passout_year', 'award_yes_no',
        'dob', 'email', 'phone', 'mobile', 'pu_pupin', 'pu_regno', 'per_address', 'ugc_qualified', 'ugc_year', 'ugc_subject_name',
        'competitive_exam_qualified', 'competitive_exam_year', 'competitive_exam_id', 'upsc_psu_exam_name',
        'other_competitive_exam', 'remarks', 'member_yes_no', 'reason_yes_no', 'payment_amount', 'donation_reason',
        'donation_other', 'is_graduacted', 'is_profession', 'is_research', 'std_id', 'course_id', 'life_member'
    ];
    protected $connection = 'mysql';

    public function setDobAttribute($date)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getDobAttribute($date)
    {
        if ($date && $date != '0000-00-00' && $date != 'null') {
            return Carbon::parse($date)->format('d-m-Y');
        }
        return '';
    }

    public function almqualification()
    {
        return $this->hasMany(AlumniQualification::class, 'alumni_stu_id', 'id');
    }

    public function graduatecourse()
    {
        return $this->hasMany(AlumniQualification::class, 'alumni_stu_id', 'id')->where('degree_type', 'UG');
    }


    public function postgradcourses()
    {
        return $this->hasMany(AlumniQualification::class, 'alumni_stu_id', 'id')->where('degree_type', 'PG');
    }


    public function professionalcourses()
    {
        return $this->hasMany(AlumniQualification::class, 'alumni_stu_id', 'id')->where('degree_type', 'professional');
    }

    public function researches()
    {
        return $this->hasMany(AlumniQualification::class, 'alumni_stu_id', 'id')->where('degree_type', 'research');
    }

    public function almexperience()
    {
        return $this->hasMany(AlumniExperience::class, 'alumni_stu_id', 'id');
    }

    public function almAward()
    {
        return $this->hasMany(AlumniAward::class, 'alumni_stu_id', 'id');
    }

    public function alumnimeet()
    {
        return $this->hasMany(AlumniMeetStudent::class, 'alumni_stu_id', 'id');
    }

    public function alumnistream()
    {
        return $this->hasMany(AlumniQualification::class, 'alumni_stu_id', 'id')->where('mcm_college', 'Y')->orderBy('passing_year', 'desc');
    }


    public function previousyearstudent()
    {
        return $this->belongsTo(PrvStudent::class, 'std_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
