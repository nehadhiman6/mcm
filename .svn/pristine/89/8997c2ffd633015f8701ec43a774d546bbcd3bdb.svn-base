<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\InvReturn;
use App\Inventory\InvReturnDet;
use Illuminate\Support\Facades\DB;
use Gate;
use App\Inventory\StockLedger;

class ReturnController extends Controller
{
    protected $ret = null;
    public function index()
    {
        if (Gate::denies('inv-return')) {
            return deny();
        }
        $store_ids = getUserStores();
        $rets = InvReturn::whereIn('store_id', $store_ids)->orderBy('id')->get()->load('location', 'staff');
        return view('inventory.inv_return.index', compact('rets'));
    }


    public function create()
    {
        if (Gate::denies('add-inv-return')) {
            return deny();
        }

        return view('inventory.inv_return.create');
    }


    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-return')) {
            return deny();
        }
        return $this->saveForm($request, $request->id);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $ret = InvReturn::findOrNew($id);
        $ret->fill($request->all());
        $this->ret = $ret;
        $slgr_ids = [];
        if (intval($id) != 0)
            $slgr_ids = StockLedger::where('trans_type', 'ir')->where('trans_id', $id)->pluck('id')->toArray();
        DB::beginTransaction();
        $ret->save();
        $this->saveretDetails($request, $ret->id, $slgr_ids);
        DB::commit();
        $id = $request->id;
        return reply('OK', compact('ret', 'id'));
    }

    private function validateForm($request, $id)
    {
        $this->validate($request, [
            'trans_dt' => 'required|date_format:"d-m-Y"|before_or_equal:'.today(),
            'loc_id' => 'required|integer|exists:locations,id',
            'store_id' => 'required|integer|exists:locations,id',
            'remarks' => 'nullable|string|max:250',
            'ret_det.*.item_id' => 'required|integer|exists:items,id',
            'ret_det.*.qty' => 'required|numeric',
            'ret_det.*.item_desc' => 'nullable|max:200',
        ],
            [
                'trans_dt*before_or_equal' => 'The trans dt must be a date before or equal to today',
            ]
        );
    }

    private function saveretDetails($request, $id, $slgr_ids)
    {
        $returns = InvReturnDet::whereRetId($id);
        $old_r_det_ids = $returns->pluck('id')->toArray();
        $current_r_det_ids = [];

        foreach ($request->ret_det as $data) {
            $r_det = InvReturnDet::findOrNew($data['id']);
            $r_det->fill($data);
            $r_det->ret_id = $id;
            $r_det->save();
            array_push($current_r_det_ids, $r_det->id);

            $part = 'Return to ' . $this->ret->storelocation->location . ' from ' . $this->ret->location->location;

            $fill_arr = [
                'trans_type' => 'ir', 'trans_det_id' => $r_det->id, 'trans_id' => $id, 'trans_date' => $request->trans_dt,
                'item_id' => $r_det->item_id, 'r_qty' => $r_det->qty, 'i_qty' => 0, 'store_id' => $request->store_id, 'loc_id' => $request->loc_id,
                'part' => $part, 'staff_id' => $request->staff_id,
            ];
            $arr = getResultModel($slgr_ids, "App\Inventory\StockLedger", $fill_arr);
            $arr[0]->save();
            $slgr_ids = $arr[1];

            // store purticulars
            $part = 'Return to ' . $this->ret->storelocation->location . ' from ' . $this->ret->location->location;

            $fill_arr = [
                'trans_type' => 'ir', 'trans_det_id' => $r_det->id, 'trans_id' => $id, 'trans_date' => $request->trans_dt,
                'item_id' => $r_det->item_id, 'i_qty' => $r_det->qty, 'r_qty' => 0, 'store_id' => $request->loc_id, 'loc_id' => $request->store_id,
                'part' => $part, 'staff_id' => $request->staff_id,
            ];
            $arr = getResultModel($slgr_ids, "App\Inventory\StockLedger", $fill_arr);
            $arr[0]->save();
            $slgr_ids = $arr[1];
        }

        $ids_to_be_delete = array_diff($old_r_det_ids, $current_r_det_ids);
        if ($ids_to_be_delete != null) {
            InvReturnDet::whereIn('id', $ids_to_be_delete)->delete();
        }
        StockLedger::whereIn('id', $slgr_ids)->delete();
    }

    public function edit($id)
    {
        if (Gate::denies('inv-edit-return')) {
            return deny();
        }
        $ret = InvReturn::whereId($id)->get();
        $ret->load('ret_dets.item', 'location');
        return view('inventory.inv_return.create', compact('ret'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-return')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
