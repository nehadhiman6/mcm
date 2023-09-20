<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Payment;
use Log;

class CorrectPaymentIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:correct_ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Correct payment ids';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $qryurl = config("college.payu.qryurl");
        $key = config('college.payu.key');
        $client = new \GuzzleHttp\Client();
        Payment::where('status', '=', 'success')
            // ->where('created_at', '>', '2018-02-03')
            ->orderBy('id')->chunk(50, function ($trns) use ($client, $qryurl, $key) {
                $trcds = implode('|', $trns->pluck('trcd')->toArray());
                $response = $client->post($qryurl, [
                    'form_params' => [
                        'merchantKey' => $key,
                        'merchantTransactionIds' => $trcds,
                    ],
                    'headers' => [
                        'authorization' => config('college.payu.auth_header'),
                        'cache-control' => 'no-cache'
                    ]
                ]);
                $data = json_decode($response->getBody()->getContents(), true);
                // dd($data);
                $result = data_get($data, 'result');
                foreach ($result as $r) {
                    // Log::info($r);
                    if (data_get($r, 'postBackParam.status', 'failed') == 'success') {
                        $trcd = data_get($r, 'postBackParam.txnid');
                        $payment = Payment::whereTrcd($trcd)->first();
                        Log::info($payment);
                        $trid = data_get($r, 'postBackParam.payuMoneyId', '');
                        if ($payment && strlen($trid) > 0 && $payment->trid != $trid) {
                            $payment->trid =  $trid;
                            $payment->save();
                            Log::info('Payu Id: ' . $trid);
                            Log::info('Payment Id: ' . $payment->trid);
                            Log::info('-----------------------------------------------------------');
                        }
                    }
                    Log::info('-------------Record Processed------------------');
                }
                $this->info('Prcocessed 50 resords');
                // dd($data);
            });
    }
}
