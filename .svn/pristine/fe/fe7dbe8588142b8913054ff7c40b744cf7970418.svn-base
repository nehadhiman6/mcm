<!DOCTYPE html>
<html>
  @include('partials.head')
  <body  class="hold-transition prospectus-page">
    <div class="pros-body" id="app" v-cloak>
      <div class="new-prosalert"> 
        <ul class="alert alert-error alert-dismissible" role="alert" v-if="fails">
          <li v-for='error in errors'>@{{ error[0] }}<li>
        </ul>
        <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
          <li v-for='error in course_errors'>@{{ error[0] }}
          <li>
            <li v-if='show_box'>
              For Details<a class="btn btn-link" @click.prevent="linkProcedure()" target="_blank"><b>Click Here</b></a>
            <li>
          
        </ul>
      </div>
      <!-- box1 -->
      <div class="box box-primary" v-if="!form_loaded">
        <div class="box-heading">
          <h4 class="box-title pros">Select Course You Want To Study</h4>
        </div>
        <div class="box-body">
          {!! Form::open(['url' => 'buyprospectus/courses', 'class' => 'form-horizontal']) !!}
          <div class="form-group">
            {!! Form::label('course_id','Select Course',['class' => 'col-sm-4 control-label required']) !!}
            <div class="col-sm-7">
              {!! Form::select('course_id',getCourses(true),null,['class' => 'form-control' ,'v-model'=>'course_id','@change'=>'showNote()']) !!}
            </div>
          </div>
          
          <div class="box-footer" style='text-align: center;'>
            {!! Form::submit('CONTINUE',['class' => 'btn btn-primary','@click.prevent' => 'show',':disabled'=>'form_loaded']) !!}
          </div>

          <div class="alert alert-info" role="alert" v-if="show_only">
           <strong>Note</strong> : All electives offered by college (including Office Management) are available under course "BAI", "BAII"and "BAIIl" respectively.
              {{-- <strong>Note for BA I & BA II Applicants:</strong>
              All electives offered by college (including Office Management) are available under course "BAI" and "BAII" respectively. --}}
          </div>

          <div class="alert alert-info" role="alert" v-if="disable">
            <strong>Note</strong> for M.Sc I (Chemistry): Please click 'Final Submission' in Admission Form, only after declaration of UG final semester result of the respective university and after updating the latest academic results in the form.
         </div>
          {!! Form::close() !!}
        </div>
      </div>
       <!-- box2 -->
    <div class="new-pros">
      <div class="box box-primary" v-if="form_loaded">
        <div class="box-heading">
          <h4 class="box-title pros">New Registration</h4>
        </div>
        {!! Form::open(['url' => 'buyprospectus', 'class' => 'form-horizontal']) !!}
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('email','Course',['class' => 'col-sm-4 control-label required']) !!}
            <div class="col-sm-7">
              <p class="form-control-static">@{{ course.course_name }}</p>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('email','Email',['class' => 'col-sm-4 control-label required']) !!}
            <div class="col-sm-7">
              {!! Form::text('email',null,['class' => 'form-control','v-model'=>'email']) !!}
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('mobile','Mobile',['class' => 'col-sm-4 control-label required']) !!}
            <div class="col-sm-7">
              {!! Form::text('mobile',null,['class' => 'form-control','v-model'=>'mobile']) !!}
            </div>
          </div>
          <div class='form-group'>
            {!! Form::label('password','Password',['class' => 'col-sm-4 control-label required']) !!}
            <div class="col-sm-7">
              <input id="password" type="password" class="form-control" name="password" required v-model='password'>
            </div>
          </div>
          <div class='form-group'>
            {!! Form::label('confirm_password','Confirm Password',['class' => 'col-sm-4 control-label required']) !!}
            <div class="col-sm-7">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required v-model='password_confirmation'>
            </div>
          </div>
          <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10 ">
                <div class="g-recaptcha"></div>
              </div>
          </div>
        </div>
        <div class="box-footer" style='text-align: center;'>
          {!! Form::submit('REGISTER',['class' => 'btn btn-primary','@click.prevent' => 'save']) !!}
          {!! Form::close() !!}
        </div>
      <!-- box-end -->
      </div>
</div>
      <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success!</strong> @{{ response }}
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
          mobile: '',
          password: '',
          password_confirmation: '',
          success: false,
          fails: false,
          saving: false,
          msg: '',
          errors: {},
          course_errors: {},
          rcapt_sig_key: "{{config('college.nocaptcha_sitekey')}}",
          rcapt_id: 0,
          g_recaptcha_response: '',
          disable:false,
          show_only:true,
          url:'https://mcmdavcwchd.edu.in/centralized-admission-procedure/',
          show_box:false
        },
        ready:function(){
          $('body').on('click', '.edit', function(e) {
                self.linkProcedure(e.target.dataset.item);
            });
        },
        methods: {
          showNote: function() {
            var self = this;
            if(self.course_id == '37'){
              self.disable = true;
              self.show_only = false
            }else{
              self.disable = false;
              self.show_only = true
            }
            
          },
          show: function() {
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
                  if(this.course.class_code == 'BBAI' || this.course.class_code == 'BCAI' ||  this.course.class_code == 'B.COMI' || this.course.class_code == 'B.COM-I SF' || this.course.class_code == 'BSC-I MED' || this.course.class_code == 'BSC-I NMED' || this.course.class_code == 'BSC-I COMP'){
                    this.course_errors = {
                      "course_id": [
                        `This course is under centralized admission, you will get username/ password in your mail after allocation of seat to fill college form.`
                      ],
                    };
                    this.show_box = true;
                  }
                  else{
                    this.course_errors = {
                      "course_id": [
                        "Admission is not yet open for the selected course."
                      ]
                    };
                    this.show_box = false;
                  }
                  // console.log(this.course_errors);
                 
                  this.form_loaded = false;
                }
                if (this.form_loaded) {
                  this.$nextTick(function () {
                      if (window.grecaptcha) {
//                        console.log(this);
                        this.rcapt_id = grecaptcha.render( $('.g-recaptcha')[0], { sitekey : this.rcapt_sig_key });

                      }
                  });
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
			this.g_recaptcha_response = grecaptcha.getResponse(this.rcapt_id);
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
                window.location = "{{ url('student/activation/link') }}";
            }, function (response) {
                this.fails = true;
                self = this;
                this.saving = false;
                if(response.status == 422) {
                  this.errors = response.data;
                }
                grecaptcha.reset();
            });
        },
        hasErrors: function() {
          return _.keys(this.course_errors).length > 0;
        },
        linkProcedure:function(){
          var self = this;
          return  window.location = "https://mcmdavcwchd.edu.in/centralized-admission-procedure/";
        }
       },
      });

    </script>
  </body>
</html>
