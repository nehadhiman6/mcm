@extends('app')

@section('toolbar')
  @include('toolbars._vendors_toolbar')
@stop

@section('content')

@can('add-inv-vendor')
  <div class="box" style="background:none;box-shadow:none">
      <a href="{{url('vendors/create')}}">
          <button class="btn  btn-flat margin">
              <span>Add Vendor</span>
          </button>
      </a>
  </div>
@endcan
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Vendors</strong>
  </div>
  <!-- /.panel-header -->
  <div class="panel-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Address</th>
          <th>Contact No.</th>
          <th>Contact Person</th>
          <th>Deal Type</th>
          @can('inv-edit-vendor')
            <th>Action</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @foreach($vendors as $vendor)
        <tr>
          <td>{{$vendor->code}}</td>
          <td>{{$vendor->vendor_name}}</td>
          <td>{{$vendor->vendor_address}}</td>
          <td>{{$vendor->contact_no}}</td>
          <td>{{$vendor->contact_person}}</td>
          <td>{{$vendor->deals_in_type_goods}}</td>
          <td>@can('inv-edit-vendor')<a class="btn btn-primary btn-xs" href="{{ url('vendors/' . $vendor->id . '/edit') }}">Edit</a>@endcan</td>
        </tr>
        @endforeach
       </tbody>
    </table>
  </div>
  <!-- /.panel-body -->
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