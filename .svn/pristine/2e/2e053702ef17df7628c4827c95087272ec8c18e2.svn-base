<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Responses;
use Illuminate\Support\Facades\Storage;

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
        return \App\Attachment::where('admission_id', '=', $adm_id)->get();
//    return view('admissions.');
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
        // dd(getFY());
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

//    public function getFilename($filename){
//
//		$entry = Attachment::where('file_type', '=', $file_type)->firstOrFail();
//		$file = Storage::disk('local')->get($entry->file_type);
//
//		return (new Response($file, 200))
//              ->header('Content-Type', $entry->mime);
//	}
//}
}
