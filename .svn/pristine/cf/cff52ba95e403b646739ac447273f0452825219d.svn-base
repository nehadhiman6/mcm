<?php

namespace App\Console\Commands;

use App\AdmissionEntry;
use App\AdmissionForm;
use App\Mail\Notification;
use App\StudentUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails to students.';

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

        $entries = AdmissionEntry::join('admission_forms', 'admission_entries.id', '=', 'admission_forms.adm_entry_id')
            // ->whereNotIn('admission_entries.id', function($q) {
            //     $q->from('students')->select('adm_entry_id');
            // })
            ->where('admission_forms.status', '=', 'N')
            ->select('admission_entries.*', 'admission_forms.std_user_id', 'admission_forms.id as adm_form_id')
            ->chunk(100, function($adm_entries) {
                foreach($adm_entries as $adm_entry) {

                    $std_user = StudentUser::find($adm_entry->std_user_id);

                    $msg = "Dear Applicant, kindly pay your MCM DAV CW admission fee online till mid night " . $adm_entry->valid_till . " by opening the url https://admissions.mcmdav.com/payadmfees/create ";
                    $msg .= "using Login Credentials -Email : {$std_user->email}, Password: {$std_user->initial_password}";
                    $msg .= ", Online Form No: {$adm_entry->adm_form_id})";


                    $this->info($msg);


                    Mail::to($std_user)->queue(new Notification($msg));

                }
       
            });

        // $this->info($students->count());


    }
}
