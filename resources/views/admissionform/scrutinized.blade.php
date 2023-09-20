@extends('app')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Scrutinized For </h3>
    </div>

    <div class="box-body">
       {!! Form::model($student, ['method' => 'POST', 'url'=>'/admission-form/scrutinized', 'class' => 'form-horizontal']) !!}
        <input type="hidden" name="form_id" value="{{$student->id}}">
        <h4> Student :  {{ $student->name }}</h4>
        <h4> Form ID :  {{ $student->id }}</h4>
        @if ($student->scrutinized == 'N')
            <h3> Are you sure  you  want to mark this form  'Scrutinized' ? </h3>
        @elseif ($student->scrutinized == 'Y')
            <h3> Are you sure  you  want to mark this form  'Un-Scrutinized' ? </h3>
        @endif
        

    </div>
    <div class="box-footer">
        {!! Form::submit('YES',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('script')
<script>
   
</script>
@stop