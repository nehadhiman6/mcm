<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\Purchase;
use App\Inventory\PurchaseDet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Inventory\StockLedger;
use Auth;
use App\Location;

class PurchaseController extends Controller
{
    protected $purchase = null;

    public function index()
    {
        if (Gate::denies('inv-purchase')) {
            return deny();
        }

        $purchases = Purchase::orderBy('id', 'desc');

        $store_ids = getUserStores();
        $purchases = $purchases->whereIn('store_id', $store_ids);

        $purchases = $purchases->get();

        // $purchases->load('locations');
        return view('inventory.purchase.index', compact('purchases'));
    }


    public function create()
    {
        if (Gate::denies('add-inv-purchase')) {
            return deny();
        }

        return view('inventory.purchase.create');
    }


    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-purchase')) {
            return deny();
        }
        return $this->saveForm($request, $request->id);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $purchase = Purchase::findOrNew($id);
        $purchase->fill($request->all());
        $this->purchase = $purchase;
        $slgr_ids = [];
        if (intval($id) != 0)
            $slgr_ids = StockLedger::where('trans_type', 'pu')->where('trans_id', $id)->pluck('id')->toArray();
        DB::beginTransaction();
        $purchase->save();
        $this->savePurchaseDetails($request, $purchase->id, $slgr_ids);
        // $this->saveStockLedgerEntry($request, $purchase->id);
        DB::commit();
        $prchase_id = $request->id;
        return reply('OK', compact('purchase', 'prchase_id'));
    }

    private function validateForm($request, $id)
    {
        $this->validate(
            $request,
            [
                'trans_dt' => 'required|date_format:"d-m-Y"|before_or_equal:'.today(),
                'store_id' => 'required|integer',
                'grant' => 'required',
                'vendor_id' => 'required|integer|exists:vendors,id',
                'bill_no' => 'required|string',
                'bill_dt' => 'required|date_format:"d-m-Y"',
                'purchase_det.*.item_id' => 'required|integer|exists:items,id',
                'purchase_det.*.qty' => 'required|numeric',
                'purchase_det.*.rate' => 'required|numeric',
                'purchase_det.*.item_desc' => 'nullable|max:200',
            ],
            [
                'store_id' => 'Store Location Is Required',
                'trans_dt*before_or_equal' => 'The trans dt must be a date before or equal to today',
            ]
        );
    }

    private function savePurchaseDetails($request, $id, $slgr_ids)
    {
        $purchase = PurchaseDet::wherePurId($id);
        $old_pur_det_ids = $purchase->pluck('id')->toArray();
        $current_pur_det_ids = [];
        foreach ($request->purchase_det as $data) {
            $pur_det = PurchaseDet::findOrNew($data['id']);
            $pur_det->fill($data);
            $pur_det->pur_id = $id;
            $pur_det->save();
            array_push($current_pur_det_ids, $pur_det->id);

            $part = 'Purchase from ' . $this->purchase->vendor->vendor_name . ' via Bill No.' . $request->bill_no . ' dated ' . $request->bill_dt;

            $fill_arr = [
                'trans_type' => 'pu', 'trans_det_id' => $pur_det->id, 'trans_id' => $id, 'trans_date' => $request->trans_dt,
                'item_id' => $pur_det->item_id, 'r_qty' => $pur_det->qty, 'i_qty' => 0, 'store_id' => $request->store_id, 'loc_id' => 0,
                'part' => $part
            ];
            // dd('rahul',$fill_arr);
            $arr = getResultModel($slgr_ids, "App\Inventory\StockLedger", $fill_arr);
            $arr[0]->save();
            // $sl->save();
            $slgr_ids = $arr[1];
        }
        $ids_to_be_delete = array_diff($old_pur_det_ids, $current_pur_det_ids);
        if ($ids_to_be_delete != null) {
            PurchaseDet::whereIn('id', $ids_to_be_delete)->delete();
        }
        StockLedger::whereIn('id', $slgr_ids)->delete();
    }

    public function edit($id)
    {
        if (Gate::denies('inv-edit-purchase')) {
            return deny();
        }
        $purchase = Purchase::whereId($id)->get();
        // dd($purchase);
        $purchase->load('purchase_dets.item', 'vendor:id,code');
        return view('inventory.purchase.create', compact('purchase'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-purchase')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }

    // private function getstore(){
    //     $locs =  Location::where("operated_by", Auth::user()->id )->get();
    //     return reply('OK', compact('locs'));
    // }
}
