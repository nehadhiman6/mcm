<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AdmissionForm;
use Illuminate\Support\Facades\DB;
use App\StudentSubs;

class AdmitStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'students:admit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admits students directly from admission forms.';

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
        $adm_forms = AdmissionForm::orderBy('id')->where('final_submission', '=', 'Y')
            ->whereRaw('ifnull(std_id, 0) = 0')
            ->whereHas('course', function ($q) {
                $q->where('course_year', '=', 1);
            });
        $this->info($adm_forms->count());

        $forms = $adm_forms->take(100)->get();
        while ($forms->count() > 0) {
            // $adm_forms->chunk(100, function ($forms) {
            foreach ($forms as $adm_form) {
                $student_det = $adm_form;
                $adm_entry = $student_det->admEntry;

                if (floatval($student_det->std_id) == 0) {
                    $student = new \App\Student();
                    $student->fill($student_det->attributesToArray());
                    $student->adm_date = today();
                    $student->admission_id = $student_det->id;
                    $student->std_type_id = 1;
                    $student->roll_no = $student_det->lastyr_rollno;
                    $student->religion = trim($student_det->religion);
                    $student->adm_entry_id = 0;
                } else {
                    $student = \App\Student::find($student_det->std_id);
                    $student->fill($student_det->attributesToArray());
                }
                $student->adm_source = 'feejunction';
                DB::beginTransaction();
                DB::connection(getYearlyDbConn())->beginTransaction();
                $student->adm_cancelled = 'N';
                $student->save();
                $student_det->status = 'A';
                $student_det->std_id = $student->id;
                $student_det->save();
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

                DB::connection(getYearlyDbConn())->commit();
                DB::commit();
            }
            $forms = $adm_forms->take(100)->get();
        };
    }
}
