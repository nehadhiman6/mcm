<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Student;
use App\FeeBillDet;
use Illuminate\Support\Facades\DB;

class RectifySubject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subjects:charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'updates subject id in fee bill details table.';

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
        $students = Student::orderBy('students.id')
            ->join('subject_charges', 'students.course_id', '=', 'subject_charges.course_id')
            ->join('student_subs', function ($q) {
                $q->on('students.id', '=', 'student_subs.student_id')
                    ->on('subject_charges.subject_id', '=', 'student_subs.subject_id');
            })
            ->join('fee_bills', 'students.id', '=', 'fee_bills.std_id')
            ->leftJoin('fee_bill_dets', function ($q) {
                $q->on('fee_bills.id', '=', 'fee_bill_dets.fee_bill_id')
                    ->on('student_subs.subject_id', '=', 'fee_bill_dets.subject_id')
                    ->where('subhead_id', '=', 123);
            })
            // ->where('students.course_id', '=', 13)
            ->whereNull('fee_bill_dets.id')
            ->select(['students.*', 'subject_charges.subject_id', DB::raw('fee_bills.id as fee_bill_id')]);
        // ->get();
        // dd($students->first());
        $students->chunk(100, function ($stds) {
            foreach ($stds as $std) {
                $fbd = FeeBillDet::where('fee_bill_id', '=', $std->fee_bill_id)
                    ->where('subhead_id', '=', 123)
                    ->get();
                if ($fbd->count() > 1) {
                    $d = $fbd->first();
                    $d->subject_id = $std->subject_id;
                    $d->save();
                }
            }
        });
    }
}
