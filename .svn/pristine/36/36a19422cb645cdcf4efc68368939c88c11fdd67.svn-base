@extends('app')
@section('toolbar')
@include('toolbars._vendors_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Edit Vendor</h3>
  </div>
  <div class="box-body">

    {!! Form::model($vendor, ['method' => 'PATCH', 'action' => ['Inventory\VendorController@update', $vendor->id], 'class' => 'form-horizontal']) !!}

    @include('inventory.vendors._form', ['submitButtonText' => 'Update Vendor'])

    {!! Form::close() !!}
  </div>
</div>

@stop

