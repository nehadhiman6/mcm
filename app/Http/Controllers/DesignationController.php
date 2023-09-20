<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use Gate;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('designation-list')){
            return deny();
        }
        $designations = \App\Designation::orderBy('name')->get();
        if (!request()->ajax()) {
            return View('staff.designation.index', compact(['designations']));
        }
        return $designations;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('designation-modify')){
            return deny();
        }
        $this->doValidate($request);
        $designation = new \App\Designation();
        $designation->fill($request->all());
        $designation->save();
        return response()->json([
                'success' => "Designations Saved Successfully",
                'designations' => Designation::orderBy('name')->get()
            ], 200, ['app-status' => 'success']);
    }

    public function doValidate(Request $request, $id = 0)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:50|unique:desigs,name,' . $id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('designation-modify')){
            return deny();
        }
        return Designation::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('designation-modify')){
            return deny();
        }
        $this->doValidate($request, $id);
        $desig = Designation::findOrFail($id);
        $desig->name = $request->name;
        $desig->update();
        return response()->json([
            'success' => "Designations Updated Successfully",
            'designations' => Designation::orderBy('name')->get()
        ], 200, ['app-status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
