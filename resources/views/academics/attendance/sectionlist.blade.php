@extends('app')

@section('toolbar')
  @include('toolbars._academics_toolbar')
@stop

@section('content')
<div id='sectionlist' v-cloak>
    <div class="box box-default box-solid" >
        <div class="box-header with-border">
          Filter
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
          <div class="form-group">
              {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
            <div class="col-sm-3">
              
              {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse','v-model'=>'course_id']) !!}
            </div>
              {!! Form::label('teacher_id','Teacher',['class' => 'col-sm-1 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::select('teacher_id',getTeachers(false),0,['class' => 'form-control select-teacher','placeholder'=> 'Select','v-model'=>'teacher_id']) !!}
            </div>
            {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          Section List
        </div>
        <div class="panel-body">
          <table class="table table-bordered" id="sectionTable" width="100%">
            <thead>
              <tr>
                <th>Serial No.</th>
                <th>Course</th>
                <th>Subject</th>
                <th>Section</th>
                <th>Action</th>
               </tr>
            </thead>
            <tbody>
            <tr v-for="data in tData">
              <td>@{{$index + 1}}</td>
              <td>@{{ data.course.course_name}}</td>
              <td>@{{ data.subject.subject}}</td>
              <td>@{{ data.section.section}}</td>
              @can('EDIT-ATTENDANCE')
                <td><a href="attendance/@{{data.id}}" class="btn btn-primary btn-xs" target="_blank"><i class="fa fa-edit"></i>Attendance</a></td>
              @endcan
              </tr>
          </tbody>
          </table>
        </div>
      </div>
  </div>
@stop
@section('script')
  <script>
      var sectionlist = new Vue({
          el:"#sectionlist",
          data:{
            teacher_id:'',
            course_id:'',
            tData:''
          },
          created:function (){
            var self = this;
            $('.selectCourse').select2({
                width:'100%',
                placeholder: 'Select Course'
            });
            $('.selectCourse').on('change',function(){
                self.course_id = $(this).val();
            });


            $('.select-teacher').select2({
                width:'100%',
                placeholder: 'Select Teacher'
            });
            $('.select-teacher').on('change',function(){
                self.teacher_id = $(this).val();
            });
          },
          methods: {
            getData:function() {
              this.errors = {};
              this.fails = false;
              data = {
                course_id: this.course_id,
                teacher_id: this.teacher_id
              };
              this.$http.get("{{ url('attendance') }}", {params: data})
                .then(function (response) {
                  this.tData = response.data;
                }, function (response) {
                  this.fails = true;
                  this.errors = response.data;
              });
            }
          }
      });
  </script>
@stop
