@extends('app')
@section('toolbar')
@include('toolbars._academics_toolbar')
@stop
@section('content') 
<div id='app'>
<div class="box box-default box-solid">
  <div class="box-header with-border">
    Details
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  {!! Form::open(['url'=>'', 'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">{{ $subsec->course->course_name }}</p>
      </div>
      {!! Form::label('subject_id','Subject ',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-4">
        <p class="form-control-static">{{ $subsec->subject->subject }}</p>
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('section','Section ',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">{{ $subsec->section->section }}</p>
      </div>
      {!! Form::label('teacher','Teacher',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-4">
        <p class="form-control-static">{{ $subsec->teacher->first_name }}</p>
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('month','Month',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
         {!! Form::selectMonth('month', null,array('required', 'class'=>'form-control', 'v-model' => 'month')) !!}
      </div>
      {!! Form::label('lectures','Lectures Delivered',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('lectures',null, array('required', 'class'=>'form-control', 'v-model' => 'lectures')) !!}
      </div>
      <div class="col-sm-2">
        {!! Form::submit('Show', ['class' => 'btn btn-primary','@click.prevent'=>'getStudents']) !!}
      </div>
    </div>
  </div>
  {!! Form::close() !!}
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    Student List
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-2 col-sm-offset-10">
        {!! Form::submit('Save List', ['class' => 'btn btn-primary form-control','@click.prevent'=>'save', ':disabled' => 'saving']) !!}
      </div>
    </div>
    <table class="table table-bordered" id ="volunteerListDashboard">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Roll No.</th>
          <th>Name</th>
          <th>Father Name</th>
          <th>Attended Lectures</th>
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
    subsec: {!! json_encode($subsec) !!},
    month: '',
    students: {},
    lectures: 0,
    saving: false,
  },
  methods: {
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
