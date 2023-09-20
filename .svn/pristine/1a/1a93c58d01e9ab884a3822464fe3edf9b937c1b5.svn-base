<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubHeadRequest extends FormRequest {

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
    $id = ($this->route('feeheads'));
    //dd($id);
    $feesubhead = ($this->route('subheads'));
    $rules = [
       'sno' => 'required|unique:' . getYearlyDbConn() . '.sub_heads,sno,null,sno,feehead_id,' . $id,
       'name' => 'required|unique:'. getYearlyDbConn(). '.sub_heads,name' . $id,
       'group'=>'required'
    ];
    //dd($rules);
    return $rules;
  }

}
