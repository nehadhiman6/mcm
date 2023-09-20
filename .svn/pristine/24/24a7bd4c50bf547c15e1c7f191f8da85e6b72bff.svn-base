@extends('app')

@section('toolbar')
    @include('toolbars._maintenance_toolbars')
@stop

@section('content')
    @can('ADD-FEEDBACK-SECTIONS')
        @if(isset($feedback_section))
            @include('maintenance.feedback_section.edit')
        @else
            @include('maintenance.feedback_section.create')
        @endif
    @endcan
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Feedback Sections</h3>
        </div>
        <div class="box-body">
            <table class='table table-bordered table-striped' id='example1'>
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Under Section</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedback_sections as $feedback_sec)
                    <tr>
                        <td>{{$feedback_sec->sno}}</td>
                        <td>{{$feedback_sec->name}}</td>
                        <td>{{$feedback_sec->feedback_section->name or ''}}</td>
                        @can('EDIT-FEEDBACK-SECTIONS')
                            <td><a href="{{ url('feedback-sections/' . $feedback_sec->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>
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
    $('#example1').DataTable();
    </script>
@stop