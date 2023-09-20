@extends('app')

@section('toolbar')
    @include('toolbars._academics_toolbar')
@stop

@section('content')
<div id='app' v-cloak>
    <div class="box box-default box-solid" >
        <div class="box-header with-border">
          Examination Details
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('exam_name', 'Examination', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::select('exam_name', getExams(), null, ['class' => 'form-control', 'v-model' => 'exam_name']) !!}
                </div>
                {!! Form::label('semester', 'Semester', ['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::select('semester', getSemesters(), null, ['class' => 'form-control', 'v-model' => 'semester']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::select('course_id',getCourses(),0,['class' => 'form-control','v-model'=>'course_id','@change' => 'getSubjectsList']) !!}
                </div>
                {!! Form::label('subject_id','Subject',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-4">
                    <select class='form-control' id='subject_id' v-model='subject_id'>
                        <option v-for="sub in subjects | orderBy 'subject'" :value="sub.id">@{{ sub.subject }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('min_marks','Min. Marks',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('min_marks',null,['class' => 'form-control','v-model'=>'min_marks']) !!}
                </div>
                {!! Form::label('max_marks','Max. Marks',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('max_marks',null,['class' => 'form-control','v-model'=>'max_marks']) !!}
                </div>
                {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!}
            </div>
        </div>
        {!! Form::close() !!}
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          Section List
        </div>
        <div class="panel-body">
            <table class="table table-bordered" id ="volunteerListDashboard">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Roll No.</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                    <tr v-for='std in students'>
                        <td>@{{ $index+1 }}</td>
                        <td>@{{ std.roll_no }}</td>
                        <td>@{{ std.name }}</td>
                        <td>@{{ std.father_name }}</td>
                        <td><input type="text" placeholder="Number of lectures" v-model='std.attended' /></td>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
  </div>
@stop

@section('script')
    <script>
        var vm = new Vue({
        el: '#app',
        data: {
            exam_name: '',
            semester: '',
            course_id: 0,
            selected_course_id: 0,
            subject_id: 0,
            min_marks: 0,
            max_marks: 0,
            subjects: [],
            students: {},
            saving: false,
        },
        methods: {
            getSubjectsList: function() {
                if(this.course_id != 0 && this.course_id != this.selected_course_id) {
                    this.$http.get("{{ url('courses') }}/"+this.course_id+"/subjects_list")
                    .then(function(response) {
                        this.subjects = response.data;
                    }, function(response) {

                    });
                }
            },
            
            getStudents: function() {
            this.$http.get("{{ url('attendance') }}/"+this.subsec.id, { params: { month: this.month }})
                .then(function(response) {
                    if(response.data.success) {
                        this.students = response.data.students;
                    }
                    console.log(response.data);
                    }, function(response) {

                });
            },
            save: function() {
                this.saving = true
                this.$http.post("{{ url('attendance') }}", this.$data )
                .then(function(response) {
                    this.saving = false;
                    if(response.data.success) {
                        // this.students = response.data.students;
                    }
                    console.log(response.data);
                }, function(response) {
                    this.saving = false;
                });
            }
        }
    });
  </script>
@stop@extends('app')

@section('toolbar')
    @include('toolbars._academics_toolbar')
@stop

@section('content')
<div id='app' v-cloak>
    <div class="box box-default box-solid" >
        <div class="box-header with-border">
          Examination Details
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('exam_name', 'Examination', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::select('exam_name', getExams(), null, ['class' => 'form-control', 'v-model' => 'exam_name']) !!}
                </div>
                {!! Form::label('semester', 'Semester', ['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::select('semester', getSemesters(), null, ['class' => 'form-control', 'v-model' => 'semester']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::select('course_id',getCourses(),0,['class' => 'form-control','v-model'=>'course_id','@change' => 'getSubjectsList']) !!}
                </div>
                {!! Form::label('subject_id','Subject',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-4">
                    <select class='form-control' id='subject_id' v-model='subject_id'>
                        <option v-for="sub in subjects | orderBy 'subject'" :value="sub.id">@{{ sub.subject }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('min_marks','Min. Marks',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('min_marks',null,['class' => 'form-control','v-model'=>'min_marks']) !!}
                </div>
                {!! Form::label('max_marks','Max. Marks',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('max_marks',null,['class' => 'form-control','v-model'=>'max_marks']) !!}
                </div>
                {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!}
            </div>
        </div>
        {!! Form::close() !!}
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          Section List
        </div>
        <div class="panel-body">
            <table class="table table-bordered" id ="volunteerListDashboard">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Roll No.</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                    <tr v-for='std in students'>
                        <td>@{{ $index+1 }}</td>
                        <td>@{{ std.roll_no }}</td>
                        <td>@{{ std.name }}</td>
                        <td>@{{ std.father_name }}</td>
                        <td><input type="text" placeholder="Number of lectures" v-model='std.attended' /></td>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
  </div>
@stop

@section('script')
    <script>
        var vm = new Vue({
        el: '#app',
        data: {
            exam_name: '',
            semester: '',
            course_id: 0,
            selected_course_id: 0,
            subject_id: 0,
            min_marks: 0,
            max_marks: 0,
            subjects: [],
            students: {},
            saving: false,
        },
        methods: {
            getSubjectsList: function() {
                if(this.course_id != 0 && this.course_id != this.selected_course_id) {
                    this.$http.get("{{ url('courses') }}/"+this.course_id+"/subjects_list")
                    .then(function(response) {
                        this.subjects = response.data;
                    }, function(response) {

                    });
                }
            },
            getStudents: function() {
            this.$http.get("{{ url('attendance') }}/"+this.subsec.id, { params: { month: this.month }})
                .then(function(response) {
                    if(response.data.success) {
                        this.students = response.data.students;
                    }
                    console.log(response.data);
                    }, function(response) {

                });
            },
            save: function() {
                this.saving = true
                this.$http.post("{{ url('attendance') }}", this.$data )
                .then(function(response) {
                    this.saving = false;
                    if(response.data.success) {
                        // this.students = response.data.students;
                    }
                    console.log(response.data);
                }, function(response) {
                    this.saving = false;
                });
            }
        }
    });
  </script>
@stop