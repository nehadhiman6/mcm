<!DOCTYPE>
<html>
  @include('partials.head')
  <body class="hold-transition login-page alumni-bg" id ="app" v-cloak>
    <div class="alumni-login">
        <div class="login-logo alumni-logo">
            <a href="#"><img src="{{ asset("/dist/img/mcm-logo.png") }}" style="height:100px;"></a>
            </div>
      <!-- /.login-logo -->
      <div class="login-box-body alumni-body">
        <div class="row">
            @if(session()->has('message'))
            <ul class="alert alert-warning">
              {{ session()->get('message') }}
            </ul>
            @endif
             @include('flash::message')
             @if(count($errors->all())>0)
            <ul class="alert alert-danger">
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
            @endif
            
        <div class="text-center">
          <h4 class="login-head text-center">REGISTER ALUMNI USER</h4>
           
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/alumniregister') }}">
              {{ csrf_field() }}
              <div class="form-group"  v-bind:class="{ 'has-error': errors['name'] }">
                <label for="name" class="col-md-5 control-label">Name</label>
  
                <div class="col-md-7">
                  <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                  <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
                </div>
              </div>

                <div class="form-group"  v-bind:class="{ 'has-error': errors['email'] }">
                  <label for="email" class="col-md-5 control-label">E-Mail Address</label>
  
                  <div class="col-md-7">
                    <input id="email" type="email" class="form-control" v-model="email" value="{{ old('email') }}" required>
                    <span id="basic-msg" v-if="errors['email']" class="help-block">@{{ errors['email'][0] }}</span>
                  </div>
                </div>
                <div class="form-group"  v-bind:class="{ 'has-error': errors['mobile'] }">
                  <label for="mobile" class="col-md-5 control-label">Mobile</label>
  
                  <div class="col-md-7">
                    <input id="mobile" type="text" class="form-control" v-model="mobile" value="{{ old('mobile') }}" required autofocus>
                    <span id="basic-msg" v-if="errors['mobile']" class="help-block">@{{ errors['mobile'][0] }}</span>
                  </div>
                </div>
                <div class="form-group"  v-bind:class="{ 'has-error': errors['password'] }">
                  <label for="password" class="col-md-5 control-label">Password</label>
  
                  <div class="col-md-7">
                    <input id="password" type="password" class="form-control" v-model="password" required>
                    <span id="basic-msg" v-if="errors['password']" class="help-block">@{{ errors['password'][0] }}</span>
                  </div>
                </div>
  
                <div class="form-group"  v-bind:class="{ 'has-error': errors['password_confirmation'] }">
                  <label for="password-confirm" class="col-md-5 control-label">Confirm Password</label>
  
                  <div class="col-md-7">
                    <input id="password-confirm" type="password" class="form-control" v-model="password_confirmation" required>
                    <span id="basic-msg" v-if="errors['password_confirmation']" class="help-block">@{{ errors['password_confirmation'][0] }}</span>
                  </div>
                </div>
                <div class="form-group">
                 {!! Form::submit('REGISTER',['class' => 'btn btn-alumni btn-block','@click.prevent' => 'save']) !!}
                  {!! Form::close() !!}

                </div>
            </form>
          </div>
        </div>
      </div>
      @include('partials.scripts')
      <script>
        var vm = new Vue({
          el: '#app',
          data: {
            name:'',
            email: '',
            mobile: '',
            password: '',
            password_confirmation: '',
            success: false,
            fails: false,
            msg: '',
            errors: {},
            reg_code: "{{ request('reg_code', '') }}",
            // rcapt_sig_key: "{{config('college.nocaptcha_sitekey')}}",
            // rcapt_id: 0,
            // g_recaptcha_response: '',
          },
          methods: {
          save: function() {
            var self = this;
            this.errors = {};
            this.saving = true;
            this.$http.post("{{ url('alumniregister') }}", this.$data)
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
                  window.location = "{{ url('alumni-student')}}";
                  // window.location = "{{ url('alumni/activation/link') }}";
                }, function (response) {
                    this.fails = true;
                    this.saving = false;
                    if(response.status == 422) {
                      self.errors = response.data;
                    }
                    grecaptcha.reset();
                });
          }
         },
        });
  
      </script>
  </body>
</html>
