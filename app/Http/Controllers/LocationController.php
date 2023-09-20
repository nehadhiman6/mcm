<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Location;

class LocationController extends Controller
{
    public function index()
    {
        if (Gate::denies('LOCATION-LIST')) {
            return deny();
        }
        $locations = Location::orderBy('location')->get();
        return view('locations.index', compact('locations'));
    }
    
    public function store(Request $request)
    {
        if (Gate::denies('EDIT-LOCATIONS')) {
            return deny();
        }
        $this->validateForm($request, $id=0);
        $locations = new Location();
        $locations->fill($request->all());
        $locations->save();
        return redirect('locations');
    }

    public function validateForm($request, $id)
    {
        $this->validate($request, [
            'location' => 'required|max:255|unique:locations,location,' . $id,
            'dept_id' => 'required|integer|exists:departments,id',
            'type'=>'required|in:classroom,hostel,other,lab',
            'block_id'=>'required'
        ]);
    }
    
    public function edit($id)
    {
        if (Gate::denies('EDIT-LOCATIONS')) {
            return deny();
        }
        $locations = Location::orderBy('location')->get();
        $location = Location::findOrFail($id);
        // dd($location);
        return view('locations.index', compact('locations', 'location'));
    }
    
    
    public function update(Request $request, $id)
    {
        if (Gate::denies('EDIT-LOCATIONS')) {
            return deny();
        }
        $this->validateForm($request, $id);
        $location = Location::findOrFail($id);
        $location->fill($request->all());
        $location->update();
        return redirect('locations');
    }

    public function getHostelLocation(Request $request){
        $locations = Location::orderBy('location')->where('type','hostel')->get();
        return reply(true,[
            'locations' =>$locations
        ]);
    }
}
