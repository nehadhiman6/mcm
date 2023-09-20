<div class="form-group">
  {!! Form::label('name','Name',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
    {!! Form::text('name',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('fund_id','Fund',['class' => 'col-sm-1 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::select('fund_id',getFunds(),null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('fund','Fund Type',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::select('fund',[''=>'Select','C'=>'College','H'=>'Hostel'],null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('concession','Concession',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-1">
    <label class="checkbox">
      <input type="checkbox" name="concession" @if(isset($fee_head) && $fee_head->concession=='Y')
             checked
             @endif value='Y' class="minimal" />
    </label>
  </div>
</div>