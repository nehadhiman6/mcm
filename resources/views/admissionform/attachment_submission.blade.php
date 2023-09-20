@extends('app')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Attachment Submission For </h3>
    </div>
    @if($student->scrutinized == 'Y')
        <div class="alert alert-success">
        <strong>This form is already Scrutinized ! First Un-Scrutinized it.</strong> .
      </div>
    @else
        @if($student->attachment_submission == 'Y')

        <div class="box-body">
        {!! Form::model($student, ['method' => 'POST', 'url'=>'/admission-form/attachment-submission', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="form_id" value="{{$student->id}}">
            <h4> Student :  {{ $student->name }}</h4>
            <h4> Form ID :  {{ $student->id }}</h4>
            <h3> Are you sure  you  want to open this form Attachment submission. ? </h3>

        </div>
        <div class="box-footer">
            {!! Form::submit('YES',['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
        @else
        
            <div class="alert alert-success">
            <strong>Success!</strong> Submission form is Open for student.
        </div>
        @endif
    @endif

</div>
@stop
@section('script')
<script>
   
</script>
@stop