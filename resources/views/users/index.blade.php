@extends('app')
@section('toolbar')
@include('toolbars._users_toolbar')
@stop
@section('content')
  @can('MODIFY-USERS')
    @include('users.create')
  @endcan

<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Users</strong>
  </div>
  <!-- /.box-header -->
  <div class="panel-body">
    <table id="users" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          @can('MODIFY-USERS')
            <th>Action</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
        <tr>
          <td>{{ $u->id }}</td>
          <td>{{ $u->name }}</a></td>
          <td>{{ $u->email }}</td>
          <td>
            @foreach($u->roles as $role)
            {{ $role->name or ''}}
            @endforeach
          </td>
          @can('MODIFY-USERS')<td><a href="{{ url('users/' . $u->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>@endcan
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
        </tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>
@stop
@section('script')
<script>
    $(function () {
      $("#users").DataTable({
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

