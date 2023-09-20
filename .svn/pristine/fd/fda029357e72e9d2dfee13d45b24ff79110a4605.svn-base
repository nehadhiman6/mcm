<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Examination\PuExamMaster;
use App\Models\Examination\PuExamMasterDetail;
use Gate;

class MasterExamController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('exam-master')) {
            return deny();
        }
        if($request->ajax()){
            $this->validate($request, [
                'exam'=>'required',
                'course_id'=>'required|integer|min:1',
            ]);
            $course = \App\Course::find($request->course_id);
            $semester = $this->getSemester($course->course_year,$request->exam);
            // $course_sub = \App\CourseSubject::where('course_id',$request->course_id)
            //             ->where(DB::raw("ifnull(semester,$semester)"),'=',$semester)->get();
            // $course_sub->load('subject');
            $exam = $request->exam;

            $data = \App\CourseSubject::leftJoin('pu_exams', function($join) use($exam) {
                $join->on('course_subject.course_id', '=', 'pu_exams.course_id')
                ->where('pu_exams.exam_name','=',$exam);
            })->leftJoin('pu_exam_dets', function($join) {
                $join->on('pu_exam_dets.pu_exam_id', '=', 'pu_exams.id')
                            ->on('course_subject.subject_id','=','pu_exam_dets.subject_id');
                })->leftJoin(getSharedDb() . 'subjects', 'course_subject.subject_id', '=', 'subjects.id')
                ->where('course_subject.course_id', '=', $request->course_id)
                ->where(DB::raw("ifnull(course_subject.semester,$semester)"),'=',$semester)
                ->select([
                    'course_subject.course_id','course_subject.subject_id','subjects.subject','course_subject.semester',
                    'course_subject.uni_code','pu_exams.exam_name','pu_exam_dets.min_marks','pu_exam_dets.max_marks'
                
                    ])->get();
            return reply(true, [
                'data' => $data,
            ]);
        }
       
        return view('examinations.exam_master');

        
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validateForm($request);
        $pu_exam =  PuExamMaster::firstOrNew(['course_id'=>$request->course_id,'exam_name'=>$request->exam]);
        $pu_exam->fill($request->all());
       
        $det = $request->marks;
            $mark_det = PuExamMasterDetail::firstOrNew(['pu_exam_id'=>$pu_exam->id,'subject_id'=>$det['subject_id']]);
            $mark_det->subject_id = $det['subject_id'];
            $mark_det->min_marks = $det['min_marks'];
            $mark_det->max_marks = $det['max_marks'];
           
        DB::connection(getYearlyDbConn())->beginTransaction();
            $pu_exam->save();
            $mark_det->pu_exam_id = $pu_exam->id;
            $mark_det->save();
        DB::connection(getYearlyDbConn())->commit();
        return reply(true, [
            'pu_exam' => $pu_exam,
        ]);
    }

    public function validateForm($request)
    {
        // dd($request->all());
        $key = $request->index;
        $rules = [
            'exam'=>'required',
            'semester'=>'required',
            'course_id'=>'required|integer|min:1',
            'marks.subject_id'=>'required|integer|min:1',
            'marks.min_marks'=>'required',
            'marks.max_marks'=>'required',
        ];
        $messages = [
            'marks.min_marks.required'=>'The min marks field is required.',
            'marks.max_marks.required'=>'The max marks field is required.',
        ];

        if($request->marks['max_marks'] < $request->marks['min_marks']){

            $rules = [
                'gen_msg.' . $key . '.min_marks'=>'required'
            ];
            $messages = [
                'gen_msg.' . $key . '.min_marks.required'=>'Min Marks not Greater then Max Marks !',
            ];
           

        }

        $this->validate($request, $rules,$messages);
    }


    public function edit($id){
        $pu_exam =  PuExamMaster::findOrFail($id);
        $pu_exam->load('pu_exam_dets');
        return view('examinations.exam_master', compact('pu_exam'));
    }


    public function puExamList(Request $request){
        if (Gate::denies('exam-master')) {
            return deny();
        }
        if ($request->ajax()) {
            $count = PuExamMaster::all()->count();
            $filteredCount = $count;
            // dd($request);
            
            $pu_exams = PuExamMaster::orderBy('id', 'DESC');

            if ($searchStr = $request->input('search.value')) {
                $pu_exams = $pu_exams->where('name', 'like', "%{$searchStr}%");
            }

            $pu_exams = $pu_exams->take($request->length);
            $filteredCount = $pu_exams->count();

            if ($request->start > 0) {
                $pu_exams->skip($request->start - 1);
            }
            $pu_exams = $pu_exams->select()->distinct()->get();
            $pu_exams->load('course');
            return [
                'draw' => intval($request->draw),
                'start' => $request->start,
                'data' => $pu_exams,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('examinations.exam_master_list');
        
        
    }



    public function getSemester($year,$exam){
       
        $odd = 1;
        $even = 2;
        if($year == 1){
            // dd($exam );
            if($exam == 'pu_odd'){
                $semester = $odd;
            }
            else{
                $semester = $even;
            }
            
        }

        if($year == 2){
            if($exam == 'pu_odd'){
                $semester = $odd+2;
            }
            else{
                $semester = $even+2;
            }
        }

        if($year == 3){
            if($exam == 'pu_odd'){
                $semester = $odd+4;
            }
            else{
                $semester = $even+4;
            }
        }
        

        return $semester;

    }
}
