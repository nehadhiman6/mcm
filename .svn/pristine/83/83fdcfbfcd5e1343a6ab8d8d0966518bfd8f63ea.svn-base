<?php

namespace App\Jobs;

use App\AlumniStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class SendAlumniRegSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // protected $alumni_ids;
    protected $msg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
        // $this->alumni_ids = $alumni_ids;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stds = AlumniStudent::where('id', '!=', 0)
            ->where('alumni_user_id', '=', 0)
            ->whereIn('passout_year', ['2015', '2016', '2017', '2018', '2019'])
            ->whereNull('reg_code')
            ->where(DB::raw('length(mobile)'), '=', 10)
            ->get();

        logger("====== SMS Count " . $stds->count() . " =========");
        // return;

        foreach ($stds as $std) {
            // Log::info($this->msg.$std->name);
            $std->reg_code = str_random(25);
            $std->save();
            $this->msg = "Dear Alumna, Kindly click on this link " . url('alumniregister') . "?reg_code={$std->reg_code}" . " and submit a few details of yours. If you are registering " .
                "for the first time, remember the password you would create. If already registered, please check and update the information. This data " .
                "is crucial for the college for the purpose of ranking also. Thank you. - MCM DAV";
            dispatch(new SendSms($this->msg, $std->mobile));
        }
    }
}
