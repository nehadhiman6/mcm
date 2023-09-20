<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstallmentRequest extends FormRequest {

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
    $id = $this->route('installment');
   // dd($installment);
    $rules = [
      'name' => 'required|max:50|unique:' . getYearlyDbConn() . '.installments,name,' . $id,
      'head_type' => 'required',
      'inst_type' => 'required'
    ];
    //dd($rules);
    return $rules;
  }

}
