@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
    @can('ADD-STATES')
        @if(isset($state))
            @include('states.edit')
        @else
            @include('states.create')
        @endif
    @endcan
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <strong>State List</strong>
        </div>
        <div class='panel-body'>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>State</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($states as $state)
                    <tr>
                        <td>{{$state->state}}</td>
                        @can('EDIT-STATES')
                        <td><a href="{{ url('states/' . $state->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            
            </table>
        </div>
    </div>
@stop
