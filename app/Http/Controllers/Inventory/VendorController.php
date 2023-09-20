<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\Vendor;
use Gate;

class VendorController extends Controller
{
    public function index()
    {
        if (Gate::denies('inv-vendor')) {
            return deny();
        }
        $vendors = Vendor::orderBy('vendor_name')->get();
        // $vendors->load('vendor_category', 'vendor_sub_category');
        return view('inventory.vendors.index', compact('vendors'));
    }
    
    
    public function create()
    {
        if (Gate::denies('add-inv-vendor')) {
            return deny();
        }

        return view('inventory.vendors.create');
    }
    
     
    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-vendor')) {
            return deny();
        }
        return $this->saveForm($request, $id=0);
    }

    private function saveForm(Request $request, $id)
    {
       
        $this->validateForm($request, $id);
        $vendor = Vendor::findOrNew($id);
        $vendor->fill($request->all());
        $vendor->save();
        return redirect('vendors');
    }

    private function validateForm(Request $request, $id)
    {
        $this->validate($request, [
            'vendor_name' => 'required|string|max:100|unique:vendors,vendor_name,'.$id,
            'code' => 'required|string|max:15|unique:vendors,code,'.$id,
            'mobile' => 'nullable|numeric|digits:10',
            'contact_person' => 'nullable|max:100',
            'contact_no' => 'required|numeric',
            'city_id' => 'nullable|integer|exists:cities,id',
            'vendor_address'=> 'required|string|max:200',
        ]);
    }

    public function edit($id)
    {
        if (Gate::denies('inv-edit-vendor')) {
            return deny();
        }
        $vendor = Vendor::findOrFail($id);
        return view('inventory.vendors.edit', compact('vendor'));
    }
    
     
    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-vendor')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }

    public function getVendor(Request $request)
    {
        if ($request->has('vendor_id')) {
            $vendor = Vendor::whereId($request->vendor_id)->first(['code']);
            $vendor_code = $vendor ? $vendor->code : null;
            return reply('OK', compact('vendor_code'));
        }
        if ($request->has('vendor_code')) {
            $vendor = Vendor::whereCode($request->vendor_code)->first(['id']);
            $vendor_id = $vendor ? $vendor->id : null;
            return reply('OK', compact('vendor_id'));
        }
    }
}
