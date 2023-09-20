<?php

namespace App\Console\Commands;

use App\Jobs\SendSms;
use Illuminate\Console\Command;
use App\Student;
use Illuminate\Support\Facades\Log;

class SendPendBalSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:pend_bal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send messages to students who have pending balance.';

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
        getYearlyDbConn(true);
        $sms = new \App\Lib\Sms();

        $sggsHostel = [
            'institution' => 'sggs',
            'fund_type' => 'H',
            'course_id' => 0
        ];

        $sggsCollege = [
            'institution' => 'sggs',
            'fund_type' => 'C',
            'course_id' => 0
        ];

        $otherHostel = ['institution' => 'others'];

        $students = Student::havingPendBal($sggsCollege);
        $this->info($students->count());

        // $msg = "Dear Student, deposit fee before 05/10/2018 midnight otherwise site will be closed and you have to pay exam fee in PU with late fee. - MCM 36, CHD";
        // $msg = "Deposit your PU exam fee latest by 23-02-2020, otherwise, the college will not be responsible. If you already deposited the fee then contact the accounts branch";
        // $msg = "Deposit your PU exam fee latest by 15-02-2020, otherwise, the college will not be responsible.";
        // $msg = "Pay your hostel balance fee latest by 12-11-2019";
        // $msg = "Pay your hostel balance fee latest by 25-11-2019 otherwise your admit card will be held and not given";
        // $msg = "Online payment on student portal is closed now. Deposit your exam. fee at PU fee counter and deposit fee receipt in the college immediately";
        // $a = $sms->send($msg, '9216800973');
        // $a = $sms->send($msg, $std->mobile);
        // $msg = "Pay your PU examination fee before 22-11-2020 after that college will not be responsible for any late fee. Ignore if already paid.";

        $msg = "Dear Student. This is to remindthe students of semester 2,4 and 6 who haven't paid their University examination fees. Kindly pay the same soon. The last date for paying the fee dues is 21/05/2021.In case of non payment of the fees college won't be responsible for any reason.(only for regular students)- MCMDAVCHD";
        $msg = "Dear student, pay your examination fee for 1st/3rd/5th semester examination online through college website www.admissions.mcmdav.com/stulogin (pay on college dues) before 20/11/2021-MCMDAVCHD";
        $msg = "All regular students of the college are advised to deposit the examination fee from 11/03/2022 to 30/03/2022 for Panjab University Semester Examinations going to be held in June/July 2022. Pay the fee on MCM student dashboard- MCMDAVCHD";

        // dispatch(new SendSms($msg, '9216561087', "1207163342537267330"));
        // return;

        foreach ($students as $std) {
            // dispatch(new SendSms($msg, $std->mobile, "1207163342537267330"));
            dispatch(new SendSms($msg, $std->mobile, "1207164653812695417"));
            Log::info($msg);
            Log::info($std->mobile);
            // break;
            // return;
        }
    }
}
