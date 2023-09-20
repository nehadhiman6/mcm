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

class SendSelectedStaffSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $type;
    protected $source;
    protected $msg;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $source, $msg)
    {
        $this->type = $type;
        $this->source = $source;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $staffs = Staff::whereType($this->type)->whereSource($this->source)->where(DB::raw('length(mobile)'), '=', 10)->get();
        foreach ($staffs as $staff) {
            Log::info('======================'.$staff->name.'===============================');
            // dispatch(new SendSms($this->msg, $staff->mobile));
        }
    }
}
