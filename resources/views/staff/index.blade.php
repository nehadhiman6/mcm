@extends('app')

@section('toolbar')
    @include('toolbars._staff_toolbar')
@stop

@section('content') 
    @include('staff.designation.form')
@stop