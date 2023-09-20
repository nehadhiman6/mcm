<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Student;
use App\SubFeeHead;
use App\FeeBillDet;
use App\FeeBill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AddExamFees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'examfees:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debits students for Exam Fees!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        getYearlyDbConn(true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pract_ids = [122, 123, 157];
        $exam_sh_id = 222;
        $exam_fee = 120;
        $students = Student::orderBy('students.id')
            ->join('courses', 'students.course_id', '=', 'courses.id')
            // ->join('student_subs', function ($q) {
            //     $q->on('students.id', '=', 'student_subs.student_id')
            //         ->on('subject_charges.subject_id', '=', 'student_subs.subject_id');
            // })
            ->whereIn('courses.id', [1, 13, 14])
            ->whereIn('students.id', function ($q) use ($pract_ids) {
                $q->from('fee_bills')
                    ->join('fee_bill_dets', 'fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
                    ->whereIn('fee_bill_dets.subhead_id', $pract_ids)
                    ->select('fee_bills.std_id');
            })
            ->whereNotIn('students.id', function ($q) use ($exam_sh_id) {
                $q->from('fee_bills')
                    ->join('fee_bill_dets', 'fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
                    ->where('fee_bill_dets.subhead_id', $exam_sh_id)
                    ->where('bill_date', '>', Carbon::createFromFormat('d-m-Y', '31-12-2022'))
                    ->select('fee_bills.std_id');
            })
            // ->where('students.id', 302)
            ->select('students.*');
        // ->whereIn('id', [7350, 7943, 7042, 7418])

        // ->get();
        // dd($students->pluck('roll_no'));
        $subhead = SubFeeHead::findOrFail($exam_sh_id);
        $date = Carbon::now()->format('d-m-Y');
        $this->info($students->count());
        // return;
        $stds = $students->take(500)->get();
        // $students->chunk(1000, function ($stds) use ($subhead, $exam_fee, $date) {
        while ($stds->count() > 0) {
            foreach ($stds as $std) {
                $feebilldet = new FeeBillDet();
                $feebilldet->fill([
                    'feehead_id' => $subhead->feehead_id, 'subhead_id' => $subhead->id, 'amount' => $exam_fee,
                    'concession' => 0, 'index_no' => 1
                ]);
                $feebill = new FeeBill();
                $feebill->fill([
                    'course_id' => $std->course_id, 'std_type_id' => $std->std_type_id,
                    'bill_date' => $date, 'install_id' => 0,
                    'concession_id' => 0,
                    'fee_type' => 'Examination Fee', 'fund_type' => 'C', 'fee_amt' => $exam_fee, 'bill_amt' => $exam_fee,
                    'amt_rec' => 0, 'concession' => 0, 'remarks' => ''
                ]);
                $feebill->std_id = $std->id;
                DB::beginTransaction(getYearlyDbConn());
                $feebill->save();
                $feebilldet->fee_bill_id = $feebill->id;
                $feebilldet->save();
                DB::commit(getYearlyDbConn());
            }
            $stds = $students->take(500)->get();
            $this->info($students->count());
        }
        // });
    }
}
