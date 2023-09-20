@extends('app')
@section('toolbar')
@include('toolbars._issue_toolbar')
@stop
@section('content')
@can('add-inv-issue')
  <div class="box" style="background:none;box-shadow:none">
      <a href="{{url('issues/create')}}">
          <button class="btn  btn-flat margin">
              <span>Add Issue</span>
          </button>
      </a>
  </div>
@endcan
<div class="box">
  <div class="box-header">
    <h3 class="box-title">Issues</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Request No</th>
          <th>Location</th>
          <th>Staff</th>
          <th>Store Locations</th>
          <th>Remarks</th>
          @can('inv-edit-issue')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($issues as $issue)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $issue->request_no or ''}}</td>
          <td>{{ $issue->location->location or ''}}</td>
          @if( $issue->staff != null)
          <td>{{ $issue->staff->name .' '. $issue->staff->middle_name .' '. $issue->staff->last_name  }}</td>
          @else
          <td></td>
          @endif
          <td>{{ $issue->storelocation ? $issue->storelocation->location : ''}}</td>
          <td>{{ $issue->remarks}}</td>
          <td>@can('inv-edit-issue')<a class="btn btn-primary btn-xs" href="{{ url('issues/' . $issue->id . '/edit') }}">Edit</a>@endcan</td>
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