@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
  @can('ADD-SUBJECTS')
    <div class="row">
      <a href="{{url('/subjects/create')}}"><button class="btn  btn-flat margin">
          <span>Add Subject</span>
        </button></a>
    </div>
  @endcan
  <div class='panel panel-default'>
    <div class='panel-heading'>
      <strong>Subjects</strong>
    </div>
    <div class='panel-body'>
      <table class="table table-bordered" id="example1">
        <thead>
          <tr>
            <th>Univ. Code</th>
            <th>Subject</th>
  <!--                    <th>Type</th>-->
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($subjects as $subject)
          <tr>
            <td>{{$subject->uni_code}}</td>
            <td>{{$subject->subject}}</td>
  <!--                    <td>@if($subject->practical == 'Y')
                Practical
                @endif
            </td>-->
            @can('EDIT-SUBJECTS')<td><a href="{{ url('subjects/' . $subject->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>@endcan
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