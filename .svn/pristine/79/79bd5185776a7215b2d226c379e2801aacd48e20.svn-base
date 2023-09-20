@extends('app')
@section('toolbar')
@include('toolbars._users_toolbar')
@stop
@section('content')
@if(isset($permission))
@include('permissions.edit')
@else
@include('permissions.create')
@endif
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Permissions</strong>
  </div>
  <div class="panel-body">
    <table id="permissions" class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($permissions as $permission)
        <tr>
          <td>{{ $permission->label }}</td>
          <td><a href="{{ url('permissions/' . $permission->id . '/edit') }}" class="btn btn-xs btn-primary">Edit</a></td>
        </tr>
        @endforeach
      </tbody>

    </table>
  </div>
</div>
@stop

@section('script')
<script>
    $(function () {
      $("#permissions").DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
      });
  });
</script>
@stop