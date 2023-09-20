<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StateRequest extends FormRequest
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
       $id = $this->route('state');
        $rules = [
            'state' => 'required|unique:states,state,' . $id,
        ];
//       //dd($this);
//         $id = $this->route('states');
//        // dd($id);
//    $rules = [
//        'state' => 'required|max:30',Rule::unique('states')->ignore($id),
//     ];
    return $rules;
    }
}
