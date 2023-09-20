<div class="form-group">
  {!! Form::label('subject','Subject',['class' => 'col-sm-1 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('subject',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('uni_code','Univ.Code',['class' => 'col-sm-1 control-label required']) !!}
  <div class="col-sm-2">
    {!! Form::text('uni_code',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('dept_id','Department',['class' => 'col-sm-1 control-label required']) !!}
  <div class="col-sm-4">
    {!! Form::select('dept_id',['' =>'Select'] + getDepartments(),null,['class' => 'form-control']) !!}
  </div>
<!--  {!! Form::label('practical','Practical ',['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-1">
        <label class="checkbox">
             <input type="checkbox" name="practical" @if(isset($subject) && $subject->practical=='Y')
                      checked
                     @endif value='Y' class="minimal" />
            
        </label>
    </div>-->
</div>
<div class="form-group">
  {!! Form::label('description','Description',['class' => 'col-sm-1 control-label']) !!}
  <div class="col-sm-5">
    {!! Form::textarea('description',null,['class' => 'form-control','size'=>'30x2']) !!}
  </div>
</div>
