<?php

namespace App\Http\Controllers\RegionalCentre;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Models\RegionalCentre\RegionalCentre;

class RegionalCentreController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view('errors.503');
        if (!$request->ajax()) {
            return view('regional_centre.index');
        }
        $count = RegionalCentre::all()->count();
        $filteredCount = $count;
        $regionals = RegionalCentre::orderBy('id', 'DESC');
        if ($searchStr = $request->input('search.value')) {
            $regionals = $regionals->where('', 'like', "%{$searchStr}%");
        }

        $regionals = $regionals->take($request->length);
        $filteredCount = $regionals->count();

        $regionals = $regionals->select(['regional_centres.*'])->distinct()->get();
        $regionals->load('course');
        return [
            'draw' => intval($request->draw),
            'start' => $request->start,
            'data' => $regionals,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
    }


    public function create()
    {
        return view('regional_centre.create');
    }

    public function store(Request $request)
    {
        return view('errors.503');

        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id = 0)
    {
        // dd($request->all());
        $this->validateForm($request, $id);
        $student = Student::where('roll_no', $request->roll_no)->first();
        $regional = RegionalCentre::findOrNew($request->id);
        $regional->stu_id = $student->id;
        $regional->name = $student->name;
        $regional->father_name = $student->father_name;
        $regional->course_id = $student->course_id;
        $regional->pupin_no = $request->pupin_no;
        $regional->roll_no = $student->roll_no;
        $regional->mobile_no = $request->mobile_no;
        $regional->add = $request->add;
        $regional->email = $request->email;
        $regional->centre1 = $request->centre1;
        $regional->centre2 = $request->centre2;
        $regional->regional_centre = 0;
        $regional->save();
        return reply(true, compact('regional'));
    }

    private function validateForm(Request $request, $id)
    {
        $rules = [
            // 'name'=> 'required|string|max:50',
            // 'father_name'=> 'required|string|max:50',
            // 'course_id'=> 'required|integer|exists:' . getYearlyDbConn() . '.courses,id',
            'pupin_no' => 'required|string|max:20',
            'roll_no' => 'required|string|max:10|unique:' . getYearlyDbConn() . '.regional_centres,roll_no,' . $request->id,
            'mobile_no' => 'required|numeric',
            'add' => 'required|string|max:200',
            'email' => 'required|email',
            'centre1' => 'required|string',
            'centre2' => 'required|string',
        ];
        $messages = [];
        if ($request->centre1 == $request->centre2) {
            $rules['centre_re'] =  'required';
            $messages['centre_re.required'] = "This Centre already choose";
        }

        $this->validate($request, $rules, $messages);
    }

    public function edit($id)
    {
        $regional = RegionalCentre::findOrFail($id);
        $regional->load('course');
        return view('regional_centre.create', compact('regional'));
    }

    public function update(Request $request, $id)
    {
        return $this->saveForm($request, $id);
    }

    public function show(Request $request, $roll_no)
    {
        $student = Student::where('roll_no', $roll_no)->first();
        if (!$student) {
            $this->validate(
                $request,
                [
                    'college_roll_no' => 'required',
                ],
                [
                    'college_roll_no.required' => 'This Roll no does not exists',

                ]
            );
        }
        return reply(
            true,
            [
                'student' => $student
            ]
        );
    }
}
