<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use Gate;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('department-list')){
            return deny();
        }
        $departments = Department::orderBy('name')->get()->load('faculty');
        if (!request()->ajax()) {
            return View('staff.department.index', compact(['departments']));
        }
        return $departments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Gate::denies('department-modify')){
            return deny();
        }
        //
        $this->doValidate($request);
        $department = new Department();
        $department->fill($request->all());
        $department->save();
        return response()->json([
            'success' => "department Saved Successfully",
            'departments' => Department::orderBy('name')->get()->load('faculty')
        ], 200, ['app-status' => 'success']);
    }

    public function doValidate(Request $request, $id = 0)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50|min:3|unique:departments,name,' . $id,
            'faculty_id' => 'required|integer|exists:faculty,id',
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
        if(Gate::denies('department-modify')){
            return deny();
        }
        return Department::findOrFail($id);
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
        if(Gate::denies('department-modify')){
            return deny();
        }
        $this->doValidate($request, $id);
        $dept = Department::findOrFail($id);
        $dept->name = $request->name;
        $dept->faculty_id = $request->faculty_id;
        $dept->save();
        return response()->json([
            'success' => "department Saved Successfully",
            'departments' => Department::orderBy('name')->get()->load('faculty')
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
