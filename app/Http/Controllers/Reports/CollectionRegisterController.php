<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class CollectionRegisterController extends Controller {

  //
  public function feeheadCollection() {
    if (Gate::denies('feeheadwise-coll')) {
      return deny();
    }
    if (!request()->ajax()) {
      return View('reports.feeheadwise_collection');
    }
  }

  public function subheadCollection() {
    if (Gate::denies('subheadwise-coll')) {
      return deny();
    }
    if (!request()->ajax()) {
      return View('reports.subheadwise_collection');
    }
  }

}
