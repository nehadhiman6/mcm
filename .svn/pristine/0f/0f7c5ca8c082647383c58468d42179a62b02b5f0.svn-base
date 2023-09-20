<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faculty;
use Gate;

class FacultyController extends Controller
{
    public function index()
    {
        if(Gate::denies('faculty-list')){
            return deny();
        }
        $faculties = Faculty::orderBy('faculty')->get();
        if (!request()->ajax()) {
            return View('staff.faculty.index', compact(['faculties']));
        }
        return $faculties;
    }

    public function store(Request $request)
    {
        if(Gate::denies('faculty-modify')){
            return deny();
        }
        $this->doValidate($request);
        $faculty = new Faculty();
        $faculty->fill($request->all());
        $faculty->save();
        return response()->json([
            'success' => "Faculty Saved Successfully",
            'faculties' => Faculty::orderBy('faculty')->get()
        ], 200, ['app-status' => 'success']);
    }

    public function doValidate(Request $request, $id = 0)
    {
        $this->validate($request, [
            'faculty' => 'required|string|max:50|unique:faculty,faculty,' . $id,
        ]);
    }

    public function edit($id)
    {
        if(Gate::denies('faculty-modify')){
            return deny();
        }
        return Faculty::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        if(Gate::denies('faculty-modify')){
            return deny();
        }
        $this->doValidate($request, $id);
        $faculty = Faculty::findOrFail($id);
        $faculty->faculty = $request->faculty;
        $faculty->save();
        return response()->json([
            'success' => "Faculty Saved Successfully",
            'faculties' => Faculty::orderBy('faculty')->get()
        ], 200, ['app-status' => 'success']);
    }
}
