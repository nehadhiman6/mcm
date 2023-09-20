<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Gate;

class RoleController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('ROLES'))
      return deny();
    $roles = \App\Role::all();
    return view('roles.index', compact('roles'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    if (Gate::denies('ROLES'))
      return deny();
    $this->validate($request, [
      'name' => 'required|unique:roles',
    ]);
    \App\Role::create($request->only(['name']));
    return redirect('roles');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    if (Gate::denies('ROLES'))
      return deny();
    $role = \App\Role::findOrFail($id);
    $roles = \App\Role::orderBy('name')->get();
    return view('roles.index', compact('roles', 'role'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    if (Gate::denies('ROLES'))
      return deny();
    $this->validate($request, [
      'name' => 'required|unique:roles,name,' . $id,
    ]);
    $role = \App\Role::findOrFail($id);
    $role->fill($request->all());
    $role->save();
    return redirect('roles');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    //
  }

  public function showPermissions($role_id) {
    $role = \App\Role::findOrFail($role_id);
    $group = \App\Group::orderBy('group_name')->get();
     $permissions = \App\Permission::whereNotIn('id',function($q){
      $q->from('group_permissions')->select('permission_id');
    })->orderBy('label')->get();
    return view('roles.permissions_to_role', compact('role', 'permissions','group'));
  }

  public function savePermissions(Request $request, $role_id) {
    $role = \App\Role::findOrFail($role_id);
    $role->permissions()->sync($request->input('permission_id', []));
    return redirect('roles');
  }

}
