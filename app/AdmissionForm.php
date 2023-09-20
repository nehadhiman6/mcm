<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits;
use DB;
use Log;
use App\Models\Discrepancy\AdmissionFormDiscrepancy;

class AdmissionForm extends Model
{
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    //
    protected $table = 'admission_forms';
    protected $fillable = [
        'adm_entry_id', 'active_tab', 'source', 'loc_cat', 'cat_id', 'resvcat_id', 'religion', 'foreign_national', 'geo_cat', 'nationality', 'name', 'mobile', 'aadhar_no', 'gender',
        'father_name', 'mother_name', 'guardian_name', 'dob', 'blood_grp', 'hostel', 'migration', 'punjabi_in_tenth', 'per_address', 'city', 'state_id', 'pincode', 'same_address', 'corr_address', 'corr_city', 'corr_state_id', 'corr_pincode', 'father_occup',
        'father_desig', 'father_phone', 'father_mobile', 'f_office_addr', 'father_email', 'mother_occup', 'mother_desig', 'mother_phone',
        'mother_mobile', 'mother_email', 'm_office_addr', 'guardian_occup', 'guardian_desig', 'guardian_phone', 'guardian_mobile',
        'guardian_email', 'g_office_addr', 'annual_income', 'pu_regno', 'pupin_no', 'course_id', 'course_code', 'academic_id', 'gap_year',
        'org_migrate', 'migrated', 'migrate_detail', 'disqualified', 'disqualify_detail', 'f_nationality', 'passportno', 'visa', 'res_permit', 'sports', 'cultural', 'academic', 'terms_conditions',
        'boarder', 'minority', 'differently_abled', 'spl_achieve', 'adhar_card', 'epic_card', 'other_religion', 'remarks_diff_abled', 'conveyance', 'veh_no', 'epic_no', 'sports_seat', 'sport_name', 'medium', 'selected_ele_id', 'passport_validity', 'visa_validity', 'res_validity', 'migration_certificate', 'migrate_from', 'migrate_deficient_sub', 'lastyr_rollno',
        'belongs_bpl', 'icssr_sponser', 'equivalence_certificate', 'father_address', 'mother_address', 'guardian_address',
        'guardian_relationship', 'guardian_email', 'addon_course_id', 'ocet_rollno','vaccinated','attachment_submission','scrutinized','vaccination_remarks','add_res_cats','antireg_ref_no','mcm_graduate','abc_id'
    ];

    protected $connection = 'yearly_db';
    protected $attributes = array(
        'nationality' => 'INDIAN'
    );

    public function setDobAttribute($date)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $date);
    }

    public function getDobAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }
    public function setPassportValidityAttribute($date)
    {
        if ($date != null) {
            $this->attributes['passport_validity'] = Carbon::createFromFormat('d-m-Y', $date);
        }
    }

    public function getPassportValidityAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }
    public function setVisaValidityAttribute($date)
    {
        if ($date != null) {
            $this->attributes['visa_validity'] = Carbon::createFromFormat('d-m-Y', $date);
        }
    }

    public function getVisaValidityAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }
    public function setResValidityAttribute($date)
    {
        if ($date != null) {
            $this->attributes['res_validity'] = Carbon::createFromFormat('d-m-Y', $date);
        }
    }

    public function getResValidityAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function academics()
    {
        return $this->hasMany(\App\AcademicDetail::class, 'admission_id', 'id');
    }

    public function sub_combinations()
    {
        return $this->hasMany(AdmisssionSubCombination::class, 'admission_id', 'id');
    }

    public function discrepancy()
    {
        return $this->hasMany(AdmissionFormDiscrepancy::class, 'admission_id', 'id');
    }

    public function alumani()
    {
        return $this->hasOne(\App\Alumani::class, 'admission_id', 'id');
    }


    public function addOnCourse()
    {
        return $this->belongsTo(\App\AddOnCourse::class, 'addon_course_id', 'id');
    }

    public function hostelData()
    {
        return $this->hasOne(\App\AdmissionFormHostel::class, 'admission_id', 'id');
    }

    public function becholorDegreeDetails()
    {
        return $this->hasOne(\App\BechelorDegreeDetails::class, 'admission_id', 'id');
    }

    public function admSubs()
    {
        return $this->hasMany(\App\AdmissionSubs::class, 'admission_id', 'id');
    }

    public function AdmissionSubPreference()
    {
        return $this->hasMany(\App\AdmissionSubPreference::class, 'admission_id', 'id')
            ->orderBy('preference_no');
    }

    public function honours()
    {
        return $this->hasMany(\App\AdmissionHonourSubject::class, 'admission_id', 'id')->orderBy('preference');
    }

    public function permanentState()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function corresState()
    {
        return $this->belongsTo(State::class, 'corr_state_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }

    public function res_category()
    {
        return $this->belongsTo(ResCategory::class, 'resvcat_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(\App\Attachment::class, 'admission_id', 'id');
    }

    public function getadmSubject()
    {
        $subs = $this->admSubs->pluck('subject')->toArray();
        return implode(', ', $subs);
    }

    public function std_user()
    {
        return $this->belongsTo(StudentUser::class, 'std_user_id', 'id')->select('id', 'name', 'mobile', 'email', 'confirmed', 'email2', 'email2_confirmed');
    }

    public function admEntry()
    {
        return $this->hasOne(AdmissionEntry::class, 'admission_id', 'id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'admission_id', 'id');
    }
    public function consent()
    {
        return $this->hasOne(\App\AddmissionConsent::class, 'admission_id', 'id');
    }

    public function hostel_form()
    {
        return $this->hasOne(AdmissionFormHostel::class, 'admission_id', 'id');
    }

    public function getAttachmentPath($file_type)
    {
        return storage_path() . "/app/images/" . $file_type . '_' . $this->id . '.' . $file->file_ext;
    }

    public function scopeBetween($query, $date_from, $date_to)
    {
        return $query->where('admission_forms.created_at', '>=', Carbon::createFromFormat('d-m-Y', $date_from)->format('Y-m-d'))
            ->where('admission_forms.created_at', '<=', Carbon::createFromFormat('d-m-Y', $date_to)->addDay()->setTime(0, 0, 0)->format('Y-m-d'));
    }

    public function feesPaid()
    {
        // dd($this->hostelFeesPaid());
        return $this->collgeFeesPaid() && $this->hostelFeesPaid();
    }

    public function collgeFeesPaid()
    {
        // if ($this->fee_paid == 'Y' || $this->admEntry) {
        if ($this->fee_paid == 'Y') {
            return true;
        } else {
            $paid = $this->std_user->payments()->whereTrnType('prospectus_fee')->where('ourstatus', '=', 'OK')->count() > 0;
            if ($paid) {
                $this->fee_paid = 'Y';
                $this->update();
                return true;
            } else {
                return false;
            }
        }
    }

    public function hostelFeesPaid()
    {
        // if ($this->reservedHostel() == false) {
        //     return true;
        // }
        if ($this->hostel != 'Y') {
            return true;
        }
        $hostel_form = $this->hostel_form;
        if ($hostel_form && $hostel_form->fee_paid == 'Y') {
            return true;
        } else {
            $paid = $this->std_user->payments()->whereTrnType('prospectus_fee_hostel')->where('ourstatus', '=', 'OK')->count() > 0;
            if ($paid && $hostel_form) {
                $hostel_form->fee_paid = 'Y';
                $hostel_form->update();
                return true;
            } else {
                return false;
            }
        }
    }

    public function reservedHostel()
    {
        return !is_null(DB::table(getPrvYearDb() . '.hostelreserve_t')->where('fld3', '=', $this->lastyr_rollno)->first());
    }

    public function getAdmFeeStr()
    {
        $adm_entry = $this->admEntry;
        $fee_str = FeeStructure::join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
            ->join('fee_heads', 'fee_heads.id', '=', 'sub_heads.feehead_id')
            ->orderBy('fee_heads.name')
            ->whereCourseId($this->course_id)
            ->whereStdTypeId($adm_entry->std_type_id)->whereInstallmentId(1)
            ->where('fee_structures.optional', '=', 'N')
            ->select(DB::raw("fee_heads.name as feehead, sum(fee_structures.amount) as amount"))
            ->groupBy('fee_heads.name');
        if($this->mcm_graduate == 'Y') {
            $course = Course::find($this->course_id);
            if(strtoupper($course->status) == 'PGRAD' && $course->final_year == 'Y') {
                $fee_str = $fee_str->where('sub_heads.id','<>',223);
            }
        }
        $fee_str = $fee_str->get();
        return $fee_str;
    }

    public function getMiscCharges()
    {
        $misc_charges = [];
        $adm_entry = $this->admEntry;

        $pract_ids = $this->admSubs()->join('course_subject', 'admission_subs.subject_id', '=', 'course_subject.subject_id')
            ->where('course_subject.practical', '=', 'Y')
            ->where('course_subject.course_id', '=', $this->course_id)
            ->get(['admission_subs.subject_id'])->pluck('subject_id')->toArray();

        // $pract_ids[] = $adm_entry->addon_course_id;
        $pract_ids[] = $adm_entry->honour_sub_id;

        $misc_charges = SubjectCharge::join(getSharedDb() . 'subjects', 'subjects.id', '=', 'subject_charges.subject_id')
            ->where('course_id', '=', $this->course_id)
            ->whereIn('subject_id', $pract_ids)
            ->select(['subjects.subject', 'subject_charges.*'])
            // ->select(['subjects.subject', 'subject_charges.pract_fee', 'subject_charges.pract_exam_fee', 'subject_charges.hon_fee', 'subject_charges.hon_exam_fee'])
            ->get();

        return $misc_charges;
    }

    public function getOtherCharges()
    {
        $other_charges = [];
        $adm_entry = $this->admEntry;
        if ($adm_entry->addon_course_id > 0) {
            $other_charges[] = [
                'name' => 'ADD ON COURSE (' . $adm_entry->add_on_course->course_name . ')',
                'charges' => config('college.add_on_fee'),
                'sh_id' => config('college.addon_sh_id')
            ];
        }
        if ($this->conveyance == 'Y') {
            $other_charges[] = [
                'name' => 'CONVEYANCE CHARGES',
                'charges' => config('college.parking_fee'),
                'sh_id' => config('college.parking_sh_id')
            ];
        }
        if ($adm_entry->std_type_id == 1 && $this->foreign_national == 'Y') {
            $other_charges[] = [
                'name' => 'FOREIGN FEES',
                'charges' => config('college.foreign_fee'),
                'sh_id' => config('college.foreign_sh_id')
            ];
        }
        if ($adm_entry->std_type_id == 1 && $this->migration == 'Y') {
            $other_charges[] = [
                'name' => 'MIGRATION FEES',
                'charges' => config('college.mig_fee'),
                'sh_id' => config('college.mig_sh_id')
            ];
        }
        return $other_charges;
    }

    public function getAdmFeeTotal()
    {
        $total = 0;
        $fee_str = $this->getAdmFeeStr();
        foreach ($fee_str as $fee) {
            $total += $fee->amount;
        }
        $misc_charges = $this->getMiscCharges();
        // foreach ($misc_charges as $misc) {
        //     $total += floatval($misc->hon_fee) + floatval($misc->hon_exam_fee) + floatval($misc->pract_fee) + floatval($misc->pract_exam_fee);
        // }
        $exam_fee = 0;
        foreach ($misc_charges as $misc) {
            if(floatval($misc->hon_exam_fee) > $exam_fee) {
                $exam_fee = floatval($misc->hon_exam_fee);
            }
            if(floatval($misc->pract_exam_fee) > $exam_fee) {
                $exam_fee = floatval($misc->pract_exam_fee);
            }
            $total += floatval($misc->hon_fee) + floatval($misc->pract_fee);
        }
        $total += $exam_fee;

        $other_charges = $this->getOtherCharges();
        foreach ($other_charges as $other) {
            $total += floatval($other['charges']);
        }
        return $total;
    }

    public static function getStrength($course_id, $subject_id)
    {
        return static::join('courses', 'admission_forms.course_id', '=', 'courses.id')
            ->join('admission_subs', 'admission_subs.admission_id', '=', 'admission_forms.id')
            ->join(getSharedDb() . 'subjects', 'admission_subs.subject_id', '=', 'subjects.id')
            ->select('admission_forms.id', 'admission_forms.name', 'admission_forms.lastyr_rollno')
            ->where('admission_forms.final_submission', '=', 'Y')
            ->where('admission_forms.course_id', '=', $course_id)
            ->where('admission_subs.subject_id', '=', $subject_id)->get();
    }
}
