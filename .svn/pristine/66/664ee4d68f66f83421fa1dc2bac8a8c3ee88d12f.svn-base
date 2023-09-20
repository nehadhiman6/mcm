<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\ItemSubCategory;
use Gate;

class ItemSubCategoryController extends Controller
{
    public function index()
    {
        if (Gate::denies('inv-sub-item-category')) {
            return deny();
        }

        $categories = ItemSubCategory::orderBy('category')->get();
        return view('inventory.item_sub_category.index', compact('categories'));
    }
     
    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-sub-item-category')) {
            return deny();
        }
        return $this->saveForm($request, $id=0);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $category = ItemSubCategory::findOrNew($id);
        $category->fill($request->all());
        $category->save();
        return redirect('items_sub_categories');
    }

    private function validateForm(Request $request, $id)
    {
        $this->validate($request, [
            'category' => 'required|string|max:100|unique:item_sub_categories,category,'.$id
        ]);
    }

    
    public function edit($id)
    {
        if (Gate::denies('inv-edit-sub-item-category')) {
            return deny();
        }
        $categories = ItemSubCategory::orderBy('category')->get();
        $category = ItemSubCategory::findOrFail($id);
        return view('inventory.item_sub_category.index', compact('category', 'categories'));
    }
    
     
    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-sub-item-category')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
