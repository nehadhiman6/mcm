@extends($dashboard)
@section('toolbar')
@include('toolbars._admentry_toolbar')
@stop
@section('content')
<div id='app' v-cloak>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Consent Entry</h3>
    </div>
    {!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
    <div class="box-body">
      <div class="form-group">
        {!! Form::label('admission_id','Online Form No',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2" >
          <input type="text" v-model="consent_entry.admission_id" :disabled='form_loaded' number placeholder="Enter Online Form No." name="admission_id" class="form-control">
		</div>
		
		{!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent' => 'showDetail',':disabled'=>'form_loaded']) !!}
		{!! Form::submit('RESET',['class' => 'btn btn-primary','@click.prevent' => 'resetForm','v-if'=>'form_loaded']) !!}

		<ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
			<div class="alert alert-danger" >
				<li v-for='error in errors' >@{{ error[0] }}<li>
			</div>
			</ul>
	  </div>
	 
    </div>
   
    {!! Form::close() !!}
  </div>
  
  <div class="box box-primary" v-show="form_loaded && student_det">
    	<div class="box-header with-border">
			
      	<h3 class="box-title">Student Details</h3>
		</div>
		<div class="box-body form-horizontal">
			<div class="alert alert-info" v-if="showConsentMessage">
				<strong>Already Submitted!</strong> Consent alredy submitted you can't modify.
			  </div>
		<fieldset class="student-detail">
			<legend>Student Details</legend>
			<div class="form-group">
				{!! Form::label('name','Name',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-4" v-bind:class="{ 'has-error': errors['student_det.name'] }">
					{!! Form::text('name',null,['class' => 'form-control','max-length'=>'50','disabled','v-model'=>'student_det.name']) !!}
				</div>
				{!! Form::label('father_name','Father',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-4" v-bind:class="{ 'has-error': errors['student_det.father_name'] }">
					{!! Form::text('father_name',null,['class' => 'form-control','disabled','v-model'=>'student_det.father_name']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('mobile','Mobile',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-4" v-bind:class="{ 'has-error': errors['student_det.mobile'] }">
					{!! Form::text('mobile',null,['class' => 'form-control','disabled','max-length'=>'10','v-model'=>'student_det.mobile']) !!}
				</div>
				{!! Form::label('email','Email',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-4" v-bind:class="{ 'has-error': errors['student_det.std_user.email'] }">
				{!! Form::text('email',null,['class' => 'form-control','disabled','v-model'=>'student_det.std_user.email']) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('course_name','Course',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-4" v-bind:class="{ 'has-error': errors['student_det.course.course_name'] }">
					{!! Form::text('course_name',null,['class' => 'form-control','disabled','max-length'=>'10','v-model'=>'student_det.course.course_name']) !!}
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Subjects/Options Preferences</legend>
				<h4>Subject Preferences</h4>
				
				<ul class="ul-margin-left"  v-for="preference in preferences_adm">
					<div>
						<label class="radio-inline">
							<input type="radio" name="sub_preference" :value="preference.preference_no" v-model="consent_entry.preference_no" >
							Preference No. @{{preference.preference_no}}.
							<ul class="ul-margin-left" v-for="subject_preference in preference.subjects">
									<li><strong>@{{subject_preference.subject.subject}}</strong></li>
							</ul>
						</label>
					</div>
				</ul>
				<div v-if="honour_preferences.length > 0">
					<h4>Honour subject Preferences</h4>
					<ul class="ul-margin-left"  v-for="honour in honour_preferences">
						<div>
							<label class="radio-inline">
								<input type="radio" name="sub_honour_preference" :value="honour.id" v-model="consent_entry.honour_sub_id" >
								Preference No. @{{ $index+1 }}. <strong> @{{honour.subject.subject}}</strong>
							</label>
						</div>
					</ul>
				</div>

				<hr>

				<label class="radio-inline">
					<h4><input type="checkbox" v-bind:true-value="'Y'"
					v-bind:false-value="'N'" name="ask_student"  v-model="consent_entry.ask_student" >
					Ask Student?</h4>
				</label>
		</fieldset>
			<ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">

				<div class="alert alert-danger" >
					<li v-for='error in errors' >@{{ error[0] }}<li>
				</div>
			</ul>
			<div>
				{!! Form::submit('SUBMIT',['class' => 'btn btn-primary','@click.prevent' => 'submitForm', "v-if" => "! showConsentMessage" ]) !!}
				{!! Form::close() !!}
			</div>
		</div>
		
		
  	</div>
	<div class="alert alert-success alert-dismissible" role="alert" v-if="success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<strong>Success!</strong> @{{ response['success'] }}
	</div>
	
</div>
@stop
@section('script')
<script>
	var no = 1000;
	var vm = new Vue({
		el: '#app',
		data: {
			form_loaded: false,
			consent_entry: {
				admission_id:'',
				preference_no:'',
				honour_sub_id:0,
				ask_student:'N',
				student_answer:'R',
				upgrade_later:'N',
				user_id:'',
				id:0
			},
			subject_preferences:[],
			honour_preferences:[],
			student_det: null,
			success: false,
			fails: false,
			errors: {},
			response: {},
			showConsentMessage:false
		},
		computed:{
			preferences_adm:function(){
				var preferences = [];
				if(this.student_det.course.id == 14) {
					this.subject_preferences.forEach(function(ele){
						var val = preferences.filter(arr => arr.preference_no == ele.preference_no);
						if(val.length> 0) {
							val[0].subjects.push(ele);
						} else {
							preferences.push({'preference_no': ele.preference_no,'subjects':[ele]});
						}
					});
				} else {
					var s = this.subject_preferences.filter(arr => arr.sub_group_id == 0);
					preferences.push({ 'preference_no': 1, 'subjects': s });
				}
				
				if(preferences.length == 1){
					this.consent_entry.preference_no = 1;
				}
				return preferences;
			}
		},
		methods: {
			submitForm:function(){
				var self = this;
				this.errors = {};
				// if(this.honour_preferences.length > 0 && this.consent_entry.honour_sub_id == 0 ){
				// 	self.errors = { 'consent_entry.honour_sub_id': ["Honour Subject is Required!"] };
          		// 	return;
				// }
				this.$http.post("{{url('consents')}}",this.consent_entry)
				.then(function(response){
						if(response.data.success==true){
							self.success = true;
							self.resetForm();
							setTimeout(function(){
								self.success = false;
							},1000);
						}
				})
				.catch(function(error){

				})
			},

			showDetail: function() {
				var self = this;
				this.form_loaded = false;
				this.errors = {};
				var data = {
					admission_id: this.consent_entry.admission_id,
				};
				
				this.$http.get("{{ url('consents/create') }}", {params: data})
				.then(function (response) {
					if(response.data.success) {
						if(response.data.adm_form && response.data.adm_form.final_submission == 'Y'){
							self.form_loaded = true;
							self.student_det =  response.data.adm_form;
							self.subject_preferences = response.data.adm_form.course.id == 14 ? response.data.adm_form.admission_sub_preference : response.data.adm_form.adm_subs;
							self.honour_preferences = response.data.adm_form.honours;
							// if(self.honour_preferences.length == 1){
							// 	this.consent_entry.honour_sub_id = self.honour_preferences[0].id;
							// }
							if(response.data.consent){
								var consent = response.data.consent;
								self.showConsentMessage=true;
								self.consent_entry.id =consent.id;
								self.consent_entry.preference_no =consent.preference_no;
								self.consent_entry.honour_sub_id =consent.honour_sub_id;
								self.consent_entry.ask_student =consent.ask_student;
								self.consent_entry.student_answer =consent.student_answer;
								self.consent_entry.upgrade_later =consent.upgrade_later;
							}
						}
						else{
							self.errors = { 'consent_entry.admission_id': ["Final Submission is pending!"] };
						}
					}
				}, function(response) {
					this.fails = true;
					this.saving = false;
					if(response.status == 422)
					this.errors = response.data;
				});
			},
			
			hasErrors: function() {
				if(this.errors && _.keys(this.errors).length > 0)
					return true;
				else
					return false;
			},
			
			resetForm: function() {
				this.form_loaded = false;
				this.totalFee = 0;
				this.consent_entry = {
					admission_id:'',
					preference_no:'',
					honour_sub_id:0,
					ask_student:'N',
					student_answer:'R',
					upgrade_later:'N',
					user_id:'',
				};
				this.showConsentMessage=false;

			},

		}
	});
    
 
</script>
<style>
	/* .ul-margin-left{
		list-style: none;
		margin: 115px;
		padding: 0;
	} */

	.ul-margin-left{

		list-style: none;
		margin: 0px 0px 0px 115px;
		padding: 0;
	}
</style>
@stop
