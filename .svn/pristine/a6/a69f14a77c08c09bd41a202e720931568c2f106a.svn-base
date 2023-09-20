<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Collection;
use App\Models\Staff\StaffQualification;
use App\Staff;
use DB;

class StaffQualificationController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'staff_id'=>'required|exists:staff,id',
            'qualifications.*.exam'=>'nullable|max:250',
            'qualifications.*.other_exam'=>'nullable|required_without:qualifications.*.exam|max:50',
            'qualifications.*.institute_id'=>'required',
            'qualifications.*.other_institute'=>'required_if:institute_id,0',
            'qualifications.*.year'=>'required|max:4|digits:4',
            'qualifications.*.percentage'=>'required_if:qualifications.*.pr_cgpa,P,C',
            // 'qualifications.*.division'=>'required|max:50',
            'qualifications.*.distinction'=>'nullable|max:500',
        ]);


        $staff = Staff::findOrFail($request->staff_id);
        $old_qual_staff_ids = $staff->qualifications()->pluck('id')->toArray();


        $qualifications = new Collection();

        foreach($request->qualifications as $qualification){
            // $qual = StaffQualification::firstOrNew('id',$qualification['id']);
            $qual = StaffQualification::firstOrNew(['id' => $qualification['id']]);
            $qual->fill($qualification);
            if($qual->pr_cgpa == 'N'){
                $qual->percentage = 0;
            }
            $qualifications->add($qual);
        }

        $new_ids = $qualifications->pluck('id')->toArray();
        $detach = array_diff($old_qual_staff_ids, $new_ids);


        DB::beginTransaction();
            $staff->qualifications()->saveMany($qualifications);
            StaffQualification::whereIn('id',$detach)->delete();
        DB::commit();

        return reply(true,[
            'staff' => $staff
        ]);
    }
}
