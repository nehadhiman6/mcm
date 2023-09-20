<?php

namespace App\Jobs;

use App\Alumani;
use App\AlumniStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class SendAlumniSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $alumni_ids;
    protected $msg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($alumni_ids, $msg)
    {
        $this->alumni_ids = $alumni_ids;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stds = AlumniStudent::whereIn('id', $this->alumni_ids)->where(DB::raw('length(mobile)'), '=', 10)->get();
        foreach ($stds as $std) {
            // Log::info($this->msg.$std->name);
            dispatch(new SendSms($this->msg, $std->mobile));
        }
    }
}
