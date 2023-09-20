<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $msg;
    protected $mobile;
    protected $template_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($msg, $mobile, $template_id = "")
    {
        $this->msg = $msg;
        $this->mobile = $mobile;
        $this->template_id = $template_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sendSms($this->msg, $this->mobile, $this->template_id);
    }
}
