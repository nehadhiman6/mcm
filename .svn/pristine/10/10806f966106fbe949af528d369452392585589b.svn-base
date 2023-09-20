@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="row">
  @can('ADD-COURSES')
    <a href="{{url('/courses/create')}}">
      <button class="btn  btn-flat margin">
        <span>Add Courses</span>
      </button>
    </a>
  @endcan
  @can('ADD-ON-COURSES')
    <a href="{{url('/courses/add-on/create')}}">
      <button class="btn  btn-flat margin">
        <span>Add add-on-Courses</span>
      </button>
    </a>
  @endcan
</div>
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Courses</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1">
      <thead>
        <tr>
          <th>S.No</th>
          <th>Course Code</th>
          <th>Course Name</th>
          <th>Starting Rollno</th>
          <th>Ending Rollno</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($courses as $course)
        <tr>
          <td>{{$course->sno}}</td>
          <td>{{$course->class_code}}</td>
          <td>{{$course->course_name}}</td>
          <td>{{$course->st_rollno}}</td>
          <td>{{$course->end_rollno}}</td>
          <td>{{$course->status}}</td>
          <td>
            @can('EDIT-COURSES')<a href="{{ url('courses/' . $course->id . '/edit') }}"><button class="btn btn-sm btn-primary">Edit</button></a>@endcan
            @can('SUBJECT-COURSES')<a  href="{{ url('courses/' . $course->id . '/subjects') }}"><button class="btn btn-sm btn-primary">Subjects</button></a>@endcan
            @can('COURSE-ATTACHMENT')<a  href="{{ url('courses/' . $course->id . '/inst-attachment') }}"><button class="btn btn-sm btn-primary" style="margin-top:5px">Attachment</button></a>@endcan
            
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
        </tr>
      </tfoot>
    </table>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example2">
      <thead>
        <tr>
          <th>Course Name</th>
          <th>Short Name</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($add_on_courses as $add_course)
        <tr>
          <td>{{$add_course->course_name}}</td>
          <td>{{$add_course->short_name}}</td>
          @can('EDIT-COURSES-TWO')
            <td>
              <a href="{{ url('courses/add-on/' . $add_course->id . '/edit') }}"><button class="btn btn-sm btn-primary">Edit</button></a>
            </td>
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