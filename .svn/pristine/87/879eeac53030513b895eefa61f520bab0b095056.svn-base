<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\FeeRcpt;
use App\FeeBillDet;
use Illuminate\Support\Facades\DB;
use App\FeeRcptDet;

class CorrectLateFeeCharges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'latefee:correct';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes late fee charges wrongly debited and collected from the students!!';

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
        $wrong_receipts = FeeRcpt::where('fee_type', '=', 'Centeralized-Installment')
            // ->where('id', '=', 6779)
            ->join(DB::raw('(select fee_rcpt_id,sum(amount-concession) as amt_rec from fee_rcpt_dets where subhead_id in (102, 103, 104) group by 1) frd'), 'fee_rcpts.id', '=', 'frd.fee_rcpt_id')
            ->get();
        // $this->info($wrong_receipts->count());
        // return ;
        $headers = ['id', 'fee_bill_id'];
        foreach ($wrong_receipts as $rec) {
            $diff = $rec->amt_rec;
            $items = FeeBillDet::where('fee_bill_id', '=', $rec->fee_bill_id)
                ->leftJoin(DB::raw('(select fee_bill_dets_id,subhead_id,sum(amount-concession) amt_recd from fee_rcpt_dets group by 1,2) as frd'), function ($q) {
                    $q->on('frd.fee_bill_dets_id', '=', 'fee_bill_dets.id')
                    ->on('frd.subhead_id', '=', 'fee_bill_dets.subhead_id');
                })
                ->whereNotIn('fee_bill_dets.subhead_id', [102, 103, 104])
                ->where(DB::raw('fee_bill_dets.amount-fee_bill_dets.concession'), '>', DB::raw('ifnull(frd.amt_recd,0)'))
                ->select('fee_bill_dets.*', 'frd.amt_recd')
                ->get();
            
            $adjusted = 0;
            foreach ($items as $item) {
                if ($diff > $adjusted) {
                    $d = floatval($item->amount) - floatval($item->amt_recd);
                    $d = $d > ($diff - $adjusted) ? $diff - $adjusted : $d;
                    $r = FeeRcptDet::where('fee_bill_dets_id', '=', $item->id)->get()->first();
                    if ($r) {
                        $r->amount = $r->amount + $d;
                    } else {
                        $r = FeeRcptDet::where('fee_rcpt_id', '=', $rec->id)
                            ->whereIn('subhead_id', [102, 103, 104])->get()->first();
                        $r->fee_bill_dets_id = $item->id;
                        $r->amount = $d;
                        $r->feehead_id = $item->feehead_id;
                        $r->subhead_id = $item->subhead_id;
                        $r->index_no = $item->index_no;
                    }
                    $r->save();
                    $adjusted += $d;
                }
            }
            if ($adjusted > 0) {
                FeeRcptDet::where('fee_rcpt_id', '=', $rec->id)
                    ->whereIn('subhead_id', [102, 103, 104])
                    ->delete();
            }
            if ($diff != $adjusted) {
                $this->info($rec);
            }
            // return ;
        }
    }
}
