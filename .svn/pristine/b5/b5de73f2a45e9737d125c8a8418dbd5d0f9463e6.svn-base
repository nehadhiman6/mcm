@extends('app')
@section('toolbar')
@include('toolbars._damage_toolbar')
@stop
@section('content')
@can('add-inv-damage')
  <div class="box" style="background:none;box-shadow:none">
      <a href="{{url('damages/create')}}">
          <button class="btn  btn-flat margin">
              <span>Add Damage</span>
          </button>
      </a>
  </div>
@endcan
<div class="box">
  <div class="box-header">
    <h3 class="box-title">Damages</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Store Locations</th>
          <th>Remarks</th>
          @can('inv-edit-damage')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($damages as $damage)
        <tr>
          <td>{{ $i }}</td>
        <td>{{ $damage->storelocations ? $damage->storelocations->location : '' }}</td>
          <td>{{ $damage->remarks}}</td>
          <td>@can('inv-edit-damage')<a class="btn btn-primary btn-xs" href="{{ url('damages/' . $damage->id . '/edit') }}">Edit</a>@endcan</td>
        </tr>
        <?php $i++; ?>
        @endforeach
        </tbody>
    </table>
  </div>
  <!-- /.box-body -->
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