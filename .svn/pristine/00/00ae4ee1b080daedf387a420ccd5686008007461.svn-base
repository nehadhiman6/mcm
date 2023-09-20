@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Update {{$fee_head->name}}</h3>
  </div>
  <div class="box-body">
    {!! Form::model($fee_head, ['method' => 'PATCH', 'action' => ['Fees\FeeHeadController@update', $fee_head->id], 'class' => 'form-horizontal']) !!}

    @include('fees.feeheads._form')
    
  </div>
 <div class="box-footer">
  {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
  {!! Form::close() !!}
</div>
</div>
@stop