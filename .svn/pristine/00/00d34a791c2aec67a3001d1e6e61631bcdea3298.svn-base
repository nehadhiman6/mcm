<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\StockLedger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class OpeningStockController extends Controller
{
    public function index()
    {
        if (Gate::denies('opening-stocks')) {
            return deny();
        }
        $opening_stocks = StockLedger::orderBy('id')->whereTransType('os');

        $store_ids = getUserStores();
        $opening_stocks = $opening_stocks->whereIn('store_id', $store_ids);

        $opening_stocks = $opening_stocks->get();
        $opening_stocks->load('item:id,item');
        return view('inventory.opening_stock.index', compact('opening_stocks'));
    }

    public function create()
    {
        if (Gate::denies('add-opening-stocks')) {
            return deny();
        }

        return view('inventory.opening_stock.create');
    }


    public function store(Request $request)
    {
        if (Gate::denies('modify-opening-stock')) {
            return deny();
        }
        $this->validate(
            $request,
            [
                'opening_det.*.item_id' => 'required|integer|exists:items,id',
                'opening_det.*.r_qty' => 'required|min:1|numeric',
                'opening_det.*.store_id' => 'required|integer',
            ],
            [
                'opening_det.*.item_id.required' => 'Item is Required !!',
                'opening_det.*.item_id.integer' => 'Item must be integer !!',
                'opening_det.*.item_id.exists' => 'Item does not exists !!',

                'opening_det.*.r_qty.required' => 'Qty is Required !!',
                'opening_det.*.r_qty.numeric' => 'Qty must be numeric !!',
                'opening_det.*.r_qty.min' => 'Qty must be greater then 0 !!',
                'opening_det.*.store_id.required' => 'Store Location is Required !!',

            ]
        );
        DB::beginTransaction();
        foreach ($request->opening_det as $data) {
            $opening_stock = new StockLedger();
            $opening_stock->fill($data);
            $opening_stock->trans_type = 'os';
            $opening_stock->trans_date = getFYStartDate();
            $opening_stock->save();
        }
        DB::commit();
        $id = $opening_stock->id;
        return reply('OK', compact('opening_stock', 'id'));
    }




    public function edit($id)
    {
        if (Gate::denies('modify-opening-stock')) {
            return deny();
        }

        $opening_stock = StockLedger::findOrFail($id);
        return view('inventory.opening_stock.edit', compact('opening_stock'));
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('modify-opening-stock')) {
            return deny();
        }

        $this->validate($request, [
            'item_id' => 'required|integer|exists:items,id',
            'r_qty' => 'required|numeric',
            'store_id' => 'required|integer|exists:locations,id',
        ]);
        $opening_stock = StockLedger::findOrNew($id);
        $opening_stock->fill($request->all());
        $opening_stock->trans_type = 'os';
        $opening_stock->trans_date = getFYStartDate();
        $opening_stock->update();
        return redirect('opening-stocks');
    }
}
