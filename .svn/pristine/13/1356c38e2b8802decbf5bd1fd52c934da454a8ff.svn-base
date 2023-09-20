<?php

namespace App\Http\Controllers\StudentAdmissionForm;

use App\AdmissionForm;
use App\Alumani;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Online\Controller;
use App\Http\Requests\StudentAdmissionRequests\ForMigAlumniRequest as ForMigAlumniRequest;
use Session;
use Illuminate\Http\Request;


class ForeignMigrationAlumniController extends Controller
{
    protected $tab_no = 0;

    private function getCurrentActiveTab()
    {
        $adm = AdmissionForm::whereStdUserId(auth('students')->user()->id)->first();
        return $adm ? $adm->active_tab : 0;
    }

    public function store(ForMigAlumniRequest $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm($request)
    {
        $adm_form = AdmissionForm::findOrFail($request->form_id);
        $adm_form->fill($request->all());
        if ($request->know_alumani == 'Y') {
            $this->alumani = Alumani::firstOrNew(['admission_id' =>  $adm_form->id]);
            $this->alumani->fill($request->get("alumani"));
            $this->alumani->save();
        }
        $adm_form->save();
        return reply('ok', [
            'active_tab' => $this->getCurrentActiveTab(),
            'adm_form' => $adm_form,
            'form_id' => $adm_form->id
        ]);
    }


    public function update(ForMigAlumniRequest $request, $id)
    {
        return $this->saveForm($request);
    }
}
