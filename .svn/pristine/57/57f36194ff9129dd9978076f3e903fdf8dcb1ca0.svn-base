@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Update {{$inst->name}}</h3>
  </div>
  <div class="box-body">
    {!! Form::model($inst, ['method' => 'PATCH', 'action' => ['Fees\InstallmentController@update', $inst->id], 'class' => 'form-horizontal']) !!}

    @include('fees.installments._form')
    
  </div>
 <div class="box-footer">
  {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
  {!! Form::close() !!}
</div>
</div>
@stop