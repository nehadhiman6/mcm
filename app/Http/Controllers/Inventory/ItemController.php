<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\Item;
use Gate;

class ItemController extends Controller
{
    public function index()
    {
        if (Gate::denies('inv-item')) {
            return deny();
        }

        $items = item::orderBy('item')->get();
        $items->load('item_category', 'item_sub_category');
        return view('inventory.items.index', compact('items'));
    }
    
    
    public function create()
    {
        if (Gate::denies('add-inv-item')) {
            return deny();
        }

        return view('inventory.items.create');
    }
    
     
    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-item')) {
            return deny();
        }
        
        return $this->saveForm($request, $id=0);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $item = Item::findOrNew($id);
        $item->fill($request->all());
        $item->save();
        return redirect('items');
    }

    private function validateForm(Request $request, $id)
    {
        $this->validate($request, [
            'item' => 'required|string|max:100|unique:items,item,'.$id,
            'unit' => 'required|string|max:10',
            'consumable' => 'nullable|in:Y,N',
            'item_code' => 'required|string|max:15|unique:items,item_code,'.$id,
            'it_cat_id' => 'required|integer|exists:item_categories,id',
            'it_sub_cat_id' => 'required|integer|exists:item_sub_categories,id',
            'remarks' => 'nullable|string|max:200',
        ]);
    }

    
    public function edit($id)
    {
        if (Gate::denies('inv-edit-item')) {
            return deny();
        }

        $item = Item::findOrFail($id);
        return view('inventory.items.edit', compact('item'));
    }
    
     
    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-item')) {
            return deny();
        }
        
        return $this->saveForm($request, $id);
    }

    public function getItem(Request $request)
    {
        if ($request->has('item_id')) {
            $item = Item::whereId($request->item_id)->first(['item_code']);
            $item_code = $item ? $item->item_code : null;
            return reply('OK', compact('item_code'));
        }
        if ($request->has('item_code')) {
            $item = Item::whereItemCode($request->item_code)->first(['id']);
            $item_id = $item ? $item->id : null;
            return reply('OK', compact('item_id'));
        }
    }
}
