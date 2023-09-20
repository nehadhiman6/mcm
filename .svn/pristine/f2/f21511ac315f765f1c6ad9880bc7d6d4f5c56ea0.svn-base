<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;

class GroupController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    if (Gate::denies('GROUPS'))
      return deny(); 
    $groups = \App\Group::orderBy('group_name')->get();
    return view('groups.index', compact('groups'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    if (Gate::denies('MODIFY-GROUPS'))
      return deny();
    return view('groups.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    if (Gate::denies('MODIFY-GROUPS'))
      return deny();
    $group = new \App\Group();
    $group->fill($request->all());
    $group->save();
    return redirect('groups');
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
    if (Gate::denies('MODIFY-GROUPS'))
      return deny();
    $groups = \App\Group::orderBy('group_name')->get();
    $group = \App\Group::findOrFail($id);
    return view('groups.index', compact('groups', 'group'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    if (Gate::denies('MODIFY-GROUPS'))
      return deny();
    $group = \App\Group::findOrFail($id);
    $group->fill($request->all());
    $group->update();
    return redirect('groups');
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

  public function permissions($grp_id) {
    $group = \App\Group::findOrFail($grp_id);
    $grp_permissions = $group->permissions;
    $selected_ids = $grp_permissions->pluck('id')->toArray();
    $permission_ids = \App\Group::join('group_permissions','groups.id','group_permissions.group_id')
                                  ->pluck('group_permissions.permission_id')->toArray();
                                  // dd($permission_ids);
    $permissions = \App\Permission::whereNotIn('id',$permission_ids)->whereAdmin('N')->orderBy('label')->get(['id', 'label']);

    // $permissions = \App\Permission::doesntHave('groups')->whereAdmin('N')->orderBy('label')->get(['id', 'label']);
    return view('groups.group_permission', compact('group', 'grp_permissions', 'permissions'));
  }

  public function addPermissions(Request $request, $grp_id) {
    $this->validate($request, [
      'add_ids' => 'required'
    ]);
    $group = \App\Group::findOrFail($grp_id);
    $ids = array_merge($group->permissions->pluck('id')->toArray(), $request->add_ids);
    $group->permissions()->sync($ids);
    $group->load(['permissions']);
    $grp_permissions = $group->permissions;
    $permission_ids = \App\Group::join('group_permissions','groups.id','group_permissions.group_id')
                                  ->pluck('group_permissions.permission_id')->toArray();
    $permissions = \App\Permission::whereNotIn('id',$permission_ids)->whereAdmin('N')->orderBy('label')->get(['id', 'label']);
    return compact('grp_permissions', 'permissions');
  }

  public function removePermissions(Request $request, $grp_id) {
    $this->validate($request, [
      'remove_ids' => 'required'
    ]);
    $group = \App\Group::findOrFail($grp_id);
    $group->permissions()->detach($request->remove_ids);
    $grp_permissions = $group->permissions;
    $permission_ids = \App\Group::join('group_permissions','groups.id','group_permissions.group_id')
    ->pluck('group_permissions.permission_id')->toArray();
    $permissions = \App\Permission::whereNotIn('id',$permission_ids)->whereAdmin('N')->orderBy('label')->get(['id', 'label']);
    return compact('grp_permissions', 'permissions');
  }

}
