@extends('excel')
@section('content')
<div class="box">
  <div class="box-header">
    <h3 class="box-title">
      List of Students
    </h3>
  </div>
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>S. No.</th>
          <th>Online Form No.</th>
          <th>Name</th>
          <th>Father Name</th>
          <th>Course</th>
          <th>Roll No.</th>
          <th>Admission No.</th>
          <th>Contact No.</th>
          <td>Blood Group</td>
          <th>Address</th>
          <th>Signature</th>
          <th>Photograph</th>
        </tr>
      </thead>
      <tbody>
          <?php $i = 1; ?>
        @foreach($students as $std)
        <tr>
          <td>{{ $i}}</td>
          <td>{{ $std->admission_id}}</td>
          <td>{{ $std->name }}</td>
          <td>{{ $std->father_name }}</td>
          <td>{{ $std->course->course_name or '' }}</td>
          <td>{{ $std->roll_no }}</td>
          <td>{{ $std->adm_no }}</td>
          <td>{{ $std->mobile }}</td>
          <td>{{ $std->blood_grp }}</td>
          <td>{{ $std->per_address }} {{ $std->city }}</td>
          <td>
            @if($path = $std->getAttachmentPath('signature'))
            <img alt="example1" src="{{ $path }}" height="42" width="42"/>
            @endif
          </td>
          <td>
            @if($path = $std->getAttachmentPath())
            <img alt="example1" src="{{ $path }}" height="42" width="42"/>
            @endif
          </td>
        </tr>
        <?php $i++; ?>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@stop
