<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Payment;
use Illuminate\Support\Facades\Log;

class AddOnlineReceipts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'online:receipts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create receipts for online transactions.';

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
        $trns = Payment::where('ourstatus', '=', 'OK')
            ->whereIn('trn_type', ['admission_fee', 'direct_college_receipt'])
            // ->where('id', '>', 101790)
            ->orderBy('id');

        logger('---------------------------- running addOnlineReceipts Job with ' . $trns->count() . ' ----------------------------------------');

        // dd($trns->first());
        $trns->chunk(50, function ($payments) {
            foreach ($payments as $trn) {
                try {
                    $trn->addReceipt();
                    // $trn->save();
                } catch (\Exception $e) {
                    Log::info("----------------- AddOnlineReceipts - Trcd: {$trn->trcd} --------------------------");
                    Log::info($e->getMessage());
                }
            }
        });
    }
}
