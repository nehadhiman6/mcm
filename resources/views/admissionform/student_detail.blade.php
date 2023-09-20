@extends($dashboard)
@section('content')
@if($adm_form->consent && $adm_form->consent->ask_student == 'Y' && $adm_form->consent->student_answer == 'R')
<div>
  <div class="alert alert-warning" role="alert">Your consent is now available to submit! Please submit your consent
  </div>
</div>
@elseif($adm_form->consent && $adm_form->consent->ask_student == 'N')
<div>
  <div class="alert alert-success" role="alert">Form Successfully processed by college.</div>
</div>
@endif
{{-- 1111 --}}
<div class="process">
  <div class="process-row nav nav-tabs">
    <div class="process-step">
      @if($adm_form->terms_conditions == 'Y' && $adm_form->active_tab == 6)
      <button type="button" class="btn btn-info btn-circle"><i class="fa fa-check  fa-3x"></i></button>
      @else
      <button type="button" class="btn btn-default btn-circle">
        <i class="fa fa-file-text  fa-3x"></i>
      </button>
      @endif
      <p><small>Fill Admission<br>Form</small></p>
    </div>

    <div class="process-step">
      @if($adm_form && $adm_form->fee_paid =='Y' )
      <button type="button" class="btn btn-info btn-circle"><i class="fa fa-check  fa-3x"></i></button>
      @else
      <button type="button" class="btn btn-default btn-circle"><i class="fa fa-inr fa-3x"></i></button>
      @endif
      <p><small>College Processing Fees<br></small></p>
    </div>
    @if($adm_form )
    <div class="process-step">
      @if(!$adm_form->hostel_form)
      <button type="button" class="btn  btn-circle" disabled=""><i class="fa fa-home fa-3x"></i></button>
      @else
      <button type="button" class="btn btn-info btn-circle"><i class="fa fa-check  fa-3x"></i></button>
      @endif
      <p><small>Hostel<br>Form (optional) </small></p>
    </div>
    @endif
    @if($adm_form->hostel_form)
    <div class="process-step">
      @if($adm_form->hostel_form && $adm_form->hostel_form->fee_paid == 'Y' )
      <button type="button" class="btn btn-info btn-circle"><i class="fa fa-check  fa-3x"></i></button>
      @else
      <button type="button" class="btn btn-default btn-circle"><i class="fa fa-inr fa-3x"></i></button>
      @endif

      <p><small>Hostel Processing Fees<br></small></p>
    </div>
    @endif
    <div class="process-step">
      @if($adm_form->final_submission == 'Y')
      <button type="button" class="btn btn-info btn-circle"><i class="fa fa-check fa-3x"></i></button>
      @else
      <button type="button" class="btn btn-default btn-circle" href="#menu4"><i
          class="fa fa-arrow-circle-up fa-3x"></i></button>
      @endif
      <p><small>Final<br>Submission</small></p>
    </div>

    @if($adm_form->final_submission == 'Y' )
    <div class="process-step">
      @if(!$adm_form->consent)
      <button type="button" style="color:grey" disabled class="btn btn-default btn-circle"><i
          class="fa fa-list-alt fa-3x"></i></button>
      @elseif($adm_form->consent && $adm_form->consent->ask_student == 'Y' && $adm_form->consent->student_answer == 'R')
      <a href="{{url('student-consent')}}"><button type="button" class="btn btn-default btn-circle"><i
            class="fa fa-list-alt fa-3x"></i></button></a>
      @elseif($adm_form->consent && (($adm_form->consent->ask_student == 'Y' && $adm_form->consent->student_answer !=
      'R' ) || $adm_form->consent->ask_student == 'N' ))
      <button type="button" class="btn btn-info btn-circle"><i class="fa fa-check fa-3x"></i></button>

      @endif
      <a href="{{url('student-consent')}}">
        <p><small>Consent Submission<br>
      </a>
      @if(!$adm_form->consent)
      <br>(This will be available soon <br>after college processing)</small></p>
      @elseif($adm_form->consent && $adm_form->consent->ask_student == 'Y' && $adm_form->consent->student_answer == 'R')
      <br><strong>Available!<strong> <br>(Please submit your consent)</small></p>
          @elseif($adm_form->consent && $adm_form->consent->ask_student == 'Y' && $adm_form->consent->student_answer !=
          'R' )
          Consent Submitted!
          @elseif($adm_form->consent && $adm_form->consent->ask_student == 'N' )
          <br><strong>Not applicable <strong> <br></small></p>
              @endif
    </div>
    @endif
  </div>
</div>

@if( $adm_form->fee_paid =='N' )
    <div class='panel panel-default'>
      <div class='panel-heading'>
        <strong style="color:red">Your College Processing Fees is Still Pending !</strong>
      </div>
     
    </div>
  @endif

  @if( $adm_form->final_submission == 'N' || $adm_form->attachment_submission	 == 'N')
    <div class='panel panel-default'>
      <div class='panel-heading'>
        <strong style="color:red">Your Final Submission is Still Pending !</strong>
      </div>
     
    </div>
  @endif
      

@if(isset($guard) && $guard == 'students')
  @if(!$adm_form->student || $adm_form->student->adm_cancelled == 'Y')
    <!-- @include('online.admissions.form_instructions') -->
  @endif

  @if($adm_form->admEntry)
    <a  href="{{ url('std-adm-entry/printslip') }}" target="_blank" class="btn btn-warning ">Show Admission Entry Slip</a>
  @endif
  @if($adm_form->final_submission == 'Y')
    @if($adm_form->admEntry)
    <a  href="{{ url('payadmfees/create') }}" target="_blank" class="btn btn-warning ">Admission Fee Payment</a>
    @endif
  @endif

  @if($adm_form->student && $adm_form->student->course->status == 'GRAD' && $adm_form->student->course->course_year == 1 )
    <div class='panel panel-default'>
      <div class='panel-body' style="font-size: 15px;">
        In view of the extension in the admission dates by Panjab University, classes will be starting from Monday,  24th July 2023. Time table and schedule of entry level classes will be shared on the dashboard accordingly.
      </div>

    </div>
  @endif
  @if($adm_form->student)
    <div class='panel panel-default'>
      <div class='panel-body' style="font-size: 15px;">
          All students/parents coming for hostel entry tomorrow ie on 23/7/23 should note that entry from main gate will be after 12:00 noon.
      </div>
    </div>
  @endif
  {{-- @if($adm_form->student && $adm_form->student->course->status == 'GRAD' && $adm_form->student->course->course_year == 1 )
    <div class='panel panel-default'>
      <div class='panel-heading'>
        <strong>Online classes for Ist year UG Classes:</strong>
      </div>
      <div class='panel-body' style="font-size: 15px;">
        The official Gmail ID of the student for attending online classes through Google Classroom is her ‘Roll no’ immediately followed by ‘First name’  at domain name - <b>mcmdavcwchd.in</b>
        For example.. <u>if a student's Roll no. is 1234 and her first name is Neha</u> then her Gmail ID will be <b>1234neha@mcmdavcwchd.in</b>. Her password will be <b>NEHA1234 (password is in Capital letters)</b>.
        If a password does not work for a student, student should try entering password with or without underscore (in both ways) as the last character. However it is mandatory to change password after first login. All can access their Email IDs through Gmail.com.
        
        <p style="padding-top:4px"><strong>Note:</strong> For any other query regarding official Gmail ID (for Google classroom), you can contact at <b>nancysharma@mcmdavcwchd.in</b></p>
      
      </div>

    </div>
  @endif --}}

  {{-- @if($adm_form->student && $adm_form->student->course->course_year > 1 )
    <div class='panel panel-default'>
      <div class='panel-heading'>
        <strong>Online classes for 2nd/3rd year of UG and 2nd year of PG students:</strong>
      </div>
      <div class='panel-body'>
        The official Gmail ID of the student for attending online classes through Google Classroom is her ‘First name’ immediately followed by ‘Roll no’ at domain name - mcmdavcwchd.in
        <br>
        For example, if the ‘First name’ of the student is Shruti and her roll no is 1100 then her Gmail ID is shruti1100@mcmdavcwchd.in . Her password is SHRUTI1100_ (password is in Capital letters).
      </div>
    </div>
  @endif --}}

 {{-- <div class='panel panel-default'>
    <div class='panel-body'>
      <strong>Note:</strong> For any other query regarding official Gmail ID (for Google classroom), you can contact at <b>nancysharma@mcmdavcwchd.in</b>
      {{-- <br>
      For any other query regarding official Gmail ID (for Google classroom), you can contact at nancysharma@mcmdavcwchd.in or call Ms. Nancy: 9646998717 
    </div>
  </div> --}}
@endif
@if(count($adm_form->discrepancy) > 0 && $adm_form->scrutinized == 'N' && $adm_form->attachment_submission == 'N')
  <div class='panel panel-default' >
      <div class='panel-heading'>
          <strong style="color:red">Following discrepancies have been found in the Form:</strong>
      </div>
      <div class='panel-body'>
        <div class="col-sm-8">
            @foreach ($adm_form->discrepancy as $det )
              @if($det->opt_name == 'form_not_submit' && $det->opt_value == 'Y')
                <p><strong class='p-head'>- Final Submission pending</p>
              @elseif($det->opt_name == 'document_pending' && $det->opt_value == 'Y')
              <p><strong class='p-head'>- Document Pending (See Remarks column)</p>
              @elseif($det->opt_name == 'consent_awaited' && $det->opt_value == 'Y')
              <p><strong class='p-head'>- Your Consent Awaited</p>
              @elseif($det->opt_name == 'admission_fee_not_paid' && $det->opt_value == 'Y')
              <p><strong class='p-head'>- Your Admission Fee Not paid</p>
              @elseif($det->opt_name == 'other' && $det->opt_value == 'Y') 
              <p><strong class='p-head'>- Other</p>
              @elseif($det->opt_name == 'discrepancy_resolved' && $det->opt_value == 'Y')
              <p><strong class='p-head'>- Form Discrepancy Resolved</p>
              @endif
            @endforeach
            @if(isset($discrepancy_remarks) && $discrepancy_remarks)
              <p><strong class='p-head'>Remarks:</strong> {{ $discrepancy_remarks }}</p>
            @endif
              <p><strong style="color:red"><i>Applicant is advised to do the needful within stipulated time. If you make changes in the form or under 'Attachment' section, click 'Final Submission' again.</i></strong></p>

              <p><strong style="color:blue"><i>Note: Admission team might take some time to recheck and verify the discrepancy you have resolved at your end. Kindly wait for updated status till then</i></strong></p>

          </div>
      </div>
  </div>
@endif
{{-- @if($adm_form->scrutinized == 'Y' && $adm_form->course->course_year == 1)
  <div class='panel panel-default' >
      <div class='panel-heading'>
          <strong style="color:red">Message:</strong>
      </div>
      <div class='panel-body'>
        <div class="col-sm-12">
          <p><strong class='p-head'>Dear Applicant</strong></p>
          <p><strong class='p-head'>Your admission form has been approved, fee slip will be generated 16/8/22 onwards as per schedule.</strong></p>
          <p><strong class='p-head'>Your admission will be provisional till the verification of original documents and approval from Panjab University.</strong></p>
          <p><strong style="color:blue">Note: Subjects combination preference (wherever applicable) will be alloted as per merit, before fee slip generation.</strong></p>
      </div>
  </div>
@endif --}}

{{-- @if($adm_form->adm_entry_id != null && $adm_form->course->class_code == 'BAI')
  <div class='panel panel-default' >
      <div class='panel-heading'>
          <strong style="color:red">Message:</strong>
      </div>
      <div class='panel-body'>
        <div class="col-sm-12">
          <p><strong class='p-head'>Dear Student,</strong></p>
          <p><strong class='p-head'>BA 1 classes will begin on 25 August 2022 and the time table will be displayed on the student dashboard on 24 August 2022. For this, click 'Time Table' option given on left pane in student dashboard.</strong></p> --}}
          {{-- <p><strong class='p-head'>Your admission will be provisional till the verification of original documents and approval from Panjab University.</strong></p>
          <p><strong style="color:blue">Note: Subjects combination preference (wherever applicable) will be alloted as per merit, before fee slip generation.</strong></p> --}}
      {{-- </div>
  </div>
@endif --}}

@if($adm_form->scrutinized == 'H')
  <div class='panel panel-default' >
      <div class='panel-heading'>
          <strong style="color:red">Regarding Hostel Seat:</strong>
      </div>
      <div class='panel-body'>
        <div class="col-sm-12">
          <p><strong class='p-head'>Dear Applicant</strong></p>
          <p><strong class='p-head'>Your hostel seat has been approved. To confirm the seat, please pay the hostel fee by clicking the option 'Pay Hostel dues'</br> in left pane  and click 'Show' button to proceed. Ignore if already paid</strong></p>
          {{-- <p><strong class='p-head'>Your admission will be provisional till the verification of original documents and approval from Panjab University.</strong></p>
          <p><strong style="color:blue">Note: Subjects combination preference (wherever applicable) will be alloted as per merit, before fee slip generation.</strong></p> --}}
      </div>
  </div>
@endif


<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Detail</strong>
    <div class="pull-right">
        <li type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Instructions</li>                  
      </div>
  </div>
  <div class='panel-body'>
    <fieldset>
      <legend>Student's Details</legend>
      <div class="col-sm-4">
        <p><strong class='p-head'>Name:</strong> {{ $adm_form->name }}</p>
        <p><strong class='p-head'>Mobile:</strong> {{ $adm_form->mobile }}</p>
        <p><strong class='p-head'>Gender:</strong> {{$adm_form->gender}}</p>
        <p><strong class='p-head'>Religion:</strong>{{ $adm_form->religion }}</p>

      </div>
      <div class="col-sm-4">
        <p><strong class='p-head'>Date Of Birth:</strong> {{ $adm_form->dob }}</p>
        <p><strong class='p-head'>Address:</strong> {{ $adm_form->per_address }}</p>
        <p><strong class='p-head'>Pincode:</strong> {{ $adm_form->pincode }}</p>
        <p><strong class='p-head'>Aadhar Number:</strong>{{ $adm_form->aadhar_no }}</p>

      </div>
      <div class="col-sm-4">
        <p><strong class='p-head'>Category:</strong>{{ $adm_form->category->name or '' }}</p>
        <p><strong class='p-head'>Reserved Category:</strong>{{ $adm_form->res_category->name or '' }}</p>
        <p><strong class='p-head'>Nationality:</strong>{{ $adm_form->nationality }}</p>
        <p><strong class='p-head'>EPIC No:</strong>{{ $adm_form->epic_no }}</p>

      </div>
    </fieldset>
    <fieldset>
      <legend>Parent Details</legend>
      <div class="row">
        <div class="col-lg-4 col-sm-12">
          <legend>
            <h4> Father's Details</h4>
          </legend>
          <p><strong class='p-head'>Name:</strong>{{ $adm_form->father_name or '' }}</p>
          <p><strong class='p-head'>Occupation:</strong>{{ $adm_form->father_occup or '' }}</p>
          <p><strong class='p-head'>Designation:</strong>{{ $adm_form->father_desig or '' }}</p>
          <p><strong class='p-head'>Phone No.:</strong>{{ $adm_form->father_phone or '' }}</p>
          <p><strong class='p-head'>Mobile No.:</strong>{{ $adm_form->father_mobile or '' }}</p>
          <p><strong class='p-head'>Email:</strong>{{ $adm_form->father_email or '' }}</p>
          <p><strong class='p-head'>Address:</strong>{{ $adm_form->father_address or '' }}</p>
          <p><strong class='p-head'>Office Address:</strong>{{ $adm_form->f_office_addr or '' }}</p>
        </div>

        <div class="col-lg-4 col-sm-12">
          <legend>
            <h4>Mother's Details</h4>
          </legend>
          <p><strong class='p-head'>Name:</strong>{{ $adm_form->mother_name or '' }}</p>
          <p><strong class='p-head'>Occupation:</strong>{{ $adm_form->mother_occup or '' }}</p>
          <p><strong class='p-head'>Designation:</strong>{{ $adm_form->mother_desig or '' }}</p>
          <p><strong class='p-head'>Phone No.:</strong>{{ $adm_form->mother_phone or '' }}</p>
          <p><strong class='p-head'>Mobile No.:</strong>{{ $adm_form->mother_mobile or '' }}</p>
          <p><strong class='p-head'>Email:</strong>{{ $adm_form->mother_email or '' }}</p>
          <p><strong class='p-head'>Address:</strong>{{ $adm_form->mother_address or '' }}</p>
          <p><strong class='p-head'>Office Address:</strong>{{ $adm_form->m_office_addr or '' }}</p>
        </div>
        <div class="col-lg-4 col-sm-12">
          <legend>
            <h4>Guardian's Details</h4>
          </legend>
          <p><strong class='p-head'>Name:</strong>{{ $adm_form->guardian_name or '' }}</p>
          <p><strong class='p-head'>Occupation:</strong>{{ $adm_form->guardian_occup or '' }}</p>
          <p><strong class='p-head'>Designation:</strong>{{ $adm_form->guardian_desig or '' }}</p>
          <p><strong class='p-head'>Phone No.:</strong>{{ $adm_form->guardian_phone or '' }}</p>
          <p><strong class='p-head'>Mobile No.:</strong>{{ $adm_form->guardian_mobile or '' }}</p>
          <p><strong class='p-head'>Email:</strong>{{ $adm_form->guardian_email or '' }}</p>
          <p><strong class='p-head'>Address:</strong>{{ $adm_form->guardian_address or '' }}</p>
          <p><strong class='p-head'>Office Address:</strong>{{ $adm_form->g_office_addr or '' }}</p>
        </div>
      </div>
  </div>
  </fieldset>
  <fieldset>
    <legend>Academics Details</legend>
    <div class="col-sm-4">
      <p><strong class='p-head'>Panjab Univ. RegNo/PUPIN NO.:</strong> {{ $adm_form->pupin_no  or 'NA'}}</p>
    </div>
    <div class="col-sm-4">
      <p><strong class='p-head'>Panjab Univ. Roll No.:</strong> {{ $adm_form->pu_regno or 'NA'}}</p>
    </div>
  </fieldset>
  @if(isset($student_sub) && isset($course_sub))
  <fieldset>
    <legend>Subjects Details</legend>
      @if(count($student_sub) > 0)
      <div class="row">
        <div class="col-sm-4">
          <p style="font-size: 17px; color: #ff6e41;"><strong class='p-head'>Allotted Subject</strong></p>
          @foreach ($student_sub as $key=>$sub )
          <span>( {{ $key+1 }} )   </span>   {{ $sub->subject }}
          @endforeach
        </div>
      @endif
      <div class="col-sm-4" >
        <p style="font-size: 17px; color: #ff6e41;"><strong class='p-head'>Compulsory Subject</strong> </p>
        @foreach ($course_sub as $key=>$sub )
        <span>( {{ $key+1 }} )   </span>  {{ $sub->subject }}
        @endforeach
      </div>
    @endif
    @if($adm_form->admEntry)
      @if($adm_form->admEntry->honour_sub_id > 0)
        <div class="col-sm-4">
          <p style="font-size: 17px; color: #ff6e41;"><strong class='p-head'> Honour Subject</strong></p>
          {{ $adm_form->admEntry->honour_sub->subject }}
        </div>
      @endif
      @if($adm_form->admEntry->addon_course_id > 0)
        <div class="col-sm-4">
          <p style="font-size: 17px; color: #ff6e41;"><strong class='p-head'>Add On Courses</strong></p>
            {{ $adm_form->admEntry->add_on_course->course_name }}
        </div>
      @endif
    @endif
  </div>
  </fieldset>
  <!--<button class="btn btn-primary" id="add_attachment">Add Attachment</button>-->
  @if(isset($guard) && $guard == 'web')
  <a href="{{ url('admission-form/' . $adm_form->id . '/edit') }}" class="btn btn-primary" id="add_attachment">
    Edit Detail
  </a>
  <a href="{{ url('admission-form/' . $adm_form->id ) }}" class="btn btn-primary" id="add_attachment">
    Preview
  </a>
  @endif
  <div class="box box-info" id="attach" style="display: none; margin-top:20px;">
    @include('admissionform._form_attachment')
  </div>

  <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Instructions (<span>Scroll down to Continue</span>)</h4>
            </div>
            <div class="modal-body">
              @include('admissionformnew.pre_instructions',['mainTitle' => "hide"])
            </div>
            <div class="modal-footer">
              <span class="highlighted-instruction"><b>*Online Centralized Admissions : College admission form to be filled only after allotment of seat at DHE portal</b></span>
              {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
            </div>
          </div>
    </div>
</div>
</div>
@stop
@section('script')
<script>
  $(document).ready(function () {
    $("#add_attachment").click(function () {
      $("#attach").show();
    });
  });
</script>
@stop