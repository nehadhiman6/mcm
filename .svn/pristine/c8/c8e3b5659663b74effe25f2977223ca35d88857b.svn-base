<?php

namespace App\Http\Controllers;

use App\Research;
use Illuminate\Http\Request;
use App\Staff;


class ResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $researches = Research::orderBy('id', 'DESC')->get();
        if (!request()->ajax()) {
            return View('staff.staff.research_index', compact(['researches']));
        }
        return $researches;
        
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
    public function store(Request $request, $id = 0)
    {
        // dd($request->all());
        // $this->validate($request,[
        //     'staff_id'=>'required|exists:staff,id',
        //     'research.title1'=>'required',
        //     'research.title2'=>'required',
        //     'research.level'=>'required',
        //     'research.authorship'=>'required',
        //     'research.pub_date'=>'required|date_format:d-m-Y',
        //     'research.impact_factor'=>'nullable|numeric',
        //     'research.citations'=>'nullable|numeric',
        //     'research.h_index'=>'nullable|numeric',
        //     'research.i10_index'=>'nullable|numeric',
           
        // ]);
        $this->validateForm($request, $id);
        $res = $request->research;
        $staff = Staff::findOrFail($request->staff_id);
        $research = Research::findOrNew($id);
        $research->fill($res);
        $research->save();
        return response()->json([
            'research' => $research, 
            'success' => "Research Add Successfully",
            'researches' => Research::orderBy('id', 'DESC')->where('staff_id','=',$staff->id)->get()
        ], 200, ['app-status' => 'success']);

        

    }

    private function validateForm(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'staff_id'=>'required|exists:staff,id',
                'research.title1'=>'required',
                'research.type'=>'required',
                'research.level'=>'required',
                'research.authorship'=>'required',
                'research.pub_date'=>'required|date_format:d-m-Y',
                'research.impact_factor'=>'nullable|numeric',
                'research.citations'=>'nullable|numeric',
                'research.h_index'=>'nullable|numeric',
                'research.i10_index'=>'nullable|numeric',
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function show(Research $research)
    {
        //
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function edit(Research $research, $id)
    {
        $research = Research::findOrFail($id);
        return reply('Ok', [
            'research' => $research,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $staff = Staff::findOrFail($request->staff_id);
        $research = Research::findOrFail($id);
        $research->fill($request->research);
        $research->update();
        return response()->json([
            'success' => "Research Updated Successfully",
            'researches' => Research::orderBy('id', 'DESC')->where('staff_id','=',$staff->id)->get()
        ], 200, ['app-status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Research  $research
     * @return \Illuminate\Http\Response
     */
    public function destroy(Research $research)
    {
        //
    }
}
