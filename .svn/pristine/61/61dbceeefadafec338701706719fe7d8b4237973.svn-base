@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">New Course</h3>
  </div>
  <div class="box-body">
    {!! Form::open(['url' => 'courses', 'class' => 'form-horizontal']) !!}
    @include('courses._form')
  </div>
  <div class="box-footer">
    {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
@stop
@section('script')
<script>
    $('#sub_combi').on('ifChecked', function(event){
       $('#subject_no').show();
    //alert(event.type + ' callback');
    });
     $('#sub_combi').on('ifUnchecked', function (event) {
        $('#subject_no').hide();
    });
</script>
@stop