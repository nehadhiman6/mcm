@extends('app')

@section('content')
<div class="col-sm-8 col-sm-offset-2">
  <div class="panel panel-default">
    <div class="panel-heading">Change Password</div>
    <div class="panel-body">
      {!! Form::open(['method' => 'PATCH','action' => ['UserController@updatePassword'], 'class' => 'form-horizontal']) !!}

      
      <div class="form-group">
        <label for="password" class="col-md-4 control-label">Old Password</label>

        <div class="col-md-6">
          <input  type="password" class="form-control" name="old_password" autofocus>
        </div>
      </div>

      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-4 control-label">New Password</label>

        <div class="col-md-6">
          <input id="password" type="password" class="form-control" name="password" >

          @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
        <div class="col-md-6">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

          @if ($errors->has('password_confirmation'))
          <span class="help-block">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
          <button type="submit" class="btn btn-primary">
            Update
          </button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
