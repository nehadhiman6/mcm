@extends('app')
@section('toolbar')
@include('toolbars._activities_toolbar')
@stop
@section('content')
@can('add-orgnization')
<div class="box" style="background:none;box-shadow:none">
    <a href="{{url('orgnization/create')}}">
        <button class="btn  btn-flat margin">
            <span>Add Organization</span>
        </button>
    </a>
</div>
@endcan
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Organization</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
            <th>Sr No</th>
            <th>Organizational Unit</th>
            <th>Organizing Unit</th>
            <th>Organization Type</th>
            <th>Parent Unit(Department)</th>
            @can('orgnization-modify')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($orgnization as $org)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $org->name}}</td>
          <td>{{ $org->external_agency ? ($org->external_agency == 'Y' ? 'Yes': 'No') :'' }}</td>
          <td>{{ $org->agency->name}}</td>
          <td>{{ $org->department->name}}</td>
          <td>@can('orgnization-modify')<a class="btn btn-primary btn-xs" href="{{ url('orgnization/' . $org->id . '/edit') }}">Edit</a>@endcan</td>
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