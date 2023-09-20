<html>
    @include('partials.head')
    <body class="hold-transition login-page main-loginbg">
        <div class="row">
            <div class="col-sm-12 col-lg-6 login-box main-box float-left">
                <div class="login-logo">
                    <a href="#"><img src="{{ asset("/dist/img/logo.png") }}"></a>
                </div>
                <!-- /.login-logo -->
                <div class="login-box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            @if(count($errors->all())>0)
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        <!-- <div class="col-sm-4">
                            <a href="#"><img src="{{ asset("/dist/img/LOGO-ICON.png") }}"></a>
                            </div> -->
                        <div class="col-sm-12 text-center">
                            <h4 class="login-head">SIGN IN TO CONTINUE</h4>
                            <form method="POST" action="{{ url('/login') }}">
                                {!! csrf_field() !!}
                                <div class="form-group has-feedback">
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email">
                                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
								</div>
								<div class="form-group has-feedback">
                                    <select  name = "session" class="form-control" placeholder="session">
										<option value="20182019" >2018-2019</option>
										<option value="20192020" >2019-2020</option>
										<option value="20202021" >2020-2021</option>
                                        <option value="20212022" selected>2021-2022</option>
                                        <option value="20222023" selected>2022-2023</option>
                                        <option value="20232024" selected>2023-2024</option>
									</select>
                                    <span class="glyphicon glyphicon-time form-control-feedback"></span>
                                </div>
                                <div class="col-md-12">
                                    <div class="checkbox icheck">
                                        <label>
                                        <input type="checkbox" name='remember' class="minimal"><span class="rm-login"> Remember Me</span>
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="row">
                                    <div class="col-xs-4 col-xs-offset-4">
                                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                                    </div>
                                </div>
                                <!--                <a class="btn btn-link forgot" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                    </a>-->
                                <!-- /.col -->
                            </form>
                        </div>
                    </div>
                    <!--        <div class="social-auth-links text-center">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                          Facebook</a>
                        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                          Google+</a>
                        </div>-->
                    <!-- /.social-auth-links -->
                    <!--<a href="#">I forgot my password</a><br>-->
                    <!--<a href="register.html" class="text-center">Register a new membership</a>-->
                </div>
                <!-- /.login-box-body -->
            </div>
            <div class="col-sm-12 col-lg-5 iw-login-new float-left">
                <!-- /.login-box -->
                <div class="col-sm-12 col-lg-6">
                    <button type="submit" class="btn in-btn-student btn-block btn-flat col-sm-12  col-lg-4"><a href="{{ url('stulogin') }}">Student Login</a></button>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <button type="submit" class="btn in-btn-alumni btn-block btn-flat col-sm-12 col-lg-4"><a href="{{ url('alumnilogin') }}">Alumni Login</a></button>
                </div>
            </div>
        </div>
        @include('partials.scripts')
        <script>
            $(function () {
              $('input').iCheck({
                checkboxClass: 'icheckbox_minimal-pink',
                radioClass: 'iradio_minimal-pink',
                increaseArea: '20%' // optional
              });
            });
        </script>
    </body>
</html>