<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Models\StudentTimeTable\StudentTimeTable;
use DB;
use Gate;
use Mockery\Undefined;

class StudentTimeTableController extends Controller
{
   
    public function index()
    {
        if (Gate::denies('add-time-table')) {
            return deny();
        }
        return view('students-timetable.index');
    }

    public function importExcelSheet(Request $request)
    {
        $file = \Illuminate\Support\Facades\Input::file($request->file);
        $newFile = $file['excel']->storeAs('excels', str_random(8) . '.xls');
        $sheet = \Maatwebsite\Excel\Facades\Excel::selectSheetsByIndex(0)->load(storage_path('app/' . $newFile))->ignoreEmpty(true)->get();

        $student_timetable = new \Illuminate\Database\Eloquent\Collection();
        // dd($sheet);
        foreach ($sheet as $row) {
            $student= Student::where('roll_no',(Int)$row->roll_number)->first();
            if($student){      
                $student_timetable->push([
                    'roll_no'  =>   $row->roll_number,
                    'std_id'   =>   $student->id, 
                    'name'   =>     $student->name, 
                    'subjects' =>   isset($row['subjects']) ? $row['subjects'] : '',
                    'honours'=>     isset($row['honours']) ? $row['honours'] : '',
                    'add_on'   =>   isset($row['add_on']) ? $row['add_on'] : '',
                    'location' =>   isset($row['location']) ? $row['location'] : '',
                    'period_0' =>   isset($row['period_0']) ? $row['period_0'] : '',
                    'period_1' =>   isset($row['period_1']) ? $row['period_1'] : '',
                    'period_2' =>   isset($row['period_2']) ? $row['period_2'] : '',
                    'period_3' =>   isset($row['period_3']) ? $row['period_3'] : '',
                    'period_4' =>   isset($row['period_4']) ? $row['period_4'] : '',
                    'period_5' =>   isset($row['period_5']) ? $row['period_5'] : '',
                    'period_6' =>   isset($row['period_6']) ? $row['period_6'] : '',
                    'period_7' =>   isset($row['period_7']) ? $row['period_7'] : '',
                    'period_8' =>   isset($row['period_8']) ? $row['period_8'] : '',
                    'period_9' =>   isset($row['period_9']) ? $row['period_9'] : '',
                    'period_10' =>  isset($row['period_10']) ? $row['period_10'] : '',
                ]);
            }
        }
        return reply(true,[
            'student_timetable' => $student_timetable
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        foreach($request->data as $data){
            $student_timetable = StudentTimeTable::firstOrNew(['roll_no'=>$data['roll_no'] ,'std_id'=>$data['std_id']]);
            $student_timetable->fill($data);
            $student_timetable->save(); 
        }
        DB::commit();
        return reply(true);
    }

   
    public function show($id)
    {
        return view ('students-timetable.edit');
    }

   
    public function getStudentTimeTable(Request $request)
    {
        $this->validate($request,[
            'roll_no'=>'required|exists:' . getYearlyDbConn() . '.students,roll_no'
        ]);
        $student_timetable = StudentTimeTable::where('roll_no',$request->roll_no)->first();
        return reply(true,
        [
            'student_timetable'=>$student_timetable
        ]);
    }
   
    public function updateStudentTimeTable(Request $request)
    {
        $this->validate($request,[
            'student_timetable.roll_no'=>'required|exists:' . getYearlyDbConn() . '.students,roll_no',
            'student_timetable.std_id'=>'required|exists:' . getYearlyDbConn() . '.students,id',
        ]);

        $student_timetable = StudentTimeTable::firstOrNew(['roll_no'=>$request->student_timetable['roll_no'] ,'std_id'=>$request->student_timetable['std_id']]);
        $student_timetable->fill($request->student_timetable);
        $student_timetable->save(); 
        return reply (true,[
            'timetable'=>$student_timetable
        ]);
    }

    public function destroy($id)
    {
        
    }
}
