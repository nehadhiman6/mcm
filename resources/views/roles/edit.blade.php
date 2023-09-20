<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Edit Role</h3>
  </div>
  {!! Form::model($role, ['method' => 'PATCH', 'action' => ['RoleController@update', $role->id], 'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('name','Name',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-3">
        {!! Form::text('name',null,['class' => 'form-control']) !!}
      </div>
      {!! Form::label('label','Label',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::text('label',null,['class' => 'form-control']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
