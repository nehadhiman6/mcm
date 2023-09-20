@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Add Category</h3>
  </div>
  <div class="box-body">
    {!! Form::open(['url' => 'categories', 'class' => 'form-horizontal']) !!}
    @include('categories._form')
  </div>
 <div class="box-footer">
  {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
  {!! Form::close() !!}
</div>
</div>
@stop
