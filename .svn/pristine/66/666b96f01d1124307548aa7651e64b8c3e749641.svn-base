<?php

namespace App\Http\Controllers\NightOut;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nightout\NightOut;
use Carbon\Carbon;
use App\Models\Hostel\HostelNightOut;
use App\Models\Hostel\HostelAttendence;

class NightOutController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $night_outs = HostelNightOut::orderBy('return_status','ASC')
                ->with('student.hostel_location.block')->get();
            return reply(true,[
                'night_outs' =>$night_outs
            ]);
        }
        return view('hostels.nightout.index');
    }

    public function create()
    {
        return view('hostels.nightout.create');
    }

   
    public function store(Request $request)
    {
        $this->validate($request,
            [
                'roll_no' =>'required',
                'departure_date' => 'required|date_format:d-m-Y',
                'expected_return_date' => 'required|date_format:d-m-Y',
                'departure_time' => 'required|date_format:H:i',
                'destination_address'=>'required|max:200',
                'remarks'=>'nullable|max:400'
        ]);
        
        $attendance_date = Carbon::createFromFormat('d-m-Y', $request->departure_date)->format('Y-m-d');

        if($request->id > 0){
            $night_out = HostelNightOut::findOrFail($request->id);
            $expected_date =  Carbon::createFromFormat('d-m-Y', $night_out->expected_return_date);
            $actual_date =  Carbon::createFromFormat('d-m-Y', $request->expected_return_date);
            if($expected_date->greaterThan($actual_date)){
                $days = $expected_date->diffInDays($actual_date);
                // $$attendance_date = $request->actual_date;
                for($i=0;$i<$days ;$i++){
                    $attendance_date = Carbon::createFromFormat('d-m-Y',  $request->expected_return_date)->addDays($i)->format('Y-m-d');;
                    $attendance = HostelAttendence::where('attendance_date',$attendance_date)->where('roll_no',$request->roll_no)->first();
                    if($attendance){
                        $attendance->delete();   
                    }
                }
                
            }
            $night_out->fill($request->all());
            $night_out->update();

        }
        else{

            $night_out = HostelNightOut::where('roll_no', $request->roll_no)
                            ->where('departure_date',$attendance_date)->first();
            if(!$night_out){
                $night_out = new HostelNightOut();
            }
            $night_out->fill($request->all());
            $night_out->save();

        
            $start_date = Carbon::createFromFormat('d-m-Y',$request->departure_date);
            $end_date   = Carbon::createFromFormat('d-m-Y',$request->expected_return_date);
            
            $days = $start_date->diffInDays($end_date);
            if($days >= 1){
                for($i=0;$i<$days ;$i++){
                    if($i > 0){
                        $attendance_date = Carbon::createFromFormat('d-m-Y', $request->departure_date)->addDays($i);
                    }
                    $attendance = HostelAttendence::firstOrCreate([
                        'attendance_date'=>$attendance_date,
                        'roll_no'=>$request->roll_no,
                    ]);
                    $attendance->status  = 'N';
                    $attendance->remarks  = $request->remarks;
                    $attendance->update();   
                }
            }
        }

        return reply(true,
        [
            'night_out' => $night_out
        ]);

    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $night_out = HostelNightOut::findOrFail($id);
        $night_out->load('student');
        return reply(true,
        [
            'night_out' =>$night_out
        ]);
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
