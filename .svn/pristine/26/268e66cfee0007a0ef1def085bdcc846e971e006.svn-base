<?php

namespace App\Console\Commands;

use App\AdmissionForm;
use App\Jobs\SendSms;
use Illuminate\Console\Command;

class SendSmsToUGApplicants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:ugapplicants';

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

        $msg = "Dear Applicant, Your form is showing under not- submitted category. Submit your form so that we can start your admission 
process. In case any of your document like 12th DMC or character certificate is pending you can upload a self attested copy of DMC 
downloaded from the Board and attach the scanned copies of original documents by 15/08/2022- MCMDAVCHD";

        $msg = "Dear Applicant, Your form is showing under not- submitted category. Submit your form so that we can start your admission process. In case any of your document like 12th DMC or character certificate is pending you can upload a self attested copy of DMC downloaded from the Board and attach the scanned copies of original documents by 15/08/2022- MCMDAVCHD";

        $applicants = AdmissionForm::join('courses','courses.id','=','admission_forms.course_id')
            ->orderBy('admission_forms.course_id')
            ->where(function($q) {
                $q->where('admission_forms.final_submission', '=', 'N')
                ->orWhere('admission_forms.attachment_submission', '=', 'N');
        
            })
            ->where('courses.status', '=', 'GRAD')
            ->select('admission_forms.*');

        $applicants->chunk(200, function($students) use ($msg) {

            $this->info($students->count());

            foreach ($students as $std) {
                logger($std->mobile . ' - ' . $msg);
                dispatch(new SendSms($msg, $std->mobile, "1207165919073920495"));
                logger("Roll No.: {$std->roll_no}, Name: {$std->name}, Course: {$std->course->course_name}");
                break;
            }
            $this->info('completed chunk');

        });
    }
}
