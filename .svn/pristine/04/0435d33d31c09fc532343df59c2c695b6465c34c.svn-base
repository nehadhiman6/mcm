@extends('app')
@section('toolbar')
@include('toolbars._vendors_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">New Vendor</h3>
  </div>
  <div class="box-body">

    {!! Form::open(['url' => 'vendors', 'class' => 'form-horizontal']) !!}

    @include('inventory.vendors._form', ['submitButtonText' => 'Add Vendor'])

    {!! Form::close() !!}
  </div>
</div>
@stop
