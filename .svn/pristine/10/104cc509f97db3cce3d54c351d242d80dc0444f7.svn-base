<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubjectSection;
use App\SubSectionDetail;
use App\Subject;
use Gate;

class SubjectSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('SECTION-DETAIL')) {
            return deny();
        }
        return view('subject_section.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSubSubjects(Request $request)
    {
        // return $request->all();

        $this->validate($request, [
            'id' => 'required|integer',
            'sub_sec_id' => 'required|min:1|integer|exists:' . getYearlyDbConn() . '.subject_sections,id',
            'teacher_id' => 'required|integer|exists:staff,id,type,Teacher',
            'sub_subject_name' => 'required|max:191',
            'is_practical' => 'required|in:Y,N',
        ]);

        $subject_section = SubjectSection::findOrFail($request->sub_sec_id);
        $subject_section->teacher_id = 0;
        $subject_section->update();
        // dd($request->id);
        if (isset($request->id) && $request->id > 0) {
            $subject_section_det = SubSectionDetail::findOrFail($request->id);
        } else {
            $subject_section_det = new SubSectionDetail();
        }
        $subject_section_det->fill($request->all());
        $subject_section_det->save();
        $subject_section->load(['sub_sec_details.teacher', 'teacher', 'course', 'section', 'subject']);
        return response()->json(['success' => 'true', 'subject_section' => $subject_section], 200, ['app-status' => 'success']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'subject_section.id' => 'required|integer',
            'subject_section.course_id' => 'required|min:1|integer|exists:' . getYearlyDbConn() . '.courses,id',
            'subject_section.subject_id' => 'required|min:1|integer',
            'subject_section.section_id' => 'required|integer|exists:' . getYearlyDbConn() . '.sections,id|unique:' . getYearlyDbConn() . '.subject_sections,section_id,' . $request->subject_section['id'] . ',id,course_id,' . $request->subject_section['course_id'] . ',subject_id,' . $request->subject_section['subject_id'],
            'subject_section.has_sub_subjects' => 'required|in:Y,N',
            'subject_section.teacher_id' => 'nullable|integer',
        ];

        $this->validate($request, $rules);

        // return $request->all();
        // $subject_section = SubjectSection::where('course_id', $request->subject_section['course_id'])
        //                 ->where('subject_id', $request->subject_section['subject_id'])
        //                 ->where('section_id', $request->subject_section['section_id'])->first();

        $subject_section = SubjectSection::firstOrCreate(
            [
                'course_id' => $request->subject_section['course_id'],
                'subject_id' => $request->subject_section['subject_id'],
                'section_id' => $request->subject_section['section_id']
            ],
            [
                'teacher_id' => $request->subject_section['teacher_id']
            ]
        );


        if ($subject_section->wasRecentlyCreated === false) {
            if ($subject_section->has_sub_subjects != $request->subject_section['has_sub_subjects'] && $subject_section->sub_sec_details->count() > 0) {
                $this->validate($request, [
                    'has_sub_subjects_changed' => 'required'
                ], [
                    'has_sub_subjects_changed.required' => 'Has sub subjects cannot be updated!'
                ]);
            }
        }
        $subject_section->teacher_id = $request->subject_section['teacher_id'];
        $subject_section->has_sub_subjects = $request->subject_section['has_sub_subjects'];
        $subject_section->save();

        // $subject_section->teacher_id = $request->subject_section['teacher_id'];
        // $subject_section->update();
        $subject_section->load(['sub_sec_details.teacher', 'teacher', 'course', 'section', 'subject']);
        $subject_sections = $this->getSubjectSections($request->subject_section['course_id'], $request->subject_section['subject_id']);
        return response()->json(['success' => 'true', 'subject_section' => $subject_section, 'subject_sections' => $subject_sections], 200, ['app-status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showSection(Request $request)
    {
        $this->validate($request, [
            'subject_section.course_id'  => 'required|min:1|integer',
            'subject_section.subject_id' => 'required|min:1|integer',
            'subject_section.section_id' => 'required|min:1|integer',
            'subject_section.has_sub_subjects' => 'required|in:Y,N',
        ]);
        $subject_section = SubjectSection::firstOrCreate(
            [
                'course_id' => $request->subject_section['course_id'],
                'subject_id' => $request->subject_section['subject_id'],
                'section_id' => $request->subject_section['section_id']
            ],
            [
                'teacher_id' => $request->subject_section['teacher_id']
            ]
        );
        $subject_section->load('sub_sec_details');
        if ($subject_section->wasRecentlyCreated === false) {
            if (count($subject_section->sub_sec_details) == 0) {
                $subject_section->has_sub_subjects = $request->subject_section['has_sub_subjects'];
                $subject_section->update();
            }
        } else {
            $subject_section->has_sub_subjects = $request->subject_section['has_sub_subjects'];
            $subject_section->update();
        }
        $subject_section->load(['sub_sec_details.teacher', 'teacher', 'course', 'section', 'subject']);
        return response()->json(['success' => 'true', 'subject_section' => $subject_section], 200, ['app-status' => 'success']);
    }

    public function show(Request $request)
    {
        if (Gate::denies('academic-section-details')) {
            return deny();
        }

        $this->validate($request, [
            'course_id' => 'required|min:1|integer',
            'subject_id' => 'required|min:1|integer',
        ]);
        $subject_sections = $this->getSubjectSections($request->course_id, $request->subject_id);
        return reply('ok', [
            'subject_sections' => $subject_sections
        ]);
    }

    private function getSubjectSections($course_id, $subject_id)
    {
        return SubjectSection::where('course_id', $course_id)->where('subject_id', $subject_id)
            ->with(['section', 'course', 'teacher', 'subject', 'sub_sec_details.teacher'])
            ->get();
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
}
        // if (Gate::denies('')) {
        //     return deny();
        // }
