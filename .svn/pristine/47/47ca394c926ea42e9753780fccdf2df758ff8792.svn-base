<div class="form-group">
  {!! Form::label('item','Item Name:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('item',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('item_code','Item Code:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('item_code',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('it_cat_id','Category:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::select('it_cat_id',getItemCategories(),null, ['class' => 'form-control']) !!}
  </div>
  {!! Form::label('it_sub_cat_id','Sub Category:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::select('it_sub_cat_id',getItemSubCategories(),null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('unit','Unit:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::select('unit',getUnits(),null, ['class' => 'form-control']) !!}
  </div>
  {!! Form::label('consumable','Consumable:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::select('consumable',getYesNo(),null, ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('remarks','Remarks:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-6 ">
    {!! Form::textarea('remarks',null,['class' => 'form-control','size' => '30x2']) !!}
  </div>
</div>
<div class="box-footer">
  {!! Form::submit($submitButtonText, ['class' => 'col-sm-offset-2 btn btn-primary']) !!}
</div>