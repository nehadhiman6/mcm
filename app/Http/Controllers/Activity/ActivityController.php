<?php

namespace App\Http\Controllers\Activity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activity\Activity;
use App\Models\Activity\ActivityCollaboration;
use App\Models\Activity\Orgnization;
use App\Models\Activity\ActivityGuest;
use DB;
use Gate;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('activities')) {
            return deny();
        }
        if(!$request->ajax())
        {
            return view('activities.activities.index');
        }
        $count = Activity::all()->count();
        $filteredCount = $count;
        $activities = Activity::orderBy('id', 'DESC');
        if ($searchStr = $request->input('search.value')) {
            $activities = $activities->where('', 'like', "%{$searchStr}%");
        }
        
        $activities = $activities->take($request->length);
        $filteredCount = $activities->count();
        $dt1 = getDateFormat($request->date_from, 'ymd');
        $dt2 = getDateFormat($request->date_to, 'ymd');
        // if ($dt1 > $dt2) {
        //     $this->validate(
        //         $request,
        //         ['date' => 'required'],
        //         ['date.required' => "Date From can't Greater than Date To"]
        //     );
        // }
        if($request->date_from) {
            $activities = $activities->whereBetween('start_date', [$dt1, $dt2]);
        }
        if ($request->start > 0) {
            $activities->skip($request->start - 1);
        }
        $activities = $activities->select(['activities.*'])->distinct()->get();
        $activities->load('orgnization.agency','acttype','actgrp','sponsor','colloboration.orgnization.agency','colloboration.collo_organization','guest'); 
        return [
            'draw' => intval($request->draw),
            'start'=>$request->start,
            'data' => $activities,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
        
    }

    public function create()
    {
        if (Gate::denies('add-activities')) {
            return deny();
        }
        return view('activities.activities.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('activities-modify')) {
            return deny();
        }
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id=0)
    {
        $this->validateForm($request, $id);
        $activity = Activity::findOrNew($request->id);
        $activity->fill($request->all());
        $this->saveGuest($request, $activity, $id);
        $act_collaboration = ActivityCollaboration::firstOrNew(['act_id' => $activity['id']]);
        $act_collaboration->act_id = $activity->id;
            if($act_collaboration->id > 0){
                if($act_collaboration->id > 0 && $request->internal == "External"){
                    $act_collaboration->agency_id = null;
                    $act_collaboration->agency_name = $request->agency_name;
                }
                else if($act_collaboration->id > 0 && $request->internal == "Internal"){
                    $act_collaboration->agency_name = null; 
                    $act_collaboration->agency_id = $request->agency_id;
                }
                else{
                    ActivityCollaboration::where('id', $act_collaboration->id)->delete();
                }
            }
            else{
                $act_collaboration->agency_id = $request->agency_id;
                $act_collaboration->agency_name = $request->agency_name;
            }
            $act_collaboration->colloboration_with_id = $request->colloboration_with_id;
            $act_collaboration->save();
        return reply('true',[
            'activity' => $activity
        ]);
    }

    private function saveGuest(Request $request, $activity,$id)
    {
        $guestids = $activity->guest->pluck('id')->toArray();
        $guests =  new \Illuminate\Database\Eloquent\Collection();
        $count = 1;
        foreach($request->guest as  $det){
            if($det['guest_name'] != '' || $det['guest_designation'] != '' || $det['guest_affiliation'] != '' ||$det['address'] != '' ){
                $guest = ActivityGuest::findOrNew($det['id']);
                $guest->fill($det);
                $guest->order_no = $count++;
                $guest->act_id = $activity->id;
                $guests->add($guest);
            }
        }
        $new_ids = $guests->pluck('id')->toArray();
        $guest = array_diff($guestids, $new_ids);
        DB::beginTransaction();
        $activity->save();
        $activity->guest()->saveMany($guests);
        ActivityGuest::whereIn('id', $guest)->delete();
        DB::commit();

    }

    private function validateForm(Request $request, $id)
    {
        $rules= [
            'start_date' => 'required|date:"d-m-y"',
            'end_date' => 'required|date:"d-m-y"|after_or_equal:'.$request->start_date,
            'org_agency_id'=> 'required|integer|exists:orgnization,id',
            'act_type_id'=> 'required|integer|exists:master_types,id',
            'act_grp_id'=> 'required|integer|exists:master_types,id',
            'topic' => 'nullable|string|max:500',
            'sponsor_address' => 'nullable|string|max:200',
            'sponsor_by_id' => 'nullable',
            'college_teachers' => 'nullable|numeric',
            'sponsor_amt' => 'nullable|numeric',
            'college_students' => 'nullable|numeric',
            'college_nonteaching' => 'nullable|numeric',
            'outsider_teachers' => 'nullable|numeric',
            'outsider_students' => 'nullable|numeric',
            'outsider_nonteaching' => 'nullable|numeric',
        ];
        $messages=[];
        // if($request->start_date > $request->end_date){
        //     $rules['date'] = 'required';
        //     $messages['date.required'] = "Start date can't Greater than End date";
            

        // }

        if ($request->collo_checkbox == 'Y') {
            $rules += [
                'agency_id' => 'required|integer|exists:master_types,id'
            ];
        }
        $this->validate($request,$rules,$messages);
    }


    public function edit($id)
    {
        if (Gate::denies('activities-modify')) {
            return deny();
        }
        $activity = Activity::findOrFail($id);
        $activity->load('orgnization','acttype','colloboration.orgnization','guest');
        return view('activities.activities.create', compact('activity'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('activities-modify')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }

    public function  destroy(Request $request, $id){
        if (Gate::denies('activities-remove')) {
            return deny();
        }
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return reply('true',[
            'activity' => $activity
        ]);
    }

    public function getOrnization($org)
    {
        $orgnization = Orgnization::where('agency_type_id', $org)->get();
        return reply(true,
            [
                'orgnization' => $orgnization
            ]);
    }
}
