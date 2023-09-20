<?php

namespace App\Http\Controllers\Admissions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Discrepancy\AdmissionFormDiscrepancy;
use DB;
use Gate;

class DiscrepancyController extends Controller
{   
    public function show($id){
        $adm_id = $id;
        return View('admentries.discrepancy.create',compact('adm_id'));
    }

    public function create(Request $request)
    {
        if (Gate::denies('discrepancy-entry')) {
            return deny();
        }

        if (!request()->ajax()) {
            return View('admentries.discrepancy.create');
        }

        $adm_form = \App\AdmissionForm::findOrFail($request['admission_id']);
        $adm_form->load(['discrepancy','course','std_user']);
        return reply(true, [
            'adm_form'=>$adm_form,
        ]);
    }

    public function store(Request $request)
    {
    //    dd($request->all());
        $this->validate($request, [
            'admission_id'=>'required|not_in:0',
            'remarks'=>'nullable',
        ]);
        $adm = \App\AdmissionForm::findOrFail($request->admission_id);
        $adm_old = $adm->discrepancy()->pluck('id')->toArray();
        $collection = new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->option as $key => $det) {
            if($det['opt_value'] != null){
                $discrepancy = AdmissionFormDiscrepancy::firstOrNew(['id'=>$det['id'], 'admission_id'=>$request->admission_id]);
                $discrepancy->remarks= $request->remarks;
                $discrepancy->admission_id= $request->admission_id;
                $discrepancy->opt_name= $det['opt_name'];
                $discrepancy->opt_value= $det['opt_value'];
                $collection->add($discrepancy);
            }
           
        }
        $new_ids = $collection->pluck('id')->toArray();
        $detach = array_diff($adm_old, $new_ids);

        DB::beginTransaction();
            $adm->discrepancy()->saveMany($collection);
            AdmissionFormDiscrepancy::whereIn('id', $detach)->delete();
        DB::commit();
        // if ($consent->ask_student == 'Y') {
        //     $msg = "Dear student, we have alotted your subjects/honours according to your preference. You can check the same and give your consent by login into MCM Students Portal on https://admissions.mcmdav.com/stulogin with in 24 hours for further processing.";
        //     $msg = "Dear student, we have alotted you subject/course you applied for. You can check the same and give your consent by login into MCM Students Portal on https://admissions.mcmdav.com/stulogin with in 24 hours for further processing.";
        //     dispatch(new SendSms($msg, $admission_form->mobile));
        //     Mail::to($admission_form->std_user)->queue(new Notification($msg));
        // }

        return reply(true, [
            'adm'=>$adm
        ]);
    }
}
