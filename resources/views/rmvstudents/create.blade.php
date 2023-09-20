@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
@stop
@section('content')
{!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
<div class="box box-info" id = "app">
  <div class="box-header with-border">
    <h3 class="box-title">Remove Student</h3>
  </div>
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('adm_no','Admission No',['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-3">
        <input type="text" v-model="adm_no" :disabled='form_loaded' number placeholder="Enter Admission No." name="adm_no" class="form-control">
      </div>
      {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent' => 'showDetail',':disabled'=>'form_loaded']) !!}
      {!! Form::submit('RESET',['class' => 'btn btn-primary','@click.prevent' => 'resetForm','v-if'=>'form_loaded']) !!}
    </div>
    <div id="student-details" v-if="form_loaded">
      <div class='form-group'>
        {!! Form::label('name','Student Name',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          <p class="form-control-static">@{{ student.name }}</p>
        </div>
        {!! Form::label('father_name','Father Name',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          <p class="form-control-static">@{{ student.father_name}}</p>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          <p class="form-control-static">@{{ student.course ? student.course.course_name : '' }}</p>
        </div>
        {!! Form::label('roll_no','Roll No.',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3">
          <p class="form-control-static">@{{ student.roll_no }}</p>
        </div>
      </div>
      <div class="form-group">
          {!! Form::label('remarks','Remarks',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-5" v-if='student.removed == "Y"'>
            <p>@{{ student.removed_detail ? student.removed_detail.remarks : '' }}</p>
          </div>
          <div class="col-sm-5" v-else>
            {!! Form::textarea('remarks', null, ['class' => 'form-control','size' => '30x2','v-model'=>"remarks"]) !!}
          </div>
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('Remove',['class' => 'btn btn-primary','@click.prevent' => 'remove','v-if'=>'form_loaded && student.removed == "N"']) !!}
    {!! Form::submit('Recover',['class' => 'btn btn-primary','@click.prevent' => 'recover','v-if'=>'form_loaded && student.removed == "Y"']) !!}
    {!! Form::close() !!}
  </div>
  <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
  {{ getVueData() }}
</div>
@stop
@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      response: {},
      adm_no : '',
      form_loaded: false,
      student: {},
      remarks: '',
      success: false,
      fails: false,
      saving: false,
      msg: '',
      errors: {},
    },
    created: function() {
//         this.showDetail();
    },
    methods:{
      showDetail: function() {
        this.errors = {};
        this.form_loaded = false;
        var data = { adm_no: this.adm_no };
        this.$http.get("{{ url('rmvstudents/create') }}", {params: data})
          .then(function (response) {
            this.form_loaded = true;
            console.log('here');
            this.student = response.data.student;
          }, function(response) {
            this.fails = true;
            this.saving = false;
            if(response.status == 422)
              this.errors = response.data;
        });
      },
      resetForm: function() {
        this.form_loaded = false;
        this.response = {};
        this.errors = {};
        this.student = {};
        adm_no: '';
        remarks: '';
      },
      remove: function(){
        this.errors = {};
        this.saving = true;
        this.$http.post("{{ url('rmvstudents') }}", this.$data)
          .then(function (response) {
              this.response = response.data;
              self = this;
              if (this.response['success']) {
                self = this;
                this.success = true;
                setTimeout(function() {
                  self.success = false;
                }, 3000);
              }
            }, function (response) {
              this.fails = true;
              self = this;
              this.saving = false;
              if(response.status == 422) {
                this.errors = response.data;
              }
            });
      },
      recover: function(){
        console.log('here');
        this.errors = {};
        this.saving = true;
        this.$http.delete("{{ url('rmvstudents') }}/"+this.student.id, this.$data)
          .then(function (response) {
              this.response = response.data;
              self = this;
              if (this.response['success']) {
                self = this;
                this.success = true;
                setTimeout(function() {
                  self.success = false;
                }, 3000);
              }
            }, function (response) {
              this.fails = true;
              self = this;
              this.saving = false;
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
      }
    }
  });
</script>
@stop