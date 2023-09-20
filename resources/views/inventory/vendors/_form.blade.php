<div class="form-group">
  {!! Form::label('vendor_name','Name:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('vendor_name',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('code','Code:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('code',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
    {!! Form::label('mobile','Mobile:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('mobile',null,['class' => 'form-control ']) !!}
  </div>
   {!! Form::label('contact_person','Contact Person:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::text('contact_person',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
    {!! Form::label('contact_no','Contact No:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('contact_no',null,['class' => 'form-control']) !!}
  </div>
    {!! Form::label('city_id','City:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::select('city_id',getCities(),null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('vendor_address','Address:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::textarea('vendor_address',null,['class' => 'form-control','size' => '30x3']) !!}
  </div>
  {!! Form::label('deals_in_type_goods','Deal In Type Goods:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::text('deals_in_type_goods',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="box-footer">
  {!! Form::submit($submitButtonText, ['class' => 'col-sm-offset-2 btn btn-primary']) !!}
</div>
