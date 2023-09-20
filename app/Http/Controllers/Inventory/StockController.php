<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\Item;
use Illuminate\Support\Facades\Gate;
use App\Inventory\StockLedger;
use Illuminate\Support\Facades\DB;
use App\Location;
use App\Inventory\ItemCategory;
use App\Inventory\ItemSubCategory;

class StockController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('inv-stock-register')) {
            return deny();
        }
        $form_opts = ['method' => 'GET', 'url' => 'stock-register', 'class' => 'form-horizontal'];
        //         $view_name = 'app';
        $data = compact('form_opts');
        if (request()->has('btn-apply') || request()->has('btn-export')) {
            $this->validate($request, [
                'date_from' => 'required|date_format:d-m-Y',
                'date_to' => 'required|date_format:d-m-Y',
                'item_id' => 'nullable|integer|exists:items,id',
                'loc_id' => 'nullable|integer|exists:locations,id',
                'cat_id' => 'nullable|integer|exists:item_categories,id',
                'sub_cat_id' => 'nullable|integer|exists:item_sub_categories,id',
            ]);
        }
        $data += $request->all();
        $dt1 = $request->get('date_from', today());
        $dt2 = $request->get('date_to', today());
        $cat_id = intval($request->get('cat_id', 0));
        $loc_id = intval($request->get('loc_id', 0));
        $sub_cat_id = intval($request->get('sub_cat_id', 0));
        $item_id = intval($request->get('item_id', 0));
        $dt1 = getDateFormat($dt1, 'ymd');
        $dt2 = getDateFormat($dt2, 'ymd');
        if ($request->radio_button == 'Y')
            $loc_id = intval($request->get('store_location_id', 0));
        else
            $loc_id = intval($request->get('loc_id', 0));
        // id, item, unit, it_cat_id, it_sub_cat_id, item_code, remarks, consumable, created_by, updated_by, created_at, updated_at
        $stocks = StockLedger::join('items', 'stock_ledger.item_id', '=', 'items.id')->where('trans_date', '<=', $dt2)
            ->select(
                [
                    'stock_ledger.item_id', 'items.item', 'items.item_code',
                    DB::raw("sum(case when stock_ledger.trans_date < '$dt1' or stock_ledger.trans_type = 'OS' then ifnull(stock_ledger.r_qty,0)-ifnull(stock_ledger.i_qty,0) else 0 end) as opening"),
                    DB::raw("sum(case when stock_ledger.trans_date between '$dt1' and '$dt2' and stock_ledger.trans_type <> 'OS' and stock_ledger.trans_type in ('PU','iss') then ifnull(stock_ledger.r_qty,0) else 0 end) as addition"),
                    DB::raw("sum(case when stock_ledger.trans_date between '$dt1' and '$dt2' and stock_ledger.trans_type <> 'OS' and stock_ledger.trans_type = 'IR' then ifnull(stock_ledger.r_qty,0) else 0 end) as issue_return"),
                    DB::raw("sum(case when stock_ledger.trans_date between '$dt1' and '$dt2' and stock_ledger.trans_type <> 'OS' and stock_ledger.trans_type = 'PR' then ifnull(stock_ledger.i_qty,0) else 0 end) as pur_return"),
                    DB::raw("sum(case when stock_ledger.trans_date between '$dt1' and '$dt2' and stock_ledger.trans_type <> 'OS' and stock_ledger.trans_type in ('ISS','ir') then ifnull(stock_ledger.i_qty,0) else 0 end) as issue"),
                    DB::raw("sum(case when stock_ledger.trans_date between '$dt1' and '$dt2' and stock_ledger.trans_type <> 'OS' and stock_ledger.trans_type = 'DAM' then ifnull(stock_ledger.i_qty,0) else 0 end) as damaged"),
                    DB::raw("sum(ifnull(stock_ledger.r_qty,0)-ifnull(stock_ledger.i_qty,0)) as closing")
                ]
            )->orderBy('items.item')->groupBy(['stock_ledger.item_id', 'items.item', 'items.item_code']);
        if ($cat_id != 0) {
            $stocks = $stocks->where('items.it_cat_id', '=', $cat_id);
        }
        if ($sub_cat_id != 0) {
            $stocks = $stocks->where('items.it_sub_cat_id', '=', $sub_cat_id);
        }
        $stocks = $stocks->where('stock_ledger.store_id', '=', $loc_id);
        if ($item_id != 0) {
            $stocks = $stocks->where('items.id', '=', $item_id);
        }

        $store_ids = getUserStores();
        $stocks = $stocks->whereIn('stock_ledger.store_id', $store_ids);

        $stocks = $stocks->get();
        $dt1 = getDateFormat($dt1, 'dmy');
        $dt2 = getDateFormat($dt2, 'dmy');

        $item = Item::find($item_id);
        if ($item != null) {
            $item = $item->item;
        }
        $item_cat = ItemCategory::find($cat_id);
        if ($item_cat != null) {
            $item_cat = $item_cat->category;
        }
        $item_sub_cat = ItemSubCategory::find($sub_cat_id);
        if ($item_sub_cat != null) {
            $item_sub_cat = $item_sub_cat->category;
        }


        $store = $request->store_location_id;
        $store = Location::find($store);

        if ($store != null) {
            $store = $store->location;
        }
        $location = $request->loc_id;
        $location = Location::find($location);
        if ($location != null) {
            $location = $location->location;
        }

        $stockreg = $stocks;
        $data += compact('stockreg', 'dt1', 'dt2', 'item', 'store', 'location', 'item_cat', 'item_sub_cat');
        //    dd($stockreg);
        //    dd($data);
        return view('inventory.stock.index', $data);
    }

    public function show(Request $request)
    {
        if (Gate::denies('inv-stock-register')) {
            return deny();
        }
        $dt1 = getDateFormat($request->date_from, 'ymd');
        $dt2 = getDateFormat($request->date_to, 'ymd');
        
        // $stockledger = StockLedger::whereItemId($request->item_id)->orderBy('trans_date')->get();
        $stockledger = StockLedger::whereItemId($request->item_id)->whereBetween('trans_date', array($dt1, $dt2))->where('trans_type', '<>', 'OS')->orderBy('trans_date');
        if ($request->loc_id == 0)
            $stockledger = $stockledger->where('store_id', $request->store_id);
        else
            $stockledger = $stockledger->where('store_id', $request->loc_id);
        $stockledger = $stockledger->get();
        $stockledger->load('staff');
        // dd($stockledger);
        $item = $request->item_id;
        $item = Item::find($item);
        if ($item != null) {
            $item = $item->item;
        }
        $store = $request->store_id;
        $store = Location::find($store);

        if ($store != null) {
            $store = $store->location;
        }
        $location = $request->loc_id;
        $location = Location::find($location);
        if ($location != null) {
            $location = $location->location;
        }

        // dd($location);

        // $location = $request->store_id;
        $start_date = $request->date_from;
        $end_date = $request->date_to;
        // $item = Item::where('id',$request->item_id)->get();
        $opqty = $request->op_qty;
        // dd($stockledger);
        $bal = $request->op_qty;
        foreach ($stockledger as $value) {
            $bal += $value->r_qty - $value->i_qty;
            $value->bal = $bal;
        }
        // return view('inventory.stock._item_details', compact('stock', 'item', 'opqty', 'dt1'));
        // if ($request->has('date_from')) {
        //     $dt1 = $stockledger->where('adm_date', '>=', mysqlDate($request->from_date));
        //     dd($dt1);
        // }
        return view('inventory.stock._item_details', compact('stockledger', 'opqty', 'dt1', 'start_date', 'item', 'location', 'store', 'end_date'));
    }
}
