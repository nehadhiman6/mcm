<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StudentCourseRequest extends FormRequest
{
    protected $stdsubs = [];
    protected $student = null;
    // protected $id = 0;
    protected $optsubsqty = 0;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //dd($this->all());
        $rules = [
            'student_id' => 'required|exists:' . getYearlyDbConn() . '.students,id',
            'course_id' => 'required|integer|min:1',
        ];
        $this->std = \App\Student::findOrFail($this->student_id);
        $this->stdsubs = [];
        $cmpgrps = $this->get("compGrp", []);
        $optgrps = $this->get("optionalGrp", []);
        $optsubs = $this->get("selectedOpts", []);
        $elective_grps = $this->get('elective_grps', []);
        $this->optsubsqty = count($optsubs);
        $grpsubs = [];
        foreach ($optgrps as $value) {
            if ($value['selectedid'] != 0) {
                $this->optsubsqty++;
            }
        }
        foreach ($elective_grps as $value) {
            if (isset($value['selectedid']) && $value['selectedid'] != 0) {
                $this->optsubsqty++;
            }
        }
        foreach ($cmpgrps as $value) {
            if ($value['selectedid'] != 0) {
                $grpsubs[$value['id']] = $value['selectedid'];
            }
        }
        if (intval($this->course_id) != 0) {
            $this->course = \App\Course::find($this->course_id);
            if ($this->course) {
                if ($this->optsubsqty != $this->course->min_optional) {
                    $rules['opt_subs_count'] = "required";
                }
                $compSubs = $this->course->getSubGroups('C');
                foreach ($compSubs as $value) {
                    if (array_key_exists($value['id'], $grpsubs) == false) {
                        $rules['comp_group'] = "required";
                    }
                }
            }
        }
        foreach ($optsubs as $key => $value) {
            $stdsub = new \App\StudentSubs();
            $stdsub->subject_id = $value;
            $stdsub->sub_group_id = 0;
            $stdsub->ele_group_id = 0;
            $this->stdsubs[] = $stdsub;
        }
        foreach ($cmpgrps as $key => $value) {
            $stdsub = new \App\StudentSubs();
            $stdsub->subject_id = $value['selectedid'];
            $stdsub->sub_group_id = $value['id'];
            $stdsub->ele_group_id = 0;
            $this->stdsubs[] = $stdsub;
        }
        foreach ($optgrps as $value) {
            if ($value['selectedid'] != 0) {
                $stdsub = new \App\StudentSubs();
                $stdsub->subject_id = $value['selectedid'];
                $stdsub->sub_group_id = $value['id'];
                $stdsub->ele_group_id = 0;
                $this->stdsubs[] = $stdsub;
            }
        }
        foreach ($elective_grps as $value) {
            if (isset($value['selectedid']) && $value['selectedid'] != 0) {
                $stdsub = new \App\StudentSubs();
                $stdsub->subject_id = $value['selectedid'];
                $stdsub->sub_group_id = 0;
                $stdsub->ele_group_id = $value['id'];
                $this->stdsubs[] = $stdsub;
            }
        }
        return $rules;
    }

    public function messages()
    {
        $msgs = [
        'student.course_id.required' => 'Select one of the Relevant Course You Want to Study',
    ];
        if ($this->exists('student.course_id') && intval($this->std['course_id']) != 0) {
            if ($this->optsubsqty < $this->course->min_optional) {
                $msgs['opt_subs_count.required'] = 'Check ! Minimum Optional subject should not be less than ' . $this->course->min_optional;
            } else {
                $msgs['opt_subs_count.required'] = 'Check ! Maximum Optional subject should not be more than ' . $this->course->min_optional;
            }
        }
        return $msgs;
    }

    public function save()
    {
        // dd($this->all());
        // $this->std = \App\Student::findOrFail($this->student_id);
        $adm_entry = $this->std->admEntry;
        $adm_entry->addon_course_id = $this->addon_course_id;
        DB::connection(getYearlyDbConn())->beginTransaction();
        $this->std->course_id = $this->course_id;
        $this->std->selected_ele_id = $this->input('student.selected_ele_id');
        $this->std->update();
        $idarr = $this->std->stdSubs->pluck('id', 'id')->toArray();
        $stdsubs = $this->stdsubs;
        \App\StudentSubs::createOrUpdateMany($stdsubs, ['student_id' => $this->std->id], $idarr);
        $adm_entry->save();
        DB::connection(getYearlyDbConn())->commit();
    }

    public function redirect()
    {
        if ($this->ajax()) {
            return reply("Updated Successfully", ['course' => $this->std->course->course_name]);
        }
    }
}
