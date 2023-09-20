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

class SendCourseStudentsSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $course_id;
    protected $msg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($course_id, $msg)
    {
        $this->course_id = $course_id;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stds = Student::existing()->notRemoved()->where('course_id', '=', $this->course_id)->where(DB::raw('length(mobile)'), '=', 10)->get();
        foreach ($stds as $std) {
            // Log::info($this->msg.' To '.$std->name);
            dispatch(new SendSms($this->msg, $std->mobile));
        }
    }
}
