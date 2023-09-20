<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory\Issue;
use Illuminate\Support\Facades\DB;

class ItemStaffLocWiseStockController extends Controller
{
    public function index(Request $request)
    {

        if (!request()->ajax()) {
            return view('inventory.item_staff_location_stock.index');
        }
        // dd($request->all());
        $rules = [
            'date_from' => 'required|date:"d-m-y"',
            'date_to' => 'required|date:"d-m-y"',
            'store_id' => 'required',
        ];
        if (intval($request->item_id) == 0) {
            $rules['staff_id'] = 'required';
        } else {
            $rules['item_id'] = 'required';
        }
        $this->validate($request, $rules);

        $dt1 = getDateFormat($request->date_from, 'ymd');
        $dt2 = getDateFormat($request->date_to, 'ymd');
        $data = Issue::join("issue_dets", 'issues.id', '=', 'issue_dets.issue_id')
            ->join('locations', 'issues.loc_id', '=', 'locations.id')
            ->join('items', 'issue_dets.item_id', '=', 'items.id')
            ->leftJoin('staff', 'issues.staff_id', '=', 'staff.id')
            ->leftJoin('desigs', 'staff.desig_id', '=', 'desigs.id')
            ->leftJoin('departments', 'staff.dept_id', '=', 'departments.id')
            ->whereBetween('issues.issue_dt', [$dt1, $dt2])->where('issues.store_id', $request->store_id)
            ->select([
                'locations.location', 'items.item', 'staff.name as first_name','staff.middle_name as middle_name','staff.last_name as last_name', 'desigs.name as desig',
                'departments.name as dept', 'issue_dets.req_for', 'issue_dets.description',
                DB::raw('sum(issue_dets.req_qty) as qty')
            ])->groupBy(DB::raw("1,2,3,4,5,6,7"))->orderBy('locations.location');
        if (intval($request->item_id) > 0) {
            $data = $data->where('issue_dets.item_id', $request->item_id);
        }
        if (intval($request->staff_id) > 0) {
            $data = $data->where('issues.staff_id', $request->staff_id);
        }
        if (intval($request->loc_id) > 0) {
            $data = $data->where('issues.loc_id', $request->loc_id);
        }

        $data = $data->get();
        // loc_name
        // item_name
        // staff_name
        // desig
        // dept
        // req_for
        // desc
        // clos_stock

        // dd($request->all());
        return $data;
    }
}
