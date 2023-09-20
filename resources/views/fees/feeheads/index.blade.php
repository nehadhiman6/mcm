@extends('app')

@section('toolbar')
  @include('toolbars._fees_maintenance_toolbar')
@stop

@section('content')
  @can('ADD-FEEHEADS')
    <div class="row">
      <a href="{{url('/feeheads/create')}}"><button class="btn  btn-flat margin">
          <span>Add Feehead</span>
        </button></a>
    </div>
  @endcan
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Feeheads</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1">
      <thead>
        <tr>
          <th>Feeheads</th>
          <th>Fund Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($feeheads as $feehead)
        <tr>
          <td>{{$feehead->name}}</td>
          <td>{{$feehead->fund->name or ''}}</td>
          <td>
            @can('EDIT-FEEHEADS')
              <a href="{{ url('feeheads/' . $feehead->id . '/edit') }}" class="btn btn-primary">Edit</a>
            @endcan
            @can('SUBHEADS-FEEHEADS')
              <a href="{{ url('feeheads/' . $feehead->id . '/subheads') }}" class="btn btn-primary">Subheads</a>
            @endcan
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