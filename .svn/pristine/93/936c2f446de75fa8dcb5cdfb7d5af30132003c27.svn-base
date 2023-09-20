<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SeatingPlan\SeatingPlanDetail;
use App\Models\ExamLocation\ExamLocation;
use Carbon\Carbon;
use Gate;

class SeatingPlanLocationController extends Controller
{
  
    public function index()
    {
        if (Gate::denies('seating-plan-location')) {
            return deny();
        }
        return view ('examinations.locationwise_plan');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'center'=>'required|not_in:0',
            'exam_name'=>'required|not_in:0',
            'session'=>'required|not_in:0',
            // 'date'=>'required|date_format:d-m-Y'
        ]);

        $seating_plan_students = $this->getSeatingPlanRecord($request);
        return reply(true,[
            'seating_plan_students'=>$seating_plan_students
        ]);
    }

    public function getSeatingPlanRecord(Request $request){
        $seating_plan_students = SeatingPlanDetail::join('seating_plans',function($join) use ($request){
            $join->on('seating_plans.id','=','seating_plan_dets.seating_plan_id');
            if($request->exam_loc_id > 0){
                $join->where('seating_plans.exam_loc_id','=',$request->exam_loc_id);
            }
        })
        ->join('date_sheets',function($join) use($request){
            $join->on('date_sheets.id','=','seating_plans.date_sheet_id')
            ->where('date_sheets.session','=',$request->session);
            if($request->date && $request->date != '' && $request->date != 'All'){
               $join->where('date_sheets.date','=',Carbon::createFromFormat('d-m-Y',$request->date)->toDateString());
            }
        })
        ->join('exam_locations',function($join) use ($request){
            $join->on('seating_plans.exam_loc_id','=','exam_locations.id')
            ->where('exam_locations.center','=',$request->center);
        });

        $seating_plan_students = $seating_plan_students->groupBy('seating_plan_dets.id')->with(['student:id,roll_no','seating_plan.exam_location.location',
                'seating_plan.exam_location.exam_loc_dets','seating_plan.subject_section.subject:subject,id','seating_plan.subject_section.course:course_name,id',
                'seating_plan.seating_plan_staff.staff','seating_plan.subject_section.section','seating_plan.subject_section.teacher'
                ])->orderBy('seat_no')
                ->select('seating_plan_dets.*')->get();
        return $seating_plan_students;
        
    }

    public function printSeatingPlan(Request $request)
    {
        $this->validate($request,[
            'center'=>'required|not_in:0',
            'exam_name'=>'required|not_in:0',
            'session'=>'required|not_in:0',
            // 'date'=>'required|date_format:d-m-Y'
        ]);

        $seating_plan_students = $this->getSeatingPlanRecord($request);

        $print = new \App\Printings\SeatingPlanPrint();
        $pdf = $print->makepdf($seating_plan_students);
        $pdf->Output("SeatingPlan.pdf", 'I');
    }
}
