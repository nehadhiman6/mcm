@extends('app')

@section('toolbar')
@include('toolbars.opening_stock_toolbar')
@stop

@section('content')
@can('add-opening-stocks')
  <div class="box" style="background:none;box-shadow:none">
      <a href="{{url('opening-stocks/create')}}">
          <button class="btn  btn-flat margin">
              <span>Add Opening Stocks</span>
          </button>
      </a>
  </div>
@endcan
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Opening Stocks</strong>
  </div>
  <!-- /.panel-header -->
  <div class="panel-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Item</th>
          <th>Qty</th>
          <th>Store Locations</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1 ?>
        @foreach($opening_stocks as $opening_stock)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $opening_stock->item->item or '' }}</td>
          <td>{{ $opening_stock->r_qty or '' }}</td>
          <td>{{ $opening_stock->storelocations ? $opening_stock->storelocations->location : '' }}</td>
          @can('modify-opening-stock')
            <td>
              <a class="btn btn-primary btn-xs" href="{{ url('opening-stocks/' . $opening_stock->id . '/edit') }}">Edit</a>
            </td>
          @endcan
        </tr>
        <?php $i++ ?>
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
