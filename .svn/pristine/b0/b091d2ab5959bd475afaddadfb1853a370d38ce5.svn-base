@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">ADD SUBHEAD TO : {{ $feehead->name }} </h3>
  </div>
  {!! Form::open(['method' => 'POST', 'action' => ['Fees\SubHeadController@store'], 'class' => 'form-horizontal']) !!}
  <div class="box-body">
   {!! Form::hidden('feehead_id', $feehead->id) !!}
    @include('fees.subheads._form')

  </div>
  <div class="box-footer">
    {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>{{ $feehead->name }} : Subheads</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Name</th>
          <th>Group</th>
          <th>Change Feehead</th>
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
           {!! Form::model($head, ['method' => 'PATCH', 'action' => ['Fees\SubHeadController@updtFeehead', $head->id], 'class' => 'form-horizontal']) !!}
           
            {!! Form::select('feehead_id',getFeehead(),null,['class' => 'form-control col-sm-2']) !!}
            <div class='col-sm-1'>
              {!! Form::submit('UPDATE',['class' => 'btn btn-primary btn-sm']) !!}
            </div>
            {!! Form::close()!!}
          </td>
          <td><a href="{{ url('subheads/'.$head->id.'/edit')}}" class="btn btn-xs btn-primary">Edit</a>
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
