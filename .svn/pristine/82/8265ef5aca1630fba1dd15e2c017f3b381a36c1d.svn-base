<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentSubjectRequest extends FormRequest
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
//    dd($this->id);
//    dd($this->all());
        $rules = [
      'student_id' => 'required|exists:' . getYearlyDbConn() . '.students,id',
    ];
        $this->student = \App\Student::findOrFail($this->student_id);
        $this->stdsubs = [];
        $cmpgrps = $this->get("compGrp", []);
        $optgrps = $this->get("optionalGrp", []);
        $optsubs = $this->get("selectedOpts", []);
        $this->optsubsqty = count($optsubs);
        $grpsubs = [];
        foreach ($optgrps as $value) {
            if ($value['selectedid'] != 0) {
                $this->optsubsqty++;
            }
        }
        foreach ($cmpgrps as $value) {
            if ($value['selectedid'] != 0) {
                $grpsubs[$value['id']] = $value['selectedid'];
            }
        }
        $this->course = \App\Course::findOrFail($this->student->course_id);
        if ($this->course) {
            if ($this->optsubsqty < $this->course->min_optional) {
                $rules['opt_subs_count'] = "required";
            }
            $compSubs = $this->course->getSubGroups('C');
            foreach ($compSubs as $value) {
                if (array_key_exists($value['id'], $grpsubs) == false) {
                    $rules['comp_group'] = "required";
                }
            }
        }
        foreach ($optsubs as $key => $value) {
            $stdsub = new \App\StudentSubs();
            $stdsub->subject_id = $value;
            $stdsub->sub_group_id = 0;
            $this->stdsubs[] = $stdsub;
        }
        foreach ($cmpgrps as $key => $value) {
            $stdsub = new \App\StudentSubs();
            $stdsub->subject_id = $value['selectedid'];
            $stdsub->sub_group_id = $value['id'];
            $this->stdsubs[] = $stdsub;
        }
        foreach ($optgrps as $value) {
            if ($value['selectedid'] != 0) {
                $stdsub = new \App\StudentSubs();
                $stdsub->subject_id = $value['selectedid'];
                $stdsub->sub_group_id = $value['id'];
                $this->stdsubs[] = $stdsub;
            }
        }
        return $rules;
    }

    public function messages()
    {
        $msgs = [];
        if ($this->optsubsqty < $this->course->min_optional) {
            $msgs['opt_subs_count.required'] = 'Check ! Minimum Optional subject should not be less than ' . $this->course->min_optional;
        } else {
            $msgs['opt_subs_count.required'] = 'Check ! Maximum Optional subject should not be more than ' . $this->course->min_optional;
        }
        return $msgs;
    }

    public function save()
    {
//     dd($this->all());
        $idarr = $this->student->stdSubs->pluck('id', 'id')->toArray();
        $stdsubs = $this->stdsubs;
        \App\StudentSubs::createOrUpdateMany($stdsubs, ['student_id' => $this->student->id], $idarr);
    }

    public function redirect()
    {
        if ($this->ajax()) {
            return reply("Subjects Updated Successfully");
        }
    }
}
