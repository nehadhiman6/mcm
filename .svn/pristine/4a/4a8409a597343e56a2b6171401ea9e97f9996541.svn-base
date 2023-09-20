<?php
$default = ['' => 'State'];
$state = $default + \App\State::pluck('state', 'id')->toArray();
?>
<div class="form-group">
  {!! Form::label('city','City',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
    {!! Form::text('city',null,['class' => 'form-control']) !!}
  </div> 
</div>
<div class="form-group">
  {!! Form::label('state','State',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
    {!! Form::select('state_id',$state,null, ['class' => 'form-control']) !!}
  </div>
</div>

