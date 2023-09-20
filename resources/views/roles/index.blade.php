@extends('app')
@section('toolbar')
@include('toolbars._users_toolbar')
@stop
@section('content')
  @CAN('MODIFY-ROLES')
    @if(isset($role))
    @include('roles.edit')
    @else
    @include('roles.create')
    @endif
  @ENDCAN
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>Roles</strong>
    </div>
    <div class="panel-body">
      <table id="roles" class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            @CAN('MODIFY-ROLES')<th>Action</th>@ENDCAN
          </tr>
        </thead>
        <tbody>
          @foreach($roles as $role)
          <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            @CAN('MODIFY-ROLES')<td><a href="{{ url('roles/' . $role->id . '/permissions') }}" class="btn btn-xs btn-primary">Permissions</a></td>@ENDCAN
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
      $("#roles").DataTable({
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
