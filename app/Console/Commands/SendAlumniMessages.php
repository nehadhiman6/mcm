<?php

namespace App\Console\Commands;

use App\AlumniStudent;
use App\Jobs\SendSms;
use Illuminate\Console\Command;

class SendAlumniMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:alumni';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $msg = "The Alumni Association of College, AMDA, wishes to donate to Director-PGI Private Grant Account for safety of doctors in this fight against Covid-19. Small contributions from the youth will be meaningful and go a long way in helping the cause.
Online Payment Procedure:
Name of the account: The Principal MCM DAV College for Women, (Alumni Fund) Account
State Bank of India
Account Number: 36048529385
IFSC Code: SBIN0010609";

        // $msg = "The Alumni Association of College, AMDA";
        // dispatch(new SendSms($msg, 9216800973));
        // dispatch(new SendSms($msg, 9216561087));
        // return;

        $alumni = AlumniStudent::orderBy('id')
            ->chunk(100, function ($students) use ($msg) {
                $this->info($students->count());
                foreach ($students as $std) {
                    // $a = $sms->send($msg, '9216800973');

                    // $a = $sms->send($msg, $std->mobile);
                    // Log::info($a);
                    // dispatch(new SendSms($msg, 9216561087));
                    // dispatch(new SendSms($msg, 9216800973));
                    // return;
                    dispatch(new SendSms($msg, $std->mobile));
                    // $this->info()
                    // logger($std);
                }
                $this->info('completed chunk');
            });
    }
}
