@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">New Concession</h3>
  </div>
  <div class="box-body">
    {!! Form::open(['url' => 'concessions', 'class' => 'form-horizontal']) !!}
    @include('fees.concessions._form')

  </div>
  <div class="box-footer">
    {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
@stop