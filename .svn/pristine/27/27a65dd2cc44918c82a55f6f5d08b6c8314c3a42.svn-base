<?php

namespace App\Http\Controllers\Online;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Responses;
use Illuminate\Support\Facades\Storage;
use Gate;

class AttachmentController extends Controller
{
    use \App\Http\Traits\SavesAttachments;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($adm_id)
    {
        // $adm_form = \App\AdmissionForm::findOrFail($adm_id);
        //  $attachment = \App\Attachment::where('admission_id', '=', $adm_id)->get();
        return \App\Attachment::where('admission_id', '=', $adm_id)->get();
        // return view('admissionform._form_attachment', compact('adm_form', 'attachment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $file_type, $id)
    {
        $adm_form = \App\AdmissionForm::findOrFail($id);
        if (Gate::denies('student-adm-form', $adm_form)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        return $this->save($request, $file_type, $id);
        //    return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($adm_id, $file_type)
    {
        return $this->download($adm_id, $file_type);
        //        dd('here');
    //

    //    dd($file);
    //  $file = $file_type . '_' . $id . '.' . $file->$file_type->extension();
    //$file_type = Storage::get($file->file_type);
    //$file_ext = Storage::get($file->file_ext);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $file_type)
    {
        dd($request->all());
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

    public function getDownload($adm_id)
    {
        $file = \App\Attachment::where('admission_id', '=', $adm_id)->firstOrFail();
        $file = $file_type . '_' . $id . '.' . $request->$file_type->extension();
        $file_type = Storage::get($file->file_type);
        $file_ext = Storage::get($file->file_ext);
        $file_path = storage_path() . "/app/images/photograph.jpeg";
        return response()->file($file_path);
        //  return response()->download($file);
    // $file_path = storage_path('/app/images/'.$file_name);
    // return response()->download($file_path);
    }

    public function addAttachments($adm_id)
    {
        $adm_form = \App\AdmissionForm::findOrFail($adm_id);
        if (Gate::denies('student-adm-form', $adm_form)) {
            abort('401', 'Resource does not belong to current user!!');
        }
        if ($adm_form->final_submission == 'Y') {
            return redirect()->back()->with('message', 'You Cant Edit Your Form After Final Submission');
        }
        $attachment = \App\Attachment::where('admission_id', '=', $adm_id)->get();
        return view('online.admissions.attachments', compact('adm_form', 'attachment'));
    }
}
