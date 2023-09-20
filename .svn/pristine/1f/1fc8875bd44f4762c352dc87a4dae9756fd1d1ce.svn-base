@extends('app')

@section('toolbar')
@if(is_teacher())
@else
  @include('toolbars._staff_toolbar')
@endif
@stop

@section('content') 
<div id="app" v-cloak>
	<ul class="nav nav-tabs" role="tablist">
		<li class="active">
			<a href="#home" role="tab" data-toggle="tab">
			<i class="fa fa-list-ul"></i> Basic Details
			</a>
		</li>
		<li><a href="#profile" role="tab" data-toggle="tab" v-show="form_id > 0">
			<i class="fa fa-graduation-cap "></i> Qualification
			</a>
		</li>
		<li>
			<a href="#experience" role="tab" data-toggle="tab" v-show="form_id > 0">
			<i class="fa fa-plus"></i> Experience
			</a>
		</li>
		<li>
			<a href="#research" role="tab" data-toggle="tab" v-show="form_id > 0">
			<i class="fa fa-plus"></i> Research
			</a>
		</li>

		<li>
			<a href="#Courses" role="tab" data-toggle="tab" v-show="form_id > 0">
			<i class="fa fa-plus"></i> Course Attended
			</a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade active in" id="home">
			<div class="box box-info" id="staffAdd" v-cloak>
				<div class="box-header with-border">
				<h3 class="box-title">{{ isset($staff) ? 'Edit Staff Member' : 'New Staff Member' }}</h3>
				</div>
				@if(isset($staff))
				{!! Form::model($staff, ['method' => 'PATCH','url' => 'staff', 'class' => 'form-horizontal']) !!}
				@else
				{!! Form::open(['url' => 'staff', 'class' => 'form-horizontal']) !!}
				@endif
				<div class="box-body">
				@include('staff.staff.form')
				</div>
				<div class="box-footer">
				{!! Form::submit((isset($staff) ? 'UPDATE' : 'ADD'),['class' => 'btn btn-primary','@click.prevent'=>'submitForm']) !!}
				</div>
				{!! Form::close() !!}
			</div>
		</div>
		<div class="tab-pane fade" id="profile" >
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title">Qualification</h3>
				</div>
				<div class="box-body">
				<div v-for='qualification in qualifications'>
					<fieldset>
						<div class='form-group row'>

							{!! Form::label('exam','Exam Type',['class' => 'col-sm-2 control-label required']) !!}
							<div class="col-sm-2">
								{!! Form::select('qualification.course_type',['0'=>'Select Type','ug' => 'UG', 'pg' => 'PG', 'others' => 'OTHERS'],null, ['class' => 'form-control', 'v-model' => 'qualification.course_type']) !!}
							</div>

							{!! Form::label('exam','Examination',['class' => 'col-sm-2 control-label required']) !!}
							<div class="col-sm-2" v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.exam'] }" >
								<select v-model="qualification.exam" class="form-control" id="getqual">
									<option v-for="c in ugpg_classes(qualification.course_type)" :value="c.class">@{{ c.display }}</option>
								</select>
							</div>	

							<div class="col-sm-3" v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.other_exam'] }" >
								<input type="text" :disabled="qualification.exam != 'others'" v-model='qualification.other_exam'  class="form-control display" placeholder="Other Equivalent Exam Name">
							</div>							
						</div>
						<div class='form-group row' v-if="qualification.course_type == 'pg'">
							{!! Form::label('exam','PG Subject',['class' => 'col-sm-2 control-label']) !!}
							<div class="col-sm-3" v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.pg_subject'] }" >
								<input type="text" v-model='qualification.pg_subject' class="form-control display" placeholder="Subject Name">
							</div>
						</div>

						<div class='form-group row'>
							{!! Form::label('institute_id','Board/University',['class' => 'col-sm-2 control-label required']) !!}
							<div class="col-sm-3" v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.institute_id'] }">
							<select v-model="qualification.institute_id" class="form-control">
								<option v-for="board in boards" :value="board.id">@{{ board.name }}</option>
								<option value="0">Others</option>
							</select>
							</div>
							<div class="col-sm-3">
							<input type="text"  v-model='qualification.other_institute' :disabled="qualification.institute_id != 0"  class="form-control" placeholder="Enter Board/University (If Others)"/>
							</div>
						</div>
						<div class='form-group row'>
							{!! Form::label('years','Year',['class' => 'col-sm-2 control-label required']) !!}
							<div class="col-sm-1"  v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.year'] }">
								<input type="text"  v-model='qualification.year'  class="form-control"/>
							</div>
							{!! Form::label('pr_cgpa','Percentage / CGPA',['class' => 'col-sm-2 control-label required']) !!}
							<div class="col-sm-2">
								{!! Form::select('pr_cgpa',['P' => 'Percentage', 'C' => 'CGPA', 'N' => 'N/A'],null, ['class' => 'form-control', 'v-model' => 'qualification.pr_cgpa','v-bind:class'=>"{ 'required': qualification.result == 'PASS' }"]) !!}
							</div>
							<div v-if="qualification.pr_cgpa != 'N'" class="col-sm-3" v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.percentage'] }">
								<input type="text" min="0" v-model='qualification.percentage'  class="form-control" placeholder="Enter Percentage/CGPA"/>
							</div>
							{{-- {!! Form::label('percentage','%age',['class' => 'col-sm-1 control-label required','v-bind:class'=>"{ 'required': qualification.result == 'PASS' }"]) !!}
							<div class="col-sm-2" v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.percentage'] }">
								<input type="number" min="0" max="100" v-model='qualification.percentage'  class="form-control"/>
							</div> --}}
							{!! Form::label('division','Division',['class' => 'col-sm-1 control-label']) !!}
							<div class="col-sm-1"  v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.division'] }">
								<input type="text" v-model='qualification.division' class="form-control"/>
							</div>
						</div>
						<div class='form-group row'>
							{!! Form::label('distinction','Distinction',['class' => 'col-sm-2 control-label']) !!}
							<div class="col-sm-8"  v-bind:class="{ 'has-error': errors['qualifications.'+$index+'.distinction'] }">
							<input type="text"  v-model='qualification.distinction'  class="form-control"/>
							</div>
						</div>
						{!! Form::button('Remove',['class' => 'btn btn-success', '@click.prevent' => 'removeRow($index)','v-if'=>'$index > 0']) !!}
				</div>
				<div class="form-group row">
				<div class="col-sm-12">
				{!! Form::button('Add Another Exam',['class' => 'btn btn-success pull-right', '@click' => 'addRow']) !!}
				</div>
				</div>
				</fieldset>
				</div>
				<div class="box-footer">
				{!! Form::submit((isset($staff) ? 'UPDATE' : 'ADD'),['class' => 'btn btn-primary','@click.prevent'=>'submitQualification']) !!}
				</div>
				
			</div>
		</div>
		<div class="tab-pane fade" id="experience" >
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title">Experience</h3>
				</div>
				<div class="box-body">
					<span class="basic-detail-note">Note:<br>
						1. Permanent Teachers are requested to fill the experience they got, before joining MCMDAV as permanent. 
						<br>
						2. Contractual/Ad hoc Teachers are requested to fill the experience  in totality, till the end of last academic session i.e. before their latest joining date in currently running session.
					</span>
					<div v-for='experience in experiences'>
						<fieldset>
							<h4>@{{ getExperienceTitle(experience)}}</h4>
							<div class='form-group row'>
								{!! Form::label('years','Years',['class' => 'col-sm-2 control-label']) !!}
								<div class="col-sm-2" v-bind:class="{ 'has-error': errors['experiences.'+$index+'.years'] }">
								<input type="number" min = "0" max="50" v-model='experience.years'  class="form-control" />
								</div>
								{!! Form::label('months','Months',['class' => 'col-sm-2 control-label']) !!}
								<div class="col-sm-2" v-bind:class="{ 'has-error': errors['experiences.'+$index+'.months'] }">
								<input type="number" min = "0" max="11" v-model='experience.months'  class="form-control" />
								</div>
								{!! Form::label('days','Days',['class' => 'col-sm-2 control-label']) !!}
								<div class="col-sm-2" v-bind:class="{ 'has-error': errors['experiences.'+$index+'.days'] }" >
								<input  type="number" min = "0" max="30"  v-model="experience.days" class="form-control">
								</div>
							</div>
						</fieldset>
					</div>
					
					<div class="box-footer">
						{!! Form::submit((isset($staff) ? 'UPDATE' : 'ADD'),['class' => 'btn btn-primary','@click.prevent'=>'submitExperiences']) !!}
					</div>
				</div>
			</div>
		</div>
		
		<div class="tab-pane fade" id="research">
			<div class="box box-info" v-show="formClose">
				<div class="box-header with-border">
					<h3 class="box-title">Research</h3>
				</div>
				
				<div class="box-body">
					@include('staff.staff.research_form')
				</div>
				<div class="box-footer">
					{!! Form::submit((isset($staff) ? 'UPDATE' : 'ADD'),['class' => 'btn btn-primary','@click.prevent'=>'submitResearch']) !!}
					<button type="button" class="btn btn-primary" @click.prevent="researchOpenForm('close')">Close</button>
					
				</div>
				{!! Form::close() !!}
			</div>

			<span v-if="resFormList">
				<div class="row">
					<button class="btn  btn-flat margin" @click.prevent='researchOpenForm()'>
						<span>Add Research</span>
					</button>
				</div>
				@include('staff.staff.research_index');
			</span>
			<div class="alert alert-success alert-dismissible" role="alert" v-if="success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Success!</strong>Data has been recorded successfully.
			</div>
			
		</div>

		<div class="tab-pane fade" id="Courses">
			<div class="box box-info" v-show="formCourseClose">
				<div class="box-header with-border">
					<h3 class="box-title">Course Attended</h3>
				</div>
				
				<div class="box-body">
					@include('staff.staff_courses.form')
				</div>
				<div class="box-footer">
					{!! Form::submit((isset($staff) ? 'UPDATE' : 'ADD'),['class' => 'btn btn-primary','@click.prevent'=>'submitCourse']) !!}
					<button type="button" class="btn btn-primary" @click.prevent="courseOpenForm('close')">Close</button>
					
				</div>
				{!! Form::close() !!}
			</div>

			<span v-if="courseFormList">
				<div class="row">
					<button class="btn  btn-flat margin" @click.prevent='courseOpenForm()'>
						<span>Add Course Attended</span>
					</button>
				</div>
				@include('staff.staff_courses.index');
			</span>
			<div class="alert alert-success alert-dismissible" role="alert" v-if="success">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong>Success!</strong>Data has been recorded successfully.
			</div>
			
		</div>

	</div>
	
</div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el:"#app",
    data:{
		form_id: {{ $staff->id or 0 }},
		admitUrl: "{{ url('staff')}}",
		qualUrl:"{{ url('staff-qual')}}",
		expUrl:"{{ url('staff-experience')}}",
		researchUrl:"{{ url('staff-research')}}",
		courseUrl:"{{ url('staff-courses')}}",
		name:'',
		middle_name : '',
		last_name : '',
		father_name: '',
		dob: '',
		subject_id:0,
		gender:'Select',
		email:'',
		desig_id:'Select',
		dept_id:'Select',
		address:'',
		mobile:'',
		mobile2:'',
		source:'Select',
		type:'Select',
		user_id:{{ isset($staff) ? $staff->user_id : 0}},
		cat_id: '',
		aadhar_no: '',
		library_code:'',
		blood_group:'',
		pan_no: '',
		emergency_contact: '',
		emergency_relation: '',
		emergency_contact2: '',
		emergency_relation2: '',
		remarks:'',
		errors:[],
		salutation : '',
		faculty_id : '',
		sub_faculty_id:'',
		address_res : '',
		area_of_specialization : 'Other',
		other_specialization : '',
		mcm_joining_date : '',
		confirmation_date:'',
		retire_date:'',
		pay_scale:'',
		teaching_exp: '',
		disclaimer:"{{ isset($staff) ? $staff->disclaimer : 'N'}}",
		all_departmnts: {!! \App\Department::where('faculty_id', '>', 0)->get(['id','name','faculty_id']) !!},
		departments: [],
		fieldsDisabled:{{ json_encode(is_teacher())}},
		user:{!! isset($staff->user) ? $staff->user:'{}' !!},
		qualifications: {!! "[{id:0, course_type: 'ug', staff_id:'', exam: '0',other_exam:'', institute_id: '','other_institute':'', year: '','percentage':'',division:'',distinction:'',pg_subject:'',pr_cgpa:''}]" !!},
		exams: {!! getAcademicExam(true) !!},
		ugpg: {!! json_encode(getUGPGExams()) !!},
		boards: {!! getBoardlist(true) !!},
		experiences: {!! isset($staff) && $staff->experiences->count() > 0 ? json_encode($staff->experiences) : "[ {'id':0,'staff_id':'','area_of_experience':'educational', 'days':'0', 'months':'0', 'years':'0' }, {'id':0, 'area_of_experience':'industrial', 'days':'0', 'months':'0', 'years':'0' }, {'id':0, 'area_of_experience':'other', 'days':'0', 'months':'0', 'years':'0' }, ]" !!},
		success:false,
		course_type: '',
		disable:true,
		permissions: {!! json_encode(getPermissions()) !!},
		research: {!! "{id:0, staff_id:'', type: '',title1:'', title2: '','title3':'', paper_status: '','level':'',publisher:'',pub_date:'',pub_mode:'',isbn:'',authorship:'',institute:'',ugc_approved:'',indexing:'',indexing_other:'',doi_no:'',impact_factor:'',citations:'',h_index:'',i10_index:'',relevant_link:'','peer_review':'','res_award':''}" !!},
		researches: {!! isset($staff->researches) ? $staff->researches:'{}'  !!},
		formClose:false,
		resFormList:true,
		course_form: {!! "{id:0, staff_id:'', courses: '',topic:'', begin_date: '','end_date':'', university_id: '','other_university':'',other_course:'',level:'',duration_days:'',org_by:'',sponsored_by:'',other_sponsor:'',collaboration_with:'',aegis_of:'',participate_as:'',affi_inst:'',mode:'',certificate:'',remarks:'',}" !!},
		boards: {!! getBoardlist(true) !!},
		courses: {!! isset($staff->courses) ? $staff->courses:'{}'  !!},
		courseFormList:true,
		formCourseClose:false,
		
		
    },
    ready: function() {
		var self = this;
		this.dept_id = {{ isset($staff) ? $staff->dept_id : 0 }};

		if(this.form_id > 0) {
			@if(isset($staff) && $staff->qualifications->count() > 0)
				var qualifications = {!!  json_encode($staff->qualifications) !!};
				self.$nextTick(function() {
					$.each(qualifications, function(index, qual) {
						qual.course_type = '';
						$.each(self.ugpg, function(index1, val) {
							// console.log(val.class, qual.exam);
							if(val.class == qual.exam) {
								qual.course_type = val.grad;
							}
						});
					})
					this.qualifications = qualifications;
				});
			@endif
		}

		if(this.faculty_id > 0) {
			this.getDepartments();
		}

		if(this.form_id == 0){
			this.mcm_joining_date = moment(new Date()).format("DD-MM-YYYY");
		}

		if(this.form_id > 0) {
			var res_staff = {!! isset($staff) && $staff ? json_encode($staff) :'0' !!};
			self.research.staff_id = res_staff.id;
		}
		if(this.form_id > 0) {
			var course_staff = {!! isset($staff) && $staff ? json_encode($staff) :'0' !!};
			self.course_form.staff_id = course_staff.id;
		}
		// 
		self.checkPermision();

			
		var select1 = $("#indexing")
            .select2({
                placeholder: "Multi Select",
                width:"100%",
            })
            .on("change", function(e) {
				// console.log(e);
				var stt = $("#indexing").val();
				
				self.research.indexing = stt.join();
				
			});
		if(this.form_id == 0){
			self.getRetirementDate();
		}
    },
    computed:{
		current_exp:function(){
			if(this.mcm_joining_date){
			var date = this.mcm_joining_date.split("-").reverse().join("-")
			return this.calcDate(new Date(),new Date(date));
			}
			return 0;
		},

		

		title1:function(){
			var self = this;
			var title = '';
			// console.log(self.research.type);
			if(self.research.type == "Journal"){
				title = 'Journal name';
			}
			else if(self.research.type == "Book" || self.research.type == "Book Chapter"){
				title = 'Book name';
				if(self.research.type == "Book"){
					self.research.title2 = '';
				}
				
			}
			else if(self.research.type == "Conference"){
				title = 'Conference name';
			}
			else{
				title = 'Title1';
			}
			return title;
		},

		title2:function(){
			var self = this;
			var title = '';
			// console.log(self.research.type);
			if(self.research.type == "Book Chapter"){
				title = 'Title of Book Chapter';
			}
			else if(self.research.type == "Conference" || self.research.type == "Journal"){
				title = 'Title of Paper';
			}
			else{
				title = 'Title2';
			}
			return title;
		},
		title3:function(){
			var self = this;
			var title = '';
			// console.log(self.research.type);
			if(self.research.type == "Conference"){
				if(self.research.paper_status == "Presented"){
					title = 'Year of Presentation';
				}
				else if(self.research.paper_status == "Published"){
					title = 'Year of Publication';
				}
				else if(self.research.paper_status == "Presented & Published"){
					title = 'Year of publication/presentation';				
				}
				else{
					title = 'Year of Publication';
				}
				
			}
			else{
				title = 'Year of Publication';
			}
			return title;
		}

		
    },
    methods:{
		getRetirementDate:function(){
			
				var formet = moment(this.mcm_joining_date,'DD-MM-YYYY')
				var retire_date = moment(formet,'DD-MM-YYYY').add('60', 'years').format('DD-MM-YYYY');
				this.retire_date = retire_date;
			
		},
		getIndexing:function(){
			var self = this;
			if(self.research.indexing.includes('Others')){
				return true;
			}
			else{
				return false;
			}
		},
		 checkPermision: function(){
                if(this.permissions['staff-joining-date'] == 'staff-joining-date'){
					this.disable = false;
                    
				}
				else if(this.form_id > 0 && this.permissions['staff-joining-date'] != 'staff-joining-date'){
					this.disable = true;
                }
            },
		ugpg_classes: function(course_type) {
			console.log('sadasdasd');
			var self = this;
			if(! course_type) {
				return [];
			}

			var classes = [];
			$.each(this.ugpg, function(index, val) {
				// console.log(index, val);
				if(val.grad == course_type) {
					classes.push(val);
				}				
			});
			return classes;
		},
		calcDate:function(date1,date2) {
			var a = moment(date1);
			var b = moment(date2);
			var years = a.diff(b, 'year');
			b.add(years, 'years');
			var months = a.diff(b, 'months');
			b.add(months, 'months');
			var days = a.diff(b, 'days');
			return years + ' years ' + months + ' months ' + days + ' days';
		},
		getDepartments: function(){
			var self = this;
			self.all_departmnts.forEach(function(e){
			if(self.faculty_id == e.faculty_id){
				self.departments.push(e);
			}
			});
		},
		getMethod: function() {
			if(this.form_id > 0)
			return 'patch';
			else
			return 'post';
		},
		getAdmitUrl: function() {
			if(this.form_id > 0)
			return this.admitUrl+'/'+this.form_id;
			else
			return this.admitUrl;
		},
		submitForm:function(){
			this.errors = {};
			var self = this;
			this.$http[this.getMethod()](this.getAdmitUrl(), this.$data)
			.then(function (response) {
				// this.form_id = response.data.form_id;
				if (response.data.success) {
					var staff= response.data.staff;
					self.success = true;
					if(self.fieldsDisabled){
						$.blockUI({'message':'<h4>Successfully updated</h4>'});
						setTimeout(function() {
							$.unblockUI()
						},1000);
					}
					else{
						setTimeout(function() {
							self.success = false;
							if(response.data.first == true){
								window.location = self.admitUrl +'/'+staff.id+'/edit';
							}
							else{
								window.location = self.admitUrl;
							}
							}, 1000);
						}
				}
			}, function (response) {
				this.fails = true;
				self = this;
				if(response.status == 422) {
				this.errors = response.data;
				}              
			});
		},
		getSource:function(){
			if(this.user && this.user.image){
			return MCM.base_url+'/user-image/'+this.user.image.id+'?'+ new Date().getTime();
			}else{
			return MCM.base_url+'/dist/img/user.jpg';
			}
		},
		addRow: function(){
			try {
				// console.log(this.qualifications);
				this.qualifications.splice(this.qualifications.length + 1, 0, {
					id:0,
					exam:'',
					other_exam:'',
					institute_id:'',
					other_institute:'',
					year:'',
					percentage:'',
					division:'',
					distinction:"",
					staff_id:"",
					pg_subject:'',
					pr_cgpa:'P',
					course_type:'',
				});
			} catch (e) {
				// console.log(e);
			}
		},
		removeRow: function(index){
			if(this.qualifications.length > 1 && index > 0)
			this.qualifications.splice(index, 1);
		},

		submitQualification:function(){
			var self= this;
			this.errors = {};
			this.$data.qualifications.forEach(function(ele){
				ele.staff_id = self.form_id;
			});
			this.$http['post'](this.qualUrl,{'staff_id': this.form_id, 'qualifications':this.$data.qualifications})
			.then(function (response) {
				self = this;
				if (response.data.success) {
					self.success = true;
					if(self.fieldsDisabled){
						$.blockUI({'message':'<h4>Successfully updated</h4>'});
						self.success = false
						setTimeout(function() {
							$.unblockUI()
						},1000);
					}
					else{
						setTimeout(function() {
							self.success = false
							// window.location = self.admitUrl;
						}, 2000);
					}
				}
			}, function (response) {
				this.fails = true;
				self = this;
				if(response.status == 422) {
				this.errors = response.data;
				// console.log(this.errors);
				// this.errors.qualifications.division='';
				}              
			});
		},
		
		submitExperiences:function(){
			this.errors = {};
			var self = this;
			this.$http['post'](this.expUrl, {'staff_id': this.form_id, 'experiences':this.$data.experiences})
			.then(function (response) {
				self = this;
				if (response.data.success) {
					self.success = true;
					if(self.fieldsDisabled){
						$.blockUI({'message':'<h4>Successfully updated</h4>'});
							setTimeout(function() {
							$.unblockUI()
						},1000);
					}
					else{
						setTimeout(function() {
							self.success = false
							window.location = self.admitUrl;
						}, 3000);
					}
				}
			}, function (response) {
				this.fails = true;
				self = this;
				if(response.status == 422) {
				this.errors = response.data;
				}              
			});
		},

		submitResearch:function(){
			this.errors = {};
			var self = this;
			self.resFormList = false;
			this.$http[this.getResMethod()](this.getResearchUrl(), {'staff_id': this.form_id, 'research':this.$data.research})
			.then(function (response) {
				self = this;
				if (response.data.success) {
					
					self.success = true;
					if(self.fieldsDisabled){
						$.blockUI({'message':'<h4>Successfully updated</h4>'});
							setTimeout(function() {
							$.unblockUI()
						},500);
					}
					else{
						setTimeout(function() {
							self.success = false
						}, 800);
					}
					this.research.id= 0;
					this.research.type= '';
					this.research.title1= '';
					this.research.title2= '';
					this.research.title3= '';
					this.research.paper_status= '';
					this.research.level= '';
					this.research.publisher= '';
					this.research.pub_date= '';
					this.research.pub_mode= '';
					this.research.isbn= '';
					this.research.authorship= '';
					this.research.institute= '';
					this.research.ugc_approved= '';
					this.research.indexing= '';
					this.research.indexing_other= '';
					this.research.doi_no= '';
					this.research.impact_factor= '';
					this.research.peer_review= '';
					this.research.citations= '';
					this.research.h_index= '';
					this.research.i10_index= '';
					this.research.relevant_link= '';
					this.research.res_award= '';
					$('.select2').val(this.research.indexing).trigger('change');
					this.researches = response.data.researches;
					self.resFormList = true;
					self.formClose = false;
				}
			}, function (response) {
				this.fails = true;
				self = this;
				if(response.status == 422) {
				this.errors = response.data;
				// console.log(this.errors);
				}              
			});
		},

		getExperienceTitle:function(experience){
			if(experience)
			return experience.area_of_experience.charAt(0).toUpperCase() + experience.area_of_experience.slice(1);
			else
			return experience.area_of_experience;
		},

		editRes: function(id) {
			this.formClose = false;
			this.resFormList = true;
			this.errors = {};
			this.$http.get("{{ url('staff-research') }}/"+id+"/edit")
			.then(function (response) {
				var research = response.data.research;
				this.research.id = research.id;
				this.research.staff_id = research.staff_id;
				this.research.type = research.type;
				this.research.title1 = research.title1;
				this.research.title2 = research.title2;
				this.research.title3 = research.title3;
				this.research.paper_status = research.paper_status;
				this.research.level = research.level;
				this.research.publisher = research.publisher;
				this.research.pub_date = research.pub_date;
				this.research.pub_mode = research.pub_mode;
				this.research.isbn = research.isbn;
				this.research.authorship = research.authorship;
				this.research.institute = research.institute;
				this.research.ugc_approved = research.ugc_approved;
				this.research.doi_no = research.doi_no;
				this.research.impact_factor = research.impact_factor;
				this.research.citations = research.citations;
				this.research.h_index = research.h_index;
				this.research.i10_index = research.i10_index;
				this.research.relevant_link = research.relevant_link;
				this.research.res_award = research.res_award;


				
				// for (let field in research) {
				// 	if(this.research.hasOwnProperty(field) && typeof(this.research[field]) != 'function') {
				// 		if(research[field])
				// 			this.research[field] = research[field];
				// 	}

				// }
				if(research.indexing != null){
					var tt = research.indexing;
					this.research.indexing =tt.split(',');
					$('#indexing').val(this.research.indexing).trigger('change');
					this.research.indexing_other = research.indexing_other;
				}
				else{
					
					this.research.indexing = research.indexing;
					$('#indexing').val(this.research.indexing).trigger('change');
					this.research.indexing_other = research.indexing_other;
				}

				this.formClose = true;
				this.resFormList = false;
				

			}, function (response) {
			this.fails = true;
			self = this;
			if(response.status == 422) {
				$('body').scrollTop(0);
				this.errors = response.data;
			}              
			});
		  },
		  getResearchUrl: function() {
		
			if(this.research.id > 0)
				return this.researchUrl+'/'+this.research.id;
			else
				return this.researchUrl;
		},

		getResMethod: function() {
			if(this.research.id > 0)
			return 'patch';
			else
			return 'post';
		},

		researchOpenForm:function(res = 'open'){
			var self = this;
			if(res == 'close'){
				self.formClose = false;
				self.resFormList = true;
				this.research.id= 0;
				this.research.type= '';
				this.research.title1= '';
				this.research.title2= '';
				this.research.title3= '';
				this.research.paper_status= '';
				this.research.level= '';
				this.research.publisher= '';
				this.research.pub_date= '';
				this.research.pub_mode= '';
				this.research.isbn= '';
				this.research.authorship= '';
				this.research.institute= '';
				this.research.ugc_approved= '';
				this.research.indexing= '';
				this.research.indexing_other= '';
				this.research.doi_no= '';
				this.research.impact_factor= '';
				this.research.peer_review= '';
				this.research.citations= '';
				this.research.h_index= '';
				this.research.i10_index= '';
				this.research.relevant_link= '';
				this.research.res_award= '';
				$('.select2').val(this.research.indexing).trigger('change');
				
			}
			else{
				self.formClose = true;
				self.resFormList = false;
			}
			
			
		},

		submitCourse:function(){
			this.errors = {};
			var self = this;
			self.courseFormList = false;
			this.$http[this.getCourseMethod()](this.getCourseUrl(), {'staff_id': this.form_id, 'course':this.$data.course_form})
			.then(function (response) {
				self = this;
				if (response.data.success) {
					
					self.success = true;
					if(self.fieldsDisabled){
						$.blockUI({'message':'<h4>Successfully updated</h4>'});
							setTimeout(function() {
							$.unblockUI()
						},500);
					}
					else{
						setTimeout(function() {
							self.success = false
						}, 800);
					}
					self.courseOpenForm('close');
					this.courses = response.data.courses;
					self.courseFormList = true;
					self.formCourseClose = false;
				}
			}, function (response) {
				this.fails = true;
				self = this;
				if(response.status == 422) {
				this.errors = response.data;
				// console.log(this.errors);
				}              
			});
		},

		editCourse: function(id) {
			this.formCourseClose = false;
			this.courseFormList = true;
			this.errors = {};
			this.$http.get("{{ url('staff-courses') }}/"+id+"/edit")
			.then(function (response) {
				var course = response.data.course;
				this.course_form.id = course.id;
				this.course_form.staff_id = course.staff_id;
				this.course_form.courses = course.courses;
				this.course_form.topic = course.topic;
				this.course_form.begin_date = course.begin_date;
				this.course_form.end_date = course.end_date;
				this.course_form.university_id = course.university_id;
				this.course_form.other_university = course.other_university;
				this.course_form.other_course = course.other_course;
				this.course_form.level = course.level;
				this.course_form.duration_days = course.duration_days;
				this.course_form.org_by = course.org_by;
				this.course_form.sponsored_by = course.sponsored_by;
				this.course_form.other_sponsor = course.other_sponsor;
				this.course_form.collaboration_with = course.collaboration_with;
				this.course_form.aegis_of = course.aegis_of;
				this.course_form.participate_as = course.participate_as;
				this.course_form.affi_inst = course.affi_inst;
				this.course_form.mode = course.mode;
				this.course_form.certificate = course.certificate;
				this.course_form.remarks = course.remarks;
				this.formCourseClose = true;
				this.courseFormList = false;
				

			}, function (response) {
			this.fails = true;
			self = this;
			if(response.status == 422) {
				$('body').scrollTop(0);
				this.errors = response.data;
			}              
			});
		  },

		getCourseUrl: function() {
			if(this.course_form.id > 0)
				return this.courseUrl+'/'+this.course_form.id;
			else
				return this.courseUrl;
		},

		getCourseMethod: function() {
			if(this.course_form.id > 0)
			return 'patch';
			else
			return 'post';
		},

		courseOpenForm:function(cor = 'open'){
			var self = this;
			if(cor == 'close'){
				self.formCourseClose = false;
				self.courseFormList = true;
				this.course_form.id= 0;
				this.course_form.courses= '';
				this.course_form.topic= '';
				this.course_form.begin_date= '';
				this.course_form.end_date= '';
				this.course_form.university_id= '';
				this.course_form.other_university= '';
				this.course_form.other_course= '';
				this.course_form.level= '';
				this.course_form.duration_days= '';
				this.course_form.org_by= '';
				this.course_form.sponsored_by= '';
				this.course_form.other_sponsor= '';
				this.course_form.collaboration_with= '';
				this.course_form.aegis_of= '';
				this.course_form.participate_as= '';
				this.course_form.affi_inst= '';
				this.course_form.mode= '';
				this.course_form.certificate= '';
				this.course_form.remarks= '';
				
			}
			else{
				self.formCourseClose = true;
				self.courseFormList = false;
			}
			
			
		},

		
    }
  });

</script>
@stop