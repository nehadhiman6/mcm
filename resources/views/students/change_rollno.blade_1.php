@extends('app')
@section('content')
<div class="box box-info" id='app'>
  <div class="box-header with-border">
    <h2 class="box-title">Update RollNo</h2>
  </div>
  {!! Form::model($student, ['method' => 'PATCH', 'action' => ['StudentController@updateRollNo', $student->id], 'class' => 'form-horizontal']) !!}

  <div class="box-body">
    <div class="form-group">
      {!! Form::label('name','Name',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">{{ $student->name }}</p>
      </div>
      {!! Form::label('class','Class',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">{{ $student->course->course_name or ''}}</p>
      </div>
      {!! Form::label('roll_no','Roll No',['class' => 'col-sm-1 control-label required']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">{{ $student->roll_no }}</p>
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('UPDATE',['class' => 'btn btn-primary','@click.prevent'=>'updateRollNo']) !!}
    <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Success!</strong> @{{ response['success'] }}
    </div>
    <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
      <li v-for='error in errors'>@{{ error[0] }}<li>
    </ul>
  </div>
  {!! Form::close() !!}
</div>
@stop
@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      student_id: {{ $student->id }},
      response: {},
      success: false,
      fails: false,
      msg: '',
      errors: [],
    },
    created: function() {
      //  this.showDetail();
    },
    methods: {
      updateRollNo: function() {
          this.errors = {};
          this.$http['patch']("{{ url('students/') .'/' . $student->id .'/updaterollno'}}", this.$data)
            .then(function (response) {
              self = this;
              if(response.data.success) {
                this.response = response.data;
                this.success = true;
                setTimeout(function() {
                  self.success = false;
                }, 3000);
              }
            }, function (response) {
              this.fails = true;
              self = this;
              if(response.status == 422) {
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
      },
    },
    
  });
</script>
@stop