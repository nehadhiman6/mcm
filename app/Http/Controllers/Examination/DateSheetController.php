<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DateSheet\DateSheet;
use App\CourseSubject;
use Gate;

class DateSheetController extends Controller
{
    
    public function index(Request $request)
    {
        if (Gate::denies('date-sheet-list')) {
            return deny();
        }
        if($request->ajax()){
            $date_sheet = DateSheet::orderBy('created_at', 'desc');
            // if ($request->from_date != '') {
            //     $date_sheet = $date_sheet->where('created_at', '>=', Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d'));
            // }
            // if ($request->to_date != '') {
            //     $date_sheet = $date_sheet->where('created_at', '<=', Carbon::createFromFormat('d-m-Y', $request->to_date)->addDays(1)->format('Y-m-d'));
            // }
            $count = $date_sheet->count();
            if ($searchStr = $request->input('search.value')) {
                $date_sheet = $date_sheet->where('id', 'like', "%{$searchStr}%");
                $filteredCount = $date_sheet->count();
            }
            $date_sheet = $date_sheet->take($request->length);
            $filteredCount = $date_sheet->count();
            if ($request->start > 0) {
                $date_sheet->skip($request->start - 1);
            }
            $date_sheet = $date_sheet->get();
            $date_sheet->load([ 'course','subject']);
            // dd($date_sheet);CRS
            return [
                'draw' => intval($request->draw),
                'start' => $request->start,
                'data' => $date_sheet,
                'recordsTotal' => $count,
                'recordsFiltered' => $filteredCount,
            ];
        }
        return view('examinations.date_sheet');
    }

   
    public function validateForm($request)
    {
        $this->validate($request,[
            'date'=>'required',
            'subject_id'=>'required|min:1|integer',
            'course_id'=>'required|exists:' . getYearlyDbConn() . '.courses,id',
            'session'=>'required',
            'exam_name'=>'required',
      
        ]);
    }

    public function store(Request $request)
    {
        if (Gate::denies('date-sheet-modify')) {
            return deny();
        }
        $this->validateForm($request);
        $course_subject = CourseSubject::where('course_id',$request->course_id)->where('subject_id',$request->subject_id)->first();
        
        $date_sheet = DateSheet::firstOrNew(['id'=>$request->id]);
        $date_sheet->fill($request->all());
        $date_sheet->course_subject_id = $course_subject->id;
        $date_sheet->save();
        return reply(true);
    }

 
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        if (Gate::denies('date-sheet-modify')) {
            return deny();
        }
        $date_sheet = DateSheet::findOrFail($id);
        return view('examinations.date_sheet',compact('date_sheet'));
    }

    
    public function update(Request $request, $id)
    {
        
    }

   
    public function destroy($id)
    {
        //
    }
}
