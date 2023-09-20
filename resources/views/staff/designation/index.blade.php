@extends('app')

@can('designation-list')
  @section('toolbar')
    @include('toolbars._staff_toolbar')
  @stop
@endcan

@section('content')
<div id ="designation">
  <div class="box box-info" v-cloak>
    <div class="box-header with-border">
      <h3 class="box-title">@{{ form_id == 0 ? 'New' : 'Update' }} Designation</h3>
    </div>
    <div class="box-body">
      {!! Form::open(['url' => 'designation', 'class' => 'form-horizontal']) !!}
      @include('staff.designation.form')

    </div>
    <div class="box-footer">
      <input class="btn btn-primary" type="submit" value="@{{ form_id == 0 ? 'ADD' : 'UPDATE' }}" @click.prevent="save">
      {!! Form::close() !!}
    </div>
  </div>
  @can('designation-list')
    @include('staff.designation.list')
  @endcan
  </div>
@stop

@section('script')
  <script>
  var vm = new Vue({
    el:'#designation',
    data:{
      errors: {},
      success: false,
      form_id: "{{ $designations->id or 0 }}",
      url: "{{ url('designation')}}",
      name:'',
      designations: {!! json_encode($designations) !!}
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
            this.name = '';
            this.designations = response.data.designations;
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
        this.$http.get("{{ url('designation') }}/"+id+"/edit")
        .then(function (response) {
          this.name = response.data.name;
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
    }
  }); 
  </script>
@stop