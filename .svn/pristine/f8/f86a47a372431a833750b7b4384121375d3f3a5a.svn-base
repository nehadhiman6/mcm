@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
      @if(isset($add_on_course))
    <h3 class="box-title">Edit Add-on Course</h3>
    @else
    <h3 class="box-title">New Add-on Course</h3>
    @endif
  </div>
  <div class="box-body">
    @if(isset($add_on_course))
    {!! Form::model($add_on_course, ['method' => 'PATCH','url'=>'courses/add-on/'. $add_on_course->id.'/edit', 'class' => 'form-horizontal']) !!}
    @else
    {!! Form::open(['url' => 'courses/add-on', 'class' => 'form-horizontal']) !!}
    @endif
    <div class='form-group'>
        {!! Form::label('course_name','Course Name',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            {!! Form::text('course_name',null,['class' => 'form-control']) !!}
        </div>
        {!! Form::label('short_name','Course Short Name',['class' => 'col-sm-2 control-label required ']) !!}
        <div class="col-sm-2">
            {!! Form::text('short_name',null,['class' => 'form-control']) !!}
        </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
@stop
