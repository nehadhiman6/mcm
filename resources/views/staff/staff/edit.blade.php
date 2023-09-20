@extends('app')
@section('toolbar')
@include('toolbars._staff_toolbar')
@stop
@section('content') 
<div class="box box-info" id="staffAdd" v-cloak>
  <div class="box-header with-border">
    <h3 class="box-title">Update Staff</h3>
  </div>
  <div class="box-body">
    {!! Form::model($staff, ['method' => 'PATCH','action' => ['StaffController@update', $staff->id], 'class' => 'form-horizontal']) !!} 
    @include('staff.staff.form')
  </div>
  <div class="box-footer">
        {!! Form::submit('Update',['class' => 'btn btn-primary','@click.prevent'=>'SubmitForm']) !!}
        {!! Form::close() !!}
  </div>
</div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el:"#staffAdd",
    data:{
      form_id: {{ $staff->id or 0 }},
      admitUrl: "{{ url('staff')}}",
      first_name:'',
      last_name:'',
      gender:'Select',
      email:'',
      desig_id:'Select',
      dept_id:'Select',
      address:'',
      mobile:'',
      source:'Select',
      type:'Select',
      remarks:'',
      pay_scale:'',
      user_id:0,
      errors:[]
    },
    methods:{
      getMethod: function() {
        if(this.form_id > 0)
          return 'patch';
        else
          return 'post';
      },
      getAdmitUrl: function() {
        console.log(this.admitUrl);
        if(this.form_id > 0)
          return this.admitUrl+'/'+this.form_id;
        else
          return this.admitUrl;
      },
      SubmitForm:function(){
        this.errors = {};
        this.$http[this.getMethod()](this.getAdmitUrl(), this.$data)
          .then(function (response) {
            this.form_id = response.data.form_id;
            self = this;
            if (response.data.success) {
              self = this;
              this.success = true;
              setTimeout(function() {
               self.success = false;
              //  console.log(self.admitUrl+'/' +self.form_id +'/details');
                window.location = self.admitUrl;
              }, 1000);
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