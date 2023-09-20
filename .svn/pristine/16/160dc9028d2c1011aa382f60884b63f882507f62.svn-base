@extends('online.dashboard')
@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Final Form Submission</strong>
  </div>
  <div class="panel-body">
    {!! Form::model($adm_form, ['method' => 'patch', 'action' => ['Online\FinalSubmissionController@confirmSubmission',$adm_form->id], 'class' => 'form-horizontal']) !!}


    <p><strong style="color: #25516b"> Please check your form thoroughly before Final Submission. You cannot edit your form once it is submitted.</strong></p>
    <p>Candidate can only preview and print after Final Submission.<br>For any further modification/correction, contact the Administration office.</p>
  </div>
  <div class="panel-footer">
    {!! Form::submit('Confirm', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
@stop