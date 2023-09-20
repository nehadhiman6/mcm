<?php

namespace App\Console;

use App\Console\Commands\SendAlumniMessages;
use App\Console\Commands\SendSmsToApplicants;
use App\Console\Commands\SendSmsToUGApplicants;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    Commands\CheckPmtStatus::class,
    //   Commands\CheckSubjects::class,
    Commands\ChangeImagesNames::class,
    Commands\UpdtImages::class,
    //   Commands\CorrectLateFeeCharges::class,
    Commands\SendMessages::class,
    SendAlumniMessages::class,
    //   Commands\CorrectPaymentIds::class,
    SendSmsToApplicants::class,
    SendSmsToUGApplicants::class,
    Commands\CorrectSections::class,
    Commands\SendPendBalSMS::class,
    Commands\ImportPupinData::class,
    Commands\AddPermissions::class,
    Commands\AddOnlineReceipts::class,
    Commands\AddSubjects::class,
    Commands\AdmitStudents::class,
    Commands\RectifySubject::class,
    Commands\AddExamFees::class,
    Commands\AddExamFeesForAddOnSubject::class,
    Commands\AddExamFeeForBA1::class,
    Commands\CheckPendingFromBank::class,
    Commands\CopyIDcardImages::class,
    Commands\SendAlumniBirthdayMail::class,
    Commands\CopyDataFromAdmForms::class,
    Commands\SendEmails::class,


  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    // $schedule->command('inspire')
    //          ->hourly();
  }

  /**
   * Register the Closure based commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    require base_path('routes/console.php');
  }
}
