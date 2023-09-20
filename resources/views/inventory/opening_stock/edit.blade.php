@extends('app')
@section('toolbar')
@include('toolbars.opening_stock_toolbar')
@stop
@section('content')
<div id="app" class="box box-info">
  <div class="box-header with-border">
  <h3 class="box-title">Edit Opening Stock</h3>
  </div>
  {!! Form::model($opening_stock, ['method' => 'PATCH', 'action' => ['Inventory\OpeningStockController@update', $opening_stock->id], 'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('item_id','Item:',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-3">
        {!! Form::select('item_id',getItems(),null,['class' => 'form-control select2']) !!}
      </div>
      {!! Form::label('r_qty','Opening Stock:',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-3">
        {!! Form::text('r_qty',null,['class' => 'form-control']) !!}
      </div>
    </div>
    <div class="form-group">
        {!! Form::label('store_id','Store Location:',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::select('store_id',getStoreLocations(),null, ['class' => 'form-control']) !!}
          @if ($errors->any())
            <p class="help-block">
              @foreach ($errors->all() as $error)
                    {{ $error ? 'Store Location is Required!!' : '' }}
              @endforeach
            </p>
          @endif
        </div>
    </div>
  </div>
  <div class="box-footer">
    {{-- {!! Form::submit('Update Opening Stock', ['class' => 'btn btn-primary']) !!} --}}
    <button class="btn btn-primary">Update Opening Stock</button>
  </div>
    {!! Form::close() !!}
</div>
@stop
