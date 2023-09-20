<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\AdmissionForm;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class AdmStrengthController extends Controller
{
    public function subStdStrength(Request $request)
    {
        if (Gate::denies('SUBJECT-WISE-STRENGTH')) {
            return deny();
        }
        if (!request()->ajax()) {
            return View('reports.subwise_adm_strength');
            // return View('reports.subwise_adm_strength', compact('toolbar'));
        }
        $this->validate($request, [
            'upto_date' => 'required|date_format:d-m-Y',
            'course_id' => 'required|integer|exists:' . getYearlyDbConn() . '.courses,id'
        ]);
        $dt = mysqlDate($request->upto_date);

        $students = AdmissionForm::join('courses', 'admission_forms.course_id', '=', 'courses.id')
            ->join('admission_subs', 'admission_subs.admission_id', '=', 'admission_forms.id')
            ->join(getSharedDb() . 'subjects', 'admission_subs.subject_id', '=', 'subjects.id')
            ->select([
                'courses.course_name', 'admission_subs.subject_id', 'subjects.subject',
                DB::raw("sum(1) as students"),
            ])
            ->where('admission_forms.final_submission', '=', 'Y')
            ->where('admission_forms.course_id', '=', $request->course_id)
            ->groupBy(DB::raw('1, 2'))->orderBy('courses.sno');



        return $students->get();
    }

    public function subwiseStdDetails(Request $request)
    {
        if (!request()->ajax()) {
            return View('reports.subwise_admdetails', $request->only('subject_id', 'course_id', 'subject'));
        }
        return AdmissionForm::getStrength($request->course_id, $request->subject_id);
    }
}
