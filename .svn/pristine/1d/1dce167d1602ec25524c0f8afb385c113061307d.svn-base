<?php

namespace App\Console\Commands;

use App\AdmissionForm;
use App\Jobs\SendSms;
use Illuminate\Console\Command;

class SendSmsToApplicants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:applicants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends sms to PG applicants who have not submitted the admission form or attached documents.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        getYearlyDbConn(true, false);

        $msg = "Dear Applicant, Your form is showing under not- submitted category. Submit your form so that we can start your 
admission process. In case your UG final semester result is pending, fill the result of 5 semesters and submit your form. 
You can upload the scanned copies of original documents when your result is declared by the University- MCMDAVCHD";



        $applicants = AdmissionForm::join('courses','courses.id','=','admission_forms.course_id')
            ->orderBy('admission_forms.course_id')
            ->where(function($q) {
                $q->where('admission_forms.final_submission', '=', 'N')
                ->orWhere('admission_forms.attachment_submission', '=', 'N');
        
            })
            ->where('courses.status', '=', 'PGRAD')
            ->select('admission_forms.*');

        $applicants->chunk(200, function($students) use ($msg) {

            $this->info($students->count());

            foreach ($students as $std) {
                logger($std->mobile . ' - ' . $msg);
                dispatch(new SendSms($msg, $std->mobile, "1207165919476981291"));
                logger("Roll No.: {$std->roll_no}, Name: {$std->name}, Course: {$std->course->course_name}");
                // break;
            }
            $this->info('completed chunk');

        });
    }
}
