<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

  use AuthorizesRequests,
      DispatchesJobs,
      ValidatesRequests;

  public function __construct() {
    $this->middleware('auth');
    $this->middleware(function($request, $next) {
      view()->share('signedIn', auth()->check());
      view()->share('loggedUser', auth()->user());
      return $next($request);
    });
    view()->share('guard', 'web');
    view()->share('dashboard', 'app');
  }

  protected function setFormData($url, $coll_var, $class_name, \Illuminate\Http\Request $request, $msg = '', $scope = 'between', $load = true) {
    $form_opts = is_array($url) ? $url : ['method' => 'GET', 'url' => $url, 'class' => 'form-horizontal'];
//    $centre_id = request()->get('centre_id', 0);
//    if ($centre_id > 0)
//      $msg .= ' For ' . \App\Centre::findOrFail($centre_id)->locname;
    $coll = $class_name::orderBy('id', 'asc');
    $view_name = $request->get('btn-export') ? 'excel' : 'app';
    $data = compact('form_opts', 'view_name');
    if (request()->has('btn-apply') || request()->has('btn-export')) {
      $rules = [];
      if ($request->has('date_from'))
        $rules['date_from'] = 'required|date_format:d-m-Y';
      if ($request->has('date_to'))
        $rules['date_to'] = 'required|date_format:d-m-Y';
      if (count($rules) > 0) {
        $this->validate($request, $rules);
        if ($scope == 'between') {
          $coll = $coll->$scope($request->date_from, $request->date_to);
          $msg .= " From " . $request->date_from . ' To ' . $request->date_to;
        }
        if ($scope == 'upto') {
          $coll = $coll->$scope($request->date_to);
          $msg .= " Upto " . $request->date_to;
        }
      }
      $data += $request->all();
    }
    $query_scopes = explode(',', $scope);
    foreach ($query_scopes as $qry_scope) {
      $qry_scope = trim($qry_scope);
      if ($qry_scope != 'between' && $qry_scope != 'upto' && strlen($qry_scope) > 0) {
        $coll = $coll->$qry_scope();
      }
    }
    if ($load)
      $coll = $coll->get();
    $data += [$coll_var => $coll, 'msg' => $msg];
    return $data;
  }

}
