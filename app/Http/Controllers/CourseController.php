<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CourseRequest;
use DB;
use Gate;
use App\CourseSubject;
use App\SubjectGroup;
use App\Course;
use App\ElectiveSubject;
use App\Staff;
use App\SubjectSection;
use App\SubSectionDetail;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getSubs']]);
        view()->share('signedIn', auth()->check());
        view()->share('user', auth()->user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('COURSES')) {
            return deny();
        }
        $courses = \App\Course::orderBy('sno')->get();
        $add_on_courses = \App\AddOnCourse::get();
        return view('courses.index', compact('courses', 'add_on_courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('ADD-COURSES')) {
            return deny();
        }
        return view('courses.create');
    }

    public function createAddOnCourse()
    {
        if (Gate::denies('COURSES')) {
            return deny();
        }
        return view('courses.addon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        if (Gate::denies('EDIT-COURSES')) {
            return deny();
        }
        // dd($request->all());
        $course = new \App\Course();
        $course->fill($request->all());
        $course->course_year = 0;
        $course->min_optional = 0;
        $course->sub_combination = $request->has('sub_combination');
        $course->adm_open = $request->has('adm_open') ? 'Y' : 'N';
        $course->save();
        return redirect('courses');
    }

    public function storeAddOnCourse(Request $request)
    {
        if (Gate::denies('ADD-ON-COURSES')) {
            return deny();
        }
        $this->validate($request, [
            'course_name' => 'required',
            'short_name' => 'required',
        ]);
        $add_on_course = new \App\AddOnCourse();
        $add_on_course->fill($request->all());
        $add_on_course->save();
        return redirect('courses');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('EDIT-COURSES')) {
            return deny();
        }
        $course = \App\Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function editAddOnCourse($id)
    {
        if (Gate::denies('EDIT-COURSES')) {
            return deny();
        }
        $add_on_course = \App\AddOnCourse::findOrFail($id);
        return view('courses.addon.create', compact('add_on_course'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, $id)
    {
        if (Gate::denies('EDIT-COURSES')) {
            return deny();
        }
        $course = \App\Course::findOrFail($id);
        $course->fill($request->all());
        $course->sub_combination = $request->has('sub_combination');
        $course->adm_open = $request->has('adm_open') ? 'Y' : 'N';
        $course->update();
        return redirect('courses');
    }

    public function updateAddOn(Request $request, $add_course_id)
    {
        if (Gate::denies('ADD-ON-COURSES')) {
            return deny();
        }
        $this->validate($request, [
            'course_name' => 'required',
            'short_name' => 'required',
        ]);
        $add_on_course = \App\AddOnCourse::findOrFail($add_course_id);
        $add_on_course->fill($request->all());
        $add_on_course->update();
        return redirect('courses');
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

    public function subjects($id)
    {
        $course = \App\Course::findOrFail($id);
        $course->load('electives', 'electives.electiveSubjects');
        // dd($course->electives->first()->electiveSubjects);
        return view('courses.subjects.index', compact('course'));
    }

    public function addSubject($id)
    {
        $course = \App\Course::findOrFail($id);
        $course_year = $course->course_year;
        $all = $course->course_id != "BA";
        $course_subjects = getCourseSubjects($course->id, $all);
        // dd($course->exists);
        $subjects = ['' => 'Select Subject'] + \App\Subject::orderBy('subject')->pluck('subject', 'id')->toArray();
        return view('courses.subjects.create', compact('course', 'subjects', 'course_subjects', 'course_year'));
    }

    public function storeSubject(Requests\CourseSubjectRequest $request, $id)
    {
        $course = \App\Course::findOrFail($id);
        $coursesubject = new \App\CourseSubject();
        $coursesubject->fill($request->all());
        $coursesubject->course_id = $course->id;
        $coursesubject->practical = $request->has('practical') ? 'Y' : 'N';
        $coursesubject->honours = $request->has('honours') ? 'Y' : 'N';
        $coursesubject->save();
        //  dd($coursesubject);
        //  \App\CourseSubject::create($request->all() + ['course_id' => $id]);
        return redirect("courses/{$course->id}/addsubject");
        return redirect('courses/' . $id . '/subjects');
    }

    public function editsubject($id)
    {
        $coursesubject = \App\CourseSubject::findOrFail($id);
        $all = $coursesubject->course->course_id != "BA";
        $course_subjects = getCourseSubjects($coursesubject->course->id, $all);
        $subjects = ['' => 'Select Subject'] + \App\Subject::orderBy('subject')->pluck('subject', 'id')->toArray();
        $course_year = $coursesubject->course->course_year;
        return view('courses.subjects.create', compact('coursesubject', 'subjects', 'course_subjects', 'course_year'));
    }

    // Not in use now
    // Deletes subject from course if not added to groups or selected by student in admission form
    public function deletesubject($id)
    {
        $coursesubject = \App\CourseSubject::findOrFail($id);
        $sub_type = $coursesubject->sub_type;
        if ($sub_type == 'C') {
            $coursesubject->delete();
            flash()->success("Deleted Successfully!");
            return redirect()->back();
        } else {
            $subject_group_det = \App\SubjectGrpDetail::where('course_sub_id', $id)->first();
            $elective_subject = \App\ElectiveSubject::where('course_sub_id', $id)->first();
            // $
            if ($subject_group_det) {
                flash()->error("Could'nt Delete. Firstly delete this Subject from Group " . $subject_group_det->subjectGroup->group_name . "");
                return redirect()->back();
            } elseif ($elective_subject) {
                flash()->error("Could'nt Delete. Firstly delete this Subject from Elective  " . $elective_subject->elective->name . "");
                return redirect()->back();
            }
            // else if(){

            // }
        }
        $course_subjects = getCourseSubjects($coursesubject->course->id);
        $subjects = ['' => 'Select Subject'] + \App\Subject::orderBy('subject')->pluck('subject', 'id')->toArray();
        return view('courses.subjects.create', compact('coursesubject', 'subjects', 'course_subjects'));
    }

    public function updatesubject(Requests\CourseSubjectRequest $request, $courseid, $id)
    {
        $coursesubject = \App\CourseSubject::findOrFail($id);
        $coursesubject->practical = $request->has('practical') ? 'Y' : 'N';
        $coursesubject->honours = $request->has('honours') ? 'Y' : 'N';
        $coursesubject->update($request->all());
        return redirect('courses/' . $courseid . '/subjects');
    }

    public function subGroup($id)
    {
        $course = \App\Course::findOrFail($id);
        return view('courses.subjects.subgroup', compact('course'));
    }

    public function addGroup(Requests\GroupSubjectsRequest $request, $id)
    {
        // dd($request->all());
        // dd($subjects->all());
        $course = \App\Course::findOrFail($id);

        $subgroup = new \App\SubjectGroup();
        $subgroup->fill($request->all());
        $subgroup->type = 'C';
        $subgroup->group_name = '';

        $subgroups = new \Illuminate\Database\Eloquent\Collection();
        DB::connection(getYearlyDbConn())->beginTransaction();
        $course->subgroups()->save($subgroup);
        foreach ($request->subjects as $course_sub_id) {
            $subgrpdet = \App\SubjectGrpDetail::firstOrNew(['sub_group_id' => $subgroup->id, 'course_sub_id' => $course_sub_id]);
            $course_subject = \App\CourseSubject::findOrFail($course_sub_id);
            $subgrpdet->subject_id = $course_subject->subject->id;
            $subgroups->add($subgrpdet);
        }
        $subgroup->subjects()->saveMany($subgroups);
        $subjects = \App\SubjectGrpDetail::whereSubGroupId($subgroup->id)
            ->join('course_subject', 'subject_group_det.course_sub_id', '=', 'course_subject.id')
            ->join(getSharedDb() . 'subjects', 'course_subject.subject_id', '=', 'subjects.id')
            ->get(['subjects.id', 'subjects.subject'])->pluck('subject', 'id');
        $group_name = implode(' or ', $subjects->all());
        $subgroup->group_name = $group_name;
        $subgroup->save();
        DB::connection(getYearlyDbConn())->commit();
        return redirect('courses/' . $course->id . '/subjects');
//        return redirect('courses/' . $id . '/subgroup');
    }

    public function editGroup($id)
    {
        $subjectgroup = \App\SubjectGroup::findOrFail($id);
        $course = $subjectgroup->course;
//        dd(isset($subjectgroup) ? $subjectgroup->subjects->pluck('subject_id')->toArray() : null);
        return view('courses.subjects.subgroup', compact('subjectgroup', 'course'));
    }

    public function updateGroup(Requests\GroupSubjectsRequest $request, $courseid, $id)
    {
        // dd($request->all());
        $subgroup = \App\SubjectGroup::findOrFail($id);
        $subgroup->s_no = $request->s_no;
        // $subjectgroup->subjects()->sync($request->input('subjects', []));
        $old_ids = $subgroup->subjects()->pluck('id')->toArray();

        $group_dets = new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->subjects as $course_sub_id) {
            $subgrpdet = \App\SubjectGrpDetail::firstOrNew(['sub_group_id' => $subgroup->id, 'course_sub_id' => $course_sub_id]);
            $course_subject = \App\CourseSubject::findOrFail($course_sub_id);
            $subgrpdet->subject_id = $course_subject->subject->id;
            $group_dets->add($subgrpdet);
        }
        $new_ids = $group_dets->pluck('id')->toArray();
        $detach = array_diff($old_ids, $new_ids);
        DB::connection(getYearlyDbConn())->beginTransaction();
        $subgroup->subjects()->saveMany($group_dets);
        \App\SubjectGrpDetail::whereIn('id', $detach)->delete();
        $subjects = \App\SubjectGrpDetail::whereSubGroupId($subgroup->id)
            ->join('course_subject', 'subject_group_det.course_sub_id', '=', 'course_subject.id')
            ->join(getSharedDb() . 'subjects', 'course_subject.subject_id', '=', 'subjects.id')
            ->get(['subjects.id', 'subjects.subject'])->pluck('subject', 'id');
        $group_name = implode(' or ', $subjects->all());
        $subgroup->group_name = $group_name;
        $subgroup->save();
        DB::connection(getYearlyDbConn())->commit();
        return redirect('courses/' . $courseid . '/subjects');
//
//        $detids = [];
//        foreach ($request->subjects as $sub) {
//            $detid = data_get($sub);
//
//                $subgroup->subjects()->updateOrCreate(['id' => $detid]);
//
//        }
//        $detach = array_diff($old_ids, $detids);
//        \App\SubjectGrpDetail::whereIn('id', $detach)->delete();
//        DB::commit();
    }

    public function getSubs(Request $request)
    {
//    dd($request->course_id);
//    dd($subjects->all());
        $course = \App\Course::findOrFail($request->course_id);
        $course->load(['subjects', 'subGroups', 'subjects.subject', 'subGroups.subjects', 'subGroups.subjects.subject']);
        $data = ['compSub' => $course->getSubs("C"), 'compGrp' => $course->getSubGroups("C"), 'optionalSub' => $course->getSubs("O"), 'optionalGrp' => $course->getSubGroups("O"), 'electives' => $course->getElectives(), 'honours' => $course->getHonours(), 'course' => $course];
        return response()->json($data);
    }

    public function getSubjectsForCharges(Request $request)
    {
        $course = \App\Course::findOrFail($request->course_id);
        return $course->getSubjectsForCharges();

        // $subjects = CourseSubject::join(getSharedDb() . 'subjects', 'subjects.id', '=', 'course_subject.subject_id')
        //     ->select('subjects.*')->where('course_subject.course_id', '=', $course->id)
        //     ->where('course_subject.practical', '=', 'Y')
        //     // ->union(
        //     //     SubjectGroup::join('subject_group_det', 'subject_group.id', '=', 'subject_group_det.sub_group_id')
        //     //         ->join('subjects', 'subjects.id', '=', 'subject_group_det.subject_id')->select('subjects.*')->where('subject_group.course_id', '=', $course->id)->where('subject_group_det.practical', '=', 'Y')
        //     // )
        //     ->get();
        // return $subjects;
    }

    public function getSubjectsList($course_id)
    {
        $course = Course::findOrFail($course_id);
        return $course->getAllSubs();
    }

    public function getSubjectsListAndCourseDet($course_id)
    {
        $course = Course::findOrFail($course_id);
        if (auth()->user()->hasRole('TEACHERS') && Gate::denies('see-courses-subjects')) {
            $teacher_id = Staff::where('user_id', auth()->user()->id)->first()->id;
            $sub_subjects = SubjectSection::where('teacher_id', $teacher_id)->where('course_id', $course_id)->with('subject')->get()->pluck('subject');
            // $sub_subjects_det = SubSectionDetail::where('teacher_id', $teacher_id)
            //                 ->whereHas('sub_section', function ($query) use ($course_id) {
            //                     $query->where('course_id', '=', $course_id);
            //                 })
            //                 ->with('sub_section.subject')->get()->pluck('sub_section.subject');  

            // new Code
            $sub_sec_ids = SubSectionDetail::where('teacher_id', $teacher_id)->pluck('sub_sec_id')->toArray();
            $sub_subjects_det = SubjectSection::whereIn('id', $sub_sec_ids)->where('course_id', '=', $course_id)->get()->pluck('subject');


            $subjects= ($sub_subjects->merge($sub_subjects_det));
        } else {
            $subjects = $course->getAllSubs();
        }
        return ['subjects' => $subjects, 'course' => $course];
    }


    public function showInstructionCourseAttach($course_id)
    {
        if (Gate::denies('COURSE-ATTACHMENT')) {
            return deny();
        }
        $course = Course::findOrFail($course_id);
        if (file_exists(storage_path() . "/app/instructions/" .'timetable_'.$course_id .'.'. 'pdf') == true) {
            $file = 'yes';
        } else {
            $file = 'no';
        }
        return view('courses.timetable_attachment.timetable_attachment', compact('course', 'course_id', 'file'));
    }

    public function saveInstructionCourseAttach(Request $request, $course_id)
    {
        $file = $request->file('image');
        if ($file->getClientOriginalExtension() != 'pdf') {
            flash()->error('This Format is not supported !');
            return redirect()->back();
        }
        $file_size = number_format($file->getClientSize() / 1024, 2);
        // dd($file_size);
        if ($file_size > config('college.max_file_upload_size')) {
            flash()->error('File size is greater than maximum allowed filesize!');
            return redirect()->back();
        }
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $file_name = $file->getClientOriginalName();
            $file->move(storage_path('app/instructions/'), 'timetable_'. $course_id . '.' . $extension);
        }
        return redirect()->back();
    }

    public function showAttachment($course_id)
    {
        $file_path = storage_path() . "/app/instructions/" .'timetable_'.$course_id .'.'. 'pdf';
        return response()->file($file_path);
    }
}
