@extends('app')

@section('toolbar')
  @include('toolbars._bill_receipt_toolbar')
@stop

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Bill/Receipt Cancellation</strong>
  </div>
  <div class="panel-body">
    {!! Form::open(['method' => 'GET',  'action' => ['BillCancellationController@getCancelDetail'], 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('fee_bill_id','Bill No',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('fee_bill_id',request('fee_bill_id'),['class' => 'form-control']) !!}
      </div>
      {!! Form::label('fee_rcpt_id','Receipt No',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('fee_rcpt_id',request('fee_rcpt_id'),['class' => 'form-control']) !!}
      </div>
      {!! Form::submit('Show',['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop