<?php

namespace App\Http\Controllers\Fees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class SubjectChargesController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index()
    {
        if (Gate::denies('SUBJECT-CHARGES')) {
            return deny();
        }
        $subcharges = \App\SubjectCharge::all();
        return view('fees.subcharges.index', compact('subcharges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('SUBJECT-CHARGES')) {
            return deny();
        }
        return view('fees.subcharges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('SUBJECT-CHARGES')) {
            return deny();
        }
        // dd($request->all());
        $this->validateForm($request);
        // dd($request->all());
        $sub_charges = new \App\SubjectCharge();
        $sub_charges->fill($request->all());
        $sub_charges->save();
        return redirect('subcharges');
    }

    private function validateForm($request, $id = 0)
    {
        $rules = [
            'course_id' => 'required|exists:' . getYearlyDbConn() . '.courses,id',
            'subject_id' => 'required|exists:' . getYearlyDbConn() . '.course_subject,subject_id,course_id,' . $request->course_id .
                    '|unique:' . getYearlyDbConn() . '.subject_charges,subject_id,' . $id . ',id,course_id,' . $request->course_id,
        ];
        if (floatval($request->pract_fee) + floatval($request->pract_exam_fee) + floatval($request->hon_fee) + floatval($request->hon_exam_fee) == 0) {
            $rules['fees'] = 'required';
        } else {
            if (floatval($request->pract_fee) > 0) {
                $rules['pract_id'] = 'required|exists:' . getYearlyDbConn() . '.sub_heads,id';
            }
            if (floatval($request->hon_fee) > 0) {
                $rules['hon_id'] = 'required|exists:' . getYearlyDbConn() . '.sub_heads,id';
            }
            if (floatval($request->pract_exam_fee) > 0 || floatval($request->hon_exam_fee) > 0) {
                $rules['exam_id'] = 'required|exists:' . getYearlyDbConn() . '.sub_heads,id';
            }
        }
        $this->validate($request, $rules);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('SUBJECT-CHARGES')) {
            return deny();
        }
        $subcharge = \App\SubjectCharge::findOrfail($id);
        $subjects = $subcharge->course->getSubjectsForCharges();
        //dd($subjects);
        return view('fees.subcharges.create', compact('subcharge', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('SUBJECT-CHARGES')) {
            return deny();
        }
        $this->validateForm($request, $id);
        $subcharge = \App\SubjectCharge::findOrfail($id);
        $subcharge->fill($request->all());
        $subcharge->update();
        return redirect('subcharges');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
