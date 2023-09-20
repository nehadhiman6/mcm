<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Student;
use Illuminate\Support\Facades\DB;
use log;

class SendStudentsSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $std_ids;
    protected $msg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($std_ids, $msg)
    {
        $this->std_ids = $std_ids;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stds = Student::whereIn('id', $this->std_ids)->where(DB::raw('length(mobile)'), '=', 10)->get();
        foreach ($stds as $std) {
            // Log::info($this->msg.$std->name);
            dispatch(new SendSms($this->msg, $std->mobile));
        }
    }
}
