@extends('app')
@section('toolbar')
@include('toolbars._purchase_return_toolbar')
@stop
@section('content')
@can('add-inv-purchase-return')
  <div class="box" style="background:none;box-shadow:none">
      <a href="{{url('purchase-returns/create')}}">
          <button class="btn  btn-flat margin">
              <span>Add Purchase Return</span>
          </button>
      </a>
  </div>
@endcan
<div class="box">
  <div class="box-header">
    <h3 class="box-title">Purchase Returns</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Vendor</th>
          <th>Bill No</th>
          <th>Bill Date</th>
          <th>Store Locations</th>
          @can('inv-edit-purchase-return')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($purchases as $pur_return)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $pur_return->vendor->vendor_name or ''}}</td>
          <td>{{ $pur_return->bill_no}}</td>
          <td>{{ $pur_return->bill_dt}}</td>
          <td>{{ $pur_return->storelocations ? $pur_return->storelocations->location : '' }}</td>
          <td>@can('inv-edit-purchase-return')<a class="btn btn-primary btn-xs" href="{{ url('purchase-returns/' . $pur_return->id . '/edit') }}">Edit</a>@endcan</td>
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