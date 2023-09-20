@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Update {{$cons->name}}</h3>
  </div>
  <div class="box-body">
    {!! Form::model($cons, ['method' => 'PATCH', 'action' => ['Fees\ConcessionController@update', $cons->id], 'class' => 'form-horizontal']) !!}

    @include('fees.concessions._form')
    
  </div>
 <div class="box-footer">
  {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
  {!! Form::close() !!}
</div>
</div>
@stop