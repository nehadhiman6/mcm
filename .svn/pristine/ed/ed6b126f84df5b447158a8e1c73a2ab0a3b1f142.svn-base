@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
  @can('ADD-SUBJECT-CHARGES')
    <div class="row">
      <a href="{{url('/subcharges/create')}}"><button class="btn  btn-flat margin">
          <span>Add Subject Charges</span>
        </button>
      </a>
    </div>
  @endcan
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>Subject With Charges</strong>
    </div>
    <div class="panel-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Course </th>
            <th>Subject</th>
            <th>Practical Fee</th>
            <th>Practical Exam Fee</th>
            <th>Honours Fee</th>
            <th>Honours Exam Fee</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($subcharges as $var)
          <tr>
            <td>{{ $var->course->course_name or '' }}</td>
            <td>{{ $var->subject->subject or '' }}</td>
            <td>{{ $var->pract_fee }}</td>
            <td>{{ $var->pract_exam_fee }}</td>
            <td>{{ $var->hon_fee }}</td>
            <td>{{ $var->hon_exam_fee }}</td>
            @can('EDIT-SUBJECT-CHARGES')<td><a href="{{ url('/subcharges/'.$var->id.'/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>@endcan
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop