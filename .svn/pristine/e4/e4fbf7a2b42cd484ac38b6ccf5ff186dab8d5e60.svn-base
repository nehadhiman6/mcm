@extends($dashboard)
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Update Email</h3>
  </div>
  {!! Form::model($std_user, ['method' => 'PATCH', 'action' => ['Admissions\AdmEntryController@updateEmail', $std_user->id], 'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('email','Email',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-3">
        {!! Form::text('email',null,['class' => 'form-control']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
@stop