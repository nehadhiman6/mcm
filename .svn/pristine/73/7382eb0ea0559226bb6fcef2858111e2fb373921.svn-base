<?php

namespace App\Http\Controllers;

use App\Models\StuCrtPass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gate;

class StudentCrtPassController extends Controller
{

    public function index(Request $request)
    {
        if (Gate::denies('stu-crt-passes')) {
            return deny();
        }
        if (!$request->ajax()) {
            return view('stu_crt_pass.index');
        }
        $count = StuCrtPass::all()->count();
        $filteredCount = $count;
        $stu_crt_passes = StuCrtPass::orderBy('id', 'DESC');
        if ($searchStr = $request->input('search.value')) {
            $stu_crt_passes = $stu_crt_passes->where('', 'like', "%{$searchStr}%");
        }

        $dt1 = getDateFormat($request->date_from, 'ymd');
        $dt2 = getDateFormat($request->date_to, 'ymd');

        if ($request->date_from) {
            $stu_crt_passes = $stu_crt_passes->whereBetween('req_date', [$dt1, $dt2]);
        }

        $stu_crt_passes = $stu_crt_passes->take($request->length);
        $filteredCount = $stu_crt_passes->count();

        $stu_crt_passes = $stu_crt_passes->select(['stu_crt_passes.*'])->distinct()->get();
        // $stu_crt_passes->load('state');
        return [
            'draw' => intval($request->draw),
            'start' => $request->start,
            'data' => $stu_crt_passes,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
    }

    public function create()
    {
        if (Gate::denies('add-stu-crt-passes')) {
            return deny();
        }
        return view('stu_crt_pass.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('stu-crt-passes-modify')) {
            return deny();
        }
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id = 0)
    {
        // dd($request->all());
        $this->validateForm($request, $id);
        $old_stu_ids = [];
        $detstudents =  new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->students as $det) {
            $student = StuCrtPass::findOrNew($det['id']);
            if ($student) {
                unset($old_stu_ids[$student->id]);
            } else {
                $student = new StuCrtPass();
            }
            $student->fill($det);
            $detstudents->add($student);
        }

        DB::beginTransaction();
        foreach ($detstudents as $det) {
            $det->save();
        }
        StuCrtPass::whereIn('id', $old_stu_ids)->delete();
        DB::commit();
        return reply('Ok');
    }



    private function validateForm(Request $request, $id)
    {
        $rules = [];
        $messages = [];
        $rules += [
            'students.*.req_date' => 'required|date_format:d-m-Y',
            'students.*.stu_name' => 'required|max:100',
            'students.*.class' => 'required|max:50',
            'students.*.roll_no' => 'required|numeric',
            'students.*.session' => 'required|max:10',
            'students.*.type' => 'required',

        ];
        $messages += [
            'students.*.roll_no.required' => 'Roll No is Required',
            'students.*.stu_name.required' => 'Student name is Required',
            'students.*.class.required' => 'Class is Required',
            'students.*.session.required' => 'Session is Required',
            'students.*.type.required' => 'Particular is Required',
            'students.*.req_date.required' => 'Date is Required',

        ];

        $this->validate($request, $rules, $messages);
    }

    public function edit($id)
    {
        if (Gate::denies('stu-crt-passes-modify')) {
            return deny();
        }
        $student = StuCrtPass::findOrFail($id);
        return view('stu_crt_pass.create', compact('student'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('stu-crt-passes-modify')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }

    public function getStudentIssueDateShow($id)
    {
        if (Gate::denies('issue-date')) {
            return deny();
        }
        $student = StuCrtPass::findOrFail($id);
        return view('stu_crt_pass.issue_date', compact('student'));
    }

    public function getStudentIssueDateSave(Request $request)
    {
        $student = StuCrtPass::findOrFail($request->id);
        $student->issue_date = $request->issue_date;
        $student->remarks = $request->remarks;
        $student->update();
        return reply('Ok', [
            'student' => $student
        ]);
    }

    public function getStudentRejectShow($id)
    {
        if (Gate::denies('stu-crt-pass-reject')) {
            return deny();
        }
        $student = StuCrtPass::findOrFail($id);
        return view('stu_crt_pass.reject', compact('student'));
    }

    public function getStudentRejectSave(Request $request)
    {
        $this->validate(
            $request,
            ['remarks' => 'required']
        );
        $student = StuCrtPass::findOrFail($request->id);
        $student->rejected = 'Y';
        $student->remarks = $request->remarks;
        $student->update();
        return reply('Ok', [
            'student' => $student
        ]);
    }
}
