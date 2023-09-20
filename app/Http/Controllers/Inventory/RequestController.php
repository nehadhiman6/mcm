<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\Requst;
use App\Inventory\Reqest;
use App\Inventory\RequestDet;
use Illuminate\Support\Facades\DB;
use Gate;

class RequestController extends Controller
{
    public function index()
    {
        if (Gate::denies('inv-request')) {
            return deny();
        }
        $requests = Reqest::orderBy('id')->get();
        $requests->load('departement');
        return view('inventory.request.index', compact('requests'));
    }
    
    
    public function create()
    {
        if (Gate::denies('inv-request')) {
            return deny();
        }

        return view('inventory.request.create');
    }
    
     
    public function store(Request $request)
    {
        if (Gate::denies('inv-request')) {
            return deny();
        }
        return $this->saveForm($request, $request->id);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $reqst = Reqest::findOrNew($id);
        $reqst->fill($request->all());
        DB::beginTransaction();
        $reqst->save();
        $this->saverequestDetails($request, $reqst->id);
        DB::commit();
        $id = $request->id;
        return reply('OK', compact('reqst', 'id'));
    }

    private function validateForm($request, $id)
    {
        $this->validate($request, [
            'trans_dt' => 'required|date_format:"d-m-Y"',
            'department_id' => 'required|integer|exists:departments,id',
            'person' => 'required|string',
            'remarks' => 'required|string|max:200',
            'request_det.*.item_id' => 'required|integer|exists:items,id',
            'request_det.*.req_qty' => 'required|numeric',
            'request_det.*.req_for' => 'required|string|max:100',
        ]);
    }

    private function saverequestDetails($request, $id)
    {
        RequestDet::whereRequestId($id)->delete();
        foreach ($request->request_det as $data) {
            $req_det = RequestDet::findOrNew($data['id']);
            $req_det->fill($data);
            $req_det->request_id = $id;
            $req_det->save();
        }
    }
  
    public function edit($id)
    {
        if (Gate::denies('inv-request')) {
            return deny();
        }
        $reqst = Reqest::whereId($id)->get();
        $reqst->load('reqst_dets');
        return view('inventory.request.create', compact('reqst'));
    }
     
    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-request')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }
}
