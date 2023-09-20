<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConcessionRequest extends FormRequest {

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
    $id = $this->route('concession');
    //dd($concession);
    $rules = [
      'name' => 'required|max:50|unique:' . getYearlyDbConn() . '.concessions,name,' . $id,
    ];
    //dd($rules);
    return $rules;
  }

}
