<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DateSheet\DateSheet;
use Carbon\Carbon;
use App\SubjectSection;
use App\Models\ExamLocation\ExamLocation;
use App\Models\SeatingPlan\SeatingPlanStaff;
use App\Staff;
use App\Models\SeatingPlan\SeatingPlan;
use App\Models\SeatingPlan\SeatingPlanDetail;
use DB;
use App\Student;
use App\SubSectionStudent;

class SeatingPlanController extends Controller
{
   
    public function index(Request $request)
    {
        if (Gate::denies('seating-plan-list')) {
            return deny();
        }
        
        $date_sheet = DateSheet::findOrFail($request->id);
        $date_sheet->load(['course','subject']);
        return view('examinations.seating_plan_datesheet',compact('date_sheet'));
    }

    public function seatingPlanList(Request $request){
        return view('examinations.seating_plan_list');
    }

    public function getSeatingPlan(Request $request){
        $this->validate($request,[
            'exam_name'=>'required|not_in:0',
        ],
        [
            'exam_name.not_in'=>'Examination is required!'
        ]);

        // $location = ExamLocation::join('seating_plans','seating_plans.exam_loc_id','=','exam_locations.id');
        $location = SeatingPlan::orderBy('exam_loc_id');
        if($request->center){
            $exam_locations_centers = ExamLocation::where('center',$request->center)->get()->pluck('id');
            $location =  $location->whereIn('exam_loc_id',$exam_locations_centers);
        }
        if($request->session){
            $location = $location->where('seating_plans.session','=',$request->session);
        }

        if($request->date != '' && $request->date != 'All'){
            $location = $location->where('seating_plans.date','=',Carbon::createFromFormat('d-m-Y',$request->date)->toDateString());
        }
        $location =  $location->with(['exam_location.location','date_sheet','subject_section.course',
            'subject_section.course','subject_section.section','subject_section.subject','seating_plan_details.student:roll_no,id','seating_plan_staff']);
        $count = $location->count();

        $location = $location->take($request->length);
        if ($request->start > 0) {
            $location->skip($request->start);
        }
        $filteredCount = $location->count();

        $location = $location->get();

        return [
            'draw' => intval($request->draw),
            'start' => $request->start,
            'data' => $location,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
    }

    
    public function create(Request $request)
    {
        $compare_date =  Carbon::createFromFormat('d-m-Y',$request->date)->toDateString();
        $same_day_datesheets = DateSheet::where('date',$compare_date)->with(['subject','course']);
        $count = $same_day_datesheets->count();
        if ($searchStr = $request->input('search.value')) {
            $same_day_datesheets = $same_day_datesheets->where('id', 'like', "%{$searchStr}%");
            $filteredCount = $same_day_datesheets->count();
        }
        $same_day_datesheets = $same_day_datesheets->take($request->length);
        $filteredCount = $same_day_datesheets->count();

        if ($request->start > 0) {
            $same_day_datesheets->skip($request->start - 1);
        }

        $same_day_datesheets = $same_day_datesheets->get();
        $same_day_datesheets->load([ 'subject','course']);
        // dd($same_day_datesheets);CRS
        return [
            'draw' => intval($request->draw),
            'start' => $request->start,
            'data' => $same_day_datesheets,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
    }

    
    public function store(Request $request)
    {
        $this->validateFrom($request);
        return $this->save($request);
    }

    public function save($request)
    {
       
        $date_sheet = DateSheet::findOrFail($request->seating_plan['date_sheet_id']);
        // dd($date_sheet);
        // $seating_plan = new SeatingPlan();
        $seating_plan = SeatingPlan::firstOrNew(['sub_sec_id'=> $request->seating_plan['sub_sec_id'],
                    'date_sheet_id'=>$request->seating_plan['date_sheet_id'],'exam_loc_id'=>$request->seating_plan['exam_loc_id']]);
        
        $seating_plan->date_sheet_id = $request->seating_plan['date_sheet_id'];
        $seating_plan->exam_loc_id = $request->seating_plan['exam_loc_id'];
        $seating_plan->date =  $date_sheet->date;
        $seating_plan->session = $date_sheet->session;
        $seating_plan->sub_sec_id = $request->seating_plan['sub_sec_id'];
        $seating_plan->occupied_seats = (int)$seating_plan->occupied_seats + $request->seating_plan['occupied_seats'];
        $seating_plan->gap_seats = (int)$seating_plan->gap_seats  + $request->seating_plan['gap_seats'];
        $seating_plan->total_seats = (int)$seating_plan->total_seats  + (int) $request->seating_plan['gap_seats'] + (int) $request->seating_plan['occupied_seats'];
        $starting_seat = SeatingPlanDetail::leftJoin('seating_plans','seating_plans.id','=','seating_plan_dets.seating_plan_id')
                ->where('seating_plans.session','=',$date_sheet->session)
                ->where('seating_plans.exam_loc_id','=',$request->seating_plan['exam_loc_id'])
                ->where('seating_plans.date',Carbon::createFromFormat('d-m-Y',$date_sheet->date)->toDateString())
                ->max('seating_plan_dets.seat_no');
                        // $starting_seat = 11;
    
        if(!$starting_seat){
            $starting_seat = 1;
        }
        else{
            $starting_seat++;    
        }


        $exam_location = ExamLocation::findOrFail($request->seating_plan['exam_loc_id']);
        $exam_location->load('exam_loc_dets');

        $starting_seat= $starting_seat  + (int) $request->seating_plan['gap_seats'];
        $seating_plan_dets =  new \Illuminate\Database\Eloquent\Collection();

        $students = array_slice($request->students, 0, $request->seating_plan['occupied_seats']);
        foreach($students as $student){
            $seating_plan_det = new SeatingPlanDetail();
            $seating_plan_det->std_id = $student['id'];
            $seating_plan_det->seat_no = $starting_seat++;
            $seating_plan_det->row_no = $this->getSeatRow($exam_location,$seating_plan_det->seat_no );
            $seating_plan_dets->add($seating_plan_det);
        }

        // for remove old staff
        $staff_asigned_to_location = SeatingPlanStaff::where('exam_loc_id',$request->seating_plan['exam_loc_id'])
                ->where('session',$date_sheet->session)
                ->where('date', Carbon::createFromFormat('d-m-Y',$date_sheet->date)->toDateString())
                ->get()
                ->pluck('id')->toArray();

        $seating_plan_staffs =  new \Illuminate\Database\Eloquent\Collection();
        foreach($request->seating_plan_staff as $staff){
            // $seating_plan_staff= SeatingPlanStaff::firstOrNew(['staff_id'=>$staff,'session'=>$date_sheet->session,
            //         'date'=> Carbon::createFromFormat('d-m-Y',$date_sheet->date)->toDateString()
            // ]);
            $seating_plan_staff= SeatingPlanStaff::where('staff_id',$staff)->where('session',$date_sheet->session)
                    ->where('date', Carbon::createFromFormat('d-m-Y',$date_sheet->date)->toDateString())->first();
            if(!$seating_plan_staff){
                $seating_plan_staff= new SeatingPlanStaff();
            }
            $seating_plan_staff->staff_id = $staff;
            $seating_plan_staff->date_sheet_id = $request->seating_plan['date_sheet_id'];
            $seating_plan_staff->session = $date_sheet->session;
            $seating_plan_staff->exam_name = $date_sheet->exam_name;
            $seating_plan_staff->date = $date_sheet->date;
            $seating_plan_staff->exam_loc_id = $request->seating_plan['exam_loc_id'];
            $seating_plan_staffs->add($seating_plan_staff);
        }

        $new_staff_ids = $seating_plan_staffs->pluck('id')->toArray();
        $detach = array_diff($staff_asigned_to_location, $new_staff_ids);

        DB::connection(getYearlyDbConn())->beginTransaction();
            $seating_plan->save();
            $seating_plan->seating_plan_details()->saveMany($seating_plan_dets);
            $seating_plan->seating_plan_staff()->saveMany($seating_plan_staffs);
            SeatingPlanStaff::whereIn('id',$detach)->delete();
        DB::connection(getYearlyDbConn())->commit();
        return reply(true);
    }

    public function getSeatRow($exam_location, $seat_no){
        $count = 1;
        foreach($exam_location->exam_loc_dets as $location){
            for($i = 0; $i< $location->seats_in_row ; $i++){
                if($count ==  $seat_no){
                    return $location->row_no;
                }
                $count++;
            }
        }
        
    }

    public function show($id)
    {
        $date_sheet = DateSheet::findOrFail($id);
        $date = $date_sheet->date;
        return view('examinations.seating_plan',compact('date'));
    }

    
    public function subjectSectionStrength(Request $request)
    {

        $subject_section = SubjectSection::findOrFail($request->sub_sec_id);
        // $subject_section_pending = Student::join('sub_sec_students','sub_sec_students.std_id','=','students.id')
        //     ->leftjoin('seating_plans','seating_plans.sub_sec_id','=','sub_sec_students.sub_sec_id')
        //     ->leftjoin('seating_plan_dets',function($join){
        //         $join->on('seating_plan_dets.seating_plan_id','=','seating_plans.id')
        //         ->on('sub_sec_students.std_id','=','seating_plan_dets.std_id');
        //     })
        //     ->where('sub_sec_students.sub_sec_id',$request->sub_sec_id)
        //     ->whereNull('seating_plan_dets.id')
        //     ->select('students.*')
        //     ->get();

        $subject_sec_students_ids = SubSectionStudent::where('sub_sec_id',$request->sub_sec_id)->get()->pluck('std_id')->toArray();
        $seating_plan_students_ids = SeatingPlan::join('seating_plan_dets','seating_plan_dets.seating_plan_id','=','seating_plans.id')
                    ->where('seating_plans.sub_sec_id','=',$request->sub_sec_id)
                    ->select('seating_plan_dets.std_id')->get()->pluck('std_id');         

        $subject_section_pending = Student::whereIn('id',$subject_sec_students_ids)
            ->whereNotIn('id',$seating_plan_students_ids)->orderBy('roll_no')
            ->get();

        $count = count($subject_section->subSecStudents);
        return reply(true,[
            'section_strength'=> $count,
            'section_pending_strength'=>   count($subject_section_pending),
            'students'=>$subject_section_pending

        ]);
    }

    public function getLocationSeats(Request $request)
    {
        $exam_location = ExamLocation::findOrFail($request->exam_loc_id);
        $exam_location->load(['location','exam_loc_dets']);

        $date_sheet = DateSheet::findOrFail($request->date_sheet_id);
        $compare_date =  Carbon::createFromFormat('d-m-Y',$date_sheet->date)->toDateString();
        $session = $date_sheet->session;
        $seating_plan_staff = null;

        $staff= Staff::leftjoin(getYearlyDb() .'.seating_plan_staff',function($join) use( $session,$compare_date) {
                $join->on('seating_plan_staff.staff_id','=','staff.id')
                ->where('seating_plan_staff.session','=',$session)
                ->where('seating_plan_staff.date','=',$compare_date);
        })
        ->whereNull('seating_plan_staff.staff_id')
        ->select('staff.*')->get();

        $seating_plan_staff = Staff::join(getYearlyDb() .'.seating_plan_staff',function($join) use( $session,$compare_date,$request) {
            $join->on('seating_plan_staff.staff_id','=','staff.id')
            ->where('seating_plan_staff.session','=',$session)
            ->where('seating_plan_staff.date','=',$compare_date)
            ->where('seating_plan_staff.exam_loc_id','=',$request->exam_loc_id);
        })->select('staff.*')->get();


        $staff = $staff->merge($seating_plan_staff);
        
        $filled_seats = ExamLocation::join('seating_plans','seating_plans.exam_loc_id','=','exam_locations.id')
            ->where('seating_plans.date','=',$compare_date)
            ->where('seating_plans.session','=',$date_sheet->session)
            ->where('seating_plans.exam_loc_id','=',$request->exam_loc_id)
            ->sum('total_seats');

        $vacant_seats = $exam_location->seating_capacity - $filled_seats;

        return reply(true,[
            'location'=> $exam_location,
            'vacant_seats'=>$vacant_seats,
            'seating_plan_staff'=> $seating_plan_staff,
            'staff'=>$staff
        ]);
    }

    
    public function validateFrom($request)
    {
        $rules =[
            'seating_plan.date_sheet_id'=>'required|exists:' . getYearlyDbConn() . '.date_sheets,id',
            'seating_plan.exam_loc_id'=>'required|exists:' . getYearlyDbConn() . '.exam_locations,id',
            'seating_plan.sub_sec_id'=>'required|exists:' . getYearlyDbConn() . '.subject_sections,id',
            'seating_plan.occupied_seats'=>'required|integer|min:1',
            'seating_plan.gap_seats'=>'nullable|integer',
            'vacant_seats'=>'required|integer|min:1',
            'students'=>'required|Array|min:1',
            'seating_plan_staff'=>'Array|required|min:1',
        ];

        $occupied_seats =(float)$request->seating_plan['occupied_seats'] +  (float)$request->seating_plan['gap_seats'];
        if($occupied_seats > $request['vacant_seats']){
            $left = (float)$request['vacant_seats']- (float)$request->seating_plan['gap_seats'];
            $rules =[
                'seating_plan.occupied_seats'=>'integer|max:'.$left,
            ];
        }
        $this->validate($request,$rules,[
            'seating_plan.occupied_seats.max'=>'Occupied Seats(Filled + Gap) cannot be greater than vacant Seats',
            'students.min'=>'There is no student pending in the selected section',
            'students.required'=>'There is no student pending in the selected section'
        ]);

    }

    public function printSeatingPlan(Request $request){
        dd($request->all());

        // $gate = GateIn::findOrFail($id);
        $print = new \App\Printings\GateInPrint();
        $pdf = $print->makepdf();
        $pdf->Output("Bill.pdf", 'I');
        exit();

    }
}
