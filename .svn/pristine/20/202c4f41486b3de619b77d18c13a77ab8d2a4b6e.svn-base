@extends('app')
@section('toolbar')
@include('toolbars._item_toolbar')
@stop
@section('content')

@can('add-inv-item')
  <div class="box" style="background:none;box-shadow:none">
      <a href="{{url('items/create')}}">
          <button class="btn  btn-flat margin">
              <span>Add Item</span>
          </button>
      </a>
  </div>
@endcan
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Items</strong>
  </div>
  <!-- /.panel-header -->
  <div class="panel-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Item</th>
          <th>Unit</th>
          <th>Code</th>
          <th>Consumable</th>
          <th>Category</th>
          <th>Sub Category</th>
          <th>Remarks</th>
          @can('inv-edit-item')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
        <?php $i=1 ?>
        @foreach($items as $item)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $item->item or '' }}</td>
          <td>{{ $item->unit or '' }}</td>
          <td>{{ $item->item_code or '' }}</td>
          <td>{{ $item->consumable != '' ? $item->consumable == 'Y' ? 'Yes' : 'No'  : ''}}</td>
          <td>{{ $item->item_category->category or '' }}</td>
          <td>{{ $item->item_sub_category->category or '' }}</td>
          <td>{{ $item->remarks or '' }}</td>
          <td>@can('inv-edit-item')<a class="btn btn-primary btn-xs" href="{{ url('items/' . $item->id . '/edit') }}">Edit</a>@endcan</td>
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
    $("#example1").DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,     
      scrollY: "300px",
      scrollX: true,
      scrollCollapse: true,
      fixedColumns: {
        leftColumns: 1,
        rightColumns: 1
      }
    });
  });
</script>
@stop
