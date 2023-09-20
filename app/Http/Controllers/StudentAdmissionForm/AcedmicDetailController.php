<?php

namespace App\Http\Controllers\StudentAdmissionForm;

use App\AcademicDetail;
use App\AdmissionForm;
use App\BechelorDegreeDetails;
use App\Course;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Online\Controller;
use App\Http\Requests\StudentAdmissionRequests\AcedmicDetailRequest as AcedmicDetailRequest;
use Session;
use Illuminate\Http\Request;
use DB;

class AcedmicDetailController extends Controller
{
    protected $tab_no = 0;

    private function getCurrentActiveTab()
    {
        $adm = AdmissionForm::whereStdUserId(auth('students')->user()->id)->first();
        return $adm ? $adm->active_tab : 0;
    }

    public function store(AcedmicDetailRequest $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm($request, $type = 'save')
    {
        // if(intval($request->course_id) > 0){
        //     $course = Course::findOrFail($request->course_id);
        //     if($course->course_name == 'MSC-I CHEMISTRY'){
        //         $this->validate(
        //             $request,
        //             [
        //                 'ocet_rollno' => 'required',
        //             ]
        //         );
        //     }
        // }
        
        $adm_form = AdmissionForm::findOrFail($request->form_id);
        $adm_form->fill($request->all());
        $idarr1 = $adm_form->academics->pluck('id', 'id')->toArray();

        if ($type == 'update') {
            $adm_form->active_tab = $this->getCurrentActiveTab();
        }

        if ($request->course_type == 'PGRAD') {
            $this->becholor_degree_details = BechelorDegreeDetails::firstOrNew(['admission_id' =>  $adm_form->id]);
            $this->becholor_degree_details->fill($request->get("postgraduate"));
            $this->becholor_degree_details->save();
        }
        DB::beginTransaction();
        AcademicDetail::createOrUpdateMany($request->acades, ['admission_id' => $adm_form->id], $idarr1);
        AcademicDetail::setLastExam($adm_form->id);
        $adm_form->update();
        DB::commit();

        return reply('ok', [
            'active_tab' => $this->getCurrentActiveTab(),
            'form_id' => $adm_form->id,
            'adm_form' => $adm_form,
        ]);
    }


    public function update(AcedmicDetailRequest $request, $id)
    {
        return $this->saveForm($request, 'update');
    }
}
