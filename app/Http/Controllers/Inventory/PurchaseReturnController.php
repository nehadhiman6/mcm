<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\PurchaseReturn;
use App\Inventory\PurchaseReturnDet;
use Illuminate\Support\Facades\DB;
use Gate;
use App\Inventory\StockLedger;

class PurchaseReturnController extends Controller
{
    protected $purchase = null;

    public function index()
    {
        if (Gate::denies('inv-purchase-return')) {
            return deny();
        }
        $store_ids = getUserStores();

        $purchases = PurchaseReturn::whereIn('store_id', $store_ids)->orderBy('id')->get();
        // $pur_returns->load('departement');
        return view('inventory.pur_return.index', compact('purchases'));
    }


    public function create()
    {
        if (Gate::denies('add-inv-purchase-return')) {
            return deny();
        }

        return view('inventory.pur_return.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-purchase-return')) {
            return deny();
        }
        return $this->saveForm($request, $request->id);
    }


    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $purchase = PurchaseReturn::findOrNew($id);
        $purchase->fill($request->all());
        $this->purchase = $purchase;
        $slgr_ids = [];
        if (intval($id) != 0)
            $slgr_ids = StockLedger::where('trans_type', 'pr')->where('trans_id', $id)->pluck('id')->toArray();
        DB::beginTransaction();
        $purchase->save();
        $this->savePurchaseDetails($request, $purchase->id, $slgr_ids);
        DB::commit();
        $id = $request->id;
        return reply('OK', compact('purchase', 'id'));
    }

    private function validateForm($request, $id)
    {
        $this->validate($request, [
            'trans_dt' => 'required|date_format:"d-m-Y"|before_or_equal:'.today(),
            'vendor_id' => 'required|integer|exists:vendors,id',
            'store_id' => 'required|integer',
            'bill_no' => 'required|string|unique:pur_return,bill_no,' . $id,
            'bill_dt' => 'required|date_format:"d-m-Y"',
            'purchase_det.*.item_id' => 'required|integer|exists:items,id',
            'purchase_det.*.qty' => 'required|numeric',
            'purchase_det.*.rate' => 'required|numeric',
            'purchase_det.*.item_desc' => 'nullable|max:200',
            ],
            [
                'trans_dt*before_or_equal' => 'The trans dt must be a date before or equal to today',
            ]
        );
    }

    private function savePurchaseDetails($request, $id, $slgr_ids)
    {
        $pur_returns = PurchaseReturnDet::wherePurRetId($id);
        $old_pur_det_ids = $pur_returns->pluck('id')->toArray();
        $current_pur_det_ids = [];

        foreach ($request->purchase_det as $data) {
            $pur_det = PurchaseReturnDet::findOrNew($data['id']);
            $pur_det->fill($data);
            $pur_det->pur_ret_id = $id;
            $pur_det->save();
            array_push($current_pur_det_ids, $pur_det->id);

            $part = 'Purchase return to '.$this->purchase->vendor->vendor_name.' for Bill No.'.$request->bill_no.' dated '.$request->bill_dt;

            $fill_arr = [
                'trans_type' => 'pr', 'trans_det_id' => $pur_det->id, 'trans_id' => $id, 'trans_date' => $request->trans_dt,
                'item_id' => $pur_det->item_id, 'i_qty' => $pur_det->qty, 'r_qty' => 0, 'store_id' => $request->store_id, 'loc_id' => 0,
                'part' => $part
            ];
            $arr = getResultModel($slgr_ids, "App\Inventory\StockLedger", $fill_arr);
            $arr[0]->save();
            $slgr_ids = $arr[1];
        }

        $ids_to_be_delete = array_diff($old_pur_det_ids, $current_pur_det_ids);
        if ($ids_to_be_delete != null) {
            PurchaseReturnDet::whereIn('id', $ids_to_be_delete)->delete();
        }
        StockLedger::whereIn('id', $slgr_ids)->delete();
    }

    public function edit($id)
    {
        if (Gate::denies('inv-edit-purchase-return')) {
            return deny();
        }
        $purchase = PurchaseReturn::whereId($id)->get();
        $purchase->load('purchase_dets.item', 'vendor:id,code');
        return view('inventory.pur_return.create', compact('purchase'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-purchase-return')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
