<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\ItemCategory;
use Gate;

class ItemCategoryController extends Controller
{
    public function index()
    {
        if (Gate::denies('inv-item-category')) {
            return deny();
        }

        $categories = ItemCategory::orderBy('category')->get();
        return view('inventory.item_category.index', compact('categories'));
    }
    
    
    public function create()
    {
        if (Gate::denies('add-inv-item-category')) {
            return deny();
        }

        return view('inventory.item_category.create');
    }
    
     
    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-item-category')) {
            return deny();
        }
        return $this->saveForm($request, $id=0);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $category = ItemCategory::findOrNew($id);
        $category->fill($request->all());
        $category->save();
        return redirect('items_categories');
    }

    private function validateForm(Request $request, $id)
    {
        $this->validate($request, [
            'category' => 'required|string|unique:item_categories,category,'.$id
        ]);
    }

    
    public function edit($id)
    {
        if (Gate::denies('inv-edit-item-category')) {
            return deny();
        }
        $categories = ItemCategory::orderBy('category')->get();
        $category = ItemCategory::findOrFail($id);
        return view('inventory.item_category.index', compact('category', 'categories'));
    }
    
     
    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-item-category')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
