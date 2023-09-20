@extends('app')
@section('toolbar')
@include('toolbars._item_toolbar')
@stop
@section('content')
  @can('add-inv-sub-item-category')
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>{{ isset($category) ? 'Update' : 'Add' }} Categories</strong>
        </div>
        @if(isset($category) && $category)
        {!! Form::model($category, ['method' => 'PATCH', 'action' => ['Inventory\ItemSubCategoryController@update', $category->id], 'class' => 'form-horizontal']) !!}
        @else 
        {!! Form::open(['url' => 'items_sub_categories', 'class' => 'form-horizontal']) !!}
        @endif
        <div class="panel-body">
            <div class="form-group">
                {!! Form::label('category','Category:',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-3"> 
                    {!! Form::text('category',null,['class' => 'form-control']) !!}
                </div>
                <div class='col-sm-2'>
                    @if(isset($category) && $category)
                    {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
                    @else
                    {!! Form::submit('Add',['class' => 'btn btn-primary']) !!}
                    @endif
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
  @endcan

<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Item Sub Categories</strong>
  </div>
  <!-- /.panel-header -->
  <div class="panel-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Category</th>
          @can('inv-edit-sub-item-category')<th>Action</th>@endcan
        </tr>
      </thead>
      <tbody>
          <?php $i=1 ?>
        @foreach($categories as $category)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $category->category }}</td>
          <td>@can('inv-edit-sub-item-category')<a class="btn btn-primary btn-xs" href="{{ url('items_sub_categories/' . $category->id . '/edit') }}">Edit</a>@endcan</td>
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
