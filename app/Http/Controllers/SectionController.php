<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('SECTIONS-LIST')){
            return deny();
        }
        $sections = \App\Section::all();
        return View('academics.section.index', compact('sections'));
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
        if(Gate::denies('ADD-SECTIONS')){
            return deny();
        }
        $this->doValidate($request);
        $section = new \App\Section();
        $section->fill($request->all());
        $section->save();
        return redirect('section');
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
        if(Gate::denies('EDIT-SECTIONS')){
            return deny();
        }
        $section = \App\Section::findOrFail($id);
        return view('academics.section.edit', compact('section'));
    }

    public function doValidate(Request $request, $id = 0)
    {
        $this->validate($request, [
            'section' => 'required|string|min:1|max:50|unique:' . getYearlyDbConn() . '.sections,section,' . $id,
        ]);
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
        if(Gate::denies('EDIT-SECTIONS')){
            return deny();
        }
        $this->doValidate($request, $id);
        $section = \App\Section::findOrFail($id);
        $section->fill($request->all());
        $section->update();
        return redirect('section');
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
