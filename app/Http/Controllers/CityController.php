<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CityRequest;
use Gate;

class CityController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index()
    {
        if (Gate::denies('CITIES')) {
            return deny();
        }
        $cities = \App\City::orderBy('city')->get();
        return view('cities.index', compact('cities'));
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
    public function store(CityRequest $request)
    {
        if (Gate::denies('EDIT-CITIES')) {
            return deny();
        }
        $input = $request->all();
        $cities = new \App\City();
        $cities->fill($input);
        $cities->save();
        return redirect('cities');
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
        if (Gate::denies('EDIT-CITIES')) {
            return deny();
        }
        $cities = \App\City::orderBy('city')->get();
        $city = \App\City::findOrFail($id);
        return view('cities.index', compact('cities', 'city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, $id)
    {
        if (Gate::denies('EDIT-CITIES')) {
            return deny();
        }
        $city = \App\City::findOrFail($id);
        $city->fill($request->all());
        $city->update();
        return redirect('cities');
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
