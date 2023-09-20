<?php

namespace App\Http\Controllers;

use App\CourseSubject;
use App\Models\SubCombination\SubjectCombination;
use App\Models\SubCombination\SubjectCombinationDetail;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gate;

class SubjectCombinationController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('sub-combination')) {
            return deny();
        }
        if(!$request->ajax())
        {
            return view('subcombination.index');
        }
        $count = SubjectCombination::all()->count();
        $filteredCount = $count;
        $combinations = SubjectCombination::orderBy('id', 'DESC');
        if ($searchStr = $request->input('search.value')) {
            $combinations = $combinations->where('', 'like', "%{$searchStr}%");
        }
        
        $combinations = $combinations->take($request->length);
        $filteredCount = $combinations->count();
        if ($request->start > 0) {
            $combinations->skip($request->start - 1);
        }
        $combinations = $combinations->select(['sub_combination.*'])->distinct()->get();
        $combinations->load('details.subject','course',); 
        return [
            'draw' => intval($request->draw),
            'start'=>$request->start,
            'data' => $combinations,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
        
    }

    public function create()
    {
        if (Gate::denies('sub-combination')) {
            return deny();
        }
        return view('subcombination.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('sub-combination-modify')) {
            return deny();
        }
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id=0)
    {
        $this->validateForm($request, $id);
        $subject = SubjectCombination::findOrNew($request->form_id);
        $subject->fill($request->all());
        $detids = [];
        if ($request->form_id > 0) {
            $detids = $subject->details->pluck('id')->toArray();
        }
        $details = new \Illuminate\Database\Eloquent\Collection();
        $ele_id = ($request->course_id == 14) ? 6:0;
        foreach ($request->subject_ids as $det) {
            $sub_combination = SubjectCombinationDetail::firstOrNew(['sub_combination_id' => $request->form_id, 'subject_id' => $det]);
            $sub_combination->subject_id = $det;
            $details->add($sub_combination);
            if($request->course_id == 14) {
                $ele_id = ($det == 5) ? 7:$ele_id;
                $ele_id = ($det == 11) ? 8:$ele_id;
                $ele_id = ($det == 23) ? 9:$ele_id;
            }
        }
        $subject->ele_id = $ele_id;
        $new_ids = $details->pluck('id')->toArray();
        $detach = array_diff($detids, $new_ids);
        DB::connection(getYearlyDbConn())->beginTransaction();
        $subject->save();
        $subject->details()->saveMany($details);
        SubjectCombinationDetail::whereIn('id', $detach)->delete();
        DB::connection(getYearlyDbConn())->commit();
        return reply('ok', [
            'subject' => $subject
        ]);
      
    }

   

    private function validateForm(Request $request, $id)
    {
        $rules= [
          
            'course_id'=> 'required|integer',
            'code'=> 'required|',
        ];
        $messages=[];

        if (count($request->subject_ids) == 0) {
            $rules += [
                'msg' => 'required'
            ];
            $messages += ['msg.required' => 'Subject is Required'];

        }
        $combinations = SubjectCombination::where('course_id',$request->course_id)->pluck('combination')->toArray();  
        if(count($combinations) > 0){
            foreach($combinations as $comb){
                if($comb === $request->combination){
                    $rules += [
                        'comb_msg' => 'required'
                    ];

                    $messages += [
                        'comb_msg.required' => 'Combination is already use this course !!'
                    ];
                }
            }
        }
        $this->validate($request,$rules,$messages);
    }


    public function edit($id)
    {
        if (Gate::denies('sub-combination-modify')) {
            return deny();
        }
        $sub_combination = SubjectCombination::findOrFail($id);
        $sub_combination->load('details.subject','course');
        return view('subcombination.create', compact('sub_combination'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('sub-combination-modify')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }

    public function getStudentCombination(Request $request){
        $combination  = CourseSubject::whereIn('subject_id',$request->subject_id)->where('course_id',$request->course_id)->get()->load('subject');
        return reply (true,[
            'combination'=>$combination
        ]);
    }

    public function getSubject($course_id){
        $sub_ids  = CourseSubject::where('course_id',$course_id)->pluck('subject_id')->toArray();
        $subject = Subject::whereIn('id',$sub_ids)->orderBy('subject')->pluck('subject', 'id')->toArray();
        // dd($subject);
        return reply (true,[
            'subject'=>$subject
        ]);
    }
}
