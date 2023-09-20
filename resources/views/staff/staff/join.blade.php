@extends('app')
@section('toolbar')
@include('toolbars._staff_toolbar')
@stop
@section('content') 
<div class="box box-info" id="staffAdd" v-cloak>
  <div class="box-header with-border">
    <h3 class="box-title">Staff Rejoin</h3>
  </div>
  <div class="box-body">
    {!! Form::model($staff, ['method' => 'PATCH','action' => ['StaffController@update', $staff->id], 'class' => 'form-horizontal']) !!} 
      
        <div class="form-group">
            {!! Form::label('name','First Name', ['class' => 'control-label col-sm-2 required'])!!}
            <div class="col-md-2 "  v-bind:class="{ 'has-error': errors['name'] }"> 
              {!! Form::text('name',null, array('required',  'class'=>'form-control','readOnly')) !!}
              <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
            </div>
            {!! Form::label('middle_name','Middle Name', ['class' => 'control-label col-sm-2 '])!!}
            <div class="col-md-2"  v-bind:class="{ 'has-error': errors['middle_name'] }"> 
              {!! Form::text('middle_name',null, array('required',  'class'=>'form-control' ,'readOnly')) !!}
              <span id="basic-msg" v-if="errors['middle_name']" class="help-block">@{{ errors['middle_name'][0] }}</span>
            </div>
            {!! Form::label('last_name','Last Name', ['class' => 'control-label col-sm-2 '])!!}
            <div class="col-md-2 "  v-bind:class="{ 'has-error': errors['last_name'] }"> 
              {!! Form::text('last_name',null, array('required', 'class'=>'form-control','readOnly')) !!}
              <span id="basic-msg" v-if="errors['last_name']" class="help-block">@{{ errors['last_name'][0] }}</span>
            </div>
        </div> 
        <div class="form-group"  >
            {!! Form::label('left_date','MCM Left Date', ['class' => 'control-label col-sm-2'])!!}
            <div class="col-md-2 " v-bind:class="{ 'has-error': errors['left_date'] }"> 
                {!! Form::text('left_date',null, array('required', 'disabled','class'=>'form-control app-datepicker','v-model'=>'left_date')) !!}
                <span id="basic-msg" v-if="errors['left_date']" class="help-block">@{{ errors['left_date'][0] }}</span>
            </div>
            {!! Form::label('mcm_joining_date','MCM Joining Date', ['class' => ' control-label col-sm-2'])!!}
            <div class="col-md-2 " v-bind:class="{ 'has-error': errors['mcm_joining_date'] }"> 
                {!! Form::text('mcm_joining_date',null, array('required', 'class'=>'form-control app-datepicker','v-model'=>'mcm_joining_date')) !!}
                <span id="basic-msg" v-if="errors['mcm_joining_date']" class="help-block">@{{ errors['mcm_joining_date'][0] }}</span>
            </div>
        </div> 
        <div class="form-group">
            {!! Form::label('remarks','Remarks', ['class' => ' control-label col-sm-2'])!!}
            <div class="col-md-10 " v-bind:class="{ 'has-error': errors['remarks'] }"> 
                {!! Form::text('remarks',null, array('required', 'class'=>'form-control','v-model'=>'remarks')) !!}
                <span id="basic-msg" v-if="errors['remarks']" class="help-block">@{{ errors['remarks'][0] }}</span>
            </div>
        </div>
    </div>
    <div class="box-footer">
            {!! Form::submit('REJOIN',['class' => 'btn btn-primary','@click.prevent'=>'SubmitForm']) !!}
            {!! Form::close() !!}
    </div>
    <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Successfully Saved!</strong>
    </div>
</div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el:"#staffAdd",
    data:{
        staff_id: {{ $staff->id or 0 }},
        admitUrl: "{{ url('staff/rejoin')}}",
        mcm_joining_date:'',
        desig_id:'',
        left_date:'',
        remarks:'',
        errors:[],
        success:false
    },
    methods:{
      SubmitForm:function(){
        this.errors = {};
        var self = this;
        self.$http['post'](this.admitUrl,this.$data)
          .then(function (response) {
            console.log(response);
            if(response.status == 200) {
                self.success = true;
                setTimeout(() => {
                    window.location = "{{ url('staff')}}";
                }, 1500);
            }
          }, function (response) {
            this.fails = true;
            self = this;
            if(response.status == 422) {
              $('body').scrollTop(0);
              this.errors = response.data;
            }              
          });
      }
    }
  });
</script>
@stop