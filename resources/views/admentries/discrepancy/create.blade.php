@extends($dashboard)
@section('toolbar')
@include('toolbars._admentry_toolbar')
@stop
@section('content')
<div id='app' v-cloak>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Discrepancy Form</h3>
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
			<!-- <div class="alert alert-info" v-if="showConsentMessage">
				<strong>Already Submitted!</strong> Consent alredy submitted you can't modify.
			  </div> -->
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
			<legend></legend>
				<div class="row">
					<div class="col-sm-3">
						<label class="col-sm-12 checkbox">
							<input type="checkbox" name="form_not_submit"  v-model='consent_entry.option.form_not_submit.opt_value' v-bind:true-value="'Y'"
								v-bind:false-value="'N'" class="minimal" />
							Final Submission pending
						</label>
					</div>
					<div class="col-sm-3">
						<label class="col-sm-12 checkbox">
							<input type="checkbox" name="document_pending" v-model='consent_entry.option.document_pending.opt_value' class="minimal" v-bind:true-value="'Y'"
								v-bind:false-value="'N'"/>
							Document Pending 
						</label>
					</div>
					<div class="col-sm-3">
						<label class="col-sm-12 checkbox">
							<input type="checkbox" name="consent_awaited" v-model='consent_entry.option.consent_awaited.opt_value' class="minimal" v-bind:true-value="'Y'"
								v-bind:false-value="'N'"/>
							Consent Awaited
						</label>
					</div>
					<div class="col-sm-3">
						<label class="col-sm-12 checkbox">
							<input type="checkbox" name="admission_fee_not_paid" v-model='consent_entry.option.admission_fee_not_paid.opt_value' class="minimal" v-bind:true-value="'Y'"
								v-bind:false-value="'N'"/>
							Admission fee not paid
						</label>
					</div>
					<div class="col-sm-3">
						<label class="col-sm-12 checkbox">
							<input type="checkbox" name="other" v-model='consent_entry.option.other.opt_value' class="minimal" v-bind:true-value="'Y'"
								v-bind:false-value="'N'"/>
							Other
						</label>
					</div>
					<div class="col-sm-3">
						<label class="col-sm-12 checkbox">
							<input type="checkbox" name="discrepancy_resolved" v-model='consent_entry.option.discrepancy_resolved.opt_value' class="minimal" v-bind:true-value="'Y'"
								v-bind:false-value="'N'"/>
							Discrepancy Resolved
						</label>
					</div>
				</div>
				<div class="row" style="margin-top:15px">
				
					{!! Form::label('remarks','Remarks',['class' => 'col-sm-2 control-label required']) !!}
					<div class="col-sm-6" v-bind:class="{ 'has-error': errors['remarks'] }">
						{!! Form::textarea('remarks',null,['class' => 'form-control','v-model'=>'consent_entry.remarks','rows'=>"4"]) !!}
					</div>
					<label class="radio-inline">
						<h4><input type="checkbox" v-bind:true-value="'Y'"
						v-bind:false-value="'N'" name="ask_student" disabled  v-model="ask_student" >
						</h4>
					</label>
			</div>
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
					remarks:'',
					id:0,
					option: {
						form_not_submit:{
							id:0,
							opt_name:'form_not_submit',
							opt_value:'',
						},
						document_pending:{
							id:0,
							opt_name:'document_pending',
							opt_value:'',
						},
						consent_awaited:{
							id:0,
							opt_name:'consent_awaited',
							opt_value:'',
						},
						admission_fee_not_paid:{
							id:0,
							opt_name:'admission_fee_not_paid',
							opt_value:'',
						},
						other:{
							id:0,
							opt_name:'other',
							opt_value:'',
						},
						discrepancy_resolved:{
							id:0,
							opt_name:'discrepancy_resolved',
							opt_value:'',
						},
					}
				},
				
			ask_student:'Y',
			student_det: null,
			success: false,
			fails: false,
			errors: {},
			response: {},
			adm_id: "{{isset($adm_id) ? $adm_id : 0 }}",
			showConsentMessage:false,
			discrepancies: {!! form_discrepancies(true) !!},

		},
		ready:function(){
			var self = this;
			self.consent_entry.admission_id = self.adm_id;
		},
		computed:{
			// preferences_adm:function(){
			// 	var preferences = [];
			// 	if(this.student_det.course.id == 14) {
			// 		this.subject_preferences.forEach(function(ele){
			// 			var val = preferences.filter(arr => arr.preference_no == ele.preference_no);
			// 			if(val.length> 0) {
			// 				val[0].subjects.push(ele);
			// 			} else {
			// 				preferences.push({'preference_no': ele.preference_no,'subjects':[ele]});
			// 			}
			// 		});
			// 	} else {
			// 		var s = this.subject_preferences.filter(arr => arr.sub_group_id == 0);
			// 		preferences.push({ 'preference_no': 1, 'subjects': s });
			// 	}
				
			// 	if(preferences.length == 1){
			// 		this.consent_entry.preference_no = 1;
			// 	}
			// 	return preferences;
			// }
		},
		methods: {
			submitForm:function(){
				var self = this;
				this.errors = {};
				this.$http.post("{{url('discrepancy')}}",this.consent_entry)
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
					console.log(error);
					this.errors = error.body;

				})
			},

			showDetail: function() {
				var self = this;
				this.form_loaded = false;
				this.errors = {};
				var data = {
					admission_id: this.consent_entry.admission_id,
				};
				
				this.$http.get("{{ url('discrepancy/create') }}", {params: data})
				.then(function (response) {
					if(response.data.success) {
                        self.form_loaded = true;
                        self.student_det =  response.data.adm_form;
						self.consent_entry.admission_id = self.student_det.id;
						self.student_det.discrepancy.forEach(function(ele){
							self.consent_entry.admission_id = ele.admission_id;
							self.consent_entry.remarks = ele.remarks;
							if(ele.opt_name == 'form_not_submit'){
								self.consent_entry.option.form_not_submit.id = ele.id;
								self.consent_entry.option.form_not_submit.opt_name = ele.opt_name;
								self.consent_entry.option.form_not_submit.opt_value = ele.opt_value
							}
							if(ele.opt_name == 'consent_awaited'){
								self.consent_entry.option.consent_awaited.id = ele.id;
								self.consent_entry.option.consent_awaited.opt_name = ele.opt_name;
								self.consent_entry.option.consent_awaited.opt_value = ele.opt_value
							}
							if(ele.opt_name == 'document_pending'){
								self.consent_entry.option.document_pending.id = ele.id;
								self.consent_entry.option.document_pending.opt_name = ele.opt_name;
								self.consent_entry.option.document_pending.opt_value = ele.opt_value
							}
							if(ele.opt_name == 'admission_fee_not_paid'){
								self.consent_entry.option.admission_fee_not_paid.id = ele.id;
								self.consent_entry.option.admission_fee_not_paid.opt_name = ele.opt_name;
								self.consent_entry.option.admission_fee_not_paid.opt_value = ele.opt_value
							}
							if(ele.opt_name == 'other'){
								self.consent_entry.option.other.id = ele.id;
								self.consent_entry.option.other.opt_name = ele.opt_name;
								self.consent_entry.option.other.opt_value = ele.opt_value
							}
							if(ele.opt_name == 'discrepancy_resolved'){
								self.consent_entry.option.discrepancy_resolved.id = ele.id;
								self.consent_entry.option.discrepancy_resolved.opt_name = ele.opt_name;
								self.consent_entry.option.discrepancy_resolved.opt_value = ele.opt_value
							}
						});
						
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
				var self =this;
				this.form_loaded = false;
				this.totalFee = 0;
				this.consent_entry = {
					admission_id :'',
					remarks:'',
					id:'',
					option :{
						form_not_submit:{
							id:0,
							opt_name:'form_not_submit',
							opt_value:'',
						},
						document_pending:{
							id:0,
							opt_name:'document_pending',
							opt_value:'',
						},
						consent_awaited:{
							id:0,
							opt_name:'consent_awaited',
							opt_value:'',
						},
						admission_fee_not_paid:{
							id:0,
							opt_name:'admission_fee_not_paid',
							opt_value:'',
						},
						other:{
							id:0,
							opt_name:'other',
							opt_value:'',
						},
						discrepancy_resolved:{
							id:0,
							opt_name:'discrepancy_resolved',
							opt_value:'',
						},
					}
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
