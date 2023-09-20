<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\Issue;
use App\Inventory\IssueDet;
use Illuminate\Support\Facades\DB;
use Gate;
use App\Inventory\StockLedger;

class IssueController extends Controller
{
    protected $issue = null;

    public function index()
    {
        if (Gate::denies('inv-issue')) {
            return deny();
        }
        $store_ids = getUserStores();
        $issues = Issue::whereIn('store_id', $store_ids)->orderBy('id', 'desc')->get();
        $issues->load('location','staff');
        return view('inventory.issue.index', compact('issues'));
    }


    public function create()
    {
        if (Gate::denies('add-inv-issue')) {
            return deny();
        }

        return view('inventory.issue.create');
    }


    public function store(Request $request)
    {
        if (Gate::denies('inv-edit-issue')) {
            return deny();
        }
        return $this->saveForm($request, $request->id);
    }

    private function saveForm(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $issue = Issue::findOrNew($id);
        $issue->fill($request->all());
        $this->issue = $issue;
        $slgr_ids = [];
        if (intval($id) != 0)
            $slgr_ids = StockLedger::where('trans_type', 'iss')->where('trans_id', $id)->pluck('id')->toArray();
        DB::beginTransaction();
        $issue->save();
        $this->saveIssueDetails($request, $issue->id, $slgr_ids);
        DB::commit();
        $id = $request->id;
        return reply('OK', compact('issue', 'id'));
    }

    private function validateForm($request, $id)
    {
        $this->validate($request, [
            'issue_dt' => 'required|date_format:"d-m-Y"|before_or_equal:'.today(),
            'loc_id' => 'required|integer|exists:locations,id',
            'store_id' => 'required|integer|exists:locations,id',
            'request_no' => 'required|string|max:15|unique:issues,request_no,' . $id,
            // 'person' => 'required|string|max:200',
            'remarks' => 'nullable|string|max:200',
            'issue_det.*.item_id' => 'required|integer|exists:items,id',
            'issue_det.*.req_qty' => 'required|numeric',
            'issue_det.*.req_for' => 'required|string|max:100',
            'issue_det.*.description' => 'nullable|string|max:200',

        ], [
            'issue_det.*.item_id.required' => 'Item field is Required !!',
            'issue_det.*.req_qty.required' => 'Quantity field is Required !!',
            'issue_det.*.req_for.required' => 'Req. For field is Required !!',
            'issue_det.*.item_id.integer' => 'Item field must be numeric !!',
            'issue_det.*.item_id.exists' => 'Item is Invalid !!',
            'issue_det.*.req_qty.numeric' => 'Quantity must be Numeric !!',
            'store_id' => 'Store Location Is Required !!',
            'issue_dt*before_or_equal' => 'The trans dt must be a date before or equal to today',
        ]);
    }

    private function saveIssueDetails($request, $id, $slgr_ids)
    {
        $issues = IssueDet::whereIssueId($id);
        $old_iss_det_ids = $issues->pluck('id')->toArray();
        $current_iss_det_ids = [];

        foreach ($request->issue_det as $data) {
            $iss_det = IssueDet::findOrNew($data['id']);
            $iss_det->fill($data);
            $iss_det->issue_id = $id;
            $iss_det->save();
            array_push($current_iss_det_ids, $iss_det->id);

            $part = 'Issued from '. $this->issue->storelocation->location .' to '.$this->issue->location->location;

            $fill_arr = [
                'trans_type' => 'iss', 'trans_det_id' => $iss_det->id, 'trans_id' => $id, 'trans_date' => $request->issue_dt,
                'item_id' => $iss_det->item_id, 'i_qty' => $iss_det->req_qty, 'r_qty' => 0, 'store_id' => $request->store_id, 'loc_id' => $request->loc_id,
                'part' => $part, 'staff_id' =>$request->staff_id,
            ];
            $arr = getResultModel($slgr_ids, "App\Inventory\StockLedger", $fill_arr);
            $arr[0]->save();
            $slgr_ids = $arr[1];
            
            $part = 'Received from '.$this->issue->storelocation->location .' to '.$this->issue->location->location;

            $fill_arr = [
                'trans_type' => 'iss', 'trans_det_id' => $iss_det->id, 'trans_id' => $id, 'trans_date' => $request->issue_dt,
                'item_id' => $iss_det->item_id, 'r_qty' => $iss_det->req_qty, 'i_qty' => 0, 'store_id' => $request->loc_id, 'loc_id' => $request->store_id,
                'part' => $part, 'staff_id' =>$request->staff_id,
            ];
            $arr = getResultModel($slgr_ids, "App\Inventory\StockLedger", $fill_arr);
            $arr[0]->save();
            $slgr_ids = $arr[1];
        }
        $ids_to_be_delete = array_diff($old_iss_det_ids, $current_iss_det_ids);
        if ($ids_to_be_delete != null) {
            IssueDet::whereIn('id', $ids_to_be_delete)->delete();
        }
        StockLedger::whereIn('id', $slgr_ids)->delete();
    }

    public function edit($id)
    {
        if (Gate::denies('inv-edit-issue')) {
            return deny();
        }
        $issue = Issue::whereId($id)->get();
        $issue->load('issue_dets', 'location','staff');
        return view('inventory.issue.create', compact('issue'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('inv-edit-issue')) {
            return deny();
        }

        return $this->saveForm($request, $id);
    }
}
