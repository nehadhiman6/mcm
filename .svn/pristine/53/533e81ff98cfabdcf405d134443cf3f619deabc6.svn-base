<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseSubjectRequest extends FormRequest {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    $id = ($this->route('courses'));
    //dd($id);
    $coursesubid = ($this->route('subjects'));
   
    // dd($coursesubid);
    $rules = [
      'subject_id' => 'required|exists:subjects,id|unique:' . getYearlyDbConn() . '.course_subject,subject_id,null,subject_id,course_id,' . $id,
    ];
    if ($coursesubid) {
      $rules['subject_id'] = 'required|unique:' . getYearlyDbConn() . ".course_subject,subject_id,$coursesubid,id,course_id,$id";
    }
    // hounour_sub_id is required only if honours link is selected in course
    $course = \App\Course::findOrFail($id);
    if($course->honours_link == 'Y'){
      if($this->honours){
        $rules['honours_sub_id'] = 'required';
      }
    }
//    dd($rules['subject_id']);
    return $rules;
  }

}
