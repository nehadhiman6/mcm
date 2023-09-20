<?php

namespace App\Http\Controllers\Alumni;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AlumniStudent;
use App\AlumniMeetStudent;
use App\AlumniMeet;
use App\Course;
use Illuminate\Support\Facades\Gate;

class AlumniMeetController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('ALUMNI-LIST')) {
            return deny();
        }
        if (!request()->ajax()) {
            return view('alumni.alumni_list');
        }

        $this->validate($request, [
            'passout_year' => 'nullable|digits:4',
            'course_id' => 'nullable|required_with:type|numeric',
            'type' => 'nullable|in:UG,PG,Professional,Research'
        ]);
        $alumni_students = AlumniStudent::orderBy('id');


        if ($request->type != "" || ($request->type != ""  && $request->student_course_id != 0)) {
            $alumni_students = $alumni_students->join('alumni_stu_qual','alumni_stu_qual.alumni_stu_id','=','alumni_students.id')
                                ->where('alumni_stu_qual.degree_type', $request->type);
            if ($request->student_course_id) {
                // dd($request->student_course_id);
                $alumni_students->where('alumni_stu_qual.course_id', $request->student_course_id);
            }
            // $alumni_students->whereHas('almqualification', function ($query) use ($request) {
            //     $query->where('degree_type', $request->type);
            //     if ($request->student_course_id) {
            //         $query->where('course_id', $request->student_course_id);
            //     }
            // });
        } else {
            if ($request->course_id > 0) {
                $alumni_students = $alumni_students->where('course_id', $request->course_id);
            } else if ($request->course_type != '') {
                $courses = Course::where('status', $request->course_type)->pluck('id')->toArray();
                $alumni_students = $alumni_students->whereIn('course_id', $courses);
            }

            if ($request->passout_year  && $request->passout_year > 0) {
                $alumni_students = $alumni_students->where('passout_year', $request->passout_year);
            }
        }
        // dd($alumni_students->first());
        if ($request->life == 'Y') {
            $alumni_students = $alumni_students->where('life_member', $request->life);
        }

        return $alumni_students->select('alumni_students.*')->get()->load('almqualification', 'previousyearstudent.course', 'almAward', 'graduatecourse', 'postgradcourses', 'professionalcourses', 'researches', 'almexperience', 'course');
    }

    public function attendingMeetList()
    {
        if (Gate::denies('ALUMNI-EVENT-LIST')) {
            return deny();
        }
        $alumnies = [];
        $meet =  getAlumniMeet();
        if ($meet) {
            $alumnies = AlumniMeetStudent::where('meet_id', $meet->id)->with(['almstudent.alumnistream'])->get();
        }
        return view('alumni.event_attending', compact('alumnies'));
    }

    public function attendingMeetListFiltered(Request $request)
    {
        if (Gate::denies('ALUMNI-LIST')) {
            return deny();
        }
        $alumnies = [];
        if ($request->event_id != 0) {
            $meet =  AlumniMeet::findOrFail($request->event_id);
            if ($meet) {
                $alumnies = AlumniMeetStudent::where('meet_id', $meet->id)->with(['almstudent.alumnistream'])->get();
            }
        }
        return view('alumni.event_attending', compact('alumnies'));
    }


    public function addEvent()
    {
        if (Gate::denies('ADD-ALUMNI-EVENT')) {
            return deny();
        }
        $alumni_meets = AlumniMeet::orderBy('meet_date', 'desc')->get();
        return view('alumni.add_event', compact('alumni_meets'));
    }

    public function store(Request $request)
    {
        if (Gate::denies('EDIT-ALUMNI-EVENT')) {
            return deny();
        }
        $alumni_es = AlumniMeet::all();
        foreach ($alumni_es as $alm) {
            $alm->active = 'N';
            $alm->update();
        }
        $alumni_e = new AlumniMeet();
        $this->validate($request, [
            'meet_date' => 'required|unique:alumni_meet',
            'meet_venue' => 'required',
            'meet_time' => 'required'
        ]);
        $alumni_e->fill($request->all());
        $alumni_e->active = 'Y';
        //make others in active

        $alumni_e->save();
        return redirect()->back();
    }

    public function edit($id)
    {
        if (Gate::denies('EDIT-ALUMNI-EVENT')) {
            return deny();
        }
        $alumni_meets = AlumniMeet::orderBy('meet_date', 'desc')->get();
        $alumni_e = AlumniMeet::findOrFail($id);
        return view('alumni.add_event', compact('alumni_e', 'alumni_meets'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('EDIT-ALUMNI-EVENT')) {
            return deny();
        }
        $alumni_e = AlumniMeet::findOrFail($id);
        $this->validate($request, [
            'meet_date' => 'required|unique:alumni_meet',
            'meet_venue' => 'required',
            'meet_time' => 'required'
        ]);
        $alumni_e->fill($request->all());
        $alumni_e->update();
        return redirect('alumnies/meet');
    }

    public function changeEventStatus($status, $id)
    {
        if (Gate::denies('ADD-ALUMNI-EVENT')) {
            return deny();
        }
        $alumni_e = AlumniMeet::findOrFail($id);
        if ($status == 'active') {
            $alumni_e->active = 'Y';
            $alumni_es = AlumniMeet::all();
            foreach ($alumni_es as $alm) {
                $alm->active = 'N';
                $alm->update();
            }
        } elseif ($status == 'in-active') {
            $alumni_e->active = 'N';
        }
        $alumni_e->update();
        return redirect('alumnies/meet');
    }

    public function paymentStatus()
    {
        return view('alumni.alumnipayments');
    }
}
