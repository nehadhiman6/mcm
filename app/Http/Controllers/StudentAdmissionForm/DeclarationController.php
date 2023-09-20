<?php

namespace App\Http\Controllers\StudentAdmissionForm;

use App\AdmissionForm;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Online\Controller;
use Session;
use Illuminate\Http\Request;


class DeclarationController extends Controller
{
    protected $tab_no = 0;

    private function getCurrentActiveTab()
    {
        $adm = AdmissionForm::whereStdUserId(auth('students')->user()->id)->first();
        return $adm ? $adm->active_tab : 0;
    }

    public function store(Request $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $type = 'save')
    {
        $this->validate(
            $request,
            [
                'terms_conditions' => 'required|in:Y',
                // 'antireg_ref_no' => 'required|max:20'
            ],
            ['terms_conditions.in' => 'Kindly Check Term & Conditions !!']
        );


        $adm_form = AdmissionForm::findOrFail($request->form_id);
        $adm_form->fill($request->all());

        if ($type == 'update')
            $adm_form->active_tab = $this->getCurrentActiveTab();

        $adm_form->update();
        return reply('ok', [
            'active_tab' => $this->getCurrentActiveTab(),
            'adm_form' => $adm_form,
            'form_id' => $adm_form->id
        ]);
    }


    public function update(Request $request, $id)
    {
        return $this->saveForm($request, 'update');
    }
}
