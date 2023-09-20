@extends('app')

@can('department-list')
  @section('toolbar')
    @include('toolbars._staff_toolbar')
  @stop
@endcan

@section('content')
<div id="staff">
  <div class="box box-info" v-cloak>
    <div class="box-header with-border">
      <h3 class="box-title">@{{ form.form_id == 0 ? 'New' : 'Update' }} Course     ( @{{ staff_detail.salutation }}  @{{ staff_detail.name }}  @{{staff_detail.middle_name}} @{{staff_detail.last_name}} ) ( @{{staff_detail.desig.name}} ) ( @{{staff_detail.dept.name}} )</h3>
       </h3>
    </div>
    <div class="box-body">
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
      @include('staff.staff_courses.form')

    </div>
    <div class="box-footer">
      <input class="btn btn-primary" type="submit" value="@{{ form.form_id == 0 ? 'ADD' : 'UPDATE' }}" @click.prevent="save">
      {!! Form::close() !!}
    </div>
  </div>
 
    @include('staff.staff_courses.index')

  </div>
@stop

@section('script')
  <script>
  function getNewForm() {
        return {
            form_id:0,
            staff_id:'',
            begin_date:'',
            end_date:'',
            university_id:'',
            other_university:'',
            courses:'',
            topic:'',
        }
    }
  var vm = new Vue({
    el:'#staff',
    data:{
        form: getNewForm(),
        errors: {},
        success: false,
        staff_id:"{{$staff_id}}",
        url: "{{ url('staff-courses')}}",
        boards: {!! getBoardlist(true) !!},
        staffs:{!! isset($staff) && $staff ? json_encode($staff) :'0' !!},
        staff_detail:{!! isset($stf) && $stf ? json_encode($stf) :'0' !!}


    },
    ready(){
      var self = this;
      self.form.staff_id = self.staff_id;
    },
    methods:{
        save:function(){
            this.errors = {};
            this.$http[this.getMethod()](this.getUrl(), this.form)
            .then(function(response) {
                if (response.data.success) {
                    console.log('dffsdfsd');
                this.success = true;
                this.form.form_id = 0;
                this.form.begin_date = '';
                this.form.end_date = '';
                this.form.university_id = '';
                this.form.other_university = '';
                this.form.courses = '';
                this.form.topic = '';
                this.staffs = response.data.staff;
                setTimeout(function() {
                self.success = false;
                }, 500);
            }
            }, 
            function(response) {
                this.errors = response.body;
            });
        },
      edit: function(id) {
        this.errors = {};
        this.$http.get("{{ url('staff-courses') }}/"+id+"/edit")
        .then(function (response) {
          this.staff = response.data.staff;
          this.form.form_id = this.staff.id;
          this.form.staff_id = this.staff.staff_id;
          this.form.begin_date = this.staff.begin_date;
          this.form.end_date = this.staff.end_date;
          this.form.university_id = this.staff.university_id;
          this.form.other_university = this.staff.other_university;
          this.form.courses = this.staff.courses;
          this.form.topic = this.staff.topic;

          
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
        if(this.form.form_id > 0)
          return this.url+'/'+this.form.form_id;
        else
          return this.url;
      },
      getMethod: function() {
        if(this.form.form_id > 0)
          return 'patch';
        else
          return 'post';
      },

      hasError: function() {
            if(this.errors && _.keys(this.errors).length > 0)
                return true;
            else
                return false;
      },
    }
  }); 
  </script>
@stop