<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\DamageDet;
use App\Inventory\Damage;
use Illuminate\Support\Facades\DB;
use Gate;
use App\Inventory\StockLedger;

class DamagesController extends Controller
{
    protected $damage = null;

    public function index()
    {
        if (Gate::denies('inv-damage')) {
            return deny();
        }
        $store_ids = getUserStores();
        $damages = Damage::whereIn('store_id', $store_ids)->orderBy('id')->get();
        // $damages->load('ret_category', 'ret_sub_category');
        return view('inventory.damage.index', compact('damages'));
    }


    public function create()
    {
        if (Gate::denies('add-inv-damage')) {
            return deny();
        }

        return view('inventory.damage.create');
    }


    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-damage')) {
            return deny();
        }

        return $this->saveForm($request, $request->id);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $damage = Damage::findOrNew($id);
        $damage->fill($request->all());
        $this->damage = $damage;
        $slgr_ids = [];
        if (intval($id) != 0)
            $slgr_ids = StockLedger::where('trans_type', 'dam')->where('trans_id', $id)->pluck('id')->toArray();
        DB::beginTransaction();
        $damage->save();
        $this->saveDamageDetails($request, $damage->id, $slgr_ids);
        DB::commit();
        $id = $request->id;
        return reply('OK', compact('damage', 'id'));
    }

    private function validateForm($request, $id)
    {
        $this->validate($request, [
            'trans_dt' => 'required|date_format:"d-m-Y"|before_or_equal:'.today(),
            'store_id' => 'required|integer',
            'remarks' => 'nullable|string|max:250',
            'damage_det.*.item_id' => 'required|integer|exists:items,id',
            'damage_det.*.qty' => 'required|numeric',
            'damage_det.*.item_desc' => 'nullable|max:200',
            ],
            [
                'trans_dt*before_or_equal' => 'The trans dt must be a date before or equal to today',
            ]
        );
    }

    private function saveDamageDetails($request, $id, $slgr_ids)
    {
        $returns = DamageDet::whereDamageId($id);
        $old_dam_det_ids = $returns->pluck('id')->toArray();
        $current_dam_det_ids = [];

        foreach ($request->damage_det as $data) {
            $dam_det = DamageDet::findOrNew($data['id']);
            $dam_det->fill($data);
            $dam_det->damage_id = $id;
            $dam_det->save();
            array_push($current_dam_det_ids, $dam_det->id);

            $part = 'Damage entry '.$this->damage->storelocations->location.' : '.$request->remarks;

            $fill_arr = [
                'trans_type' => 'dam', 'trans_det_id' => $dam_det->id, 'trans_id' => $id, 'trans_date' => $request->trans_dt,
                'item_id' => $dam_det->item_id, 'i_qty' => $dam_det->qty, 'r_qty' => 0, 'store_id' => $request->store_id, 'loc_id' => 0,
                'part' => $part
            ];
            $arr = getResultModel($slgr_ids, "App\Inventory\StockLedger", $fill_arr);
            $arr[0]->save();
            $slgr_ids = $arr[1];
        }

        $ids_to_be_delete = array_diff($old_dam_det_ids, $current_dam_det_ids);
        if ($ids_to_be_delete != null) {
            DamageDet::whereIn('id', $ids_to_be_delete)->delete();
        }
        StockLedger::whereIn('id', $slgr_ids)->delete();
    }

    public function edit($id)
    {
        if (Gate::denies('inv-edit-damage')) {
            return deny();
        }

        $damage = Damage::whereId($id)->get();
        $damage->load('damage_dets.item');
        return view('inventory.damage.create', compact('damage'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-damage')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
