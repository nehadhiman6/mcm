@extends('app')
@section('toolbar')
@include('toolbars._item_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">New Item</h3>
  </div>
  <div class="box-body">

    {!! Form::open(['url' => 'items', 'class' => 'form-horizontal']) !!}

    @include('inventory.items._form', ['submitButtonText' => 'Add Item'])

    {!! Form::close() !!}
  </div>
</div>
@stop
