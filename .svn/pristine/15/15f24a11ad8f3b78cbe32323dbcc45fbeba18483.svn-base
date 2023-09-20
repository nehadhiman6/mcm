<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\CourseSubject;

class GroupSubjectsRequest extends FormRequest
{

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
        $course_id = $this->route('courses');
        $id = ($this->route('groups'));
        $rules = [
            's_no' => 'required|integer|min:1|unique:' . getYearlyDbConn() . '.subject_group,s_no,' . $id . ',id,course_id,' . $course_id,
            // 'type' => 'required',
        ];
        foreach ($this->subjects as $key => $course_sub_id) {
            $course_sub = CourseSubject::findOrFail($course_sub_id);
            $rules['subjects.' . $key] = Rule::unique(getYearlyDbConn() . '.subject_group_det', 'course_sub_id')->where(function ($q) use ($id) {
                $q->where('sub_group_id', '!=', $id);
            });
            $msgs["subjects.{$key}.unique"] = "{$course_sub->subject->subject} already added to this Elective Option!";
        }
        
        // dd($rules);
        return $rules;
    }

    public function messages()
    {
        $msgs = [];
        foreach ($this->subjects as $key => $course_sub_id) {
            $course_sub = CourseSubject::findOrFail($course_sub_id);
            $msgs["subjects.{$key}.unique"] = "{$course_sub->subject->subject} already added to this Elective Option!";
        }
        return $msgs;
    }
}
