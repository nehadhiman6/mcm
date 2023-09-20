@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="row">
  <a href="{{ url('courses') }}"><button class="btn  btn-primary margin">
      <span>Go Back</span>
    </button>
  </a>
  <a href="{{ url('courses/' . $course->id . '/addsubject') }}"><button class="btn  btn-flat margin">
      <span>Add Subject</span>
    </button>
  </a>
  <a href="{{ url('courses/' . $course->id . '/subgroup') }}"><button class="btn  btn-flat margin">
      <span>Add Sub.Group</span>
    </button>
  </a>
  <a href="{{ url('courses/' . $course->id . '/electives') }}"><button class="btn  btn-flat margin">
      <span>Add Electives</span>
    </button>
  </a>
</div>
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>{{$course->course_name}}: Subjects And Subject Group</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1">
      <thead>
        <tr>
        <th>Code</th>
          <th>Subjects</th>
          <th>Optional/Compulsory</th>
          <th>Semester</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($course->subjects as $subject)
        <tr>
        <td>{{ $subject->uni_code }}</td>
          <td>{{ $subject->subject->subject or '' }}</td>
          <td>
            @if ($subject->sub_type == 'C')
            Compulsory
            @else
            @if ($subject->sub_type == 'O')
            Optional
            @else
            Elective
            @endif
            @endif
          </td>
          <td>{{ getSemestersName($subject->semester) }}</td>
          <td><a href="{{ url('courses/' . $subject->id . '/editsubject') }}" class="btn btn-primary btn-xs">Edit</a>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tfoot>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Group Name</th>
          <th>Optional/Compulsory</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($course->subgroups as $subgrp)
        <tr>
          <td>{{ $subgrp->s_no }}</td>
          <td>{{ $subgrp->group_name }}</td>
          <td> 
            @if ($subgrp->type == 'C')
            Compulsory
            @else
            @if ($subgrp->type == 'O')
            Optional
            @endif
            @endif
          </td>
          <td><a href="{{ url('courses/' . $subgrp->id . '/editgroup') }}" class="btn btn-primary btn-xs">Edit</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Electives Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($course->electives as $elective)
        <tr>
          <td>{{ $elective->name }}</td>
          <td><a href="{{ url('electives/' . $elective->id ) }}" class="btn btn-primary btn-xs">Edit</a>
           <a href="{{ url('electives/'. $course->id . '/' . $elective->id . '/addsubjects') }}" class="btn btn-primary btn-xs">subjects</a> 
           <a href="{{ url('electives/'. $course->id . '/'. $elective->id . '/' . 'addgroup') }}" class="btn btn-primary btn-xs">Group</a></td>
        </tr>
        @endforeach
      </tbody>
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