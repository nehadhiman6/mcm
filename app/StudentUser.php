<?php

namespace App;

use App\Notifications\Email2Confirmation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\StdResetPasswordNotification;
use App\Notifications\StdActivationNotofication;
use Illuminate\Support\Facades\DB;

class StudentUser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = 'students';
    protected $fillable = [
        'name', 'mobile', 'email', 'password', 'confirmation_code', 'email2', 'email_code', 'mobile_verified', 'otp', 'initial_password'
    ];
    protected $login_fy = '';
    protected $table = 'student_users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $connection = 'yearly_db';

    public function sendPasswordResetNotification($token)
    {
        return $this->notify(new StdResetPasswordNotification($token));
    }

    public function sendActivationNotofication()
    {
        $token = str_random(15);
        $this->confirmation_code = $token;
        $this->save();
        $this->notify(new StdActivationNotofication($token));
    }

    public function adm_form()
    {
        return $this->hasOne(AdmissionForm::class, 'std_user_id', 'id');
    }

    public function verified()
    {
        $this->confirmed = 1;
        //    $this->confirmation_code = null;
        $this->save();
    }

    public function sendEmail2ActivationNotofication()
    {
        $token = str_random(15);
        $this->email2_code = $token;
        $this->save();
        $this->notify(new Email2Confirmation($token));
    }

    public function confirm_email2()
    {
        $this->email2_confirmed = 'Y';
        //    $this->confirmation_code = null;
        $this->save();
    }

    public function routeNotificationFor()
    {
        return $this->email2_confirmed !== 'Y' ? $this->email : $this->email2;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'std_user_id', 'id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, 'std_user_id', 'id');
    }

    public function admitStudent($payment_id = 0)
    {
        $bill_amt = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $student_det = $this->adm_form;
        $adm_entry = $student_det->admEntry;
        $feebilldets = new \Illuminate\Database\Eloquent\Collection();
        $feerecdets = new \Illuminate\Database\Eloquent\Collection();
        $fee_str = \App\FeeStructure::whereCourseId($student_det->course_id)
            ->whereStdTypeId($adm_entry->std_type_id)->whereInstallmentId(1)
            ->whereOptional('N')
            ->with(['subhead'])
            ->get();
        $index_no = 1;
        foreach ($fee_str as $det) {
            $feebilldet = new \App\FeeBillDet();
            $feebilldet->fill([
                'feehead_id' => $det->subhead->feehead_id, 'subhead_id' => $det->subhead_id, 'amount' => $det->amount,
                'concession' => 0, 'index_no' => $index_no
            ]);
            $feebilldets->add($feebilldet);
            $fee_amt += floatval($det->amount);

            $feerecdet = new \App\FeeRcptDet();
            $feerecdet->fill(['feehead_id' => $det->subhead->feehead_id, 'subhead_id' => $det->subhead_id, 'amount' => $det->amount, 'index_no' => $index_no]);
            $feerecdets->add($feerecdet);
            $index_no++;
        }
        $misc_charges = $student_det->getMiscCharges();

        $exam_fee = 0;
        $subject_id = 0;
        $mc_exam_fee_obj = null;
        foreach ($misc_charges as $mc) {
            if (floatval($mc->hon_exam_fee) > $exam_fee) {
                $exam_fee = floatval($mc->hon_exam_fee);
                $subject_id = $mc->subject_id;
                $mc_exam_fee_obj = $mc;
            }
            if (floatval($mc->pract_exam_fee) > $exam_fee) {
                $exam_fee = floatval($mc->pract_exam_fee);
                $subject_id = 0;
                $mc_exam_fee_obj = $mc;
            }
        }
        foreach ($misc_charges as $mc) {
            if (floatval($mc->hon_fee) > 0) {
                $feebilldet = new \App\FeeBillDet();
                $sh = SubFeeHead::findOrFail($mc->hon_id);
                $feebilldet->fill([
                    'feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($mc->hon_fee),
                    'subject_id' => $mc->subject_id, 'concession' => 0, 'index_no' => $index_no
                ]);
                $feebilldets->add($feebilldet);
                $fee_amt += floatval($feebilldet->amount);

                $feerecdet = new \App\FeeRcptDet();
                $feerecdet->fill(['feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($mc->hon_fee), 'index_no' => $index_no]);
                $feerecdets->add($feerecdet);
                $index_no++;
            }
            if ($mc_exam_fee_obj && $mc->id == $mc_exam_fee_obj->id) {
                $feebilldet = new \App\FeeBillDet();
                $sh = SubFeeHead::findOrFail($mc->exam_id);
                $feebilldet->fill([
                    'feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => $exam_fee,
                    'subject_id' => $subject_id, 'concession' => 0, 'index_no' => $index_no
                ]);
                $feebilldets->add($feebilldet);
                $fee_amt += floatval($feebilldet->amount);

                $feerecdet = new \App\FeeRcptDet();
                $feerecdet->fill(['feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => $exam_fee, 'index_no' => $index_no]);
                $feerecdets->add($feerecdet);
                $index_no++;
            }


            // if (floatval($mc->hon_exam_fee) > 0) {
            //     $feebilldet = new \App\FeeBillDet();
            //     $sh = SubFeeHead::findOrFail($mc->exam_id);
            //     $feebilldet->fill([
            //         'feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($mc->hon_exam_fee),
            //         'subject_id' => $mc->subject_id, 'concession' => 0, 'index_no' => $index_no
            //     ]);
            //     $feebilldets->add($feebilldet);
            //     $fee_amt += floatval($feebilldet->amount);

            //     $feerecdet = new \App\FeeRcptDet();
            //     $feerecdet->fill(['feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($mc->hon_exam_fee), 'index_no' => $index_no]);
            //     $feerecdets->add($feerecdet);
            //     $index_no++;
            // }

            if (floatval($mc->pract_fee) > 0) {
                $feebilldet = new \App\FeeBillDet();
                $sh = SubFeeHead::findOrFail($mc->pract_id);
                $feebilldet->fill([
                    'feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($mc->pract_fee),
                    'concession' => 0, 'index_no' => $index_no
                ]);
                $feebilldets->add($feebilldet);
                $fee_amt += floatval($feebilldet->amount);

                $feerecdet = new \App\FeeRcptDet();
                $feerecdet->fill(['feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($mc->pract_fee), 'index_no' => $index_no]);
                $feerecdets->add($feerecdet);
                $index_no++;
            }

            // if (floatval($mc->pract_exam_fee) > 0) {
            //     $feebilldet = new \App\FeeBillDet();
            //     $sh = SubFeeHead::findOrFail($mc->exam_id);
            //     $feebilldet->fill([
            //         'feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($mc->pract_exam_fee),
            //         'concession' => 0, 'index_no' => $index_no
            //     ]);
            //     $feebilldets->add($feebilldet);
            //     $fee_amt += floatval($feebilldet->amount);

            //     $feerecdet = new \App\FeeRcptDet();
            //     $feerecdet->fill(['feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($mc->pract_exam_fee), 'index_no' => $index_no]);
            //     $feerecdets->add($feerecdet);
            //     $index_no++;
            // }
        }
        $other_charges = $student_det->getOtherCharges();
        foreach ($other_charges as $oc) {
            $feebilldet = new \App\FeeBillDet();
            $sh = SubFeeHead::findOrFail($oc['sh_id']);
            $feebilldet->fill([
                'feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($oc['charges']),
                'concession' => 0, 'index_no' => $index_no
            ]);
            $feebilldets->add($feebilldet);
            $fee_amt += floatval($feebilldet->amount);

            $feerecdet = new \App\FeeRcptDet();
            $feerecdet->fill(['feehead_id' => $sh->feehead_id, 'subhead_id' => $sh->id, 'amount' => floatval($oc['charges']), 'index_no' => $index_no]);
            $feerecdets->add($feerecdet);
            $index_no++;
        }

        $bill_amt += $fee_amt;
        if (floatval($student_det->std_id) == 0) {
            $student = new \App\Student();
            $student->fill($student_det->attributesToArray());
            $student->adm_date = today();
            $student->admission_id = $student_det->id;
            $student->std_type_id = $adm_entry->std_type_id;
            $student->roll_no = $student_det->lastyr_rollno;
            $student->religion = trim($student_det->religion);
            $student->selected_ele_id = $student_det->selected_ele_id;
        } else {
            $student = \App\Student::find($student_det->std_id);
            $student->fill($student_det->attributesToArray());
        }
        $student->adm_source = 'online';
        $student->loc_cat = $student_det->loc_cat ? $student_det->loc_cat : 'General';
        DB::beginTransaction();
        DB::connection(getYearlyDbConn())->beginTransaction();
        $student->adm_cancelled = 'N';
        $student->save();
        $student_det->status = 'A';
        $student_det->std_id = $student->id;
        $student_det->save();
        //dd($this->admform->admSubs);
        // foreach ($student_det->admSubs as $subs) {
        //     $subject = new \App\StudentSubs();
        //     $subject->student_id = $student->id;
        //     $subject->subject_id = $subs['subject_id'];
        //     $subject->save();
        // }
        $old_sub_ids = $student->pluck('id')->toArray();
        $std_subs = new \Illuminate\Database\Eloquent\Collection();
        foreach ($student_det->admSubs as $subs) {
            $attr = ['subject_id' => $subs->subject_id, 'student_id' => $student->id];
            $values = ['sub_group_id' => $subs->sub_group_id, 'ele_group_id' => $subs->ele_group_id];
            $subject = StudentSubs::firstOrNew($attr, $values);
            if ($subject->exists) {
                $subject->fill($values);
            }
            $subject->save();
            $std_subs->add($subject);
        }
        if (count($old_sub_ids) > 0) {
            $new_sub_ids = $std_subs->pluck('id')->toArray();
            $to_be_removed = array_diff($old_sub_ids, $new_sub_ids);
            $student->stdSubs()->whereIn('id', $to_be_removed)->delete();
        }

        $feebill = new \App\FeeBill();
        $feebill->fill([
            'course_id' => $student_det->course_id, 'std_type_id' => $adm_entry->std_type_id,
            'bill_date' => today(),
            'install_id' => 1,
            'fee_type' => 'Admission', 'fee_amt' => $fee_amt, 'bill_amt' => $bill_amt, 'amt_rec' => $fee_amt, 'remarks' => 'Online'
        ]);
        $feebill->std_id = $student->id;
        $feercpt = new \App\FeeRcpt();
        $feercpt->fill([
            'rcpt_date' => today(),
            // 'chqno' => trim($this['formdata']['chqno']),
            // 'concession_id' => $this['formdata']['concession_id'],
            'fee_type' => 'Admission', 'details' => 'Online', 'amount' => $fee_amt
        ]);
        $feercpt->std_id = $student->id;
        $feercpt->payment_id = $payment_id;

        $feebill->save();
        $feebill->feeBillDets()->saveMany($feebilldets);
        $feercpt->fee_bill_id = $feebill->id;
        $feercpt->save();
        $feercpt->feeRcptDets()->saveMany($feerecdets);
        DB::connection(getYearlyDbConn())->table('fee_rcpt_dets')
            ->join('fee_bill_dets', 'fee_rcpt_dets.index_no', '=', 'fee_bill_dets.index_no')
            ->where('fee_bill_dets.fee_bill_id', '=', $feebill->id)
            ->where('fee_rcpt_dets.fee_rcpt_id', '=', $feercpt->id)
            ->update(['fee_rcpt_dets.fee_bill_dets_id' => DB::raw('fee_bill_dets.id')]);
        DB::connection(getYearlyDbConn())->commit();
        DB::commit();
        return $feercpt->id;
    }

    public function receivePayment($fund_type = 'C', $pay_id = 0)
    {
        $fee_type = 'Receipt';
        if ($fund_type == 'H') {
            $fee_type = $this->outsider == 'Y' ? 'Receipt_Hostel_Outsider' : 'Receipt_Hostel';
        }
        $bill_amt = 0;
        $amt_rec = 0;
        $fee_amt = 0;
        $concession = 0;
        $index_no = 1;
        $student = $this->student;
        $pend_bal = $student->getPendingFeeDetails($fund_type, false);
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
                'concession_id' => 0,
                'fee_type' => $fee_type, 'fund_type' => $fund_type, 'details' => 'Online', 'amount' => $amt_rec
            ]);
            $feercpt->std_id = $student->id;
            $feercpt->payment_id = $pay_id;
            DB::beginTransaction();
            DB::connection(getYearlyDbConn())->beginTransaction();
            $feercpt->save();
            $feercpt->feeRcptDets()->saveMany($feerecdets);
            DB::connection(getYearlyDbConn())->commit();
            DB::commit();
        }
        return $amt_rec > 0 ? $feercpt->id : 0;
    }
}
