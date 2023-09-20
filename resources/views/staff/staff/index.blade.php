@extends('app')

@can('staff-list')
  @section('toolbar')
      @include('toolbars._staff_toolbar')
  @stop
@endcan

@section('content') 
<div class="row">
    <a href="{{url('staff/create')}}">
        <button class="btn  btn-flat margin">
            <span>Add Staff</span>
        </button>
    </a>
</div>
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Staff List</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="staffTable">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Name</th>
          <th>Gender</th>
          <th>Designation</th>
          <th>Faculty</th>
          <th>Nature of Appointment</th>
          <th>Department</th>
          <th>DOB</th>
          <th>Mobile</th>
          <th>Qualification</th>
          <th>D O Aptt</th>
          <th>Email</th>
          <th>Permanent Address</th>
          <th>Residence Address</th>
          <th>Emergency Contact1</th>
          <th>Emergency Contact2</th>
          <th>Library code</th>
          <th>Blood Group</th>
          <th>MCM Joining Date</th>
          <th>D O Confirmation</th>
          <th>Due Date Of Retirement</th>
          <th>Year Wise Retirement</th>
          <th>Left Date</th>
          <th>Photo</th>
          <th>Username</th>
          <th>Pay Scale</th>
          <th>RC/OC Course</th>

          <th>Remarks</th> 
          @if(auth()->user()->hasRole('TEACHERS'))
          @else
          <th>Action</th>
          @endif
        </tr>
      </thead>
        @php $i=1 @endphp
       
        @foreach($staffs as $staff)
         <tr>
            <td>{{ $i }}</td>
            <td>{{ $staff->salutation }} {{  $staff->name }}  {{$staff->middle_name}} {{$staff->last_name}}</td>
            <td>{{ $staff->gender or ''}}</td>
            <td>{{ $staff->desig->name  or '' }}</td>
            <td>{{ $staff->faculty->faculty  or ''}}</td>
            <td>{{ $staff->source  or ''}}</td>
            <td>{{ $staff->dept->name  or ''}}</td>
            <td>{{ $staff->dob or ''}}</td>
            <td>{{ $staff->mobile  or ''}}</td>
            <td>
            <!-- @php $details =''; @endphp -->
              @foreach($staff->qualifications as $qul)
                        @php 
                          $details = ($details == '') ? '' : ',';
                          $details .= $qul->exam ;
                        @endphp
                      {{$details}}
              @endforeach


            </td>
            <td>
            
            {{$staff->mcm_joining_date . ' as '}}
            {{$staff->first_designation->old_desig->name or $staff->desig->name}}
            @foreach($staff->promotions as $pro)
                        @php 
                          $details = ($details == '') ? '' : '/';
                          $details .= $pro->promotion_date . ' as '.$pro->new_desig->name ;
                        @endphp
                   {{ $details }}
            @endforeach
            </td>
            <td>{{ $staff->email  or ''}}</td>
            <td>{{ $staff->address or ''}}</td>
            <td>{{ $staff->address_res or '' }}</td>
            <td>{{ $staff->emergency_contact or '' }}  @if($staff->emergency_relation)(@endif{{$staff->emergency_relation}}@if($staff->emergency_relation))@endif</td>
            <td>{{ $staff->emergency_contact2 or ''}} @if($staff->emergency_relation2)(@endif{{$staff->emergency_relation2}}@if($staff->emergency_relation2))@endif</td>
            <td>{{ $staff->library_code or ''}}</td>
            <td>{{ $staff->blood_group or ''}}</td>
            <td>{{ $staff->mcm_joining_date or ''}}</td>
            <td>{{ $staff->confirmation_date or ''}}</td>
            <td>{{ $staff->retire_date or '' }}</td>
            <td>
              @php
                  $date = $staff->retire_date ;
                  $dt = $date != '' ? strtotime($date) : '';
                  
                @endphp
                @if($dt != '')
                  {{date('Y',$dt)}}
                @endif
            </td>
            <td>{{ $staff->left_date or ''}}</td>
            <td>
                @if($staff->user && $staff->user->image)
                  <a target="_blank" href="{{ url('user-image')}}/{{$staff->user->image->id}}"/>{{$staff->user->image->id}}</a>
                @endif
            </td>
            <td>{{ $staff->user->name or ''}} / {{ $staff->user->email or ''}}</td>
            <td>{{ $staff->pay_scale or '' }}</td>
            <td>
            @php $details =''; @endphp
              @foreach($staff->courses as $cou)
                        @php 
                          $details = ($details == '') ? '' : ',';
                          $details .= $cou->courses ;
                        @endphp
                      {{$details}}
              @endforeach


            </td>
            <td>{{ $staff->remarks or '' }}</td>
            @can('staff-modify')
              @if(auth()->user()->hasRole('TEACHERS'))
              @else
                <td>
                  <a href="{{ url('staff/' . $staff->id . '/edit') }}" class="btn btn-primary iw-mb-1">Edit</a>
                  @if(!$staff->left_date)
                    <a href="{{ url('staff/' . $staff->id . '/left') }}" class="btn btn-primary ">Left</a>
                  @else
                    <a href="{{ url('staff/' . $staff->id . '/rejoin') }}" class="btn btn-primary">Rejoin</a>
                  @endif
                  <!-- @can('staff-courses')
                    <a href="{{ url('staff-courses/' . $staff->id) }}" class="btn btn-primary iw-mb-1">Course</a>
                  @endcan -->
                  @can('staff-promotion')
                    <a href="{{ url('staff-promotion/' . $staff->id) }}" class="btn btn-primary ">Promotion</a>
                  @endcan
                </td>
              @endif
            @endcan
        </tr>
        @php $i++; @endphp
        @endforeach
    </table>
  </div>
</div>
@stop

@section('script')
  <script>
    $(function () {
      $("#staffTable").DataTable({
        dom: 'Bfrtip',   
        scrollY: "300px",
        scrollX: true,
        buttons: [
            'pageLength', 'excel'
        ],
        fixedColumns: {
          leftColumns: 1,
          rightColumns: 1
        }
      });
    });
  </script>
@stop
