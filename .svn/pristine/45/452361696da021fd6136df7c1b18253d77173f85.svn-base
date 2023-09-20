@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Update {{$category->name}}</h3>
  </div>
  <div class="box-body">
    {!! Form::model($category, ['method' => 'PATCH', 'action' => ['CategoryController@update', $category->id], 'class' => 'form-horizontal']) !!}

    @include('categories._form')
    
  </div>
 <div class="box-footer">
  {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
  {!! Form::close() !!}
</div>
</div>
@stop