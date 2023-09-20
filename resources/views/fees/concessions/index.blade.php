@extends('app')

@section('toolbar')
    @include('toolbars._fees_maintenance_toolbar')
@stop

@section('content')
    @can('ADD-CONCESSION')
        <div class="row">
            <a href="{{url('/concessions/create')}}">
                <button class="btn  btn-flat margin">
                    <span>Add Concession</span>
                </button>
            </a>
        </div>
    @endcan
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <strong>Concesssions</strong>
        </div>
        <div class='panel-body'>
            <table class="table table-bordered" id="example1">
                <thead>
                    <tr>
                        <th>Concessions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($concessions as $concession)
                    <tr>
                        <td>{{$concession->name}}</td>
                        @can('EDIT-CONCESSION')
                            <td><a href="{{ url('concessions/' . $concession->id . '/edit') }}" class="btn btn-primary">Edit</a></td>
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