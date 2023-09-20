@extends('app')
@section('toolbar')
@include('toolbars._academics_toolbar')
@stop
@section('content') 
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Update Section</h3>
  </div>
  <div class="box-body">
    {!! Form::model($section, ['method' => 'PATCH','action' => ['SectionController@update', $section->id], 'class' => 'form-horizontal']) !!} 
    @include('academics.section.form')
  </div>
  <div class="box-footer">
        {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
  </div>
</div>
@stop