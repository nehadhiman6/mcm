@extends($dashboard)

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Resend Activation Link</div>

        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('student/activation/link') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">E-Mail Address</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" autocomplete="off" required autofocus>

                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                {!! Form::captcha() !!}
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Resend Activation Link
                </button>
              </div>
            </div>
            
            
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
