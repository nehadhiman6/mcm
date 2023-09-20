<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest {

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

    $id = $this->route('city');
    $rules = [
      'city' => 'required|max:40|unique:cities,city,' . $id,
      'state_id' => 'required',
    ];
    return $rules;
  }

}
