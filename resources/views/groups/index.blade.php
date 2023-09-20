@extends('app')
@section('toolbar')
@include('toolbars._users_toolbar')
@stop
@section('content')
  @can('MODIFY-GROUPS')
    @if(isset($group))
      @include('groups.edit')
    @else
      @include('groups.create')
    @endif
  @endcan
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>Groups</strong>
    </div>
    <div class="panel-body">
      <table class='table table-bordered' id='groups'>
        <thead>
          <tr>
            <th>Group</th>
            @if( hasAccessToMenuOption(['MODIFY-GROUPS','MODIFY-GROUP-PERMISSION']))
              <th>Action</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @foreach($groups as $group)
          <tr>
            <td>{{ $group->group_name }}</td>
            <td>
                @can('MODIFY-GROUPS')
                  <a href="{{ url('groups/' . $group->id . '/edit') }}" class="btn btn-xs btn-primary">
                    <i class="fa fa-pencil-square-o" aria-hidden="true">Edit</i>  
                  </a>
                @endcan
                @can('MODIFY-GROUP-PERMISSION')
                  <a href="{{ url('groups/' . $group->id . '/permissions') }}" class="btn btn-xs btn-primary">Permissions</a>
                @endcan
            </td>
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
      $("#groups").DataTable({
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