<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelUtilities;
use Carbon\Carbon;
use DB;
use Storage;
use Log;
use App\Models\Online\StudentFeedback;

class Student extends Model
{

    //
    use Traits\ModelUtilities,
        Traits\AutoUpdateUserColumns;

    protected $table = 'students';
    protected $fillable = [
        'adm_entry_id', 'std_user_id', 'std_type_id', 'roll_no', 'loc_cat', 'cat_id', 'resvcat_id', 'religion', 'foreign_national', 'geo_cat', 'nationality', 'name', 'mobile', 'aadhar_no', 'gender',
        'father_name', 'mother_name', 'guardian_name', 'dob', 'blood_grp', 'hostel', 'migration', 'blind', 'per_address', 'city', 'state_id', 'pincode', 'same_address', 'corr_address', 'corr_city', 'corr_state_id', 'corr_pincode', 'father_occup',
        'father_desig', 'father_phone', 'father_mobile', 'f_office_addr', 'father_email', 'mother_occup', 'mother_desig', 'mother_phone',
        'mother_mobile', 'mother_email', 'm_office_addr', 'guardian_occup', 'guardian_desig', 'guardian_phone', 'guardian_mobile',
        'guardian_email', 'g_office_addr', 'annual_income', 'pu_regno', 'pupin_no', 'course_id', 'gap_year',
        'org_migrate', 'migrated', 'migrate_detail', 'disqualified', 'disqualify_detail', 'f_nationality', 'passportno', 'visa', 'res_permit', 'sports', 'cultural', 'academic', 'epic_no', 'minority', 'other_religion',
        'hostel_room_id'
    ];
    protected $connection = 'yearly_db';

    public function setDobAttribute($date)
    {
        $this->attributes['dob'] = setDateAttribute($date);
    }

    public function getDobAttribute($date)
    {
        $date = getDateAttribute($date);
        return $date;
    }

    public function setAdmDateAttribute($date)
    {
        $this->attributes['adm_date'] = getDateFormat($date, 'ymd');
    }

    public function getAdmDateAttribute($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');
        return $date;
    }

    public function stdSubs()
    {
        return $this->hasMany(\App\StudentSubs::class, 'student_id', 'id');
    }

    public function stdSubsCharges()
    {
        return $stdSubs = $this->stdSubs()
            ->join('students', 'students.id', '=', 'student_subs.student_id')
            ->join('subject_charges', function ($q) {
                $q->on('student_subs.subject_id', '=', 'subject_charges.subject_id')
                    ->on('students.course_id', '=', 'subject_charges.course_id');
            })
            ->select('student_subs.*');
        //     ->get();
        // $stdSubs->load('subject');
        // return $stdSubs;
    }

    public function stdSubsCharged()
    {
        return $this->stdSubs()
            ->join('students', 'students.id', '=', 'student_subs.student_id')
            ->join('fee_bills', 'students.id', '=', 'fee_bills.std_id')
            ->join('fee_bill_dets', function ($q) {
                $q->on('student_subs.subject_id', '=', 'fee_bill_dets.subject_id')
                    ->on('fee_bills.id', '=', 'fee_bill_dets.fee_bill_id');
            })
            ->select('student_subs.*')
            ->distinct();
        //    ->get();
    }

    public function stdHonsCharges()
    {
        return $stdSubs = $this->admEntry()
            ->join('students', 'students.adm_entry_id', '=', 'admission_entries.id')
            ->join(getSharedDb() . 'subjects', 'subjects.id', '=', 'admission_entries.honour_sub_id')
            ->join('subject_charges', function ($q) {
                $q->on('admission_entries.honour_sub_id', '=', 'subject_charges.subject_id')
                    ->on('students.course_id', '=', 'subject_charges.course_id');
            })
            ->select('admission_entries.*', 'subjects.subject');
        //     ->get();
        // $stdSubs->load('subject');
        // return $stdSubs;
    }

    public function stdHonsCharged()
    {
        return $this->admEntry()
            ->join('students', 'students.adm_entry_id', '=', 'admission_entries.id')
            ->join(getSharedDb() . 'subjects', 'subjects.id', '=', 'admission_entries.honour_sub_id')
            ->join('fee_bills', 'students.id', '=', 'fee_bills.std_id')
            ->join('fee_bill_dets', function ($q) {
                $q->on('admission_entries.honour_sub_id', '=', 'fee_bill_dets.subject_id')
                    ->on('fee_bills.id', '=', 'fee_bill_dets.fee_bill_id');
            })
            ->select('admission_entries.*', 'subjects.subject')
            ->distinct();
        //    ->get();
    }

    public function stdSubsUnCharged()
    {
        return $this->stdSubs()
            ->join('students', 'students.id', '=', 'student_subs.student_id')
            ->join('subject_charges', function ($q) {
                $q->on('student_subs.subject_id', '=', 'subject_charges.subject_id')
                    ->on('students.course_id', '=', 'subject_charges.course_id')
                    // ->where('subject_charges.pract_fee', '>', 0)
                ;
            })
            ->leftJoin('fee_bills', function ($q) {
                $q->on('students.id', '=', 'fee_bills.std_id')
                    // ->where('fee_bills.fee_type', '=', 'Subject Charges')
                ;
            })
            ->leftJoin('fee_bill_dets', function ($q) {
                $q->on('student_subs.subject_id', '=', 'fee_bill_dets.subject_id')
                    ->on('fee_bills.id', '=', 'fee_bill_dets.fee_bill_id');
            })
            ->whereNull('fee_bill_dets.id')
            ->select('subject_charges.*')
            ->distinct();
        //    ->get();
    }

    public function stdHonsUnCharged()
    {
        $bill_ids = $this->fee_bills->pluck('id')->toArray();
        return $this->admEntry()
            ->join('students', 'students.adm_entry_id', '=', 'admission_entries.id')
            ->join('subject_charges', function ($q) {
                $q->on('admission_entries.honour_sub_id', '=', 'subject_charges.subject_id')
                    ->on('students.course_id', '=', 'subject_charges.course_id')
                    // ->where('subject_charges.pract_fee', '>', 0)
                ;
            })
            // ->leftJoin('fee_bills', function ($q) {
            //     $q->on('students.id', '=', 'fee_bills.std_id')
            //         // ->where('fee_bills.fee_type', '=', 'Subject Charges')
            //     ;
            // })
            ->leftJoin('fee_bill_dets', function ($q) use ($bill_ids) {
                $q->on('admission_entries.honour_sub_id', '=', 'fee_bill_dets.subject_id')
                    // ->on('fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
                    ->whereIn('fee_bill_dets.fee_bill_id', $bill_ids);
                // ->whereIn('fee_bill_dets.fee_bill_id', function ($q1) {
                //     $q1->from('fee_bills')
                //         ->where('fee_bills.std_id', '=', 'students.id')
                //         ->select('fee_bills.id');
                // });
            })
            ->whereNull('fee_bill_dets.id')
            ->select('subject_charges.*');
        //    ->get();
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function res_category()
    {
        return $this->belongsTo(ResCategory::class, 'resvcat_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function admForm()
    {
        return $this->belongsTo(AdmissionForm::class, 'admission_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(\App\Attachment::class, 'admission_id', 'admission_id');
    }

    public function admEntry()
    {
        return $this->belongsTo(AdmissionEntry::class, 'adm_entry_id', 'id');
    }

    public function stdType()
    {
        return $this->belongsTo(StudentType::class, 'std_type_id', 'id');
    }

    public function std_user()
    {
        return $this->belongsTo(StudentUser::class, 'std_user_id', 'id')->select('id', 'name', 'mobile', 'email', 'confirmed', 'mobile_verified', 'email2_confirmed');
    }

    public function last_exam()
    {
        return $this->hasOne(AcademicDetail::class, 'admission_id', 'admission_id')->with('board')->where('last_exam', '=', 'Y');
    }

    public function fee_bills()
    {
        return $this->hasMany(FeeBill::class, 'std_id', 'id');
    }

    public function removed_detail()
    {
        return $this->hasOne(RemovedStudent::class, 'std_id', 'id');
    }

    public function feedback()
    {
        return $this->hasMany(StudentFeedback::class, 'std_id', 'id');
    }

    public function saveAttributes()
    {
        // $this->adm_no = next_admno();
        $this->adm_no = $this->roll_no;
        // $this->roll_no = nextRollno($this->course_id);
    }

    public function scopeExisting($q)
    {
        return $q->where('students.adm_cancelled', '=', 'N');
    }

    public function scopeNotRemoved($q)
    {
        return $q->where('students.removed', '=', 'N');
    }

    public function scopeHostler($q)
    {
        return $q->whereIn('students.id', function ($q) {
            $q->from('fee_bills')
                ->where('fee_type', '=', 'Admission_Hostel')
                ->select('std_id');
        });
    }

    public function hostel_location()
    {
        return $this->belongsTo(Location::class, 'hostel_room_id');
    }

    public function isCourseRollNo()
    {
        return Course::where(DB::raw('cast(st_rollno as UNSIGNED)'), '<=', floatval($this->roll_no))
            ->where(DB::raw('cast(end_rollno as UNSIGNED)'), '>=', floatval($this->roll_no))
            ->whereId($this->course_id)
            ->exists();
    }

    public function getPendingBal()
    {
        $fee_bills = "(select bills.std_id,sum(bills.bill_amt)-sum(ifnull(rcpts.amount,0)) as bal_amt from fee_bills bills " .
            "left join " .
            "(select f.fee_bill_id,sum(r.amount) as amount from fee_bill_dets f join fee_rcpt_dets r on f.id=r.fee_bill_dets_id join fee_rcpts fr on r.fee_rcpt_id=fr.id where fr.cancelled='N' group by 1) as rcpts on bills.id=rcpts.fee_bill_id where bills.cancelled='N' group by 1) as fee_bills";
        return floatval(\App\Student::join(DB::raw($fee_bills), 'students.id', '=', 'fee_bills.std_id')
            ->where('students.id', '=', $this->id)->select('fee_bills.bal_amt')
            ->get()->first()->bal_amt);
    }

    public static function havingPendBal($data)
    {
        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_bill_dets', 'fee_rcpt_dets.fee_bill_dets_id', '=', 'fee_bill_dets.id')
            ->join('fee_rcpts', 'fee_rcpt_dets.fee_rcpt_id', '=', 'fee_rcpts.id')
            ->where('fee_rcpts.cancelled', '=', 'N')
            ->groupBy('fee_bill_dets.fee_bill_id')
            ->select('fee_bill_dets.fee_bill_id', DB::raw('sum(fee_rcpt_dets.amount+fee_rcpt_dets.concession) as amount'));

        $fee_bills = \App\FeeBill::leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), 'fee_bills.id', '=', 'receipts.fee_bill_id')
            ->mergeBindings($fee_rcpt_dets->getQuery())
            ->where('fee_bills.cancelled', '=', 'N');

        if ($data['institution'] == 'sggs') {
            $fee_bills->groupBy('fee_bills.std_id')
                ->select('fee_bills.std_id', DB::raw('sum(fee_bills.bill_amt)-sum(ifnull(receipts.amount,0)) as bal_amt'));

            if ($data['fund_type'] != '') {
                $fee_bills = $fee_bills->where('fee_bills.fund_type', '=', $data['fund_type']);
            }
            $students = \App\Student::join(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'students.id', '=', 'fee_bills.std_id')
                ->mergeBindings($fee_bills->getQuery())
                ->existing()
                ->notRemoved()
                ->where('fee_bills.bal_amt', '!=', 0);
            if ($data['course_id'] != 0) {
                $students = $students->where('course_id', '=', $data['course_id']);
            }
            $students = $students->select('students.id', 'students.std_type_id', 'students.adm_no', 'students.name', 'students.roll_no', 'students.father_name', 'students.mobile', 'students.course_id', 'fee_bills.bal_amt')
                ->with(['course' => function ($q) {
                    $q->select('id', 'course_name');
                }]);
        } else {
            $fee_bills->groupBy('fee_bills.outsider_id')
                ->select('fee_bills.outsider_id', DB::raw('sum(fee_bills.bill_amt)-sum(ifnull(receipts.amount,0)) as bal_amt'));
            $students = \App\Outsider::orderBy('outsiders.course_name')->join(DB::raw("({$fee_bills->toSql()}) as fee_bills"), 'outsiders.id', '=', 'fee_bills.outsider_id')
                ->mergeBindings($fee_bills->getQuery())
                ->where('fee_bills.bal_amt', '!=', 0);
            $students = $students->select('outsiders.id', 'outsiders.std_type_id', 'outsiders.adm_no', 'outsiders.name', 'outsiders.roll_no', 'outsiders.father_name', 'outsiders.mobile', 'outsiders.course_name', 'fee_bills.bal_amt');
        }
        return $students->get();
    }

    public function getPendingFeeDetails($fund_type = 'C', $group = true, $last_fbid = 0)
    {
        $fee_rcpt_dets = \App\FeeRcptDet::join('fee_rcpts', 'fee_rcpts.id', '=', 'fee_rcpt_dets.fee_rcpt_id')
            ->groupBy(DB::raw('1,2,3'))
            ->select('fee_rcpt_dets.fee_bill_dets_id', 'fee_rcpt_dets.feehead_id', 'fee_rcpt_dets.subhead_id', DB::raw('sum(fee_rcpt_dets.amount+ifnull(fee_rcpt_dets.concession,0)) as amt_rec'))
            ->where('fee_rcpts.cancelled', '=', 'N');
        $pend_bal = \App\FeeBillDet::join('fee_bills', 'fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
            ->leftJoin(DB::raw("({$fee_rcpt_dets->toSql()}) as receipts"), function ($q) {
                $q->on('receipts.fee_bill_dets_id', '=', 'fee_bill_dets.id')
                    ->on('receipts.feehead_id', '=', 'fee_bill_dets.feehead_id')
                    ->on('receipts.subhead_id', '=', 'fee_bill_dets.subhead_id');
            })->mergeBindings($fee_rcpt_dets->getQuery())
            ->where('fee_bills.fund_type', '=', $fund_type)
            ->where('fee_bills.std_id', '=', $this->id)
            ->where('fee_bills.cancelled', '=', 'N')
            ->whereRaw('fee_bill_dets.amount-ifnull(fee_bill_dets.concession,0)-ifnull(receipts.amt_rec,0) > 0')
            ->select('fee_bill_dets.id', 'fee_bill_dets.index_no', 'fee_bill_dets.feehead_id', 'fee_bill_dets.subhead_id', DB::raw('fee_bill_dets.amount-ifnull(fee_bill_dets.concession,0)-ifnull(receipts.amt_rec,0) as amount'), DB::raw('0 as concession'), DB::raw('fee_bill_dets.amount-ifnull(fee_bill_dets.concession,0)-ifnull(receipts.amt_rec,0) as amt_rec'));
        if ($last_fbid > 0) {
            $pend_bal = $pend_bal->where('fee_bills.id', '<=', $last_fbid);
        }
        $pend_bal = $pend_bal->get();

        if ($group) {
            $pend_bal = $pend_bal->groupBy(function ($item, $key) {
                return $item['subhead']['feehead']['name'];
            });
        }

        return $pend_bal;
    }

    public function getAttachmentPath($file_type = 'photograph')
    {
        $file_path = '';
        if ($this->admForm->attachments->count() > 0) {
            $file = $this->admForm->attachments->where('file_type', '=', $file_type)->first();
            if ($file) {
                $file_path = $file_type . '_' . $file->admission_id . '.' . $file->file_ext;
                //        $file_path = $file_type . '_911.jpeg';
                //        dd($file_path);
                //        dd(Storage::exists('images/' . $file_path));
                if (Storage::exists('images/' . $file_path)) {
                    return storage_path() . "/app/images/" . $file_path;
                    return '<img alt="example1" src="' . storage_path() . "/app/images/" . $file_path . '" height="42" width="42"/>';
                }
            }
        }
        return null;
    }

    public function receivePayment($fund_type = 'C', $last_fbid = 0, $pay_id = 0)
    {
        $fee_type = 'Receipt';
        if ($fund_type == 'H') {
            $fee_type = 'Receipt_Hostel';
        }
        $bill_amt = 0;
        $amt_rec = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $pend_bal = $this->getPendingFeeDetails($fund_type, false, $last_fbid);
        logger($pend_bal);
        $feerecdets = new \Illuminate\Database\Eloquent\Collection();
        foreach ($pend_bal as $det) {
            $fee_amt += floatval($det['amount']);
            $concession += floatval($det['concession']);
            $amt_rec += floatval($det['amt_rec']);
            if ($det['amt_rec'] > 0) {
                $feerecdet = new \App\FeeRcptDet();
                $feerecdet->fill(['fee_bill_dets_id' => $det['id'], 'feehead_id' => $det['feehead_id'], 'subhead_id' => $det['subhead_id'], 'amount' => $det['amt_rec'], 'index_no' => $index_no]);
                $feerecdets->add($feerecdet);
            }
            $index_no++;
        }
        $bill_amt += $fee_amt - $concession;
        if ($amt_rec > 0) {
            $feercpt = new \App\FeeRcpt();
            $feercpt->fill([
                'rcpt_date' => today(),
                'concession_id' => 0, 'std_id' => $this->id,
                'fee_type' => $fee_type, 'fund_type' => $fund_type, 'details' => 'Online', 'amount' => $amt_rec
            ]);
            $feercpt->payment_id = $pay_id;

            DB::beginTransaction();
            DB::connection(getYearlyDbConn())->beginTransaction();
            $feercpt->save();
            $feercpt->feeRcptDets()->saveMany($feerecdets);
            DB::connection(getYearlyDbConn())->commit();
            DB::commit();
        }
        return isset($feercpt) ? $feercpt->id : 0;
    }

    public static function getStrength($course_id, $subject_id)
    {
        $honSub = CourseSubject::whereCourseId($course_id)
            ->whereSubjectId($subject_id)
            ->first();

        $students = static::existing()->notRemoved()->join('courses', 'students.course_id', '=', 'courses.id')


            ->select('students.adm_no', 'students.name', 'students.roll_no')
            ->where('students.adm_cancelled', '=', 'N')
            ->where('students.course_id', '=', $course_id);

        if ($honSub->honours == 'Y') {
            $students = $students->join('admission_entries', 'admission_entries.admission_id', '=', 'students.admission_id')
                ->join(getSharedDb() . 'subjects', 'admission_entries.honour_sub_id', '=', 'subjects.id')
                ->where('admission_entries.honour_sub_id', '=', $subject_id);
        } else {
            $students = $students->join('student_subs', 'student_subs.student_id', '=', 'students.id')
                ->join(getSharedDb() . 'subjects', 'student_subs.subject_id', '=', 'subjects.id')
                ->where('student_subs.subject_id', '=', $subject_id);
        }

        return $students->get();

        return static::existing()->notRemoved()->join('courses', 'students.course_id', '=', 'courses.id')
            ->join('student_subs', 'student_subs.student_id', '=', 'students.id')
            ->join(getSharedDb() . 'subjects', 'student_subs.subject_id', '=', 'subjects.id')
            ->select('students.adm_no', 'students.name', 'students.roll_no')
            ->where('students.adm_cancelled', '=', 'N')
            ->where('students.course_id', '=', $course_id)
            ->where('student_subs.subject_id', '=', $subject_id)->get();
    }

    public function marks_details()
    {
        return $this->hasMany(StudentMarks::class, 'std_id', 'id');
    }
}
