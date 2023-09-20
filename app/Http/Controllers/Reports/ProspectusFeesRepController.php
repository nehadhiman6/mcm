<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class ProspectusFeesRepController extends Controller
{

  //
    public function index(Request $request)
    {
        if (Gate::denies('prospectus-fees')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('reports.prospectus_feesreport');
        }
        $messages = [];
        $rules = [
          'from_date' => 'required',
          'upto_date' => 'required',
        ];
        $this->validate($request, $rules, $messages);
        $prospectus_fee = \App\Payment::where('trn_type', 'like', 'prospectus_fee%')->where('ourstatus', '=', 'OK');

        $prospectus_fee = $prospectus_fee->where('created_at', '>=', mysqlDate($request->from_date))
          ->where('created_at', '<', \Carbon\Carbon::createFromFormat('d-m-Y', $request->upto_date)->addDay()->setTime(0, 0, 0));

        return $prospectus_fee->with([
          'std_user' => function ($q) {
              $q->select('id', 'name');
          },
          'std_user.adm_form' => function ($q) {
              $q->select('id', 'std_user_id', 'name');
          }])
          ->get();
    }
}
