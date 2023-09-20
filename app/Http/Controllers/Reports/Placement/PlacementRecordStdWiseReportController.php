<?php

namespace App\Http\Controllers\Reports\Placement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Placement\Placement;
use App\Models\Placement\PlacementStudent;
use Gate;
use Illuminate\Support\Facades\DB;

class PlacementRecordStdWiseReportController extends Controller
{
    public function index(Request $request)
    {

        if (Gate::denies('placement-std-wise-report')){
            return deny();
        }
        if (!request()->ajax()) {
            return view('placement.reports.placement_record_std_wise');
        }
        // $this->validate($request, [
        //     'year' => 'required',
        // ]);
        $session = $request->year;
        $database = getYearlyDbConnFromDb($session);
        $data = DB::table($database. '.placements')
                ->join($database. '.placement_students','placements.id','=','placement_students.placement_id')
                // ->join(getYearlyDb().'.students','placement_students.std_id','=','students.id')
                ->join($database.'.courses','placement_students.course_id','=','courses.id')
                ->join(getSharedDb() . 'placement_companies', 'placements.comp_id', '=', 'placement_companies.id')
                // ->join(getYearlyDb().'.resources','resources.resourceable_id','=','placements.id')
                ->leftJoin($database.'.resources', function ($join) {
                    $join->on('resources.resourceable_id', '=', 'placement_students.id')
                        ->where('resources.resourceable_type', '=', PlacementStudent::class);
                })
                ->select([
                    'placement_students.name','courses.course_name as class','placement_students.roll_no','placements.drive_date as date','placement_companies.name as comp_name'
                    ,'placement_students.pay_package as pack_offer','placement_students.job_profile as post','placements.nature as nature_drive',
                    'placements.type as wether','placements.min_salary as mini_salary','placements.max_salary as max_salary','placement_students.phone as contact_detail'
                    ,'placement_students.email as email','placement_students.id as place_std_id','resources.resourceable_id','placement_students.letter_type',
                   'placement_students.session as session'
                ]);
        // $data = DB::table($database. '.placements')
        //         ->join(getYearlyDb(). '.placement_students','placements.id','=','placement_students.placement_id')
        //         ->join(getYearlyDb().'.students','placement_students.std_id','=','students.id')
        //         ->join(getYearlyDb().'.courses','students.course_id','=','courses.id')
        //         ->join('placement_companies', 'placements.comp_id', '=', 'placement_companies.id')
        //         // ->join(getYearlyDb().'.resources','resources.resourceable_id','=','placements.id')
        //         ->leftJoin(getYearlyDb().'.resources', function ($join) {
        //             $join->on('resources.resourceable_id', '=', 'placement_students.id')
        //                 ->where('resources.resourceable_type', '=', PlacementStudent::class);
        //         })
        //         ->select([
        //             'students.name','courses.course_name as class','students.roll_no','placements.drive_date as date','placement_companies.name as comp_name'
        //             ,'placement_students.pay_package as pack_offer','placement_students.job_profile as post','placements.nature as nature_drive',
        //             'placements.type as wether','placements.min_salary as mini_salary','placements.max_salary as max_salary','students.mobile as contact_detail'
        //             ,'placement_students.email as email','placement_students.id as place_std_id','resources.resourceable_id','placement_students.letter_type',
        //             DB::raw("$session as session"),
        //         ]);
        // if ($request->year) {
        //     $data = $data->where('placement_students.session', $request->year);
        // }

        if (intval($request->comp_id) != 0) {
            $data = $data->where('placements.comp_id', $request->comp_id);
        }
        if (intval($request->course_id) != 0) {
            $data = $data->where('placement_students.course_id', $request->course_id);
        }
        if ($request->type != 'A') {
            $data = $data->where('placements.type', $request->type);
        }

        $data = $data->get();
            // dd($data);
        // dd($request->all());
        // name
        // class
        // roll_no
        // date
        // session
        // comp_name
        // pack_offer
        // post
        // offer_letter
        // sel_email
        // nature_drive
        // wether
        // mini_salary
        // max_salary
        // contact_detail
        // email
        // photo

        // dd($request->all());
        return $data;
    }
}
