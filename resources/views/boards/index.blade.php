@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
    @can('ADD-BOARD-UNIV')
        <div class="row">
            <a href="{{url('/boards/create')}}"><button class="btn  btn-flat margin">
                    <span>Add Board/Univ.</span>
                </button></a>
        </div>
    @endcan
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <strong>Board/Universities</strong>
        </div>
        <div class='panel-body'>
            <table class="table table-bordered" id="example1">
                <thead>
                    <tr>
                        <th>Board/University</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($boards as $board)
                    <tr>
                        <td>{{$board->name}}</td>
                        @can('EDIT-BOARD-UNIV')
                            <td><a href="{{ url('boards/' . $board->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
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