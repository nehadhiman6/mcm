<?php

namespace App\Http\Controllers\Placement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Placement\Placement;
use App\Models\Resource\Resource;
use App\Staff;
use App\Student;
use Gate;

class PlacementController extends Controller
{
    use \App\Http\Traits\SavesAttachments;
    public function index(Request $request)
    {
        if (Gate::denies('placements')) {
            return deny();
        }
        if (!$request->ajax()) {
            return view('placement.placement.index');
        }
        $count = Placement::all()->count();
        $filteredCount = $count;
        $placements = Placement::orderBy('id', 'DESC');
        if ($searchStr = $request->input('search.value')) {
            $placements = $placements->where('', 'like', "%{$searchStr}%");
        }
        
        $placements = $placements->take($request->length);
        $filteredCount = $placements->count();

        $placements = $placements->select(['placements.*'])->distinct()->get();
        $placements->load('placement_students','company','resources');
        // dd($placements);
        foreach($placements as $place){
            $staff = [];
            $staff_ids =  explode (",",$place->staff_id);
            // dd($staff_ids);ss
            $staff = Staff::whereIn('id',$staff_ids)->get()->load('dept');
            $place->staff = $staff;
        }
        // dd($staff);
        return [
            'draw' => intval($request->draw),
            'start'=>$request->start,
            'data' => $placements,
            'recordsTotal' => $count,
            'recordsFiltered' => $filteredCount,
        ];
    }


    public function create()
    {
        if (Gate::denies('add-placements')) {
            return deny();
        }
        return view('placement.placement.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('placements-modify')) {
            return deny();
        }
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id=0)
    {
        $this->validateForm($request, $id);
        $placement = Placement::findOrNew($request->id);
        $placement->fill($request->all());
        $placement->save();
        return reply(true, compact('placement'));
    }

    private function validateForm(Request $request, $id)
    {
        $rules = [
            'drive_date'=> 'required|date_format:d-m-Y',
            'type' => 'required|in:P,I,E',
            'nature' => 'required',
            'comp_id' => 'required|exists:placement_companies,id',
            'hr_personnel' => 'required|max:50',
            'contact_no' => 'required|max:50',
            'email' => 'required|max:100',
            'staff_id' => 'required',
            'job_profile' => 'required|max:50',
            'stu_reg' => 'required|numeric',
            'stu_appear' => 'nullable|numeric',
            'max_salary' => 'required|numeric',
            'min_salary' => 'required|numeric',
            'round_no' => 'required|numeric',
        ];
        $messages = [
            
        ];
       

        $this->validate($request, $rules, $messages);
    }

    public function edit($id)
    {
        if (Gate::denies('placements-modify')) {
            return deny();
        }
        $placement = Placement::findOrFail($id);
        // $placement->load('state');
        return view('placement.placement.create', compact('placement'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('placements-modify')) {
            return deny();
        }
        return $this->saveForm($request, $id);
    }

    public function getDepartment($staff_id){
        $staff = Staff::find($staff_id)->load('dept');
        return reply(
            true,
            [
                'staff' => $staff
            ]
        );
    }

    public function getPlacementUpload($place_id){
        // if (Gate::denies('placements-modify')) {
        //     return deny();
        // }
        $id = $place_id;
        $placement = Placement::findOrFail($place_id);
        $placement->load('resources.attachment');
        return view('attachment.attachment', compact('placement','id'));
    }


    public function attachment(Request $request,$id)
    {
        $messages = [];
        // dd($file->getClientOriginalExtension());
        $rules = [
            'file' => 'required|mimes:pdf|max:' . config('college.max_file_upload_size')
        ];
        $messages = [
           'file' . '.mimes' => 'Check File Type, upload a Pdf format.',
           'file' . '.max' => 'File Size should not be more than 300KB. '
        ];
      
        $this->validate($request, $rules, $messages);
        $file_upload = $this->uploadStore($request);
       
        return [
            'resource' => $file_upload,
            
        ];
    }

    public function saveResources(Request $request)
    {
        // dd($request->all());
        $messages = [];
        $rules = [
            'id' => 'required|not_in:0',
            'attachment_id' => 'required|not_in:0',
        ];
        $messages = [
            'attachment_id.not_in' => 'Please Select Attachment !!',
         ];
        $this->validate($request, $rules,$messages);
        $resource = Resource::firstOrNew([
            'doc_type' => 'placement', 'resourceable_type' => Placement::class,
            'resourceable_id' => $request->id
        ]);
        $resource->resourceable_type = Placement::class;
        $resource->resourceable_id = $request->id;
        $resource->attachment_id = $request->attachment_id;
        $resource->doc_type = 'placement';
        // dd($resource);
        $resource->save();
        return reply(true, [
            'resources' => $resource,
            'attachment' => Resource::find($resource->id)->load('attachment'),
        ]);
    }

    public function getAttachmentShow(Request $request, $id){
        $resource = Resource::where('resourceable_type', Placement::class)->where('resourceable_id',$id)->first();
        $attachment_id = $resource->attachment_id;
        return $this->attachmentShow($request,$attachment_id);
    }
}
