@extends('app')
@section('toolbar')
@include('toolbars._ret_toolbar')
@stop
@section('content')
@can('inv-return')
  <div class="box" style="background:none;box-shadow:none">
      <a href="{{url('returns/create')}}">
          <button class="btn  btn-flat margin">
              <span>Add Return</span>
          </button>
      </a>
  </div>
@endcan
<div class="box">
  <div class="box-header">
    <h3 class="box-title">Returns</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Location</th>
          <th>Store Locations</th>
          <th>Staff</th>
          <th>Remarks</th>
          @can('inv-edit-return')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($rets as $ret)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $ret->location->location or ''}}</td>
          <td>{{ $ret->storelocation ? $ret->storelocation->location : ''}}</td>
          @if( $ret->staff != null)
          <td>{{ $ret->staff->name .' '. $ret->staff->middle_name .' '. $ret->staff->last_name  }}</td>
          @else
          <td></td>
          @endif
          <td>{{ $ret->remarks}}</td>
          <td>@can('inv-edit-return')<a class="btn btn-primary btn-xs" href="{{ url('returns/' . $ret->id . '/edit') }}">Edit</a>@endcan</td>
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