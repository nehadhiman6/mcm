<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyProspectusRequest extends FormRequest
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
        $rules = [
        // 'first_name' => 'required',
        //  'last_name' => 'required',
        'email' => 'required|email|max:255|unique:' . getYearlyDbConn() . '.student_users',
        'mobile' => 'required|min:10|max:10|unique:' . getYearlyDbConn() . '.student_users',
        'password' => 'required|min:6|confirmed',
    ];
        return $rules;
    }
}
