<div class="form-group" v-if="fieldsDisabled">
  {!! Form::label('image','Image', ['class' => 'control-label col-sm-2 required'])!!}
  <div class="col-md-4 "   v-bind:class="{ 'has-error': errors['image'] }"> 
    <img :src="getSource()" alt="your image" width="115" height="115"/>
    <h5><a class="btn btn-primary" href="{{ url('user-upload')}}">Upload Image</a></h5>
    <span id="basic-msg" v-if="errors['image']" class="help-block">@{{ errors['image'][0] }}</span>
  </div>
 
</div>

<div class="form-group">
  {!! Form::label('salutation','Salutation', ['class' => 'control-label col-sm-2 required'])!!}
  <div class="col-md-2 "  v-bind:class="{ 'has-error': errors['salutation'] }"> 
    {!! Form::select('salutation',getSalutation(),null, array('required', 'class'=>'form-control','v-model'=>'salutation')) !!}
    <span id="basic-msg" v-if="errors['salutation']" class="help-block">@{{ errors['salutation'][0] }}</span>
  </div>
</div>

<div class="form-group">
  {!! Form::label('name','First Name', ['class' => 'control-label col-sm-2 required'])!!}
  <div class="col-md-2 "  v-bind:class="{ 'has-error': errors['name'] }"> 
    {!! Form::text('name',null, array('required',  'class'=>'form-control','v-model'=>'name')) !!}
    <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
  </div>
  {!! Form::label('middle_name','Middle Name', ['class' => 'control-label col-sm-2 '])!!}
  <div class="col-md-2"  v-bind:class="{ 'has-error': errors['middle_name'] }"> 
    {!! Form::text('middle_name',null, array('required',  'class'=>'form-control','v-model'=>'middle_name')) !!}
    <span id="basic-msg" v-if="errors['middle_name']" class="help-block">@{{ errors['middle_name'][0] }}</span>
  </div>
  {!! Form::label('last_name','Last Name', ['class' => 'control-label col-sm-2 '])!!}
  <div class="col-md-2 "  v-bind:class="{ 'has-error': errors['last_name'] }"> 
    {!! Form::text('last_name',null, array('required', 'class'=>'form-control','v-model'=>'last_name')) !!}
    <span id="basic-msg" v-if="errors['last_name']" class="help-block">@{{ errors['last_name'][0] }}</span>
  </div>
</div> 

<div class="form-group">
  {!! Form::label('gender','Gender', ['class' => 'control-label col-sm-2 required'])!!}
  <div class="col-md-2 "  v-bind:class="{ 'has-error': errors['gender'] }"> 
    {!! Form::select('gender',getGender(),null, array('required','class'=>'form-control','v-model'=>'gender','placeholder'=>'Select')) !!}
    <span id="basic-msg" v-if="errors['gender']" class="help-block">@{{ errors['gender'][0] }}</span>
  </div>
  {!! Form::label('dob','DOB', ['class' => ' control-label col-sm-2 required'])!!}
  <div class="col-md-2 " v-bind:class="{ 'has-error': errors['dob'] }"> 
    {!! Form::text('dob',null, array('required', 'class'=>'form-control app-datepicker ','v-model'=>'dob')) !!}
    <span id="basic-msg" v-if="errors['dob']" class="help-block">@{{ errors['dob'][0] }}</span>
  </div>
  {!! Form::label('fateh_name','Father Name', ['class' => 'control-label col-sm-2 '])!!}
  <div class="col-md-2 "  v-bind:class="{ 'has-error': errors['father_name'] }"> 
    {!! Form::text('father_name',null, array('required', 'class'=>'form-control','v-model'=>'father_name')) !!}
    <span id="basic-msg" v-if="errors['last_name']" class="help-block">@{{ errors['father_name'][0] }}</span>
  </div>
</div> 

<div class="form-group"  >
    {!! Form::label('email','Email', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-3 " v-bind:class="{ 'has-error': errors['email'] }"> 
      {!! Form::text('email',null, array('class'=>'form-control', ':disabled' => "fieldsDisabled",'v-model'=>'email')) !!}
      <span id="basic-msg" v-if="errors['email']" class="help-block">@{{ errors['email'][0] }}</span>
    </div>
    {!! Form::label('mobile','Mobile', ['class' => ' control-label col-sm-1 required'])!!}
    <div class="col-md-2 " v-bind:class="{ 'has-error': errors['mobile'] }"> 
      {!! Form::text('mobile',null, array('required', 'class'=>'form-control','v-model'=>'mobile')) !!}
      <span id="basic-msg" v-if="errors['mobile']" class="help-block">@{{ errors['mobile'][0] }}</span>
    </div>
    {!! Form::label('mobile2','Alter. Mobile', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-2 " v-bind:class="{ 'has-error': errors['mobile2'] }"> 
      {!! Form::text('mobile2',null, array('required', 'class'=>'form-control','v-model'=>'mobile2')) !!}
      <span id="basic-msg" v-if="errors['mobile']" class="help-block">@{{ errors['mobile2'][0] }}</span>
    </div>
</div>

<div class="form-group">
  {!! Form::label('address','Permanent Address', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-6 " v-bind:class="{ 'has-error': errors['address'] }"> 
    {!! Form::textarea('address',null, array('required', 'class'=>'form-control','size'=>'50x2','v-model'=>'address')) !!}
    <span id="basic-msg" v-if="errors['address']" class="help-block">@{{ errors['address'][0] }}</span>
  </div>
  {!! Form::label('cat_id','Category',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['cat_id'] }">
      {!! Form::select('cat_id',getCategory(),null,['class' => 'form-control','v-model'=>'cat_id']) !!}
      <span id="basic-msg" v-if="errors['cat_id']" class="help-block">@{{ errors['cat_id'][0] }}</span>
    </div>
</div>

<div class="form-group">
  {!! Form::label('address_res','Residential Address', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-6 " v-bind:class="{ 'has-error': errors['address_res'] }"> 
    {!! Form::textarea('address_res',null, array('required', 'class'=>'form-control','size'=>'50x2','v-model'=>'address_res')) !!}
    <span id="basic-msg" v-if="errors['address_res']" class="help-block">@{{ errors['address_res'][0] }}</span>
  </div>
  {!! Form::label('library_code','Library Code',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['library_code'] }">
      {!! Form::text('library_code',null, array('required', 'class'=>'form-control','v-model'=>'library_code')) !!}
      <span id="basic-msg" v-if="errors['library_code']" class="help-block">@{{ errors['library_code'][0] }}</span>
    </div>

</div>

  <div class="form-group"  >
    {!! Form::label('faculty_id','Faculty', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-3 " v-bind:class="{ 'has-error': errors['faculty_id'] }"> 
      {!! Form::select('faculty_id',getFaculty(),null, array('required', 'class'=>'form-control','v-model'=>'faculty_id', '@click'=>'getDepartments')) !!}
      <span id="basic-msg" v-if="errors['faculty_id']" class="help-block">@{{ errors['faculty_id'][0] }}</span>
    </div>
    {!! Form::label('sub_faculty_id','Sub Faculty', ['class' => ' control-label col-sm-1'])!!}
    <div class="col-md-3 " v-bind:class="{ 'has-error': errors['sub_faculty_id'] }"> 
      {!! Form::select('sub_faculty_id',getFaculty(),null, array('required', 'class'=>'form-control','v-model'=>'sub_faculty_id', '@click'=>'getDepartments')) !!}
      <span id="basic-msg" v-if="errors['sub_faculty_id']" class="help-block">@{{ errors['sub_faculty_id'][0] }}</span>
    </div>
    {!! Form::label('desig_id','Designation', ['class' => ' control-label col-sm-1'])!!}
    <div class="col-md-2 " v-bind:class="{ 'has-error': errors['desig_id'] }"> 
      {!! Form::select('desig_id',getDesignations(), null, array('required', 'class'=>'form-control','v-model'=>'desig_id','placeholder'=>'Select')) !!}
      <span id="basic-msg" v-if="errors['desig_id']" class="help-block">@{{ errors['desig_id'][0] }}</span>
    </div>
   
</div> 
<div class="form-group"  >
    {!! Form::label('dept_id','Department', ['class' => 'control-label col-sm-2'])!!}
    <div class="col-md-3 " v-bind:class="{ 'has-error': errors['dept_id'] }"> 
      <select name="dept_id" id="dept_id" v-model='dept_id' class='form-control'>
        <option v-for="dept in departments" :value="dept.id">@{{ dept.name }}</option>
      </select>
      <span id="basic-msg" v-if="errors['dept_id']" class="help-block">@{{ errors['dept_id'][0] }}</span>
    </div>
    {!! Form::label('source','Nature of Appointment', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-3" v-bind:class="{ 'has-error': errors['source'] }"> 
      {!! Form::select('source',getStaffSource(), null, array('required', 'class'=>'form-control','v-model'=>'source','placeholder'=>'Select')) !!}
      <span id="basic-msg" v-if="errors['source']" class="help-block">@{{ errors['source'][0] }}</span>
    </div>
</div>

<div class="form-group">
 
    {!! Form::label('mcm_joining_date','MCM Joining Date', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-3 " v-bind:class="{ 'has-error': errors['mcm_joining_date'] }"> 
      <!-- <input type="text" name="mcm_joining_date" v-model="mcm_joining_date" class="form-control app-datepicker" @change.prevent="checkPermision()"> -->
      {!! Form::text('mcm_joining_date',null, array('required', 'class'=>'form-control app-datepicker',':disabled'=>'disable','v-model'=>'mcm_joining_date','@blur.prevent'=>'getRetirementDate()')) !!}
      <span id="basic-msg" v-if="errors['mcm_joining_date']" class="help-block">@{{ errors['mcm_joining_date'][0] }}</span>
    </div>
    {!! Form::label('confirmation_date','Confirmation Date', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-3 " v-bind:class="{ 'has-error': errors['confirmation_date'] }" > 
       {!! Form::text('confirmation_date',null, array('required', 'class'=>'form-control app-datepicker','v-model'=>'confirmation_date')) !!}
      <span id="basic-msg" v-if="errors['confirmation_date']" class="help-block">@{{ errors['confirmation_date'][0] }}</span>
    </div>
    {{-- {!! Form::label('teaching_exp','Previous Experience', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-2 " v-bind:class="{ 'has-error': errors['teaching_exp'] }"> 
      {!! Form::text('teaching_exp',null, array('required', 'class'=>'form-control','v-model'=>'teaching_exp','placeholder'=> 'years months & days')) !!}
      <span id="basic-msg" v-if="errors['teaching_exp']" class="help-block">@{{ errors['teaching_exp'][0] }}</span>
    </div> --}}
   
</div>
<div class="form-group"> 
  {!! Form::label('teaching_exp','Current Experience', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['teaching_exp'] }"> 
      {!! Form::text('teaching_exp',null, array('required','readOnly','class'=>'form-control','v-model'=>'current_exp')) !!}
      <span id="basic-msg" v-if="errors['teaching_exp']" class="help-block">@{{ errors['teaching_exp'][0] }}</span>
    </div>
</div>
{{-- <div class="form-group">
  {!! Form::label('qualification','Qualification', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-2 " v-bind:class="{ 'has-error': errors['type'] }"> 
    {!! Form::text('qualification',null, array('class'=>'form-control','v-model'=>'qualification')) !!}
    <span id="basic-msg" v-if="errors['qualification']" class="help-block">@{{ errors['qualification'][0] }}</span>
  </div>
  
  {!! Form::label('area_of_specialization','Area Of Specialization', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-2 " v-bind:class="{ 'has-error': errors['area_of_specialization'] }"> 
    {!! Form::select('area_of_specialization',getAreaSpecilization(), null, array('required', 'readOnly','class'=>'form-control','v-model'=>'area_of_specialization','placeholder'=>'Select')) !!}
    <span id="basic-msg" v-if="errors['area_of_specialization']" class="help-block">@{{ errors['area_of_specialization'][0] }}</span>
  </div>
  <div v-show="area_of_specialization == 'Other'" class="col-md-2 " v-bind:class="{ 'has-error': errors['other_specialization'] }"> 
    {!! Form::text('other_specialization',null, array('required', 'class'=>'form-control','v-model'=>'other_specialization')) !!}
    <span id="basic-msg" v-if="errors['other_specialization']" class="help-block">@{{ errors['other_specialization'][0] }}</span>
  </div>
</div>  --}}

<div class="form-group">
  {!! Form::label('aadhar_no','Aadhar No.', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-3 " v-bind:class="{ 'has-error': errors['aadhar_no'] }"> 
    {!! Form::text('aadhar_no',null, array('class'=>'form-control','v-model'=>'aadhar_no')) !!}
    <span id="basic-msg" v-if="errors['aadhar_no']" class="help-block">@{{ errors['aadhar_no'][0] }}</span>
  </div>
  {!! Form::label('pan_no','PAN No.', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-3 " v-bind:class="{ 'has-error': errors['pan_no'] }"> 
    {!! Form::text('pan_no', null, array('class'=>'form-control','v-model'=>'pan_no')) !!}
    <span id="basic-msg" v-if="errors['pan_no']" class="help-block">@{{ errors['pan_no'][0] }}</span>
  </div>
</div> 

<div class="form-group">
  {!! Form::label('emergency_contact','Emergency Contact 1', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-3 " v-bind:class="{ 'has-error': errors['emergency_contact'] }"> 
    {!! Form::text('emergency_contact',null, array('class'=>'form-control','v-model'=>'emergency_contact')) !!}
    <span id="basic-msg" v-if="errors['emergency_contact']" class="help-block">@{{ errors['emergency_contact'][0] }}</span>
  </div>
  {!! Form::label('emergency_relation','Relation', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-3 " v-bind:class="{ 'has-error': errors['emergency_relation'] }"> 
    {!! Form::text('emergency_relation', null, array('class'=>'form-control','v-model'=>'emergency_relation')) !!}
    <span id="basic-msg" v-if="errors['emergency_relation']" class="help-block">@{{ errors['emergency_relation'][0] }}</span>
  </div>
</div> 

<div class="form-group">
  {!! Form::label('emergency_contact2','Emergency Contact 2', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-3 " v-bind:class="{ 'has-error': errors['emergency_contact2'] }"> 
    {!! Form::text('emergency_contact2',null, array('class'=>'form-control','v-model'=>'emergency_contact2')) !!}
    <span id="basic-msg" v-if="errors['emergency_contact2']" class="help-block">@{{ errors['emergency_contact2'][0] }}</span>
  </div>
  {!! Form::label('emergency_relation2','Relation', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-3 " v-bind:class="{ 'has-error': errors['emergency_relation2'] }"> 
    {!! Form::text('emergency_relation2', null, array('class'=>'form-control','v-model'=>'emergency_relation2')) !!}
    <span id="basic-msg" v-if="errors['emergency_relation2']" class="help-block">@{{ errors['emergency_relation2'][0] }}</span>
  </div>
</div> 

<div class="form-group">
  {!! Form::label('type','Type', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-2 " v-bind:class="{ 'has-error': errors['type'] }"> 
    {!! Form::select('type',getStaffType(), null, array('required',  ':disabled' => "fieldsDisabled", 'class'=>'form-control','v-model'=>'type','placeholder'=>'Select')) !!}
    <span id="basic-msg" v-if="errors['type']" class="help-block">@{{ errors['type'][0] }}</span>
  </div>
  @if(auth()->user()->hasRole('TEACHERS'))
    {!! Form::label('user_id','Username', ['class' => ' control-label col-sm-2','v-if'=>"type == 'Teacher'"])!!}
    <div class="col-md-2 " v-bind:class="{ 'has-error': errors['user_id'] }" v-if="type == 'Teacher'"> 
        {!! Form::select('user_id',getUser(), [], array('required', ':disabled' => "fieldsDisabled", 'class'=>'form-control','v-model'=>'user_id','readOnly' ,'disabled')) !!}
      <span id="basic-msg" v-if="errors['user_id']" class="help-block">@{{ errors['user_id'][0] }}</span>
    </div>
  @else
    {!! Form::label('user_id','Username', ['class' => ' control-label col-sm-2','v-if'=>"type == 'Teacher'"])!!}
    <div class="col-md-2 " v-bind:class="{ 'has-error': errors['user_id'] }" v-if="type == 'Teacher'"> 
      {!! Form::select('user_id',getUser(), null, array('required',  ':disabled' => "fieldsDisabled",'class'=>'form-control','v-model'=>'user_id')) !!}
      <span id="basic-msg" v-if="errors['user_id']" class="help-block">@{{ errors['user_id'][0] }}</span>
    </div>
  @endif    
  {!! Form::label('blood_group','Blood Group', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-2 ">
  {!! Form::select('blood_group',getBloodGroup(),null,['class' => 'form-control ','v-model'=>'blood_group']) !!}
</div>
</div>

<div class="form-group">
{!! Form::label('retire_date','Retirement Date', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-3 " v-bind:class="{ 'has-error': errors['retire_date'] }" > 
       {!! Form::text('retire_date',null, array('required', 'class'=>'form-control app-datepicker','v-model'=>'retire_date')) !!}
      <span id="basic-msg" v-if="errors['retire_date']" class="help-block">@{{ errors['retire_date'][0] }}</span>
    </div>
  {!! Form::label('pay_scale','Pay Scale', ['class' => ' control-label col-sm-2'])!!}
  <div class="col-md-3 " v-bind:class="{ 'has-error': errors['pay_scale'] }"> 
    {!! Form::select('pay_scale',getPayScale(),null, array('required', 'class'=>'form-control','v-model'=>'pay_scale')) !!}
    <span id="basic-msg" v-if="errors['pay_scale']" class="help-block">@{{ errors['pay_scale'][0] }}</span>
  </div>
</div> 

<div class="form-group">
    {!! Form::label('remarks','Remarks', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-10 " v-bind:class="{ 'has-error': errors['remarks'] }"> 
      {!! Form::text('remarks',null, array( 'class'=>'form-control','v-model'=>'remarks')) !!}
      <span id="basic-msg" v-if="errors['remarks']" class="help-block">@{{ errors['remarks'][0] }}</span>
    </div>
</div> 

<div class ="form-group" v-if="fieldsDisabled"> 
  <div class="col-sm-11 col-sm-offset-1">
    <label class="control-label required">
      <input type='checkbox' v-model="disclaimer"  v-bind:true-value="'Y'"  v-bind:false-value="'N'" name='centralized'  class="checkbox-inline">
      Certified that information given above is true and correct to the best of my knowledge.  
    </label>
    <span id="basic-msg" v-if="errors['disclaimer']" class="help-block">@{{ errors['disclaimer'][0] }}</span>
  </div>
</div>


