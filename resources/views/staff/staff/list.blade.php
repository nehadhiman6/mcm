<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Staff List</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="staffTable">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Gender</th>
          <th>Designation</th>
          <th>Department</th>
          <th>Mobile</th>
          <th>Email</th>
          <th>Address</th>
          <th>Remarks</th>
          @if(auth()->user()->hasRole('TEACHERS'))
          @else
          <th>Action</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @php $i=1 @endphp
        @foreach($staffs as $staff)
         <tr>
          <td>{{ $i }}</td>
          <td>{{ $staff->first_name }}</td>
          <td>{{ $staff->last_name }}</td>
          <td>{{ $staff->gender }}</td>
          <td>{{ $staff->desig_id }}</td>
          <td>{{ $staff->dept_id }}</td>
          <td>{{ $staff->mobile }}</td>
          <td>{{ $staff->email }}</td>
          <td>{{ $staff->address }}</td>
          <td>{{ $staff->remarks }}</td>
          @if(auth()->user()->hasRole('TEACHERS'))
          @else
          <td>
            <a href="{{ url('staff/' . $staff->id . '/edit') }}" class="btn btn-primary">Edit</a>
          </td>
          @endif
        </tr>
        @php $i++; @endphp
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@section('script')
    <script>
         $(function () {
            $("#staffTable").DataTable();
        });
    </script>
@stop