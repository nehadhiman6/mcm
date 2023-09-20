@extends('app')
@section('toolbar')
@include('toolbars._users_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Edit: {{ $user1->name }}</h3>
  </div>
  <div class="box-body">

    {!! Form::model($user1, ['method' => 'PATCH', 'action' => ['UserController@update', $user1->id], 'class' => 'form-horizontal']) !!}

    @include('users._form')
  </div>
  <div class='box-footer'>
    {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
   </div>
  {!! Form::close() !!}
</div>
@stop
