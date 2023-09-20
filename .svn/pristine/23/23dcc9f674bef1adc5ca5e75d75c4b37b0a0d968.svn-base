<?php

namespace App\Http\Controllers\Placement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Placement\Company;
use Gate;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('placement-companies')) {
            return deny();
        }
        if (!$request->ajax()) {
            return view('placement.placement_company.index');
        }
        $count = Company::all()->count();
        $filteredCount = $count;
        $companies = Company::orderBy('id', 'DESC');
        if ($searchStr = $request->input('search.value')) {
            $companies = $companies->where('', 'like', "%{$searchStr}%");
        }
        
        $companies = $companies->take($request->length);
        $filteredCount = $companies->count();

        $companies = $companies->select(['placement_companies.*'])->distinct()->get();
        $companies->load('state');
        return [
            'draw' => intval($request->draw),
            'start'=>$request->start,
            'data' => $companies,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
    }


    public function create()
    {
        if (Gate::denies('add-placement-companies')) {
            return deny();
        }
        return view('placement.placement_company.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('placement-companies-modify')) {
            return deny();
        }
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id=0)
    {
        $this->validateForm($request, $id);
        $company = Company::findOrNew($request->id);
        $company->fill($request->all());
        $company->save();
        return reply(true, compact('company'));
    }

    private function validateForm(Request $request, $id)
    {
        $rules = [
            'name'=> 'required|string|max:50',
            'add' => 'nullable|string|max:200',
            'state_id' => 'required|integer|exists:states,id',
            'city' => 'required|string',
            'comp_type' => 'nullable|string',
            'comp_nature' => 'nullable|string',
           

        ];
        $messages = [
            
        ];
       

        $this->validate($request, $rules, $messages);
    }

    public function edit($id)
    {
        if (Gate::denies('placement-companies-modify')) {
            return deny();
        }
        $company = Company::findOrFail($id);
        $company->load('state');
        return view('placement.placement_company.create', compact('company'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('placement-companies-modify')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
