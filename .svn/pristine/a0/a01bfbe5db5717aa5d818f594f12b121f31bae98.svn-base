<?php

namespace App\Http\Controllers\Placement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Placement\Placement;
use App\Models\Placement\PlacementStudent;
use App\Models\Resource\Resource;
use App\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Gate;

class PlacementStudentController extends Controller
{

    use \App\Http\Traits\SavesAttachments;
    
    
    public function show($id){
        if (Gate::denies('placement-student-details')) {
            return deny();
        }
        $btn_name = 'AP';
        $placement = Placement::findOrFail($id)->load('company');
        return view('placement.placement.student_details', compact('id','btn_name','placement'));
    }

    public function getPlacementStudent(Request $request, $roll_no,$session)
    {
        $database = getYearlyDbConnFromDb($session);
        $student = DB::table($database. '.students')
                        ->join($database. '.courses','students.course_id','=','courses.id')
                        ->join('categories','students.cat_id','=','categories.id')
                        ->join($database. '.student_users','students.std_user_id','=','student_users.id')
                        ->where('students.roll_no', $roll_no)->select(['students.*','courses.course_name as course_name','categories.name as cat_name','student_users.email'])->first();

        //  dd($student);           
        if (!$student) {
            $this->validate(
                $request,
                [
                    'college_roll_no' => 'required',
                ],
                [
                    'college_roll_no.required' => 'This Roll no does not exists',

                ]
            );
        }
        // if($student){
        //     $student = $student->load('course','category');
        // }
        return reply(
            true,
            [
                'student' => $student
            ]
        );
    }

    public function store(Request $request)
    {
        return $this->saveForm($request);
    }

    private function saveForm(Request $request, $id=0)
    {
        // dd($request->all());
        $this->validateForm($request, $id);
        $old_res_ids = [];
        $placement = Placement::findOrFail($request->place_id);
        $detstuids = $placement->placement_students->pluck('id')->toArray();
        $old_res_ids = Resource::whereIn('resourceable_id',$detstuids)->where('resourceable_type' , PlacementStudent::class)->pluck('id')->toArray();
        $detstudents =  new \Illuminate\Database\Eloquent\Collection();
        $resources =  new \Illuminate\Database\Eloquent\Collection();
        foreach ($request->students as $det) {
                $student = PlacementStudent::findOrNew($det['id']);
                $student->placement_id = $request->place_id;
                $student->session = $det['session'];
                $student->std_id = $det['stu_id'];
                $student->roll_no = $det['roll_no'];
                $student->name = $det['name'];
                $student->mother_name = $det['mother_name'];
                $student->father_name = $det['father_name'];
                $student->cat_id = $det['cat_id'];
                $student->course_id = $det['course_id'];
                $student->phone = $det['phone_no'];
                $student->email = $det['email'];
                $student->job_profile = $det['job_profile'];
                $student->remarks = $det['remarks'];
                $student->status = $det['status'];
                $student->pay_package = $det['pay_package'];
                $student->letter_type = $det['letter_type'];
                if($det['status'] == 'Selected' && $det['attachment_id'] > 0){
                    $resource = Resource::firstOrNew(['resourceable_type' => PlacementStudent::class, 'resourceable_id' => $det['id']]);
                    $resource->attachment_id = $det['attachment_id'];
                    $resource->resourceable_id = $det['id'];
                    $resource->resourceable_type = PlacementStudent::class;
                    $resources->add($resource);
                }
                $detstudents->add($student);
        }
        $new_ids = $detstudents->pluck('id')->toArray();
        $depent = array_diff($detstuids, $new_ids);
        $new_res_ids = $resources->pluck('id')->toArray();
        $res_depent = array_diff($old_res_ids, $new_res_ids);
        DB::beginTransaction();
        $placement->placement_students()->saveMany($detstudents);
        foreach ($resources as $key => $res) {
            $res->save();
        }
        PlacementStudent::whereIn('id', $depent)->delete();
        Resource::whereIn('id', $res_depent)->delete();
        DB::commit();
        return reply('Ok');
    }

   

    private function validateForm(Request $request, $id)
    {
        $rules = [];
        $messages= [];
        $rules += [
            'students.*.roll_no' => 'required|numeric',
            'students.*.email' => 'required',
            'students.*.job_profile' => 'required|max:50',
            'students.*.status' => 'required|in:SL,Selected,AP',
        ];
        $messages += [
            'students.*.roll_no.required' => 'Roll No is Required',
            'students.*.email.required' => 'Email is Required',
            'students.*.job_profile.required' => 'Job Profile is Required',
        ];
        
        $this->validate($request, $rules, $messages);
    }

    public function getPlacementStudentEdit($place_id,$btn_name)
    {
        $id = $place_id;
        $placement = Placement::findOrFail($id)->load('company');
        // if($btn_name == 'Selected'){
            // $placement_student = PlacementStudent::where('placement_id',$place_id)->where('status','=','SL')->get();
        // }else{
            $placement_student = PlacementStudent::where('placement_id',$place_id)->get();

        // }
        $placement_student->load('student.course','student.category','course','category','resource.attachment');
        return view('placement.placement.student_details', compact('placement_student','id','btn_name','placement'));
    }

    public function update(Request $request, $id)
    {
        return $this->saveForm($request, $id);
    }

    public function saveResources(Request $request,$id)
    {
        $messages = [];
        // dd($request->all());
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

    public function getAttachmentShow(Request $request, $id){
        $resource = Resource::where('resourceable_type', PlacementStudent::class)->where('resourceable_id',$id)->first();
        $attachment_id = $resource->attachment_id;
        return $this->attachmentShow($request,$attachment_id);
    }

}
