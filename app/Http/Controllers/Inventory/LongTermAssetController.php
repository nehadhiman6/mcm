<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\Issue;
use App\Inventory\Purchase;
use App\Inventory\StockLedger;
use Gate;
use Illuminate\Support\Facades\DB;

class LongTermAssetController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('long-term-asset')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('inventory.longtermasset.index');
        }
        // dd($request->all());
        $this->validate($request, [
            'date_from' => 'required|date:"d-m-y"',
            'date_to' => 'required|date:"d-m-y"',
            'item_id' => 'required',
            'store_id' => 'required',

        ]);
        $dtop = getDateAdd($request->date_from, -1);
        $dt1 = getDateFormat($request->date_from, "ymd");
        $dt2 = getDateFormat($request->date_to, "ymd");
        $store_id = $request->store_id;
        $op_qty = StockLedger::where('store_id', $request->store_id)->where('item_id', $request->item_id)
            ->where(function ($cond) use ($dt1) {
                $cond->where('trans_type', '=', 'OS')
                    ->orWhere('trans_date', '<', $dt1);
            })->sum(DB::raw("ifnull(r_qty,0)-ifnull(i_qty,0)"));
        $data = Purchase::join('purchase_dets', 'purchases.id', '=', 'purchase_dets.pur_id')
            ->join('vendors', 'purchases.vendor_id', '=', 'vendors.id')
            ->whereBetween('purchases.trans_dt', [$dt1, $dt2])
            ->where('purchase_dets.item_id', $request->item_id)
            ->where('purchases.store_id', $request->store_id)
            ->select([
                'purchases.trans_dt', 'vendors.vendor_name', 'purchases.bill_no',
                'purchase_dets.qty', DB::raw("'P' as type,'' as iss_from,'' as iss_to,'' as person,0 as qty_iss,'' as remarks")
            ]);

        $iss_data = Issue::join('issue_dets', 'issues.id', '=', 'issue_dets.issue_id')
            ->join('locations', 'issues.store_id', '=', 'locations.id')
            ->join(DB::raw('locations a1'), 'issues.loc_id', '=', 'a1.id')
            ->whereBetween('issues.issue_dt', [$dt1, $dt2])
            ->where('issue_dets.item_id', $request->item_id)
            ->where(function ($cond) use ($store_id) {
                $cond->where('issues.store_id', '=', $store_id)
                    ->orWhere('issues.loc_id', '=', $store_id);
            })
            ->select([
                'issues.issue_dt as trans_dt', DB::raw("'' as vendor_name,'' as bill_no,0 as qty,'I' as type"),
                'locations.location as iss_from', 'a1.location as iss_to', 'issues.person', 'issue_dets.req_qty as qty_iss', 'issues.remarks'
            ]);
        $data = $data->unionAll($iss_data)->orderBy('trans_dt');
        $data = $data->get();
        // trans_date
        // vendors_detail
        // bill_details
        // qty
        // succ_tot
        // iss_from
        // iss_to
        // con_detail
        // qty_issue
        // bal_stock
        // remarks
        // dd($request->all());
        return compact('data', 'dtop', 'op_qty');
    }
}
