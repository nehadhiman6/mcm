@extends($dashboard)
@if($dashboard == 'app')
@endif
@section('content')
<div id="app" v-cloak>
    <div>
		<ul class="alert alert-error alert-dismissible" role="alert" v-show="fails">
			<li  v-for='error in errors'>@{{ error}} </li>
		</ul>
		<div v-if="adm_form.consent.ask_student == 'Y' && (adm_form.consent.student_answer == 'N' || adm_form.consent.student_answer == 'Y') ">
			<div class="alert alert-success" role="alert">
				Your consent has been successfully submitted!
			</div>
		</div>

		<div v-if="adm_form.consent.ask_student == 'Y' && adm_form.consent.student_answer == 'R'" class="box">
			<div class="box-header">
				Consent
			</div>
			<div class="box-body">
				<fieldset v-if="adm_form.course_id == 14">
					<legend>Subjects/Options Preferences</legend>
						
						<div class="row">
							<div class="col-md-6">
								<h4>Subjects Preferences</h4>
							<ul class="ul-margin-left"  v-for="preference in preferences_adm">
								<div>
									Preference No. @{{preference.preference_no}}.
									<ul class="ul-margin-left" v-for="subject_preference in preference.subjects">
											<li>@{{subject_preference.subject.subject}}</li>
									</ul>
								</div>
							</ul>
						</div>
						<div class="col-md-6">
							<div v-if="adm_form.honours.length > 0">
								<h4>Honour subject Preferences</h4>
								<ul class="ul-margin-left"  v-for="honour in adm_form.honours">
									<li> @{{ $index+1 }}.  @{{honour.subject.subject}}</li>
								</ul>
							</div>
						</div>
						</div>
				</fieldset>
				<fieldset>
					<legend>Preference allotted</legend>
					<div class="row">
						<div class="col-md-6">
							<strong>Subjects : </strong>
							<ul>Preference No. 
								@{{adm_form.consent.preference_no}}
								<li class="list-left-margin" v-for="sub in adm_form.adm_subs">
									<strong v-if="sub.sub_group_id == 0"> @{{sub.subject.subject}}</strong>
								</li>
							</ul>
						</div>

						<div class="col-md-6">
							<strong v-if="adm_form.consent.honour_assigned">Honour: </strong>
							<ul v-if="adm_form.consent.honour_assigned">
								Preference No. @{{adm_form.consent.honour_assigned.preference}}
								<li class="list-left-margin" >
									<strong> @{{adm_form.consent.honour_assigned.subject.subject}}</strong>
								</li>
							</ul>
						</div>
						
					</div>
					<div class="row col-md-10 col-md-offset-1">
						{{-- <label>Do you agree to continue with above mentioned subjects?</label> --}}
						<label>Do you agree to continue with the subject/course you applied for?</label>

						<div>
							<label class="radio-inline">
								<input type="radio" name="student_answer" :value="'Y'" v-model="student_response" > Yes, i do accept.
							</label>
						</div>
						<div>
							<label class="radio-inline">
								<input type="radio" name="student_answer" :value="'L'" v-model="student_response" > Yes, i do accept but I want to upgrade later.
							</label>
						</div>
						<div>
							<label class="radio-inline">
								<input type="radio" name="student_answer" :value="'N'" v-model="student_response" >No, I don't accept.
							</label>
						</div>
						
					</div>
					<div class="row col-md-10 col-md-offset-1">
						{{-- <label>Do you agree to continue with above mentioned subjects?</label> --}}
						<p style="color:#983032; margin: 10px 0 0 0;">NOTE: Clicking the option 'want to upgrade later' does not guarantee allotment of desired change-of-subjects at a later stage. It is subject to availability of seats. Also, this option is not applicable to students who are already allotted their Preference 1.</p>

					</div>
				</fieldset>
				<div class="box-footer">
					{!! Form::submit('SUBMIT',['class' => 'btn btn-primary','@click.prevent' => 'submitForm']) !!}
				</div>
			</div>
			<div>
				<ul class="alert" role="alert" v-if="hasErrors()">
					<div class="alert alert-danger" >
						<li v-for='error in errors' >@{{ error[0] }}<li>
					</div>
				</ul>
			</div>
		</div>
    </div>
</div>
@stop

@section('script')
  <script>
 
    var vm = new Vue({
      el: '#app',
      data: function(){
			return {
				consent:{
					admission_id:{{$adm->id}},
					preference_no:'',
					honour_sub_id:0,
					ask_student:'N',
					student_answer:'R',
					upgrade_later:'N',
					user_id:'',
				},
				adm_form : {!! $adm !!},
				student_response:'',
				success: false,
				fails: false,
				errors: {},
				response: {},
			}
      },
	  computed:{
		preferences_adm:function(){
				var preferences = [];
				this.adm_form.admission_sub_preference.forEach(function(ele){
					var val = preferences.filter(arr => arr.preference_no == ele.preference_no );
					if(val.length> 0){
						val[0].subjects.push(ele);
					}
					else{
						preferences.push({'preference_no':ele.preference_no,'subjects':[ele]});
					}
				});
				return preferences;
			}
		},
      ready(){
		this.consent = this.adm_form.consent;
	  },
	  methods:{
		submitForm:function(){
			var self= this;
			this.errors = {};
			if(this.student_response == 'Y' || this.student_response == 'N'||this.student_response == 'L'){
				var statusText = this.student_response == 'Y' ?'want to accept ':this.student_response=='N' ? 'do not want to accept':
				this.student_response=='L' ?'want to Upgrate Later':'';
				if (confirm('Are you sure you '+ statusText+' ?')) {
					if(this.student_response == 'Y' ||this.student_response == 'N'){
						this.consent.student_answer = this.student_response ;
					}
					else{
						this.consent.student_answer = 'Y';
						this.consent.upgrade_later = 'Y';
					}

					this.$http.post("{{url('student-consent')}}",this.consent)
					.then(function(response){
							if(response.data.success==true){
								self.success = true;
								setTimeout(function(){
									self.success = false;
									window.location = "{{url('/') }}" +'/admforms/' + self.consent.admission_id + '/details';
								
								},1000);
							}
					})
					.catch(function(error){

					})
				} 
			}
			self.errors = { 'consent.student_answer': ["Please select your choice!"] };
			
		},
			
		hasErrors: function() {
			if(this.errors && _.keys(this.errors).length > 0)
				return true;
			else
				return false;
		},
			
	  }

    });
  </script>
  <style>
	.list-left-margin{
		margin-left:15%;
	}

	.ul-margin-left{
		list-style: none;
		margin: 0px 0px 0px 80px;
		padding: 0;
	}
  </style> 
@endsection

