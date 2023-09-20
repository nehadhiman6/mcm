<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;

class NIRFReportController extends Controller
{
    public function index(Request $request)
    {
        if( Gate::denies('nirf-report') ){
            return deny();
        }
        if (!request()->ajax()) {
            return View('nirfreport.index');
        }
    }
}
