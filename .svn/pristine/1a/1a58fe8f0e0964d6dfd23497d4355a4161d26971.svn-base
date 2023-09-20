<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Excel;
use Gate;

class IDCardController extends Controller
{

  //
    public function index(Request $request)
    {
//    dd($request->all());
        if (Gate::denies('idcard-report')) {
            return deny();
        }
        if (!request()->ajax() && $request->input('excel', 'N') == 'N') {
            return View('reports.idcard_report');
        }
        $students = \App\Student::join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno')->orderBy('students.card_no')
        ->where('students.adm_cancelled', '=', 'N')
        ->whereIn('admission_id', function ($query) {
            $query->from('attachments')
          ->where(function ($q) {
              $q->where('file_type', 'signature');
          })
          ->select('admission_id');
        })
        ->whereIn('admission_id', function ($query) {
            $query->from('attachments')
          ->where(function ($q) {
              $q->where('file_type', 'photograph');
          })
          ->select('admission_id');
        })
        ->whereIn('admission_id', function ($query) {
            $query->from('admission_forms')
          ->where(function ($q) {
              $q->where('final_submission', 'Y');
          })
          ->select('id');
        })
        ->with(['attachments' => function ($q) {
            $q->whereIn('file_type', ['photograph', 'signature']);
        }]);
        if ($request->input('from_card_no', 0) > 0) {
            $students = $students->where('card_no', '>=', $request->input('from_card_no', 0));
        }
        if ($request->input('to_card_no', 0) > 0) {
            $students = $students->where('card_no', '<=', $request->input('to_card_no', 0));
        }
        if ($request->course_id != 0) {
            $students = $students->where('courses.id', '=', $request->course_id);
        }
        if ($request->having_card == 'Y') {
            $students = $students->where('card_no', '!=', 0);
        } else {
            $students = $students->where('card_no', '=', 0);
        }
//    if ($request->from_card_no == '') {
//      $students = $students->where('card_no', $request->from_card_no);
//    } else
//      $students = $students->where('card_no', '>=', $request->from_card_no)
//        ->where('card_no', '<=', $request->to_card_no);

        $students = $students->select('students.*', 'course_name');
        if ($request->excel == 'N') {
            return $students->get();
        } else {
            $view = 'reports.idcard_excel';
            $students = $students->get();
            $file = 'idcard';
            Excel::create($file, function ($excel) use ($students, $file, $view) {
                $excel->sheet($file, function ($sheet) use ($students, $view) {
                    $sheet->loadView($view, ['students' => $students]);
                });
            })->export('xlsx');
        }
    }

    public function generateCardNo(Request $request)
    {
        //  dd($request->all());
        if (Gate::denies('GEN-IDCARD-NO')) {
            return deny();
        }
        $students = \App\Student::join('courses', 'courses.id', '=', 'students.course_id')->orderBy('courses.sno')
        ->where('students.adm_cancelled', '=', 'N')
        ->whereIn('admission_id', function ($query) {
            $query->from('attachments')
          ->where(function ($q) {
              $q->where('file_type', 'signature');
          })
          ->select('admission_id');
        })
        ->whereIn('admission_id', function ($query) {
            $query->from('attachments')
          ->where(function ($q) {
              $q->where('file_type', 'photograph');
          })
          ->select('admission_id');
        })
        ->whereIn('admission_id', function ($query) {
            $query->from('admission_forms')
          ->where(function ($q) {
              $q->where('final_submission', 'Y');
          })
          ->select('id');
        });
//        ->where('students.card_no', '=', 0);
        if ($request->course_id != 0) {
            $students = $students->where('courses.id', '=', $request->course_id);
        }
        $students = $students->select('students.*')->orderBy('students.id');
//    dd($students->get());
        $students->chunk(50, function ($stds) {
//      dd($stds);
            foreach ($stds as $std) {
//        dd($std);
                if ($std->card_no == 0) {
                    DB::connection(getYearlyDbConn())->beginTransaction();
                    $std->card_no = next_cardno();
                    $std->update();
                    DB::connection(getYearlyDbConn())->commit();
                }
            }
        });

        return reply('Card Nos Generated Successfully!');
    }
}
