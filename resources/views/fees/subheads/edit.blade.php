@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Update</h3>
  </div>
  <div class="box-body">
    {!! Form::model($subhead, ['method' => 'PATCH', 'action' => ['Fees\SubHeadController@update', $subhead->id], 'class' => 'form-horizontal']) !!}

    @include('fees.subheads._form')

  </div>
  <div class="box-footer">
    {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
@stop
@section('script')
<script>
  $("#groupName").select2({
    escapeMarkup: function (markup) {
      return markup;
    },
    //  minimumInputLength: 50,
    tags: true,
  });
</script>
@stop