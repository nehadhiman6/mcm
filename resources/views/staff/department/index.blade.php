@extends('app')

@can('department-list')
  @section('toolbar')
    @include('toolbars._staff_toolbar')
  @stop
@endcan

@section('content')
<div id="department">
  <div class="box box-info" v-cloak>
    <div class="box-header with-border">
      <h3 class="box-title">@{{ form_id == 0 ? 'New' : 'Update' }} Department</h3>
    </div>
    <div class="box-body">
      {!! Form::open(['url' => 'department', 'class' => 'form-horizontal']) !!}
      @include('staff.department.form')

    </div>
    <div class="box-footer">
      <input class="btn btn-primary" type="submit" value="@{{ form_id == 0 ? 'ADD' : 'UPDATE' }}" @click.prevent="save">
      {!! Form::close() !!}
    </div>
  </div>
  @can('department-list')
    @include('staff.department.list')
  @endcan
  </div>
@stop

@section('script')
  <script>
  $('.select2').on('change',function(e){
      vm.faculty_id = parseInt($(this).val());
  });
  var vm = new Vue({
    el:'#department',
    data:{
      errors: {},
      success: false,
      form_id: "{{ $departments->id or 0 }}",
      url: "{{ url('department')}}",
      name:'',
      faculty_id: 0,
      departments: {!! json_encode($departments) !!}
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
            this.faculty_id = 0;
            $('.select2').val('').trigger('change');
            this.departments = response.data.departments;
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
        this.$http.get("{{ url('department') }}/"+id+"/edit")
        .then(function (response) {
          this.name = response.data.name;
          this.faculty_id = response.data.faculty_id;
          $('.select2').val(this.faculty_id).trigger('change');
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