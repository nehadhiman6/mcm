<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Illuminate\Database\Eloquent\Collection;
use App\Models\Staff\StaffExperience;
use App\Staff;
use DB;

class StaffExperienceController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'staff_id'=>'required|exists:staff,id',
            'experiences.*.days'=>'required|numeric',
            'experiences.*.months'=>'required|numeric',
            'experiences.*.years'=>'required|numeric',
        ]);


        $staff = Staff::findOrFail($request->staff_id);
        $old_exp_staff_ids = $staff->experiences()->pluck('id')->toArray();


        $experiences = new Collection();

        foreach($request->experiences as $experience){
            $exp = StaffExperience::firstOrNew(['id' => $experience['id']]);
            $exp->fill($experience);
            $experiences->add($exp);
        }

        $new_ids = $experiences->pluck('id')->toArray();
        $detach = array_diff($old_exp_staff_ids, $new_ids);


        DB::beginTransaction();
            $staff->experiences()->saveMany($experiences);
            StaffExperience::whereIn('id',$detach)->delete();
        DB::commit();

        return reply(true,[
            'staff' => $staff
        ]);
    }
}
