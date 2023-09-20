<?php

namespace App\Http\Traits;

use App\Models\Resource\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait SavesAttachments
{
    public function save(Request $request, $file_type, $id)
    {
        $student = \App\AdmissionForm::findOrFail($id);
        //dd($file_type);
        $messages = [];
        $rules = [
            $file_type => 'required|mimes:pdf|max:' . config('college.max_file_upload_size')
        ];
        $messages = [
            $file_type . '.mimes' => 'Check File Type, upload a Pdf format.',
            $file_type . '.max' => 'File Size should not be more than 300KB. '
        ];
        if ($file_type == 'photograph') {
            $rules[$file_type] = 'required|mimes:jpeg,bmp,png,jpg|max:' . config('college.max_photo_upload_size');
            $messages = [$file_type . '.max' => 'File Size should not be more than ' . config('college.max_photo_upload_size') . 'KB'];
        }
        if ($file_type == 'signature') {
            $rules[$file_type] = 'required|mimes:jpeg,bmp,png,jpg|max:' . config('college.max_sign_upload_size');
            $messages = [$file_type . '.max' => 'File Size should not be more than '  . config('college.max_sign_upload_size') . 'KB'];
        }

        if ($file_type == 'parent_signature') {
            $rules[$file_type] = 'required|mimes:jpeg,bmp,png,jpg|max:' . config('college.max_sign_upload_size');
            $messages = [$file_type . '.max' => 'File Size should not be more than '  . config('college.max_sign_upload_size') . 'KB'];
        }
        // logger($rules);
        //    if ($file_type == 'mark_sheet' || $file_type == 'dob_certificate' || $file_type == 'char_certificate' || $file_type == 'migrate_certificate' || $file_type == 'gap_certificate' || $file_type == 'uid') {
        //      $rules[$file_type] = 'required|mimes:pdf|max:' . config('college.max_file_upload_size');
        //      $messages = [
        //        $file_type.'.mimes' => 'Check File Type,upload a Pdf format.',
        //        $file_type.'.max' =>'File Size should not be more than 300KB. '
        //      ];
        //    }
        $this->validate($request, $rules, $messages);
        $file = $file_type . '_' . $id . '.' . $request->$file_type->extension();
        $path = $request->$file_type->storeAs('images', $file);
        // return $path;
        $attachment = \App\Attachment::firstOrNew(['admission_id' => $id, 'file_type' => $file_type]);
        $attachment->fill($request->all() + ['admission_id' => $student->id]);
        $attachment->file_type = $file_type;
        $attachment->file_ext = $request->$file_type->extension();
        $attachment->save();
        return ['files' => [
            'name' => $file,
            'url' => (request()->user()->type == 'student' ? route('students.get.image', [$id, $file_type]) : route('office.get.image', [$id, $file_type]))
        ]];
        // return response()->download($path);
        // return response()->file($path);
    }

    public function download($adm_id, $file_type)
    {
        // dd($file_type);
        //    $student = \App\Attachment::where('admission_id', '=', $adm_id)->first();
        $file = \App\Attachment::where('admission_id', '=', $adm_id)
            ->where('file_type', '=', $file_type)->first();
        //  dd($file);

        if ($file) {
            $file_path = "images" . getFY() . "/" . $file_type . '_' . $adm_id . '.' . $file->file_ext;
            if (Storage::disk('local')->exists($file_path) == false) {
                $file_path = "images/" . $file_type . '_' . $adm_id . '.' . $file->file_ext;
            }
            //      dd($file_path);
            return response()->file(storage_path('app/' . $file_path));
        }
    }


    public function uploadStore(Request $request){
        $file = $request->file('file');
        $session  = session()->get('fy','');
        $attachment = new Attachment();
        if ($file) {
            $attachment->file_ext = $file->getClientOriginalExtension();
            $attachment->file_name = $file->getClientOriginalName();
            $attachment->mime_type = $file->getMimeType();
            DB::beginTransaction();
                $attachment->save();
                $file->move(storage_path('app/yearly-files/'.$session.'/'), $attachment->id . '.' . $attachment->file_ext);
            DB::commit();
            return $attachment;
        }
    }

    public function attachmentShow(Request $request, $id)
    {
        $session  = session()->get('fy','');
        $attachment = Attachment::findOrFail($id);
        if ($attachment) {
            $file_path = storage_path() . "/app/yearly-files/$session/" . $id . '.' . $attachment->file_ext;
            return response()->file($file_path);
        }
    }

    public function getAttachmentThumbnail(Request $request, $id)
    {
        $session  = session()->get('fy','');
        $attachment = Attachment::findOrFail($id);
        $img_types=['image/bmp','image/jpeg','image/gif','image/png'];
        $pdf_types= ['application/pdf'];

        if ($attachment) {
            if (in_array($attachment->mime_type, $img_types)) {
                $file_path = storage_path() . "/app/yearly-files/$session/" . $id . '.' . $attachment->file_ext;
                return response()->file($file_path);
            }
            else if(in_array($attachment->mime_type, $pdf_types)){
                $file_path = public_path() . "/images/pdf.png";
                return response()->file($file_path);
            }
            else {
                $file_path = public_path() . "/images/other.png";
                return response()->file($file_path);
            }
        }
    }

      // direct from file
    public function deleteAttachment(Request $request){
        $session  = session()->get('fy','');
        $file_id = $request->getContent();
        if($file_id > 0){
            DB::beginTransaction();
            $attachment =  Attachment::findOrFail($file_id);
            if($attachment){
                $image_path = storage_path('app/yearly-files/'.$session.'/'). $attachment->id .'.'.$attachment->file_ext;
                // Value is not URL but directory file path
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $attachment->delete();
            DB::commit();
            return reply(true, ['attachment' => $attachment]);
        }
    }
}
