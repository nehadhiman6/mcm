@extends($dashboard)
@section('content')
<div>
	@php $alumni_meet = getAlumniMeet() @endphp
	<ul class="alert alert-info alert-dismissible" role="alert">
		<li>You are requested to spare a few minutes to fill this form. It has become mandatory for every college to keep an updated record of their Alumni. This is also essential for a good ranking of the college. 
			We are sure you would like to see your college always on the top of the charts.</li>
	</ul>
<div id='app' v-cloak>
	<ul class="alert alert-error alert-dismissible" role="alert" v-if="fails">
		<li  v-for='error in errors'>@{{ error}} <li>
	</ul>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">Alumni Details</h3>
		</div>
		<div class="box-body">
			@if(isset($alm_student))
				{!! Form::model($alm_student, ['method' => 'PATCH', 'class' => 'form-horizontal']) !!}
			@else
				{!! Form::open([ 'class' => 'form-horizontal']) !!}
			@endif
			@include('alumni.studentform')
			@include('alumni.academic_form')
			{{-- @include('alumni.meet') --}}
			 
			@include('alumni.experience_form')
			@include('alumni.award_form')
			@include('alumni.other_info_form')
			{{-- @include('alumni.member_form') --}}

			

		</div>
		<div class="box-footer">
			@if(isset($alm_student))
				<input class="btn btn-primary" id="btnsubmit"  type="submit" value="UPDATE & CONTINUE" @click.prevent="admit">
			@else
				<input class="btn btn-primary" id="btnsubmit" type="submit" value="ADD & CONTINUE" @click.prevent="admit">
			@endif
			{!! Form::close() !!}
			<div class="alert alert-success alert-dismissible" role="alert" v-if="success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Success!</strong> @{{ response['success'] }}
			</div>
			{{ getVueData() }} <br><br>
			<div>
			<ul class="alert alert-error alert-dismissible" role="alert" v-if="fails">
				<li  v-for='error in errors'>@{{ error}} <li>
			</ul>
			</div>
		</div>
	</div>
</div>
</div>
@stop
@section('script')
<script>
  var vm = new Vue({
	el: '#app',
	data: {
		form_id: {{ $alm_student->id or 0 }},
		admitUrl:'alumni-student',
		base_url:"{{url('/')}}",
		fails:false,
		graduatecourse: {!! (isset($alm_student->graduatecourse) && $alm_student->graduatecourse->count() > 0) ? json_encode($alm_student->graduatecourse) : "[{'course_id':'0','mcm_college':'Y','degree_type':'UG','other_institute':'','subject':'','other_course':''}]" !!},
		postgraduatecourses:{!! (isset($alm_student->postgradcourses) && $alm_student->postgradcourses->count() > 0) ? json_encode($alm_student->postgradcourses) : "[{'course_id':'0','mcm_college':'Y','degree_type':'PG','other_institute':'','subject':'','other_course':''}]" !!},
		professionaldegrees:{!! (isset($alm_student->professionalcourses) && $alm_student->professionalcourses->count() > 0)? json_encode($alm_student->professionalcourses) : "[{'course_id':'0','mcm_college':'Y','degree_type':'professional','other_institute':'','subject':'','other_course':''}]" !!},
		researchdegrees:{!! (isset($alm_student->researches) && $alm_student->researches->count() > 0)? json_encode($alm_student->researches) :"[{'course_id':'0','mcm_college':'Y','degree_type':'research','other_institute':'','research_area':'','other_course':''}]" !!},
		experience:{!!(isset($alm_student->almexperience) && $alm_student->almexperience->count() > 0)? json_encode($alm_student->almexperience) :"[{'emp_type':'0','org_name':'','designation':'','org_address':'','num_of_employees':'','start_date':'','end_date':'','currently_working':'N','area_of_work':''}]" !!},
		awards:{!!(isset($alm_student->almaward) && $alm_student->almaward->count() > 0)? json_encode($alm_student->almaward) :"[{'award_name':'','award_field':'','award_year':''}]" !!},
		name:'',  //done
		father_name: "",  //done
		mother_name:'',
		ugc_qualified:"{!! isset($alm_student->ugc_qualified) && $alm_student->ugc_qualified == 'Y' ? 'Y': 'N' !!}",
		ugc_subject_name:'',
		dob:'',
		email:'',
		mobile:'',
		pu_pupin: '',
		pu_regno: '',
		competitive_exam_qualified:"{!! isset($alm_student->competitive_exam_qualified) && $alm_student->competitive_exam_qualified == 'Y' ? 'Y': 'N' !!}",
		competitive_exam_id:{!! (isset($alm_student->competitive_exam_id)) ? $alm_student->competitive_exam_id: 0 !!},
		per_address: '', //done
		gender: '',  //done
		passout_year:'',//done
		errors:{},
		graduateCourses:{!! graduateCourses()!!},
		postGraduateCourses:{!! postGraduateCourses() !!},
		employmentTypes:{!! employmentTypes() !!},
		professionalCourses:{!! professionalCourses() !!},
		researchCourses:{!!researchCourses() !!},
		competitive:{!! competitionexams() !!},
		upsc_psu_exam_name:'',
		other_competitive_exam:'',
		attending_meet:"N",
		meet:"{{ $alumni_meet->id or 0}}",
		alm_student:{!! isset($alm_student) ? $alm_student :  "{}"!!},
		showPgSection: false,
		showRecSection: false,
		showProSection: false,
		showAwardSection: false,
		showMemberSection: false,
		showReasonSection: false,
		showDonationOther:false,

		is_graduacted: "{!! isset($alm_student->is_graduacted) && $alm_student->is_graduacted == 'Y' ? 'Y': 'N' !!}",
		is_profession: "{!! isset($alm_student->is_profession) && $alm_student->is_profession == 'Y' ? 'Y': 'N' !!}",
		is_research: "{!! isset($alm_student->is_research) && $alm_student->is_research == 'Y' ? 'Y': 'N' !!}",

		member_yes_no: "{!! isset($alm_student->member_yes_no) && $alm_student->member_yes_no == 'Y' ? 'Y': 'N' !!}",
		reason_yes_no: "{!! isset($alm_student->reason_yes_no) && $alm_student->reason_yes_no == 'Y' ? 'Y': 'N' !!}",
		award_yes_no: "{!! isset($alm_student->award_yes_no) && $alm_student->award_yes_no == 'Y' ? 'Y': 'N' !!}",
		ugc_year: '',
		competitive_exam_year: '',
		donation_other: '',
		donation_reason: '',
		payment_amount: '',
		remarks:''


	},

	ready: function(){
		console.log('here');
		// this.showHidePgRecPro('');
		// this.showHidePgRecPro('');
		// this.showHidePgRecPro('');
		this.showHidePgRecPro('award');
		this.showHidePgRecPro('research');
		this.showHidePgRecPro('pg');
		this.showHidePgRecPro('professional');
		this.showPayment('member');
		this.showPayment('reason');
		this.showOtherField();
	},

	created:function(){
		var self = this;
		if(this.meet > 0 && this.alm_student != ''){
			if(this.alm_student.alumnimeet){
				this.alm_student.alumnimeet.forEach(function(ele){
					if(ele.meet_id == parseInt(self.meet)){
						self.attending_meet  = ele.attending_meet;
					}
				});
			}
		}
	},
	
	methods: {

		getAdmitUrl: function() {
			if(this.form_id > 0)
			  return this.base_url +'/'+this.admitUrl+'/'+this.form_id;
			else
			  return this.admitUrl;
		},

	  	getMethod: function() {
			if(this.form_id > 0)
			return 'patch';
			else
			return 'post';
	  	},

		admit: function() {
			var self = this;
			this.errors = {};
			var form =   Object.assign({},this.$data);
			delete form['graduateCourses'];
			delete form['postGraduateCourses'];
			delete form['employmentTypes'];
			delete form['researchCourses'];
			delete form['professionalCourses'];
			console.log(form);
			this.$http[this.getMethod()](this.getAdmitUrl(), form)
			.then(function (response) {
				this.form_id = response.data.form_id;
				if (response.data.success) {
				this.success = true;
				setTimeout(function() {
					self.success = false;
					window.location = self.base_url +'/'+ self.admitUrl+'/' +self.form_id +'/show-donation';
				}, 1000);
			  }
			}, function (response) {
				self.fails = true;
				if(response.status == 422) {
				$('body').scrollTop(0);
				console.log(response.data);
				self.errors = response.data;
			  }              
		  	});
	  	},

	  	addRow: function(type){
			if(type == "pg"){
				this.postgraduatecourses.push({'course_id':'0','mcm_college':'Y','degree_type':'PG','other_institute':'','subject':''});
			}	
			else if(type =="professional"){
				this.professionaldegrees.push({'course_id':'0','mcm_college':'Y','degree_type':'professional','other_institute':'','subject':''});
			}
			else if(type =="research"){
				this.researchdegrees.push({'course_id':'0','mcm_college':'Y','degree_type':'research','other_institute':'','subject':'','research_area':''});
			}
			else if(type =="exp"){
				this.experience.push({'emp_type':'0','org_name':'','org_address':'','num_of_employees':'','start_date':'','end_date':'','currently_working':'N','area_of_work':''});
			}
			else if(type =="award"){
				this.awards.push({'award_name':'','award_field':'','award_year':''});
			}
	 	},

		removeRow: function(index,type){
			if(type == "pg"){
				if(this.postgraduatecourses.length > 1 && index > 0)
					this.postgraduatecourses.splice(index, 1);
			}
			else if(type =="professional"){
				if(this.professionaldegrees.length > 1 && index > 0)
					this.professionaldegrees.splice(index, 1);
			}
			else if(type =="research"){
				if(this.researchdegrees.length > 1 && index > 0)
					this.researchdegrees.splice(index, 1);
			}
			else if(type =="exp"){
				if(this.experience.length > 1 && index > 0)
					this.experience.splice(index, 1);
			}
			else if(type =="award"){
				if(this.awards.length > 1 && index > 0)
					this.awards.splice(index, 1);
			}
		},

		changedCompetitiveExam:function(){
			if(this.competitive_exam_qualified == 'N'){
				this.competitive_exam_id =0;
				this.other_competitive_exam = "";
				this.upsc_psu_exam_name = "";
			}
		},

		changedUGCExam:function(){
			var self = this;
			if(self.ugc_qualified == 'N'){
				self.ugc_subject_name = '';
				self.ugc_year = '';
			}
		},

		currentlyWorkingChanged:function(index){
			console.log(index);
			console.log(this.experience[index].currently_working );
			console.log(this.experience[index].end_date);
			console.log(this.experience[index]);

			if(this.experience[index].currently_working == "Y"){
				this.experience[index].end_date = "";
			}
		},

		showHidePgRecPro: function(type){
			if(type=='pg'){
				if(this.is_graduacted == 'Y'){
					this.showPgSection = true;
				}else{
					this.showPgSection = false;
				}
			}
			
			if(type=='research'){
				if(this.is_research == 'Y'){
					this.showRecSection = true;
				}else{
					this.showRecSection = false;
				}
			}

			if(type=='professional'){
				if(this.is_profession == 'Y'){
					this.showProSection = true;
				}else{
					this.showProSection = false;
				}
			}

			if(type=='award'){
				if(this.award_yes_no == 'Y'){
					this.showAwardSection = true;
				}else{
					this.showAwardSection = false;
				}
			}
			
		},

		showPayment: function(type){
			if(type=='member'){
				if(this.member_yes_no == 'Y'){
					this.showMemberSection = true;
				}else{
					this.showMemberSection = false;
				}
			}
			if(type=='reason'){
				if(this.reason_yes_no == 'Y'){
					this.showReasonSection = true;
				}else{
					this.showReasonSection = false;
				}
			}
		},

		showOtherField: function(){
			if(this.donation_reason == 'Others'){
				this.showDonationOther = true;
			}else{
				this.showDonationOther = false;
			}
		}
	}
  });
</script>
@stop