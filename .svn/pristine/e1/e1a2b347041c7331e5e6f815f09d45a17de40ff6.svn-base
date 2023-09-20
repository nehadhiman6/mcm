<?php

namespace App\Http\Controllers\Activity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activity\AgencyType;
use Gate;

class AgencyTypeController extends Controller
{
    public function index(){
        if (Gate::denies('agency')) {
            return deny();
        }
        $agency_types = AgencyType::orderBy('id')->get();
        return view('activities.agency.index', compact('agency_types'));
    }


    public function create()
    {
        if (Gate::denies('agency-types')) {
            return deny();
        }
        return view('activities.agency.create');
    }

    public function store(Request $request){
        if (Gate::denies('agency-types-modify')) {
            return deny();
        }
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id=0){
        // dd($request->all());
        $this->validateForm($request, $id);
        $agency_type = AgencyType::findOrNew($request->id);
        $agency_type->fill($request->all());
        $agency_type->save();
        return reply(true,compact('agency_type'));
    }

    private function validateForm(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name'=> 'required|string|max:100',
                'master_type'=> 'required|string|max:50',
            ]
        );
    }

    public function edit($id)
    {
        if (Gate::denies('agency-types-modify')) {
            return deny();
        }
        $agency_type = AgencyType::findOrFail($id);
        return view('activities.agency.create', compact('agency_type'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('agency-types-modify')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
