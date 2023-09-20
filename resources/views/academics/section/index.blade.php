@extends('app')

@section('toolbar')
    @include('toolbars._academics_toolbar') 
@stop

@section('content')
    @can('ADD-SECTIONS')
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">New Section</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['url' => 'section', 'class' => 'form-horizontal']) !!}
                @include('academics.section.form')
            </div>
            <div class="box-footer">
                {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    @endcan
    <div class='panel panel-default'>
        @include('academics.section.list')
    </div>
@stop