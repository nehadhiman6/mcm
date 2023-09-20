@extends('app')

@section('toolbar')
    @include('toolbars._fees_maintenance_toolbar')
@stop

@section('content')
    @can('ADD-INSTALLMENTS')
        <div class="row">
            <a href="{{url('/installments/create')}}"><button class="btn  btn-flat margin">
                    <span>Add Installment</span>
                </button></a>
        </div>
    @endcan
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <strong>Installments</strong>
        </div>
        <div class='panel-body'>
            <table class="table table-bordered" id="example1">
                <thead>
                    <tr>
                        <th>Installments</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($installments as $install)
                        <tr>
                            <td>{{$install->name}}</td>
                            @can('EDIT-INSTALLMENTS')
                                <td><a href="{{ url('installments/' . $install->id . '/edit') }}" class="btn btn-primary">Edit</a></td>
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