<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ExamLocation\ExamLocation;
use DB;
use App\Models\ExamLocation\ExamLocationDetail;
use App\Models\SeatingPlan\SeatingPlanStaff;
use App\Models\DateSheet\DateSheet;
use Carbon\Carbon;
use App\Student;
use Gate;

class ExamLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::denies('exam-location-list')) {
            return deny();
        }
  
        if($request->ajax()){
            $exam_location = ExamLocation::orderBy('created_at', 'desc');
            $count = $exam_location->count();
            if ($searchStr = $request->input('search.value')) {
                $exam_location = $exam_location->where('id', 'like', "%{$searchStr}%");
                $filteredCount = $exam_location->count();
            }
            $exam_location = $exam_location->take($request->length);
            $filteredCount = $exam_location->count();
            if ($request->start > 0) {
                $exam_location->skip($request->start - 1);
            }
            $exam_location = $exam_location->get();
            $exam_location->load([ 'location','exam_loc_dets']);
            // dd($exam_location);CRS
            return [
                'draw' => intval($request->draw),
                'start' => $request->start,
                'data' => $exam_location,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('examinations.exam_locations');
    }

    public function validateForm($request)
    {
        $this->validate($request,[
            // 'loc_id'=>'required|exists:locations,id|unique:exam_locations,loc_id,'.$request->loc_id.','.$request->id .',id,center,'.$request->center,
            'loc_id'=>'required|exists:locations,id|unique:' .getYearlyDbConn(). '.exam_locations,loc_id,'.$request->id,
            'seating_capacity'=>'required|min:1|integer',
            'no_of_rows'=>'required|integer|min:1',
            'center'=>'required',
            'dets.*.row_no'=>'required|min:1|integer',
            'dets.*.seats_in_row'=>'required|min:1|integer'
        ],[
            'dets.*.row_no.required'=>'Row Number is required',
            'dets.*.seats_in_row.required'=>'Number of seats are required',
            'dets.*.seats_in_row.integer'=>'Number of seats must be a Number',
            'loc_id.unique'=>'This location is already taken for another exam location.'
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('exam-location-modify')) {
            return deny();
        }
        $this->validateForm($request);

        $exam_location =  ExamLocation::firstOrNew(['loc_id'=>$request->loc_id,'center'=>$request->center]);
        $exam_location->fill($request->all());

        $old_ids = $exam_location->exam_loc_dets->pluck('id')->toArray();

        $exam_location_details =  new \Illuminate\Database\Eloquent\Collection();
        foreach($request->dets as  $det){
            $exam_loc_det = ExamLocationDetail::firstOrNew(['exam_location_id'=>$exam_location->id,'row_no'=>$det['row_no']]);
            $exam_loc_det->row_no = $det['row_no'];
            $exam_loc_det->seats_in_row = $det['seats_in_row'];
            $exam_location_details->add($exam_loc_det);
        }

        $new_ids = $exam_location_details->pluck('id')->toArray();
        $detach = array_diff($old_ids, $new_ids);

        DB::connection(getYearlyDbConn())->beginTransaction();
            $exam_location->save();
            $exam_location->exam_loc_dets()->saveMany($exam_location_details);
            ExamLocationDetail::whereIn('id',$detach)->delete();
        DB::connection(getYearlyDbConn())->commit();
        return reply(true);
    }

    
    public function getCenterLocations(Request $request)
    {
        $exam_locations = ExamLocation::where('center',$request->center)->get();
        $exam_locations->load(['location']);
        return reply(true,[
            'locations'=> $exam_locations,
        ]);
    }

   
    public function edit($id)
    {
        if (Gate::denies('exam-location-modify')) {
            return deny();
        }
        $exam_location = ExamLocation::findOrFail($id);
        $exam_location->load(['location','exam_loc_dets']);
        return view('examinations.exam_locations',compact('exam_location'));
    }

    
  

  
    public function destroy($id)
    {
        //
    }
}
