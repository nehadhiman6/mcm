<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Staff;
use Illuminate\Support\Facades\DB;
use Log;

class SendStaffSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $staff_ids;
    protected $msg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($staff_ids, $msg)
    {
        $this->staff_ids = $staff_ids;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $staffs = Staff::whereIn('id', $this->staff_ids)->where(DB::raw('length(mobile)'), '=', 10)->get();
        foreach ($staffs as $staff) {
            Log::info($staff->name);
            // dispatch(new SendSms($this->msg, $staff->mobile));
        }
    }
}
