<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Elective;
use DB;
use App\CourseSubject;
use Illuminate\Validation\Rule;
use App\ElectiveGroupDetail;
use App\ElectiveGroup;
use App\ElectiveSubject;

class ElectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        //
        $course = \App\Course::findOrFail($id);
        return view('courses.electives.create', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //
        $course = \App\Course::findOrFail($id);
        if ($course) {
            $this->validate($request, [
                'name' => 'required'
            ]);
            $elective =  new Elective();
            $elective->course_id = $id;
            $elective->fill($request->all());
            flash("Updated Successfully!");
            $elective->save();
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $elective = \App\Elective::findOrFail($id);
        $course = \App\Course::findOrFail($elective->course_id);
        return view('courses.electives.create', compact('elective', 'course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $elective = \App\Elective::findOrFail($id);
        $elective->fill($request->all());
        $elective->update();
        flash("Updated Successfully!");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function addSubjects($course_id, $elective_id)
    {
        $course = \App\Course::findOrFail($course_id);
        $course_subjects = getCourseSubjects($course->id);
        $elective = \App\Elective::findOrFail($elective_id);
        return view('courses.electives.subjectcreate', compact('course', 'course_subjects', 'elective'));
    }

    public function storesubject(Request $request, $id)
    {
        //
        $elective = \App\Elective::findOrFail($id);
        $this->subjectsValidation($request);
        
        $elective_subject = new  \App\ElectiveSubject();
        $course_subject =  \App\CourseSubject::findOrFail($request->course_sub_id);
        // dd($course_subject->subject);
        $subject_id = $course_subject->subject->id;
        $elective_subject->subject_id =  $subject_id ;
        $elective_subject->fill($request->all());
        flash("Added Successfully!");
        $elective_subject->save();
        return redirect()->back();
    }

    public function removesubject($id)
    {
        $elective = ElectiveSubject::findOrFail($id);
        $elective->delete();
        flash()->success('Successfully removed!!');
        return redirect()->back();
    }

    private function subjectsValidation($request, $id = 0)
    {
        $this->validate($request, [
            'course_id' => 'required|integer|exists:'. getYearlyDbConn() . '.courses,id',
            'ele_id'=>'required|integer|exists:'. getYearlyDbConn() . '.electives,id',
            'course_sub_id'=>'required|integer|exists:'. getYearlyDbConn() . '.course_subject,id,sub_type,O',
            'sub_type'=>'in:C,O'
        ]);
    }

    public function editSubjects($id)
    {
        $elective_subject = \App\ElectiveSubject::findOrFail($id);
        $course = \App\Course::findOrFail($elective_subject->course_id);
        $course_subjects = getCourseSubjects($course->id);
        $elective = \App\Elective::findOrFail($elective_subject->ele_id);
        return view('courses.electives.subjectcreate', compact('course', 'course_subjects', 'elective_subject', 'elective'));
    }

    public function updatesubject(Request $request, $ele_sub_id)
    {
        $this->subjectsValidation($request, $ele_sub_id);
        $elective_subject = \App\ElectiveSubject::findOrFail($ele_sub_id);
        $course_subject =  \App\CourseSubject::findOrFail($request->course_sub_id);
        $subject_id = $course_subject->subject->id;
        $elective_subject->subject_id =  $subject_id ;
        $elective_subject->fill($request->all());
        $elective_subject->update();
        flash("Updated Successfully!");
        return redirect()->back();
    }

    public function addGroup($course_id, $elective_id)
    {
        $course = \App\Course::findOrFail($course_id);
        $elective = \App\Elective::findOrFail($elective_id);
        return view('courses.electives.sub_group', compact('course', 'elective'));
    }

    public function storeGroup(Request $request, $id)
    {
        $elective = \App\Elective::findOrFail($id);
        $this->validateGroup($request, $id, 0, $elective);
        // dd($request->all());
        
        $elective_group = new  \App\ElectiveGroup();
        $elective_group->fill($request->all());
        $elective_group->s_no = intval($request->s_no);
        $elective_group->course_id = $elective->course_id;
        $elective_group->ele_id = $id;
        $elective_group_dets = [];
        foreach ($request->subjects as $subject) {
            $elective_group_det = new \App\ElectiveGroupDetail;
            $elective_group_det->course_sub_id = $subject;
            $course_subject =  \App\CourseSubject::findOrFail($subject);
            $elective_group_det->subject_id = $course_subject->subject->id;
            $elective_group_dets[] = $elective_group_det;
        }
        // return $lab_pack_dets;
        $elective_group_det->ele_group_id = $elective_group->id;
        DB::connection(getYearlyDbConn())->beginTransaction();
        $elective_group->save();
        $elective_group->details()->saveMany($elective_group_dets);
        $subjects = ElectiveGroupDetail::whereEleGroupId($elective_group->id)
            ->join('course_subject', 'elective_group_det.course_sub_id', '=', 'course_subject.id')
            ->join( getSharedDb() .'subjects', 'course_subject.subject_id', '=', 'subjects.id')
            ->get(['subjects.id', 'subjects.subject'])->pluck('subject', 'id');
        $group_name = implode(' or ', $subjects->all());
        $elective_group->group_name = $group_name;
        $elective_group->save();
        DB::connection(getYearlyDbConn())->commit();
        flash("Added Successfully!");
        return redirect()->back();
    }

    private function validateGroup($request, $ele_id = 0, $ele_group_id = 0, $elective = null)
    {
        $rules = [
            'type'=>'required'
        ];
        $msgs = [];
        foreach ($request->subjects as $key => $course_sub_id) {
            $course_sub = CourseSubject::findOrFail($course_sub_id);
            $rules['subjects.' . $key] = [
                'required',
                Rule::unique(getYearlyDbConn() . '.elective_subject', 'course_sub_id')->where(function ($q) use ($ele_id) {
                    $q->where('ele_id', '=', $ele_id);
                })
            ];
            $msgs["subjects.{$key}.unique"] = "{$course_sub->subject->subject} already added to this Elective Option!";
        }

        //check subject do not exist in the same elective group already
        $ele_group_ids = $elective ? $elective->groups()->where('id', '!=', $ele_group_id)->pluck('id')->toArray() : [];
        // dd($ele_group_ids);
        if (count($ele_group_ids) > 0) {
            $duplicates = ElectiveGroupDetail::whereIn('ele_group_id', $ele_group_ids)->whereIn('course_sub_id', $request->subjects)->get();
            foreach ($duplicates as $key => $dup) {
                $rules["dup.{$key}"] = 'required';
                $msgs["dup.{$key}.required"] = "{$dup->coursesubject->subject->subject} already added to this Elective Option Groups!";
            }
        }
        $this->validate($request, $rules, $msgs);
    }

    public function showGroup($id)
    {
        $elective_group = \App\ElectiveGroup::findOrFail($id);
        $elective = \App\Elective::findOrFail($elective_group->ele_id);
        $course = \App\Course::findOrFail($elective->course_id);
        return view('courses.electives.sub_group', compact('course', 'elective', 'elective_group'));
    }

    public function updateGroup(Request $request, $id)
    {
    //    dd($request->all());
        $elective_group = \App\ElectiveGroup::findOrFail($id);
        $this->validateGroup($request, $elective_group->ele_id, $id, $elective_group->elective);
        // dd($request->all());

        $elective_group->fill($request->only('s_no', 'type'));
        $elective_group->s_no = intval($request->s_no);
        $elective_group_dets = new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->subjects as $subject) {
            $elective_group_det = \App\ElectiveGroupDetail::firstOrNew(['ele_group_id' => $elective_group->id, 'course_sub_id' => $subject]);
            $elective_group_det->course_sub_id = $subject;
            $course_subject =  \App\CourseSubject::findOrFail($subject);
            $elective_group_det->subject_id = $course_subject->subject->id;
            $elective_group_dets->add($elective_group_det);
        }
        $old_ids = $elective_group->details->pluck('id')->toArray();
        $new_ids = $elective_group_dets->pluck('id')->toArray();
        $detach = array_diff($old_ids, $new_ids);
        $elective_group_det->ele_group_id = $elective_group->id;
        DB::connection(getYearlyDbConn())->beginTransaction();
        $elective_group->save();
        $elective_group->details()->saveMany($elective_group_dets);
        if (is_array($detach) && count($detach) > 0) {
            ElectiveGroupDetail::whereIn('id', $detach)->delete();
        }
        $subjects = ElectiveGroupDetail::whereEleGroupId($elective_group->id)
            ->join('course_subject', 'elective_group_det.course_sub_id', '=', 'course_subject.id')
            ->join( getSharedDb() . 'subjects', 'course_subject.subject_id', '=', 'subjects.id')
            ->get(['subjects.id', 'subjects.subject'])->pluck('subject', 'id');
        $group_name = implode(' or ', $subjects->all());
        $elective_group->group_name = $group_name;
        $elective_group->save();
        DB::connection(getYearlyDbConn())->commit();
        flash("Updated Successfully!");
        return redirect("electives/{$elective_group->course_id}/{$elective_group->ele_id}/addgroup");
    }
}
