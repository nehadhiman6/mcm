<!DOCTYPE html>
<html>
  @include('partials.head')
  <body class="hold-transition login-page alumni-bg">
    <div class="student-login">
      <div class="login-logo alumni-logo">
      <a href="#"><img src="{{ asset("/dist/img/mcm-logo.png") }}" style="height:100px;"></a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body alumni-body ">
        <div class="row">
          <div class="col-sm-12">
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
          </div>
          <!-- <div class="col-sm-3">
            <a href="#"><img src="{{ asset("/dist/img/LOGO-ICON.png") }}"></a>
          </div> -->
          <div class="col-sm-12 text-center">
            <h4 class="login-head">Existing User Login Here</h4>

            <form method="POST" action="{{ url('alumnilogin') }}" class='form-horizontal'>
              {!! csrf_field() !!}
              <div class="form-group">
                <div class="pull-left stu-field">
                    {!! Form::label('email','Email',['class' => 'control-label required']) !!}
                </div>
                <div class="col-sm-12 col-xs-12 input-group">
                  <span class="input-group-addon stu-icon"><i class="glyphicon glyphicon-user"></i></span>
                  <span class="stu-input"><input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email"></span>
                </div>
              </div>

              <div class="form-group">
                <div class="pull-left stu-field">
                  {!! Form::label('password','Password',['class' => 'control-label required']) !!}
                </div>
                <div class="col-sm-12 col-xs-12 input-group ">
                  <span class="input-group-addon stu-icon"><i class="fa fa-lock"></i></span>
                  <span class="stu-input"><input type="password" name="password" class="form-control" placeholder="Password"></span>
                </div>
              </div>
              <!-- /.col -->
              <div class="form-group stu-btns">
                <div class="col-sm-6 col-xs-6" style="padding-left:0px;">
                  <button type="submit" class="btn btn-primary btn-block btn-flat" >Login</button>
                </div>
               
                <div class="col-sm-6 col-xs-6" style="padding-right:0px;">
                  <a href="{{url('/alumniregister')}}" class="btn btn-primary btn-block btn-flat">Register</a>
                </div>
              </div>
              <div class="or-box">
                    <span class="or">OR</span>
                </div>
         
              <div class="form-group acnt-link">
                <div class="col-sm-6 col-xs-12 stu-actlink1">
                  <a class="btn btn-link forgot" href="{{ url('alumni/password/reset') }}">
                    Forgot Your Password?
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
  </body>
</html>
