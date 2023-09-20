<?php

namespace App\Http\Controllers\Reports\Placement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Placement\Placement;
use Illuminate\Support\Facades\DB;
use Gate;

class PlacementRecordDriveWiseReportController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('placement-drive-wise-report')){
            return deny();
        }
        if (!request()->ajax()) {
            return view('placement.reports.placement_record_drive_wise');
        }
        $session = $request->year;
        $database = getYearlyDbConnFromDb($session);
        $place_stds = DB::table($database. '.placement_students')
                    ->select([
                        'placement_id',
                        DB::raw("sum(1) as ap"),
                        DB::raw("sum(case when status = 'SL' then  1 else 0 end) as sl"),
                        DB::raw("sum(case when status = 'Selected' then 1 else 0 end) as sel"),
                        // DB::raw("max(case when status = 'AP' then 0 when status = 'SL' then 1 else 2 end) as status")
                    ])->groupBy('placement_id');
        // dd($place_stds->get());
        $qry = '('.$place_stds->toSql().')a1';
        // dd($qry);
        // dd($place_stds->toSql());
        $data = DB::table($database. '.placements')
                // ->joinSub($place_stds,'a1','a1.placement_id', '=', 'placements.id')
                ->leftJoin(DB::raw("$qry"),'a1.placement_id', '=', 'placements.id')
                ->join('placement_companies', 'placements.comp_id', '=', 'placement_companies.id')
                ->leftJoin($database.'.resources', function ($join) {
                    $join->on('resources.resourceable_id', '=', 'placements.id')
                        ->where('resources.resourceable_type', '=', Placement::class);
                })
                ->select([
                    'placements.drive_date',
                    'placements.id as place_id',
                    'placement_companies.name as comp_name'
                    ,'placements.hr_personnel as per_desig','placements.contact_no as phone','placements.email as email',
                    'placements.stu_reg as reg_stu','placement_companies.add as comp_add','placement_companies.comp_type as type',
                    'placement_companies.comp_nature as comp_nature','a1.ap','a1.sl','a1.sel','resources.resourceable_id',
                    DB::raw("$session as session"),
                    DB::raw("'' as comp_turnover"),
                    DB::raw("a1.sl+a1.sel as tot_sl"),
                    // DB::raw("sum(case when a1.status = 0 then  1 else 0 end) as ap"),
                    // DB::raw("sum(case when a1.status = 1 then  1 else 0 end) as sl"),
                    // DB::raw("sum(case when a1.status = 2 then  1 else 0 end) as sel"),
                ])->groupBy(DB::raw('1,2,3,4,5,6,7,8,9,10,11','12','13','14'));
        if (intval($request->comp_id) != 0) {
            $data = $data->where('placements.comp_id', $request->comp_id);
        }

        $data = $data->get();
        // dd($data);
        // dd($data);
        // dd($request->all());
        // session
        // comp_name
        // drive_date
        // per_desig
        // phone
        // email
        // reg_stu
        // appear_std
        // shortlisted_std
        // select_std
        // comp_turnover
        // comp_add
        // type
        // comp_nature
        return $data;
    }
}
