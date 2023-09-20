@extends('online.dashboard')
@if($dashboard == 'app')
@section('toolbar')
<!-- @include('toolbars._admform_toolbar') -->
@stop
@endif
@section('content')
<div>
  <div id='app' v-cloak>
    <ul class="alert alert-error alert-dismissible" role="alert" v-if="fails">
      <li  v-for='error in errors'>@{{ error }} <li>
    </ul>
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><strong>Hostel Form</strong></h3>
      </div>
       
      <div class="box-body form-horizontal">

        @if($hostel_form->exists)
          {!! Form::model($hostel_form, ['method' => 'PATCH', 'action' => ['Online\HostelApplicationController@update', $hostel_form->id], 'class' => 'form-horizontal']) !!}
        @else
          {!! Form::open(['url' => 'hostel-form', 'class' => 'form-horizontal']) !!}
        @endif

        @include('hostelform._hostel_form')
      </div>
      <div class="box-footer">
        @if($hostel_form->exists)
        <input class="btn btn-primary" id="btnsubmit"  type="submit" value="UPDATE" @click.prevent="submitHostelForm">
        {!! Form::close() !!}
        <!-- @if(isset($guard)&& $guard == 'web')
        <button class="btn btn-primary" id="add_attachment">Attachments</button>
        @endif -->
        @else
        <input class="btn btn-primary" id="btnsubmit" type="submit" value="ADD" @click.prevent="submitHostelForm">
        @endif
        {!! Form::close() !!}

        <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success!</strong> @{{ response['success'] }}
        </div>
              {{ getVueData() }}
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
      form_id: {{ $hostel_form->id or 0 }},
      admission_id:{{ $admission_id}},
      response: {},
      success: false,
      fails: false,
      msg: '',
      errors: [],
      schedule_backward_tribe: '',
      serious_ailment: '',
      prv_hostel_block: '',
      prv_room_no: '',
      prv_class: '',
      prv_roll_no: '',
      guardian_name:'',
      guardian_phone:'',
      guardian_mobile:'',
      guardian_email:'',
      guardian_address:'',
      room_mate: '',
      ac_room:'N',
      g_office_addr: '',
      guardian_relationship:'',
      admitUrl: "{{ url('hostel-form') }}",
      adm_form : {!! $adm_form !!},
      hostel_form : {!! $hostel_form !!}
    },
    ready:function(){
        var self = this;
        self.ac_room = self.hostel_form.ac_room;
    },
    methods:{
      submitHostelForm:function(){
        var self = this;
        this.errors = {};
        this.$http[this.getMethod()](this.getAdmitUrl(), this.$data)
          .then(function (response) {
            hostelData= response.data;
            if (response.data.success) {
              this.success = true;
              console.log(hostelData);
              setTimeout(function() {
              for (let field in hostelData) {
                if(self.$data.hasOwnProperty(field) && typeof(self.$data[field]) != 'function') {
                  self.$data[field] = hostelData[field];
                }
                this.form_id = response.data.id;
                window.location = "{{ url('admforms') }}"+'/' +self.admission_id +'/details';
              }
              self.success = false;
              }, 2000);
            }
          }, function (response) {
            this.fails = true;
            if(response.status == 422) {
              $('body').scrollTop(0);
              this.errors = response.data;
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

    }
});

</script>
@stop
