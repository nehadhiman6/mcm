@extends('app')
@section('toolbar')
@include('toolbars._activities_toolbar')
@stop
@section('content')
@can('agency-types')
<div class="box" style="background:none;box-shadow:none">
    <a href="{{url('agency-types/create')}}">
        <button class="btn  btn-flat margin">
            <span>Add Organization/Sponsor/Activity</span>
        </button>
    </a>
</div>
@endcan
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Organization/Sponsor/Activity</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
            <th>Sr No</th>
            <th>Organization/Sponsor/Activity</th>
            <th>Agency Type</th>
            @can('agency-types-modify')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($agency_types as $agency_type)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $agency_type->name}}</td>
          <td>{{ $agency_type->master_type}}</td>
          <td>@can('agency-types-modify')<a class="btn btn-primary btn-xs" href="{{ url('agency-types/' . $agency_type->id . '/edit') }}">Edit</a>@endcan</td>
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