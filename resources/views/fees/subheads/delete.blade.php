@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-primary" >
  <div class="box-header with-border">
    Delete Subhead : {{ $subhead->name }}
  </div>
      <div class="box-body">
        {!! Form::model($subhead, ['method' => 'DELETE', 'action' => ['Fees\SubHeadController@destroy', $subhead->id], 'class' => 'form-horizontal']) !!}

        <p>Are You Sure You Want To Delete This</p>

      </div>
      <div class="box-footer">
        {!! Form::submit('DELETE',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
      </div>
    </div>
@stop

