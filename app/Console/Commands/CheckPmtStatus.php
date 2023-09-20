<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Payment;

class CheckPmtStatus extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:check {days=7} {--trid=0} {--trcd=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks online payments status.';

    protected $default_hours = 7;

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
        if ($this->option('trid') || $this->option('trcd') != 'false') {
            $payment = $this->option('trid') ? Payment::find($this->option('trid')) : Payment::whereTrcd($this->option('trcd'))->first();
            if ($payment) {
                // $this->info($payment);
                $payment->checkStatus();
            }
            return;
        }

        $now = Carbon::now();
        $start = Carbon::now()->setTime(0, 0, 0);
        // $this->info($this->argument('days'));
        if ($now->diffInHours($start) < $this->default_hours || $this->argument('days') != 7) {
            $dt_from = Carbon::now()->subDays($this->argument('days'))->setTime(0, 0, 0)->format('Y-m-d');
            $dt_to = Carbon::now()->subHours(3)->format('Y-m-d H:i:s');
        } else {
            $dt_from = Carbon::now()->subHours(12)->format('Y-m-d H:i:s');
            $dt_to = Carbon::now()->subHours(3)->format('Y-m-d H:i:s');
        }
        $this->info($dt_from . ' to ' . $dt_to);
        $payments = Payment::where('trntime', '>=', $dt_from)
            ->where('trntime', '<=', $dt_to)
            // ->whereRaw('created_at = updated_at')
            // ->where('id', '=', 3069)
            // ->whereRaw('created_at = updated_at')
            // ->whereRaw("created_at > '2018-01-17'")
            // ->where('ourstatus', '!=', 'NA')
            // ->whereIn('status', ['', 'pending'])
            ->orderBy('id');
        // dd($payments->toSql());
        $this->info($payments->get()->count());
        $payments->chunk(100, function ($trns) {
            foreach ($trns as $payment) {
                // if ($payment->through == 'payu' && $payment->ourstatus != 'NA' && in_array($payment->status, ['', 'pending']) && in_array($payment->unmappedstatus, ['userCancelled', 'dropped']) == false) {
                if ($payment->through == 'payu' && $payment->created_at == $payment->updated_at) {
                    // $this->info($payment->id);
                    $payment->checkStatus();
                }
                if ($payment->through == 'paytm') {
                    $payment->checkStatus();
                }
                if ($payment->through == 'atom') {
                    $payment->checkStatus();
                }
                if ($payment->through == 'sbipay') {
                    $resp = $payment->checkStatus();
                }
            }
            // $this->info('waiting...');
            // sleep(5);
        });
    }
}
