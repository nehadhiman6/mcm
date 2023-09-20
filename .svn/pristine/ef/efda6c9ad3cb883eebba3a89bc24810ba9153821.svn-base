<?php

namespace App\Console\Commands;

use App\AdmissionForm;
use Illuminate\Console\Command;

class CopyDataFromAdmForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:admformdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command copies data from admission_form table to students table ';

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

        $applicants = AdmissionForm::orderBy('admission_forms.id')
            ->where('admission_forms.final_submission', '=', 'Y')
            ->whereIn('admission_forms.course_id',[4,11,17,18,38,41,47])
            ->select('admission_forms.*');

        $applicants->chunk(200, function($students) {

            $this->info($students->count());

            foreach ($students as $adm_form) {
                // logger("Roll No.: {$adm_form->roll_no}, Name: {$adm_form->name}, Course: {$adm_form->course->course_name}");
                if ($adm_form->std_id != 0 && $adm_form->status == 'A') {
                    $student = $adm_form->student;
                    $student->per_address = $adm_form->per_address;
                    $student->city = $adm_form->city;
                    $student->blood_grp = $adm_form->blood_grp;
                    $student->minority = $adm_form->minority;
                    $student->religion = $adm_form->religion;
                    $student->other_religion = $adm_form->other_religion;
                    $student->geo_cat = $adm_form->geo_cat;
                    // $student->nationality = $adm_form->nationality;
                    $student->name = $adm_form->name;
                    $student->mobile = $adm_form->mobile;
                    $student->aadhar_no = $adm_form->aadhar_no;
                    $student->epic_no = $adm_form->epic_no;
                    $student->gender = $adm_form->gender;
                    $student->father_name = $adm_form->father_name;
                    $student->mother_name = $adm_form->mother_name;
                    $student->guardian_name = $adm_form->guardian_name;
                    $student->dob = $adm_form->dob;
                    $student->migration = $adm_form->migration;
                    $student->hostel = $adm_form->hostel;
                    $student->per_address = $adm_form->per_address;
                    $student->city = $adm_form->city;
                    $student->state_id = $adm_form->state_id;
                    $student->pincode = $adm_form->pincode;
                    $student->same_address = $adm_form->same_address;
                    $student->corr_address = $adm_form->corr_address;
                    $student->corr_city = $adm_form->corr_city;
                    $student->corr_state_id = $adm_form->corr_state_id;
                    $student->corr_pincode = $adm_form->corr_pincode;
                    $student->father_occup = $adm_form->father_occup;
                    $student->father_desig = $adm_form->father_desig;
                    $student->father_phone = $adm_form->father_phone;
                    $student->father_mobile = $adm_form->father_mobile;
                    $student->f_office_addr = $adm_form->f_office_addr;
                    $student->f_office_addr = $adm_form->f_office_addr;
        
                    $student->father_email = $adm_form->father_email;
                    $student->mother_occup = $adm_form->mother_occup;
                    $student->mother_desig = $adm_form->mother_desig;
                    $student->mother_phone = $adm_form->mother_phone;
                    $student->mother_mobile = $adm_form->mother_mobile;
                    $student->mother_email = $adm_form->mother_email;
                    $student->m_office_addr = $adm_form->m_office_addr;
                    $student->guardian_occup = $adm_form->guardian_occup;
                    $student->guardian_desig = $adm_form->guardian_desig;
                    $student->guardian_phone = $adm_form->guardian_phone;
                    $student->guardian_mobile = $adm_form->guardian_mobile;
                    $student->guardian_email = $adm_form->guardian_email;
                    $student->g_office_addr = $adm_form->g_office_addr;
                    $student->annual_income = $adm_form->annual_income;
                    $student->pu_regno = $adm_form->pu_regno;
                    $student->pu_regno2 = $adm_form->pu_regno2;
                    $student->pupin_no = $adm_form->pupin_no;
                    $student->org_migrate = $adm_form->org_migrate;
                    $student->migrated = $adm_form->migrated;
                    $student->migrate_detail = $adm_form->migrate_detail;
                    $student->disqualified = $adm_form->disqualified;
                    $student->disqualify_detail = $adm_form->disqualify_detail;
                    $student->sports = $adm_form->sports;
                    $student->cultural = $adm_form->cultural;
                    $student->academic = $adm_form->academic;
                    $student->foreign_national = $adm_form->foreign_national;
                    $student->f_nationality = $adm_form->f_nationality;
                    $student->foreign_national = $adm_form->foreign_national;
                    $student->passportno = $adm_form->passportno;
                    $student->visa = $adm_form->visa;
                    $student->res_permit = $adm_form->res_permit;
                    $student->update();
                }
                $adm_form->update();
            }
                // break;
            $this->info('completed chunk');

        });
    }
}
