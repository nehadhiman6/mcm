@extends('app')
@section('toolbar')
@include('toolbars.alumni_message_toolbar')
@stop
@section('content')
<!--<div class="row">
  <a href="{{url('/adm-entries/create')}}">
    <button class="btn  btn-flat margin">
      <span>New Admission Entry</span>
    </button>
  </a>
</div>-->
<div class="box box-default box-solid " id='app' v-cloak>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
	  <div class="form-group row">
		{!! Form::label('course_type','Course Type',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-2">                                                                                     
		{!! Form::select('course_type',[''=>'Select','GRAD'=>'UG','PGRAD'=>'PG'],null,['class' => 'form-control','v-model'=>'form.course_type','@change'=>'changeCourseType']) !!}
		</div>
		{!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-3">                                                      
		<select class="form-control" v-model="form.course_id" >                      
			<option value="0">Select</option>
			<option v-for="course in courses" :value="course.id">@{{ course.course_name }}</option>
		</select>
		</div>
	  </div>
	<div class="form-group row">
		{!! Form::label('passout_year',' Passout Year',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-2">
				<select class="form-control"  v-model="form.passout_year">                      
						<option value="0">Select</option>
						<option v-for="pass in pass_years" :value="pass">@{{ pass }}</option>
					</select>
    </div>
  </div>
  <div class="form-group row text-center">
    <b>OR</b>
  </div>
  <div class="form-group row">
      {!! Form::label('type','Type',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('type',getCoursesType(),null,['class' => 'form-control ','v-model' => 'form.type','@change'=>'changeType']) !!}
        <span id="basic-msg" v-if="errors['type']" class="help-block">@{{ errors['type'][0] }}</span>
      </div>
      {!! Form::label('course_id','Course filled by Student',['class' => 'col-sm-2 control-label', 'v-show' => 'form.type != "" ']) !!}
      <div class="col-sm-3" v-if="form.type != '' && form.type == 'UG' ">
          <select class="form-control" v-model="form.student_course_id" @change.prevent = 'changeType'>
              <option value="0">Select</option>
              <option v-for="course in graduateCourses" :value="course.id">@{{ course.name }}</option>
          </select>    
      </div>
      <div class="col-sm-3" v-if="form.type != '' && form.type == 'PG' ">
        <select class="form-control" v-model="form.student_course_id" @change.prevent = 'changeType'>
            <option value="0">Select</option>
            <option v-for="course in postGraduateCourses" :value="course.id">@{{ course.name }}</option>
        </select>    
      </div>
      <div class="col-sm-3" v-if="form.type != '' && form.type == 'Professional' ">
        <select class="form-control" v-model="form.student_course_id" @change.prevent = 'changeType'>
            <option value="0">Select</option>
            <option v-for="course in professionalCourses" :value="course.id">@{{ course.name }}</option>
        </select>    
      </div>
      <div class="col-sm-3" v-if="form.type != '' && form.type == 'Research' ">
        <select class="form-control" v-model="form.student_course_id" @change.prevent = 'changeType'>
            <option value="0">Select</option>
            <option v-for="course in researchCourses" :value="course.id">@{{ course.name }}</option>
        </select>    
      </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
  <div class='row'>
    <div class='col-sm-8'>
      <div class='panel panel-default' >
        <div class="panel-heading">
          <strong>Students List</strong>
        </div>
        <div class = "panel-body">
          <table class="table table-bordered" id="example1" width="100%"></table>
        </div>
      </div>
    </div>
    <div class='col-sm-4'>
      <div class="box box-default box-solid ">
        <div class="box-body">
          {!! Form::label('','Subject',['class' => 'col-sm-3 control-label ']) !!}
          <div class="col-sm-12">
            {!! Form::text('',null,['class' => 'form-control','v-model' => 'subject']) !!}
          </div>
        </div>
        <div class="box-body"> 
          {!! Form::label('','Message',['class' => 'col-sm-3 control-label ']) !!}
          <div class="col-sm-12">
            {!! Form::textarea('',null,['class' => 'form-control','size'=>'31x4','v-model' => 'msg']) !!}
          </div>
        </div>
        <div class="box-footer">
          {!! Form::submit('SEND',['class' => 'btn btn-primary','@click.prevent' => 'confirmation("few")',':disabled'=>"std_ids.length == 0"]) !!}
          {!! Form::submit('SEND to All',['class' => 'btn btn-primary','@click.prevent' => 'confirmation("all")',':disabled'=>"std_ids.length > 0"]) !!}
          {!! Form::submit('SMS',['class' => 'btn btn-primary','@click.prevent' => 'confirmation("all")',':disabled'=>"std_ids.length > 0"]) !!}
          {!! Form::submit('Email',['class' => 'btn btn-primary','@click.prevent' => 'confirmation("all")',':disabled'=>"std_ids.length > 0"]) !!}

          {!! Form::close() !!}
        </div>
        <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success!</strong>Thank you! Your message has been sent successfully.
        </div>
        <ul class="alert alert-error alert-dismissible" role="alert" v-if ="errors.length > 0">
          <strong>Failed!</strong>
          <li v-for='error in errors'>@{{ error }}<li>
        </ul>
      </div>
    </div>
  </div>
</div>
 
<!-- Button trigger modal -->

@stop
@section('script')
<script>
$(document).ready(function() {
  $('body').on('click', '.std_id', function() {
    var idx;
    idx = _.indexOf(vm.std_ids,$(this).val());
    if(idx == -1) {
        vm.std_ids.push($(this).val());
    } else {
        vm.std_ids.splice(idx,1);
    }
  });
});
var msgElement =   $('.return-msg');
var vm = new Vue({
    el: '#app',
    data: {
      form: {
		course_type: '',       
		passout_year:'',
		course_id:'0',
        type:'',
        student_course_id:'0',
	},
      courses: {!! json_encode(getFinalYearCourses()) !!},
			pass_years:{!! json_encode(getPassingYears()) !!},
      std_ids: [],
      type: '',
      course_id: {{ $course->id or request("course_id",0) }},
      tData: [],
      table: null,
      formOpen: true,
      msg: '',
      subject: '',
      createUrl: "{{ url('/') . '/send-sms-alumni/' }}",
      courses: {!! \App\Course::get(['id', 'course_name', 'status'])->toJson() !!},
      success: false,
      fails: false,
      response: {},
      errors: [],
      sendOnly:true,
      show: false,
      graduateCourses: {!! graduateCourses() !!},
      postGraduateCourses: {!! postGraduateCourses() !!},
      professionalCourses: {!! professionalCourses() !!},
      researchCourses: {!! researchCourses() !!},
      errors: {},
      
    },
    created: function() {
      self = this;
      var target= 0;
      this.table = $('#example1').DataTable({
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50, -1 ],
              [ '10 rows', '25 rows', '50 rows', 'Show all' ]
          ],
          buttons: [
             'pageLength',
              {
                  extend: 'excelHtml5',
                  exportOptions: { orthogonal: 'export' }
              },
            ],
          "processing": true,
          "scrollCollapse": true,
          "ordering": true,
          data: [],
          columnDefs: [
			{ title: 'Sr no.', targets: target++, data: 'name',
				"render":function(data, type, row, meta){
						return meta.row + 1
					}
			},
            { title: 'Select', targets:target++, data: 'id',"width": "5%",
           'render': function (data, type, row, meta){
             return '<input type="checkbox" name="id[]" value="'+row.id+'" class="std_id">';
            }},
            { title: 'Student Name', targets: target++, data: 'name'},
            { title: 'Father Name', targets: target++, data: 'father_name'},
            { title: 'Email', targets: target++, data: 'email',
								"render":function(data, type, row, meta){
									return data ? data :'';
								}
						},
						{ title: 'Mobile', targets: target++, data: 'mobile',
								"render":function(data, type, row, meta){
									return data ? data :'';
								}
						},
            { targets: '_all', visible: true }
          ],
          "sScrollX": true,
          'order': [[1, 'asc']]
      });
    },
    computed: {   
        getCourses: function(){
          self = this;
          return this.courses.filter(function(course){
            return course.status == self.form.course_type;
          });
        },
      },
    methods: {
      getData: function() {
        var self = this;
        this.success = false;
        this.errors = [];
        data = $.extend({}, {
          course_id: self.form.course_id,
          course_type:self.form.course_type,
          passout_year:self.form.passout_year,
          student_course_id:self.form.student_course_id,
          type:self.form.type
        })
        this.$http.get("{{ url('send-sms-alumni') }}", {params: data})
        .then(function (response) {
          this.tData = response.data.alumni_students;
          this.reloadTable();
        }, function (response) {
        });
      },
  
      changeCourseType:function(){
        var self = this;
        self.form.type = "";
        self.form.student_course_id = 0;
        data = $.extend({}, {
          course_type: self.form.course_type,
        })
        this.$http.get("{{url('send-sms-alumni/course-list')}}", {params: data})
          .then(function(response){
            if(response.status == 200){
              self.courses =  response.data.courses;
            }
        })
        .catch(function(){
  
        });
      },
  
      confirmation:function(status){
        var me = this;
        var msg = "Do you want to send this SMS?";
        if(status == "all"){
          msg = "Do you want to send this SMS to all?";
          var r = confirm(msg);
          if (r == true) {
            me.sendSmsAll();
          } 
          return;
        }
        var r = confirm(msg);
        if (r == true) {
          me.sendSms();
        } 
        return;
      },
      sendSms: function() {
        this.success = false;
        this.errors = [];
        var me= this;
        data = $.extend({}, {
          msg: this.msg,
          subject:this.subject,
          std_ids:this.std_ids,
        })
        this.$http.post("{{ url('send-sms-alumni') }}", data)
          .then(function (response) {
//            this.classes = response.data;
            if(response.status == 200){
              me.success = true;
            }
            this.std_ids = [];
            this.reloadTable();
        }) 
          .catch(function (response) {
                if(response.status == 422) {
                    self.errors = response.data;
                }   
            });
      },
      
      sendSmsAll: function() {
        var me = this;
        this.success = false;
        this.errors = [];
        msgElement.empty();
        data = $.extend({}, {
          msg: this.msg,
          subject:this.subject,
          course_id:this.course_id,
        })
        this.$http.post("{{ url('send-sms-alumni/course') }}", data)
          .then(function (response) {
//            this.classes = response.data;
            if(response.status == 200){
              me.success = true;
            }
     
            this.std_ids = [];
            this.reloadTable();
          }) 
          .catch(function (response) {
                if(response.status == 422) {
                    self.errors = response.data;
                }   
            });
      },

		reloadTable: function() {
			this.table.clear();
			this.table.rows.add(this.tData).draw();
		},

		hasErrors: function() {
			console.log(this.errors && _.keys(this.errors).length > 0);
			if(this.errors && _.keys(this.errors).length > 0)
			return true;
			else
			return false;
		},

		changeType:function(){
			this.form.course_type = "";
			this.form.course_id = 0;
			this.form.passout_year = 0;
		}
    },    
  });
</script>
@stop

 