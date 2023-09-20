<?php

namespace App\Console\Commands;

use App\AdmissionEntry;
use App\Jobs\SendSms;
use Illuminate\Console\Command;
use Log;

class SendMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send messages to students!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // getYearlyDbConn(true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $course_ids = [4,11,17,18,38,41,47];
        getYearlyDbConn(true);
        $courses = \App\Course::orderBy('id', 'desc')
            // where('final_year', '=', 'Y')
            ->where('course_year', '=', 1)
            ->where('status', '=', 'GRAD')
            // ->where('id', '!=', 4)
            // ->where('id', '=', 25)
            // ->whereIn('id', $course_ids)
            ->get();

        // $adm_entries = AdmissionEntry::leftJoin('students', 'students.admission_id', '=', 'admission_entries.admission_id')
        //     ->whereNull('students.id')
        //     ->where('admission_entries.id', '<', 423)
        //     ->where('admission_entries.valid_till', '>', '2020-08-05')
        //     ->select('admission_entries.*');

        // $msg = "Dear Student, You are requested to fill the registration form at www.pgexam.puchd.ac.in. For any inquiry, contact Exam Branch of the College office";
        // $msg = "Registered at www.nad.ndml.in latest by 14Th April, 2020 " .
        //     "i) New Registration iii) enter personal details iii) upload photograph/signature iv) enter current recent pass details iv) create a User ID & Password and verify after entering OTP without Aadhar Card and send acknowledgement copy to  mcmadmissions@gmail.com, MCM DAV College for Women, mentioning your College Roll No._____ Batch _____ " .
        //     "For Assistant contact - 9781666786'";
//         $msg = "The Alumni Association of College, AMDA, wishes to donate to Director-PGI Private Grant Account for safety of doctors in this fight against Covid-19. Small contributions from the youth will be meaningful and go a long way in helping the cause.
        // Online Payment Procedure:
        // Name of the account: The Principal MCM DAV College for Women, (Alumni Fund) Account
        // State Bank of India
        // Account Number: 36048529385
        // IFSC Code: SBIN0010609";

//         $msg = "Final Year Students of U.G./P.G. who want to opt for regional examination centres AT i.e. Hoshiarpur, Ludhiana, Moga,
        // Ferozepur, Muktsar, Fazilka and Abohar to fill their details in form provided on http://admissions.mcmdav.com/regional-centres/create by 28.06.2020
        // positively, for details check notice on college website.";

        $msg = "Attention final year students!! Download your admit card from daily announcements section in college website or follow link 
https://mcmdavcwchd.edu.in/news/admit-cards-for-final-year-examinations-september-2020/. For any query, kindly contact Mr. 
Vikas Sharma (9781666786)";

        $msg = "Pay your PU December Examination fee on your student login (pay college dues) before 11-11-2020";

        $msg = "Pay your PU December Examination fee on your student login (pay college dues) before 11-11-2020. Ignore this message if you are not a MCM student in 2020-21 session.";

        $msg = "This is for the information of all the students of First Year (B.A, B.Sc, B.Sc MFT,  BBA, B.Com and BBA-I) that their Registration Return has been displayed at College website https://mcmdavcwchd.edu.in/  if any correction in name, attach 10+2 certificate, do mention your working contact number also and drop Whatsapp message too (Vikas Sharma – 9781666786) (10.00 a.m. to 1.00 p.m.)";
        $msg = "Corrections pointed out by you in Registration Return 2020-21 has been rectified, this is final report. Kindly check carefully (Subjets, Names),  if your name is not in list Kindly Call Vikas Sharma 9781666786. Check college website https://mcmdavcwchd.edu.in";
        
        $msg = "Check particulars at https://mcmdavcwchd.edu.in/ (daily announcements) and if any correction requires or name/roll no. missing in the list then drop message (Whatsapp only) 9781666786 (before 11.00 a.m. (17th November 2020) Thereafter No change will be entertained). Mobile No. change will not be entertained.";

        $msg = "Regular PG Students to fill up their 2nd/4th Semester Examination form At http://pgexam.puchd.ac.in/
Do fill your correct Course/ Subjects   :  Masters of  Arts  - English, Economics, Hindi, Sociology, Psychology
M.Sc Mathematics/ Chemistry
M.Com
Don’t fill M.A Education
Do fill correct College Name i.e. MCM DAV College for Women";

        $msg = "Dear Applicant, kindly fill the Online College Admission Form as per the instructions (Step 2) given here: https://mcmdavcwchd.edu.in/centralized-admission-procedure/ within 3 days of paying your admission fee- MCMDAVCW";

        $msg = "Dear student, pay your examination fee for 1st/3rd/5th semester examination online through college website www.admissions.mcmdav.com/stulogin (pay on college dues) before 20/10/2021-MCMDAVCHD";

        $msg = "First Year students to check their particulars i.e. Name, Father's/Mother's Name, Board Name, 12th Roll No., subjects : https://mcmdavcwchd.edu.in/daily-announcements-2/. if any change in subjects etc. intimate : 9781666786 (9.30 a.m. to 11.30 a.m.) latest by 05.11.2021. Thereafter NO correction will not be entertained- MCMDAVCHD";

        $msg = "Dear Student, please check your Father's/Mother's Name/10+2 Roll No/Board Name/ 12th Result/Subjects Studying in  MCM DAV College for Women (Presently). If any correction, message to 9781666786 mentioning your College Roll No.-MCMDAV";

        // $msg = "Pay your PU December Semester Examination fee before 17-11-2020, after that college will not be responsible for any late fees";

        // dispatch(new SendSms($msg, 9216800973, "1207166636937082897"));
        // dispatch(new SendSms($msg, 9216561087, "1207166636937082897"));
        
        // return;

        foreach ($courses as $course) {
            $course->students()
                ->where('removed', '=', 'N')
                ->where('adm_cancelled', '=', 'N')
                ->orderBy('id')
                // ->where('roll_no', '=', '8544')
                ->chunk(200, function ($students) use ($msg) {
                    $this->info($students->count());
                    foreach ($students as $std) {
                        logger($std->mobile . ' - ' . $msg);
                        dispatch(new SendSms($msg, $std->mobile, "1207166636937082897"));
                        // logger("Roll No.: {$std->roll_no}, Name: {$std->name}, Course: {$std->course->course_name}");
                    }
                    $this->info('completed chunk');
                });
        }

        // foreach ($courses as $course) {
        //     $course->adm_forms()
        //         ->where('final_submission', '=', 'N')
        //         // ->where('adm_cancelled', '=', 'N')
        //         ->orderBy('id')
        //         // ->where('roll_no', '=', '8544')
        //         ->chunk(100, function ($students) use ($msg) {
        //             $this->info($students->count());
        //             foreach ($students as $std) {
        //                 if ($std->admEntry) {
        //                     logger($std->mobile);
        //                     dispatch(new SendSms($msg, $std->mobile, "1207163048773083074"));
        //                     // logger("Roll No.: {$std->roll_no}, Name: {$std->name}, Course: {$std->course->course_name}");
        //                 }
        //             }
        //             $this->info('completed chunk');
        //         });
        // }

        // $adm_entries->chunk(50, function ($aes) {
        //     foreach ($aes as $ae) {
        //         $adm_form = $ae->admForm;
        //         $std_user = $adm_form->std_user;
        //         $msg = "Dear Applicant , pay your admission fee online till 12:00 midnight " . $ae->valid_till . " by going to url https://admissions.mcmdav.com/payadmfees/create";
        //         if (strlen(trim($std_user->initial_password)) > 0) {
        //             // $msg .= " Login Credentials - Email: {$std_user->email}, Password: {$std_user->initial_password}";
        //             $msg .= " using Login Credentials - Email: {$std_user->email}, Password: {$std_user->initial_password}";
        //         }
        //         $msg .= ", Online Form No: {$adm_form->id})";
    
        //         logger($msg);
        //     }
        // });
    }
}
