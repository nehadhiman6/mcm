@extends('app')

@section('toolbar')
    @include('toolbars._maintenance_toolbars')
@stop

@section('content')
     @can('ADD-LOCATIONS')   
        @if(isset($location))
            @include('locations.edit')
        @else
            @include('locations.create')
        @endif
    @endcan

    <div class='panel panel-default' id="locations">
        <div class='panel-heading'>
            <strong>Locations List</strong>
        </div>
        <div class='box-body'>
            <table id="dt-locations" class='table table-bordered table-striped' width="100%">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Department</th>
                        <th>Type</th>
                        <th>Block</th>
                        <th>Is Store</th>
                        <th>Operated By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locations as $location)
                    <tr>
                        <td>{{$location->location}}</td>
                        <td>{{$location->department->name or ''}}</td>
                        <td>{{$location->type or ''}}</td>
                        <td>{{$location->block->name or ''}}</td>
                        <td>{{$location->is_store or ''}}</td>
                        <td>{{$location->user->name or ''}}</td>
                        @can('EDIT-LOCATIONS')
                            <td><a href="{{ url('locations/' . $location->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('script')
    <script>
    var sm = new Vue({
        el: '#locations',
        data: {
        },
        ready:function(){
            console.log('dfsfa');
            $(function () {
                $('#dt-locations').DataTable({
                        dom: 'Bfrtip',
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        'pageLength':10,
                        "autoWidth": false,
                        "scrollX": true,
                        buttons: [
                        'pageLength',
                        ],
                    });
              });
            // $("#dt-locations").DataTable();
        }

    });
    </script>
@stop