@extends('app')
@section('toolbar')
@include('toolbars._item_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
  <h3 class="box-title">Edit Item</h3>
  </div>
  <div class="box-body">

    {!! Form::model($item, ['method' => 'PATCH', 'action' => ['Inventory\ItemController@update', $item->id], 'class' => 'form-horizontal']) !!}

    @include('inventory.items._form', ['submitButtonText' => 'Update Item'])

    {!! Form::close() !!}
  </div>
</div>

@stop

