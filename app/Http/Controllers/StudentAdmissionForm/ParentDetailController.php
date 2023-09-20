<?php

namespace App\Http\Controllers\StudentAdmissionForm;

use App\AdmissionForm;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Online\Controller;
use App\Http\Requests\StudentAdmissionRequests\ParentDetailRequest as ParentDetailRequest;
use Session;
use Illuminate\Http\Request;


class ParentDetailController extends Controller
{
    protected $tab_no = 0;

    private function getCurrentActiveTab()
    {
        $adm = AdmissionForm::whereStdUserId(auth('students')->user()->id)->first();
        return $adm ? $adm->active_tab : 0;
    }

    public function store(ParentDetailRequest $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm($request, $type = 'save')
    {
        $parent_detail = AdmissionForm::findOrFail($request->form_id);
        $parent_detail->fill($request->all());
        if ($type == 'update')
            $parent_detail->active_tab = $this->getCurrentActiveTab();
        $parent_detail->update();
        return reply('ok', [
            'active_tab' => $this->getCurrentActiveTab(),
            'adm_form' => $parent_detail,
            'form_id' => $parent_detail->id
        ]);
    }


    public function update(ParentDetailRequest $request, $id)
    {
        logger($request->user());
        return $this->saveForm($request, 'update');
    }



    // public function printDetail($id)
    // {
    //     //
    //     $student = \App\AdmissionForm::findOrFail($id);
    //     return view('admissionform.admprint', compact('students', 'student'));
    // }

    // public function details($id)
    // {
    //     $adm_form = \App\AdmissionForm::findOrFail($id);
    //     // dd($adm_form->reservedHostel());
    //     $adm_form->load('student');
    //     if (Gate::denies('student-adm-form', $adm_form)) {
    //         abort('401', 'Resource does not belong to current user!!');
    //     }
    //     return view('admissionform.parent_detail', compact('adm_form'));
    // }
}
