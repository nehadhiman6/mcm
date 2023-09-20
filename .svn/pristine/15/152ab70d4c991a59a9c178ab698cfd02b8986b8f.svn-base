<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Payment;
use Carbon\Carbon;

class CheckPendingFromBank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check payments pending from bank.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        getYearlyDbConn(true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $payments = Payment::where('status', 'like', '%pend%')
            ->where('created_at', '<', Carbon::now()->format('Y-m-d'))
            ->orderBy('id');
        // dd($payments->toSql());
        // $this->info($payments->count());
        $this->info($payments->get()->count());
        // return;
        $payments->chunk(50, function ($trns) {
            foreach ($trns as $payment) {
                $payment->checkStatus(false, false, false);
                sleep(2);
            }
        });
    }
}
