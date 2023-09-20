@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
    @can('ADD-CITIES')
        @if(isset($city))
            @include('cities.edit')
        @else
            @include('cities.create')
        @endif
    @endcan

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>City</th>
                <th>State</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cities as $city)
            <tr>
                <td>{{$city->city}}</td>
                <td>{{$city->state->state}}</td>
                @can('EDIT-CITIES')
                    <td><a href="{{ url('cities/' . $city->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
@stop