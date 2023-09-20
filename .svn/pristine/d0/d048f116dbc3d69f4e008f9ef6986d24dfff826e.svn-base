@extends('app')

@can('faculty-list')
  @section('toolbar')
    @include('toolbars._staff_toolbar')
  @stop
@endcan

@section('content')
<div id ="faculty">
  <div class="box box-info" v-cloak>
    <div class="box-header with-border">
      <h3 class="box-title">@{{ form_id == 0 ? 'New' : 'Update' }} Faculty</h3>
    </div>
    <div class="box-body">
      {!! Form::open(['url' => 'faculty', 'class' => 'form-horizontal']) !!}
      @include('staff.faculty.form')

    </div>
    <div class="box-footer">
      <input class="btn btn-primary" type="submit" value="@{{ form_id == 0 ? 'ADD' : 'UPDATE' }}" @click.prevent="save">
      {!! Form::close() !!}
    </div>
  </div>
  @can('faculty-list')
    @include('staff.faculty.list')
  @endcan
  </div>
@stop

@section('script')
  <script>
  var vm = new Vue({
    el:'#faculty',
    data:{
      errors: {},
      success: false,
      form_id: "{{ $faculties->id or 0 }}",
      url: "{{ url('faculty')}}",
      faculty:'',
      faculties: {!! json_encode($faculties) !!}
    },
    methods:{
      save: function() {
        this.errors = {};
        this.$http[this.getMethod()](this.getUrl(), this.$data)
        .then(function (response) {
          this.form_id = response.data.form_id;
          self = this;
          if (response.data.success) {
            self = this;
            this.success = true;
            this.form_id = 0;
            this.faculty = '';
            this.faculties = response.data.faculties;
            setTimeout(function() {
              self.success = false;
            }, 500);
          }
        }, function (response) {
          this.fails = true;
          self = this;
          if(response.status == 422) {
            $('body').scrollTop(0);
            this.errors = response.data;
          }              
        });
      },
      edit: function(id) {
        this.errors = {};
        this.$http.get("{{ url('faculty') }}/"+id+"/edit")
        .then(function (response) {
          this.faculty = response.data.faculty;
          this.form_id = id;
        }, function (response) {
          this.fails = true;
          self = this;
          if(response.status == 422) {
            $('body').scrollTop(0);
            this.errors = response.data;
          }              
        });
      },
      getUrl: function() {
        if(this.form_id > 0)
          return this.url+'/'+this.form_id;
        else
          return this.url;
      },
      getMethod: function() {
        if(this.form_id > 0)
          return 'patch';
        else
          return 'post';
      },

      hasErrors: function() {
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
    }
  }); 
  </script>
@stop