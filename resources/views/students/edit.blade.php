@extends('app')
@section('content')
<div class="box box-info" id='app' v-cloak>
  <div class="box-header with-border">
    <h3 class="box-title">Student Edit</h3>
  </div>
  {!! Form::model($student, ['method' => 'PATCH', 'action' => ['StudentController@update', $student->id], 'class' => 'form-horizontal']) !!}

  <div class="box-body">
    <fieldset>
      <legend>Student Details</legend>
      <div class="form-group">
        {!! Form::label('std_type','Student Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          <p class="form-control-static">@{{ student.std_type.name }}</p>
        </div>
        {!! Form::label('course','Course',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          <p class="form-control-static">@{{ student.course.course_name}}</p>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('loc_cat','Relevant Category',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.loc_cat'] }">
          <label class="radio-inline">
            {!! Form::radio('loc_cat', 'UT',null, ['class' => 'minimal','v-model'=>'student.loc_cat']) !!}
            UT Pool
          </label>
          <label class="radio-inline">
            {!! Form::radio('loc_cat', 'General',null, ['class' => 'minimal','v-model'=>'student.loc_cat']) !!}
            General Pool
          </label>
          <span id="basic-msg" v-if="errors['student.loc_cat']" class="help-block">@{{ errors['student.loc_cat'][0] }}</span>
        </div>
        {!! Form::label('geo_cat','For Information',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.loc_cat'] }">
          <label class="radio-inline">
            {!! Form::radio('geo_cat', 'Rural',null, ['class' => 'minimal','v-model'=>'student.geo_cat']) !!}
            RURAL
          </label>
          <label class="radio-inline">
            {!! Form::radio('geo_cat', 'Urban',null, ['class' => 'minimal','v-model'=>'student.geo_cat']) !!}
            URBAN
          </label>
          <span id="basic-msg" v-if="errors['student.geo_cat']" class="help-block">@{{ errors['student.geo_cat'][0] }}</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('cat_id','Category',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.cat_id'] }">
          {!! Form::select('cat_id',getCategory(),null,['class' => 'form-control','v-model'=>'student.cat_id','@change'=>'isForeignNational']) !!}
          <span id="basic-msg" v-if="errors['student.cat_id']" class="help-block">@{{ errors['student.cat_id'][0] }}</span>
        </div>
        {!! Form::label('resvcat_id','Reserved Category',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.resvcat_id'] }">
          {!! Form::select('resvcat_id',getResCategory(),null,['class' => 'form-control','v-model'=>'student.resvcat_id']) !!}
          <span id="basic-msg" v-if="errors['student.resvcat_id']" class="help-block">@{{ errors['student.resvcat_id'][0] }}</span>
        </div>
      </div>
      	<div class='form-group'>
          {!! Form::label('minority','Minority',['class' => 'col-sm-2 control-label required']) !!}
			<div class="col-sm-3" v-bind:class="{ 'has-error': errors['minority'] }">
			<label class="radio-inline">
				{!! Form::radio('minority', 'Y',null, ['class' => 'minimal','v-model'=>'student.minority']) !!}
				Yes
			</label>
			<label class="radio-inline">
				{!! Form::radio('minority', 'N',null, ['class' => 'minimal','v-model'=>'student.minority']) !!}
				No
			</label>
			<span id="basic-msg" v-if="errors['minority']" class="help-block">@{{ errors['minority'][0] }}</span>
			</div>
			<div  v-if="student.minority == 'Y'">
			{!! Form::label('religion','Religion',['class' => 'col-sm-2 control-label required']) !!}
			<div class="col-sm-5" v-bind:class="{ 'has-error': errors['religion'] }">
				<label class="radio-inline">
				{!! Form::radio('religion', 'Sikh',null, ['class' => 'minimal','v-model'=>'student.religion']) !!}
				SIKH
				</label>
				<label class="radio-inline">
				{!! Form::radio('religion', 'Muslim',null, ['class' => 'minimal','v-model'=>'student.religion']) !!}
				MUSLIM
				</label>
				<label class="radio-inline">
				{!! Form::radio('religion', 'Christian',null, ['class' => 'minimal','v-model'=>'student.religion']) !!}
				CHRISTIAN
				</label>
				<label class="radio-inline">
				{!! Form::radio('religion', 'Others',null, ['class' => 'minimal','id'=>'others','v-model'=>'student.religion']) !!}
				OTHERS
				</label>
				<span id="basic-msg" v-if="errors['religion']" class="help-block">@{{ errors['religion'][0] }}</span>
			</div>
			<div v-if="student.religion == 'Others'" v-bind:class="{ 'has-error': errors['other_religion'] }">
				<div class="col-sm-5"></div>
				{!! Form::label('other_religion','Mention here',['class' => 'col-sm-2 control-label required']) !!}
				<div class="col-sm-3">
					{!! Form::text('other_religion',null,['class' => 'form-control','v-model'=>'student.other_religion']) !!}
				</div>
				<span id="basic-msg" v-if="errors['other_religion']" class="help-block">@{{ errors['other_religion'][0] }}</span>
			</div>  
			</div>
		</div>
      	<div class="form-group">
        {!! Form::label('nationality','Nationality',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.nationality'] }">
    <!--      <input type="text" v-model="nationality" class="form-control" null :readonly = "foreign_national=='N'" >-->
          {!! Form::text('nationality',null,['class' => 'form-control','v-model'=>'student.nationality',':readonly'=>'foreign_national=="N"']) !!}
		</div>
		{!! Form::label('gender','Gender',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-4" v-bind:class="{ 'has-error': errors['student.gender'] }">
          <label class="radio-inline">
            {!! Form::radio('gender', 'Male',null, ['class' => 'minimal','v-model'=>'student.gender']) !!}
            Male
          </label>
          <label class="radio-inline">
            {!! Form::radio('gender', 'Female',null, ['class' => 'minimal','v-model'=>'student.gender']) !!}
            Female
          </label>
          <label class="radio-inline">
            {!! Form::radio('gender', 'Transgender',null, ['class' => 'minimal','v-model'=>'student.gender']) !!}
            Transgender
          </label>
          <span id="basic-msg" v-if="errors['student.gender']" class="help-block">@{{ errors['student.gender'][0] }}</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('name','Name',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.name'] }">
          {!! Form::text('name',null,['class' => 'form-control','max-length'=>'50','v-model'=>'student.name']) !!}
        </div>
        {!! Form::label('dob','D.O.B',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.dob'] }">
          {!! Form::text('dob',null,['class' => 'form-control app-datepicker','v-model'=>'student.dob']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('mobile','Mobile',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.mobile'] }">
          {!! Form::text('mobile',null,['class' => 'form-control','max-length'=>'10','v-model'=>'student.mobile']) !!}
        </div>
        {!! Form::label('aadhar_no','AAdhar No.',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.aadhar_no'] }">
          {!! Form::text('aadhar_no',null,['class' => 'form-control','v-model'=>'student.aadhar_no']) !!}
        </div>
      </div>
      <div class="form-group">
      {!! Form::label('aadhar_no','AAdhar No.',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.aadhar_no'] }">
          {!! Form::text('aadhar_no',null,['class' => 'form-control','v-model'=>'student.aadhar_no']) !!}
        </div>

      {!! Form::label('epic_no','EPIC No.(Voter card number)',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['epic_no'] }">
          {!! Form::text('epic_no',null,['class' => 'form-control','v-model'=>'epic_no','pattern'=>'[0-9]',':disabled'=>"epic_card == 'N'"]) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('father_name','Father',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.father_name'] }">
          {!! Form::text('father_name',null,['class' => 'form-control','v-model'=>'student.father_name']) !!}
        </div>
        {!! Form::label('mother_name','Mother',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.mother_name'] }">
          {!! Form::text('mother_name',null,['class' => 'form-control','v-model'=>'student.mother_name']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('guardian_name','Guardian',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('guardian_name',null,['class' => 'form-control','v-model'=>'student.guardian_name']) !!}
		</div>
		{!! Form::label('email','Email',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('email',null,['class' => 'form-control','v-model'=>'student.std_user.email','readOnly']) !!}
        </div>
      </div>

      <div class='form-group'>
        {!! Form::label('blood_grp','Blood Group',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['student.blood_grp'] }">
          {!! Form::select('blood_grp',getBloodGroup(),null,['class' => 'form-control','v-model'=>'student.blood_grp']) !!}
        </div>
        {!! Form::label('migration','Migration',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-1">
          <label class="checkbox">
            <input type="checkbox" name="migration" v-model = 'student.migration' value='Y' class="minimal" v-bind:true-value="'Y'"
                   v-bind:false-value="'N'">
          </label>
        </div>
        {!! Form::label('blind','Blind student',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-1">
          <label class="checkbox">
            <input type="checkbox" name="blind" v-model = 'student.blind' class='minimal' v-bind:true-value="'Y'"
                   v-bind:false-value="'N'" />
          </label>
        </div>
        {!! Form::label('hostel','Hostel Required',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-1">
          <label class="checkbox">
            <input type="checkbox" name="hostel" v-model = 'student.hostel' value='Y' class="minimal" v-bind:true-value="'Y'"
                   v-bind:false-value="'N'">
          </label>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('per_address','Permanent Address',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student.per_address'] }">
          {!! Form::textarea('per_address', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'student.per_address']) !!}
        </div>
        <!--    {!! Form::label('same_address','Same as Permanent Address',['class' => 'col-sm-1 control-label']) !!}-->
        <div class="col-sm-1">
          <label class="checkbox-inline">
            <input type="checkbox" id="same_addr" v-model = 'student.same_address' value="Y" class="minimal" v-bind:true-value="'Y'"
                   v-bind:false-value="'N'" @change ="copy_address" class='minimal'/>
          </label>
          <p class="text-sm">Same Address</p>
        </div>
        {!! Form::label('corr_address','Corresp. Address',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::textarea('corr_address', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'student.corr_address']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('city','City',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('city',null,['class' => 'form-control','v-model'=>'student.city']) !!}
        </div>
        {!! Form::label('corr_city','City',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('corr_city',null,['class' => 'form-control','v-model'=>'student.corr_city']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('state_id','State',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('state_id',getStates(),null,['class' => 'form-control','v-model'=>'student.state_id']) !!}
        </div>
        {!! Form::label('corr_state_id','State',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('corr_state_id',getStates(),null,['class' => 'form-control','v-model'=>'student.corr_state_id']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('pincode','Pincode',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['student.pincode'] }">
          {!! Form::text('pincode',null,['class' => 'form-control','v-model'=>'student.pincode']) !!}
          <span id="basic-msg" v-if="errors['student.pincode']" class="help-block">@{{ errors['student.pincode'][0] }}</span>
        </div>
        {!! Form::label('corr_pincode','Pincode',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('corr_pincode',null,['class' => 'form-control','v-model'=>'student.corr_pincode']) !!}
        </div>
      </div>
    </fieldset>
    <fieldset>
  <legend>Parent Details</legend>
  <div class="row">
    <div class="col-lg-4 col-sm-12">
     <legend><h4> Father's Details</h4></legend>
      <div class='form-group'>
        {!! Form::label('father_phone','Phone No.(with STD Code).',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::text('father_phone',null,['class' => 'form-control','v-model'=>'father_phone']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('father_mobile','Mobile No.',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['father_mobile'] }">
          {!! Form::text('father_mobile',null,['class' => 'form-control','v-model'=>'student.father_mobile']) !!}
          <span id="basic-msg" v-if="errors['father_mobile']" class="help-block">@{{ errors['father_mobile'][0] }}</span>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('father_email','Email',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['father_email'] }">
          {!! Form::text('father_email',null,['class' => 'form-control','v-model'=>'student.father_email']) !!}
          <span id="basic-msg" v-if="errors['father_email']" class="help-block">@{{ errors['father_email'][0] }}</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('f_office_addr','Office Address',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['f_office_addr'] }">
          {!! Form::textarea('f_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'student.f_office_addr']) !!}
          <span id="basic-msg" v-if="errors['f_office_addr']" class="help-block">@{{ errors['f_office_addr'][0] }}</span>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 col-sm-12">
       <legend><h4>Mother's Details</h4></legend>
      <div class='form-group'>
        {!! Form::label('mother_phone','Phone No.(with STD Code).',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::text('mother_phone',null,['class' => 'form-control','v-model'=>'student.mother_phone']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('mother_mobile','Mobile No.',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['mother_mobile'] }">
          {!! Form::text('mother_mobile',null,['class' => 'form-control','v-model'=>'student.mother_mobile']) !!}
          <span id="basic-msg" v-if="errors['mother_mobile']" class="help-block">@{{ errors['mother_mobile'][0] }}</span>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('mother_email','Email',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['mother_email'] }">
          {!! Form::text('mother_email',null,['class' => 'form-control','v-model'=>'student.mother_email']) !!}
          <span id="basic-msg" v-if="errors['mother_email']" class="help-block">@{{ errors['mother_email'][0] }}</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('m_office_addr','Office Address',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::textarea('m_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'m_office_addr']) !!}
        
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-12">
    <legend><h4>Guardian's Details</h4></legend>
        <div class='form-group'>
          {!! Form::label('guardian_phone','Phone No.(with STD Code).',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7">
          {!! Form::text('guardian_phone',null,['class' => 'form-control','v-model'=>'guardian_phone']) !!}
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('guardian_mobile','Mobile No.',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7"  v-bind:class="{ 'has-error': errors['guardian_mobile'] }">
          {!! Form::text('guardian_mobile',null,['class' => 'form-control','v-model'=>'guardian_mobile']) !!}
          <span id="basic-msg" v-if="errors['guardian_mobile']" class="help-block">@{{ errors['guardian_mobile'][0] }}</span>
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('guardian_email','Email',['class' => 'col-sm-4 control-label ']) !!}
          <div class="col-sm-7">
          {!! Form::text('guardian_email',null,['class' => 'form-control','v-model'=>'guardian_email']) !!}
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('g_office_addr','Office Address',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7">
          {!! Form::textarea('g_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'g_office_addr']) !!}
          </div>
        </div>
    </div>
  </div>
 <div>
</div>
</fieldset>
    <fieldset>
    <legend>Academic Details</legend>
      <div class='form-group' >
          {!! Form::label('pu_regno','Punjab Univ. Roll No.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['pu_regno'] }">
          {!! Form::text('pu_regno',null,['class' => 'form-control','v-model'=>'student.pu_regno']) !!}
          <span id="basic-msg" v-if="errors['pu_regno']" class="help-block">@{{ errors['pu_regno'][0] }}</span>
        </div>
        {!! Form::label('pupin_no','Punjab Univ. RegNo/PUPIN NO.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['pupin_no'] }">
          {!! Form::text('pupin_no',null,['class' => 'form-control','v-model'=>'student.pupin_no','placeholder'=>'11 digit identification no.(if any)']) !!}
        <span id="basic-msg" v-if="errors['pupin_no']" class="help-block">@{{ errors['pupin_no'][0] }}</span>
        </div>
      </div>
    </fieldset>
  </div>
  <div class="box-footer">
    {!! Form::submit('UPDATE',['class' => 'btn btn-primary','@click.prevent'=>'updtStudent']) !!}
  </div>
  <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
   {!! Form::close() !!}
   {{ getVueData() }}
</div>
@stop
@section('script')
<script>
var vm = new Vue({
    el: '#app',
    data: {
      student: {!! isset($student) ? json_encode($student) : '{}' !!},
      student_id: {{ $student->id }},
      response: {},
      success: false,
      fails: false,
      msg: '',
      errors: {},
      admitUrl: "{{  url('students') }}",
    },
    
    created: function() {
      console.log("here");
      
    },
    methods: {
      copy_address: function(e){
        if(this.same_address == "Y") {
          this.corr_address = this.per_address;
          this.corr_city = this.city;
          this.corr_state_id = this.state_id;
          this.corr_pincode = this.pincode;
        }else{
          this.corr_address = '';
          this.corr_city = '';
          this.corr_state_id = 0;
          this.corr_pincode = '';
        }
      },
      isForeignNational: function(e){
        var selected = $('#cat_id option:selected').text();
        this.student.foreigner = selected.toUpperCase().search('FOREIGN') > -1;
        if(this.foreigner) {
          this.student.foreign_national = 'Y';
          this.student.nationality = '';
        } else {
          this.student.foreign_national = 'N';
          this.student.nationality = 'INDIAN'
        }
      },
      updtStudent: function() {
        this.errors = {};
        self = this;
        console.log('here');
        this.$http.patch(this.admitUrl +'/'+ self.student.id, this.$data)
          .then(function (response) {
           if (response.data.success) {
              self = this;
              this.success = true;
              this.student_id = response.data.student_id;
              setTimeout(function() {
                self.success = false;
              //  console.log(self.admitUrl+'/' +self.form_id +'/details');
              //   window.location = '/students';
              }, 3000);
            }
          }, function (response) {
            this.fails = true;
            self = this;
            if(response.status == 422) {
              $('body').scrollTop(0);
              this.errors = response.data;
            }              
          });
      },
      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      }
    },
  });
</script>
@stop
