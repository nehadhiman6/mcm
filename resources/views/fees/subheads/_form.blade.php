<div class='form-group'>
  {!! Form::label('sno','S. No',['class' => 'col-sm-1 control-label required']) !!}
  <div class="col-sm-1">
    {!! Form::text('sno',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('name','Name',['class' => 'col-sm-1 control-label required']) !!}
  <div class="col-sm-2">
    {!! Form::text('name',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('group','Group',['class' => 'col-sm-1 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::select('group',getGroup(),null,['class' => 'form-control ', 'id'=>'groupName', 'data-placeholder' => 'Select or add group']) !!}

  </div>
  {!! Form::label('refundable','Refundable',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-1">
    <label class="checkbox">
      <input type="checkbox" name="refundable" @if(isset($subhead) && $subhead->refundable=='Y')
             checked
             @endif value='Y' class="minimal" />
    </label>
  </div>
</div>