<!DOCTYPE html>
<html>
@include('partials.head')

<body class="hold-transition login-page student-bg">
    {{-- <div class="iw-stu-float"> --}}

        {{-- <div class="col-sm-12 text-center iw-quest-btn-main">
            <a class="iw-btn-term" href="{{ url('paper-dwnld') }}">Question paper for Panjab University Examination, September 2020</a>
        </div> --}}
    <div class="student-login">
        <div class="login-logo">
            <a href="#"><img src="{{ asset("/dist/img/logo.png") }}" style="height:120px;"></a>
        </div>
        <!-- /.login-logo -->

        <div class="login-box-body stu-body">
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
                    <h4 class="info-line"><strong>Old Students are also required to register first for the Session
                            2023-2024</strong></h4>

                    <form method="POST" action="{{ url('stulogin') }}" class='form-horizontal'>
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <div class="pull-left stu-field">
                                {!! Form::label('email','Email',['class' => 'control-label required']) !!}
                            </div>
                            <div class="col-sm-12 col-xs-12 input-group">
                                <span class="input-group-addon stu-icon"><i class="glyphicon glyphicon-user"></i></span>
                                <span class="stu-input"><input type="email" name="email" class="form-control"
                                        value="{{ old('email') }}" placeholder="Email" autocomplete="off"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="pull-left stu-field">
                                {!! Form::label('password','Password',['class' => 'control-label required']) !!}
                            </div>
                            <div class="col-sm-12 col-xs-12 input-group ">
                                <span class="input-group-addon stu-icon"><i class="fa fa-lock"></i></span>
                                <span class="stu-input"><input type="password" name="password" class="form-control"
                                        placeholder="Password"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="pull-left stu-field" >
                                <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="form-group stu-btns">
                            <div class="col-sm-6 col-xs-6" style="padding-left:0px;">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                            </div>

                            <div class="col-sm-6 col-xs-6" style="padding-right:0px;">
                                <a href="{{url('/buyprospectus')}}"
                                    class="btn btn-primary btn-block btn-flat">Register</a>
                            </div>
                        </div>
                        <div class="or-box">
                            <span class="or">OR</span>
                        </div>

                        <div class="form-group acnt-link">
                            <div class="col-sm-6 col-xs-12 stu-actlink1">
                                <a class="btn btn-link forgot" href="{{ url('student/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                            <div class="col-sm-6 col-xs-12 stu-actlink2">
                                <a class="btn btn-link" href="{{ url('student/activation/link') }}">
                                    Activate Your Account.
                                </a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </form>
                    {{-- <span class="info-line"><b>Click Here to Pay Admission fee Direct </b></span><br><a
                        href="{{ url('payadmfees/create')}}"><button class="btn btn-primary">Pay Admission
                            Fee</button><br> --}}
                        
                            {{-- <span class="info-line"><b >Click Here to Apply for Regional Centre Examination </b></span><br><a href="{{ url('regional-centres/create')}}">
                        <beutton class="btn btn-primary" style="margin-left:2px;">Regional Centre</beutton> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="iw-terms-condition">
        <a class="iw-btn-term" href="{{ url('term-conditions') }}">Terms and Conditions</a>
    </div>
    {{-- </div> --}}

    {{-- <script src="{{ asset('plugins/jQuery/jQuery-2.2.0.min.js') }}"></script> --}}

    {{-- <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script> --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    


</body>

</html>