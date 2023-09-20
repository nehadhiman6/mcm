<?php

namespace App\Http\Controllers\NightOut;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hostel\HostelNightOut;
use App\Location;
use Carbon\Carbon;
use App\Models\Hostel\HostelAttendence;

class NightOutReturnController extends Controller
{
    
    public function index()
    {
        return view('hostels.nightout.index');
    }

    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $night_out = HostelNightOut::findOrFail($request->id);
        $night_out->actual_return_date = $request->actual_return_date;
        $night_out->return_status = 'R';
        $night_out->remarks = $request->remarks;
        $night_out->save();

        $actual_date = Carbon::createFromFormat('d-m-Y',$night_out->actual_return_date);
        $expected_date =  Carbon::createFromFormat('d-m-Y', $night_out->expected_return_date);
      
        if($expected_date->greaterThan($actual_date)){
            $days = $expected_date->diffInDays($actual_date);
            // $$attendance_date = $request->actual_date;
            for($i=0;$i<$days ;$i++){
                $attendance_date = Carbon::createFromFormat('d-m-Y',  $request->actual_return_date)->addDays($i)->format('Y-m-d');;
                $attendance = HostelAttendence::where('attendance_date',$attendance_date)->where('roll_no',$request->roll_no)->first();
                if($attendance){
                    $attendance->delete();   
                }
            }
            
        }
        return reply(true,[
            'night_out' => $night_out
        ]);
    }

    
    public function show(Request $request)
    {
        
        $night_outs = HostelNightOut::leftJoin('students', function ($q) use($request )  {
            $q->on('hostel_night_out.roll_no', '=', 'students.roll_no');
        });
        if($request->block_id > 0){
            $locations = Location::where('block_id',$request->block_id)->pluck('id')->toArray();
            $night_outs->whereIn('students.hostel_room_id',$locations);
        }

        if($request->location_id > 0){
            $night_outs = $night_outs->where('students.hostel_room_id',$request->location_id);
        }

        if ($request->upto_date == '' && $request->from_date != '') {
            $night_outs = $night_outs->where('hostel_night_out.departure_date', getDateFormat($request->from_date, "ymd"));
        } else if($request->upto_date != '' && $request->from_date != ''){
            $night_outs = $night_outs->where('hostel_night_out.departure_date', '>=', getDateFormat($request->from_date, "ymd"))
            ->where('hostel_night_out.departure_date', '<=', getDateFormat($request->upto_date, "ymd"));
        
        }
        $night_outs = $night_outs->where('return_status','P');
        $night_outs= $night_outs->select(['hostel_night_out.*','students.name'])->get();
        
        return reply(true,
        [
            'night_outs' => $night_outs
        ]);
    }

    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }
}
