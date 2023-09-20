<?php

namespace App\Jobs;

use App\AlumniStudent;
use App\Mail\SendAlumniBirthdayEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendAlumniBirthday implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data = [];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $dt1 = today();
        $day = getDateSub($dt1, 'D');
        $month_no = getDateSub($dt1, 'M');
        $alumnis = AlumniStudent::where(DB::raw('day(dob)'), '=', $day)->where(DB::raw('month(dob)'), '=', $month_no)
                    ->where('email', '!=', '')
                    ->select(['id', 'email', 'name'])->get();

        config([
            'mail.from.name' => 'Alumni MCM DAV',
            'mail.username' => env('MAIL_USERNAME_ALUMNI', env('MAIL_USERNAME')),
            'mail.password' => env('MAIL_PASSWORD_ALUMNI', env('MAIL_PASSWORD')),
        ]);
            
        // dd($alumnis);
        foreach ($alumnis as $alumni) {
            Mail::to($alumni->email)->send(new SendAlumniBirthdayEmail($alumni->name));
            // Mail::to('suman@infowayindia.com')->send(new SendAlumniBirthdayEmail($alumni->name));
            // break;
        }

        // foreach ($this->data as $val) {
        //     Mail::to($val['email'])->send(new SendAlumniBirthdayEmail($val['name']));
        // }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd($this->data);
    }
}
