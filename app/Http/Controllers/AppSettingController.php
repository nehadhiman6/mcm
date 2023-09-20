<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Gate;

class AppSettingController extends Controller
{
    public function create()
    {
        if (Gate::denies('app-setting')) {
            return deny();
        }
        $app_setting = AppSetting::all();

        return view('appsetting.create', compact('app_setting'));
    }

    public function store(Request $request)
    {
       
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id = 0)
    {

        $this->validate(
            $request,
            [
                'std_key.hostel.key_value' => 'required',
                'std_key.college.key_value' => 'required',
                'std_key.hostel.description' => 'required',
                'std_key.college.description' => 'required',
            ],
            [
                'std_key.hostel.key_value.required' => 'The hostel status field is required',
                'std_key.college.key_value.required' => 'The college status field is required',
                'std_key.hostel.description.required' => 'The hostel description field is required',
                'std_key.college.description.required' => 'The college description field is required',

            ]
        );
        foreach ($request->std_key as $key => $det) {
            $setting = AppSetting::firstOrNew(['id' =>$det['id'], 'key_name' => $det['key_name']]);
            $setting->key_value = $det['key_value'];
            $setting->description = $det['description'];
            $setting->save();
        }
        return reply('Ok', [
            'setting' => $setting,
        ]);
    }
}
