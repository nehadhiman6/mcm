@extends('app')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Bill/Receipt Cancellation</strong>
  </div>
  <div class="panel-body">
    {!! Form::model($fee_bill, ['method' => 'DELETE', 'action' => ['BillCancellationController@destroy', $id], 'class' => 'form-horizontal']) !!}
    <input type="hidden" name='fee_bill_id' value="{{ $fee_bill->id or '' }}" />
    <input type="hidden" name='fee_rcpt_id' value="{{ $fee_rcpt->id or '' }}" />

    @if($fee_bill && ($fee_bill->fee_type == 'Admission'))
    <div class="alert alert-warning" role="alert">
      <strong>This is Admission BIll, so admission will also be cancelled!!</strong>
    </div>
    @endif
    <div class="row">
      <div class="col-sm-4">
        @if($student)
        <p><span class="label-name">Adm No.:</span> {{ $student->adm_no or $fee_rcpt->student->adm_no }}</p>
        <p><span class="label-name">Student Name:</span>{{ $student->name or $fee_rcpt->student->name}} </p>
        <p><span class="label-name">Father Name:</span>{{ $student->father_name or $fee_rcpt->student->father_name }}</p>
        <p><span class="label-name">Class:</span>{{ $student->course->course_name  or $fee_rcpt->student->course->course_name }} </p>
        @else
        <p><span class="label-name">Adm No.:</span> {{ $fee_bill->outsider->adm_no or $fee_rcpt->outsider->adm_no }}</p>
        <p><span class="label-name">Student Name:</span>{{ $fee_bill->outsider->name or $fee_rcpt->outsider->name}} </p>
        <p><span class="label-name">Father Name:</span>{{ $fee_bill->outsider->father_name or $fee_rcpt->outsider->father_name }}</p>
        <p><span class="label-name">Class:</span>{{ $fee_bill->outsider->course_name  or $fee_rcpt->outsider->course_name }} </p>
        @endif
      </div>
      <div class="col-sm-4">
        <p><span class="label-name">Bill No.:</span> {{ $fee_bill->id or '' }}</p>
        <p><span class="label-name">Bill Amount:</span> {{ $fee_bill->bill_amt or '' }}</p>
        <p><span class="label-name">Receipt No.:</span> {{ $fee_rcpt->id or '' }}</p>
        <p><span class="label-name">Receipt Amount:</span> {{ $fee_rcpt->amount or '' }}</p>
      </div>
      <div class="col-sm-4">
        @if($student)
        <p><span class="label-name">Pref.CONTACT NO:</span>{{ $student->mobile or $fee_rcpt->student->mobile }}</p>
        <p><span class="label-name">Address:</span>{{ $student->per_address }}</p>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        {!! Form::label('cancelled_remarks','Cancellation Remarks',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-6">
          {!! Form::textarea('cancelled_remarks', null, ['size' => '30x2' ,'class' => 'form-control']) !!}
        </div>
      </div>
    </div>
    <!--<a href="{{url('/')}}" class="btn btn-primary">Edit</a>-->
    {!! Form::submit('Confirm Cancellation', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
@stop
