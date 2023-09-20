@extends('donation_app')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Donation</h3>
    </div>
    {!! Form::open(['url' => 'donations', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
      <div class="form-group">
        {!! Form::label('name','Name',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3">
          {!! Form::text('name',null,['class' => 'form-control']) !!}
        </div>
        {!! Form::label('contact','Contact',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3">
          {!! Form::text('contact',null,['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('passout_year','Passout Year',['class' => 'col-sm-2 control-label required ']) !!}
        <div class="col-sm-3">
          {!! Form::text('passout_year',null,['class' => 'form-control']) !!}
        </div>
        {!! Form::label('email_id','Email',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3">
          {!! Form::text('email_id',null,['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('donation_amount','Donation Amount',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3">
          {!! Form::text('donation_amount',null,['class' => 'form-control']) !!}
        </div>
        {!! Form::label('donation_occasion','Donation Occasion',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3">
          {!! Form::text('donation_occasion',null,['class' => 'form-control']) !!}
        </div>
      </div>
    </div>
    <div class="box-footer">
      {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
    </div>
  </div>
@stop