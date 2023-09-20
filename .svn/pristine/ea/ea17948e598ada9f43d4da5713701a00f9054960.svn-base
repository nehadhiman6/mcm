<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest {

  protected $series_msg = [];

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
    $id = $this->route('course');
    $rules = [
        'sno' => 'required|unique:' . getYearlyDbConn() . '.courses,sno,' . $id,
        'class_code' => 'required|unique:' . getYearlyDbConn() . '.courses,class_code,' . $id,
        //  'course_id' =>'required|unique:' . getYearlyDbConn() . '.courses,course_id,' . $id,
        'course_name' => 'required|unique:' . getYearlyDbConn() . '.courses,course_name,' . $id,
        'no_of_seats' => 'required|integer',
        'st_rollno' => 'required|integer|min:1',
        'end_rollno' => 'required|integer|min:' . (floatval($this->st_rollno) + 1),
        'min_optional' => 'required',
        'max_optional' => 'required',
        // 'adm_open'=>'required',
        // 'adm_close_date'=>'required'
    ];
    if ($course = \App\Course::checkSeries($this->st_rollno, $id)) {
      $rules['starting'] = 'required';
      $this->series_msg['starting.required'] = "Starting rollno is in conflict with $course->course_name";
    }
    if ($course = \App\Course::checkSeries($this->end_rollno, $id)) {
      $rules['ending'] = 'required';
      $this->series_msg['ending.required'] = "Ending rollno is in conflict with $course->course_name";
    }

    return $rules;
  }

  public function messages() {
    return $this->series_msg;
  }

}
