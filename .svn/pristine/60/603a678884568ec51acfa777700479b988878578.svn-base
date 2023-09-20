<?php

namespace App\Listeners;

use App\Events\PaymentInitiated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Jobs\CheckPmtStatus;
use Carbon\Carbon;

class QueuePmtStatus
{
    public $timeout = 15;  //Minutes
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->timeout = config('college.payment_trn_wait', 1);
    }

    /**
     * Handle the event.
     *
     * @param  PaymentInitiated  $event
     * @return void
     */
    public function handle(PaymentInitiated $event)
    {
        $trans = $event->trans;
        if ($trans) {
            $job = (new CheckPmtStatus($trans))->delay(Carbon::now()->addMinutes($this->timeout));
            dispatch($job);
        }
        Log::info('----------Event Fired----------');
    }
}
