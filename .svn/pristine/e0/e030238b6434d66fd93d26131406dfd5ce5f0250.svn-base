@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class='panel panel-default'>
    <div class='panel-heading'>
        <strong>Courses</strong>
    </div>
    <div class='panel-body'>
        <table class="table table-bordered" id="example1">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Course Name</th>
                    <th>No of Students</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              <?php $i =1 ?>
                @foreach($courses as $course)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$course['course_name'] or ''}}</td>
                        <td>{{ getStudentsByCourse($course['id'])}}</td>
                        @can('ALUMNI-EXPORT-BUTTON')
                          <td>
                              <a href="{{ url('export_to_alumni/' . $course['id']) }}">
                                  <button class="btn btn-sm btn-primary">Export</button>
                              </a>
                          </td>
                        @endcan
                    </tr>
                    <?php $i++ ?>
                @endforeach
            </tbody>
        </table>
  </div>
{{-- 
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
          <td>
            <a href="{{ url('courses/add-on/' . $add_course->id . '/edit') }}"><button class="btn btn-sm btn-primary">Edit</button></a>
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
        </tr>
      </tfoot>
    </table>
  </div> --}}
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