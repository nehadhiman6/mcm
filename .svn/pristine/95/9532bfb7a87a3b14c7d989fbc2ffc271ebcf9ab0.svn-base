@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
  @can('ADD-RESERVED-CATEGORIES')
    <div class="row">
      <a href="{{url('/resvcategories/create')}}"><button class="btn  btn-flat margin">
          <span>Add Res.Category</span>
        </button></a>
    </div>
  @endcan
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Reserved Categories</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1">
      <thead>
        <tr>
          <th>Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr>
          <td>{{$category->name}}</td>
          @can('EDIT-RESERVED-CATEGORIES')
            <td>
              <a href="{{ url('resvcategories/' . $category->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a>
            </td>
          @endcan
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
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