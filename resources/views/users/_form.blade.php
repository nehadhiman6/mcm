<div class="form-group">
  {!! Form::label('name','Name:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3"> 
    {!! Form::text('name',null,['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
  {!! Form::label('email','Email:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-6"> 
    {!! Form::text('email',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('role_id','Role:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-6 ">
     {!! Form::select('role_id',\App\Role::pluck('name','id'),null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('password','Password:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-4"> 
    <input type='password' name='password' class='form-control'>
  </div>
</div>

<div class="form-group">
  {!! Form::label('password_confirmation','Confirm Password:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-4"> 
    <input type='password' name='password_confirmation' class='form-control'>
   </div>
</div>
