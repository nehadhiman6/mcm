@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">New Subhead</h3>
  </div>
  @if(isset($subhead))
  {!! Form::model($subhead, ['method' => 'PATCH', 'action' => ['FeeHeadController@updateSubHeads', $subhead->id], 'class' => 'form-horizontal']) !!}
  @else
  {!! Form::model($feehead, ['method' => 'POST', 'action' => ['FeeHeadController@addSubHeads', $feehead->id], 'class' => 'form-horizontal']) !!}
  @endif
  <div class="box-body">
    <div class='form-group'>
      {!! Form::label('sno','S. No',['class' => 'col-sm-1 control-label required']) !!}
      <div class="col-sm-1">
        {!! Form::text('sno',null,['class' => 'form-control']) !!}
      </div>
      {!! Form::label('name','Name',['class' => 'col-sm-1 control-label required']) !!}
      <div class="col-sm-2">
        {!! Form::text('name',null,['class' => 'form-control']) !!}
      </div>
      {!! Form::label('group','Group',['class' => 'col-sm-1 control-label required']) !!}
      <div class="col-sm-3">
         {!! Form::select('group',getGroup(),null,['class' => 'form-control ','id'=>'groupName']) !!}
       
      </div>
      {!! Form::label('refundable','Refundable',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-1">
        <label class="checkbox">
          <input type="checkbox" name="refundable" @if(isset($subhead) && $subhead->refundable=='Y')
                 checked
                 @endif value='Y' class="minimal" />
        </label>
      </div>
    </div>
  </div>
  <div class="box-footer">
    @if(isset($subhead))
    {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
    @else
    {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    @endif
    {!! Form::close() !!}
  </div>
</div>
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Sub Feeheads</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Name</th>
          <th>Group</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($feehead->subHeads as $head)
        <tr>
          <td>{{ $head->sno }}</td>
          <td>{{ $head->name }}</td>
          <td>{{ $head->group }}</td>
          <td>
            <a href="{{ url('subheads/'.$head->id.'/editsubhead')}}" class="btn btn-primary btn-sm">Edit</a>
           </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@stop
@section('script')
<script>
  $("#groupName").select2({
     escapeMarkup: function (markup) { return markup; },
  //  minimumInputLength: 50,
    tags: true,
  });
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
@stop