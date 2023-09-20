@extends('app')
@section('toolbar')
@include('toolbars._purchase_toolbar')
@stop
@section('content')
@can('add-inv-purchase')
  <div class="box" style="background:none;box-shadow:none">
      <a href="{{url('purchases/create')}}">
          <button class="btn  btn-flat margin">
              <span>Add Purchase</span>
          </button>
      </a>
  </div>
@endcan
<div class="box">
  <div class="box-header">
    <h3 class="box-title">Purchases</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Vendor</th>
          <th>Purchase Date</th>
          <th>Bill No</th>
          <th>Bill Date</th>
          <th>Store Loc</th>
          <th>Grant</th>
          @can('inv-edit-purchase')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($purchases as $purchase)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $purchase->vendor->vendor_name or ''}}</td>
          <td>{{ $purchase->trans_dt}}</td>
          <td>{{ $purchase->bill_no}}</td>
          <td>{{ $purchase->bill_dt}}</td>
          <td>{{ $purchase->locations ? $purchase->locations->location : ''}}</td>
          <td>{{ $purchase->grant}}</td>
          <td>@can('inv-edit-purchase')<a class="btn btn-primary btn-xs" href="{{ url('purchases/' . $purchase->id . '/edit') }}">Edit</a>@endcan</td>
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