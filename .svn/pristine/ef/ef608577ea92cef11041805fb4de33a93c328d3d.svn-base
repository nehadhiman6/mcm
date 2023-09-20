<?php

namespace App\Http\Controllers\Activity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activity\Orgnization;
use Gate;

class OrgnizationController extends Controller
{
    public function index(Request $request){
        if (Gate::denies('orgnization')) {
            return deny();
        }
        // if($request->ajax()){
        //     $orgnization = Orgnization::orderBy('id')->get();
        //     return reply(true,[
        //         'data' => $orgnization
        //     ]);
        // }
        // return view('activities.orgnization.index');

        $orgnization = Orgnization::orderBy('id')->with('department','agency')->get();
        return view('activities.orgnization.index', compact('orgnization'));
    }

    public function create()
    {
        if (Gate::denies('add-orgnization')) {
            return deny();
        }
        return view('activities.orgnization.create');
    }

    public function store(Request $request){
        if (Gate::denies('orgnization-modify')) {
            return deny();
        }
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id=0){
        // dd($request->all());
        $this->validateForm($request, $id);
        $orgnization = Orgnization::findOrNew($request->id);
        $orgnization->fill($request->all());
        $orgnization->save();
        return reply(true);
        
    }

    private function validateForm(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name'=> 'required|string|max:100|unique:orgnization,name,' . $request->id,
                'external_agency'=> 'required|in:Y,N',
                'agency_type_id'=> 'required|integer|exists:master_types,id',
                'dept_id'=> 'nullable|integer|exists:departments,id',
            ]
        );
    }

    public function edit($id){
        if (Gate::denies('orgnization-modify')) {
            return deny();
        }
        $orgnization = Orgnization::findOrFail($id);
        return view('activities.orgnization.create',compact('orgnization'));

    }

    public function update(Request $request, $id){
        if (Gate::denies('orgnization-modify')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
