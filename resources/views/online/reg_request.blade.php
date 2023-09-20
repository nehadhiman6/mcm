<!DOCTYPE html>
<html>
  @include('partials.head')
  <body  class="hold-transition prospectus-page">
    <div class="pros-body" id="app">
      <ul class="alert alert-error alert-dismissible" role="alert" v-if="fails">
        <li v-for='error in errors'>@{{ error[0] }}<li>
      </ul>
      <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
        <li v-for='error in course_errors'>@{{ error[0] }}<li>
      </ul>
      <div class="box box-primary" v-if="!form_loaded">
        <div class="box-heading">
          <h4 class="box-title pros">Select Course You Want To Study</h4>
        </div>
        <div class="box-body">
          {!! Form::open(['url' => 'buyprospectus/courses', 'class' => 'form-horizontal']) !!}
          <div class="form-group">
            {!! Form::label('course_id','Select Course',['class' => 'col-sm-4 control-label required']) !!}
            <div class="col-sm-7">
              {!! Form::select('course_id',getCourses(),null,['class' => 'form-control' ,'v-model'=>'course_id']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('email','Email',['class' => 'col-sm-4 control-label required']) !!}
            <div class="col-sm-7">
              {!! Form::text('email',null,['class' => 'form-control','v-model'=>'email']) !!}
            </div>
          </div>
          <div class="box-footer" style='text-align: center;'>
            {!! Form::submit('CONTINUE',['class' => 'btn btn-primary']) !!}
          </div>
          {!! Form::close() !!}
        </div>
      </div>
      {{ getVueData() }}
    </div>
    @include('partials.scripts')
<script>
    var vm = new Vue({
      el: '#app',
      data: {
        response: {},
        form_loaded: false,
        course: {},
        course_id: {{ $course->id or request("course_id",0) }},
        email: '',
        success: false,
        fails: false,
        saving: false,
        msg: '',
        errors: {},
        course_errors: {},
      },
      methods:{
        show : function() {
          this.course_errors = {};
          if(this.course_id == 0) {
            this.course_errors = {
              "course_id": [
                "The selected course id is invalid."
              ]
            };
            return;
          }
          var data = { course_id: this.course_id };
          this.$http.post("{{ url('buyprospectus/courses') }}", data)
            .then(function (response) {
              this.form_loaded = true;
              this.course = response.data.course;
              if(this.course.adm_open == 'N') {
                this.course_errors = {
                  "course_id": [
                    "Admission is not yet open for the selected course."
                  ]
                };
                this.form_loaded = false;
              }
            }, function(response) {
              this.fails = true;
              this.saving = false;
              if(response.status == 422)
                this.course_errors = response.data;
        });
      },
      save: function() {
        this.errors = {};
        this.saving = true;
        this.$http.post("{{ url('buyprospectus') }}", this.$data)
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
              window.location = "{{ url('admforms') }}";
             // console.log(response);
            }, function (response) {
              this.fails = true;
              self = this;
              this.saving = false;
            //  this.response.errors = response.data;
              if(response.status == 422) {
                this.errors = response.data;
              }
//              console.log(response.data);              
            });
      },
      hasErrors: function() {
        return _.keys(this.course_errors).length > 0;
      }
     },
    });
              
</script>
</body>
</html>