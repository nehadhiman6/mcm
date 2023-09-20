@extends('online.dashboard')
@section('content')
<section class="invoice">
  <div class="header">
    <div class="logo">
      <img src="{{ asset("/dist/img/logo_2.PNG") }}" height= "55">
    </div>
    <div class="title">
      <strong>Sri Guru Gobind Singh College, Sector 26, Chandigarh</strong><br>
      APPLICATION FORM FOR ADMISSION (SESSION 2016-17)
    </div>
    <div class="form-class">
      <strong>  Form No</strong> : {{ $student->id }}<br>
    </div>
  </div>
  <!-- info row -->
  <div class="row">
    <div class="col-sm-6 col-sm-offset-4">
      <div class="title"><b>Class:</b> {{$student->course->course_name}}</div>
    </div>
  </div>
  <div class="row invoice-info">
    <div class="col-sm-6 col-sm-offset-2 invoice-col">
      <p  class="prv_font"><strong class='p-head'>Relevant Category :</strong>{{ $student->loc_cat }}</p>
      <p  class="prv_font"><strong class='p-head'>Location :</strong>{{ $student->geo_cat }}</p>
      <p  class="prv_font"><strong class='p-head'>Category:</strong>{{ $student->category->name or '' }}</p>
      <p  class="prv_font"><strong class='p-head'>Reserved Category:</strong>{{ $student->res_category->name or '' }}</p>
      <p  class="prv_font"><strong class='p-head'>Nationality:</strong>{{ $student->nationality }}</p>
      <p  class="prv_font"><strong class='p-head'>Religion:</strong>{{ $student->religion }}</p>
      <p  class="prv_font"><strong class='p-head'>Candidate Name:</strong>{{ $student->name }}</p>
      <p  class="prv_font"><strong class='p-head'>Gender:</strong>{{ $student->gender }}</p>
      <p  class="prv_font"><strong class='p-head'>Date Of Birth:</strong>{{ $student->dob }}</p>
      <p  class="prv_font"><strong class='p-head'>Blood Group:</strong>{{ $student->blood_grp }}</p>
      <p  class="prv_font"><strong class='p-head'>Father's Name:</strong>{{ $student->father_name }}</p>
      <p  class="prv_font"><strong class='p-head'>Mother's Name:</strong>{{ $student->mother_name or '' }}</p>
      <p  class="prv_font"><strong class='p-head'>Mobile No:</strong>{{ $student->mobile }}</p>
      <p  class="prv_font"><strong class='p-head'>Permanent Address:</strong>{{ $student->per_address }}
        , <strong>Pincode: </strong>{{$student->pincode}}
      </p>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <div class="column4">
        <img src = "{{ url('attachment/' . $student->id) }}/photograph" height="178" width= "186" class="student-image" alt="Student Image">
      </div>
      <div class="column5">
        <img src = "{{ url('attachment/' . $student->id) }}/signature" height="60" width= "186" class="student-image" alt="Signature">
      </div>
    </div>

  </div>
  <!-- /.row -->

  <!-- Table row -->
  <div class="row">
    <div class='col-sm-10 col-sm-offset-1'>
      <h4><strong>Course Information</strong></h4>
      <div class="row">
        <div class="col-sm-9">
          <strong class="p-head">Course Name:</strong> {{$student->course->course_name or ''}}
        </div>
        <div class="col-sm-3">
          <strong class="p-head">Semester:</strong> 
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <strong class="p-head">Selected Subjects:</strong> 
        </div>
        <div class="col-sm-8">
          <strong>Compulsary</strong>
          @foreach($comp_subjects as $sub)
          @if($sub->sub_type == 'C')
          <p><strong></strong>{{ $sub->subject->subject}}</p>
          @endif
          @endforeach
          <strong>Optional</strong>
          @if($student->admSubs)
          <?php $i = 1; ?>
          @foreach($student->admSubs as $subject)
          <p><strong>{{ $i }}) &nbsp;</strong>{{ $subject->subject->subject}}</p>
          <?php $i++; ?>
          @endforeach
          @endif
        </div>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <div class="row">
    <div class='col-sm-10 col-sm-offset-1'>
      <h4><strong>Academic Detail</strong></h4>
      @foreach($student->academics as $acad)
      <div class='row'>
        <div class="col-sm-4">
          <strong class="p-head">Course:</strong>{{$acad->exam}}
        </div>
        <div class="col-sm-4">
          <strong class="p-head">Institution:</strong>{{$acad->institute}}
        </div>
        <div class="col-sm-4">
          <strong class="p-head">Board/University:</strong>
        </div>
      </div>
      <div class='row'>
        <div class="col-sm-4">
          <strong class="p-head">Roll No:</strong> {{$acad->rollno}}
        </div>
        <div class="col-sm-4">
          <strong class="p-head">Year:</strong> {{$acad->year}}
        </div>
        <div class="col-sm-4">
          <strong class="p-head">Result:</strong> {{$acad->result}}
        </div>
      </div>
      <div class='row'>
        <div class="col-sm-4">
          <strong class="p-head">Marks Obtained /%age:</strong> {{$acad->marks}}/{{$acad->marks_per}}
        </div>
        <div class="col-sm-8">
          <strong class="p-head">Subjects Offered:</strong> {{$acad->subjects}}
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="row">
    <div class='col-sm-10 col-sm-offset-1'>
      <h4><strong>Other Detail</strong></h4>
      <div class='row'>
        <div class="col-sm-6">
          <p><strong class="p-head">Gap Year:</strong> {{ $student->gap_year}}
          </p>
        </div>
      </div>
      <div class='row'>
        <div class="col-sm-10">
          <p><strong class="p-head">Migrating Details:</strong>{{ $student->migrate_detail}}</p>
        </div>
      </div>
      <div class='row'>
        <div class="col-sm-10">
          <p><strong class="p-head">Disqualify Details:</strong>{{ $student->disqualify_detail}}</p>
        </div>
      </div>
    </div>
  </div>
  <div class='row'>
    <div class='col-sm-9 col-sm-offset-1'>
      <h4><strong>Document Attached</strong></h4>
      <table class='table table-bordered'>
        <tr>
          <th>Photograph</th>
          <td>
            @if($student->attachments->where('file_type','photograph')->first())
            &#10004;
            @endif
          </td>
        </tr>
        <tr>
          <th>Signature</th>
          <td>
            @if($student->attachments->where('file_type','signature')->first())
            &#10004;
            @endif
          </td>
        </tr>
        <tr>
          <th>Detailed Marks Sheet of all lower Examinations</th>
          <td>
            @if($student->attachments->where('file_type','mark_sheet')->first())
            &#10004;
            @endif
          </td>
        </tr>
        <tr>
          <th>Matric/Secondary Certificate for Date Of Birth</th>
          <td>
            @if($student->attachments->where('file_type','dob_certificate')->first())
            &#10004;
            @endif
          </td>
        </tr>
        <tr>
          <th>Character Certificate from the Institution last attended(original)</th>
          <td>@if($student->attachments->where('file_type','char_certificate')->first())
            &#10004;
            @endif
          </td>
        </tr>
        <tr>
          <th>Affidavit Justifying gap Year,if applicable</th>
          <td>
            @if($student->attachments->where('file_type','gap_certificate')->first())
            &#10004;
            @endif
          </td>
        </tr>
        <tr>
          <th>Residence Proof/Adhaar Card/Voter Card/Passport etc</th>
          <td>
            @if($student->attachments->where('file_type','uid')->first())
            &#10004;
            @endif
          </td>
        </tr>
      </table>
    </div>
    <div class='col-sm-10 col-sm-offset-1'>
      <h4 style="text-align: center;"><strong>DECLARATION</strong></h4>
      <ol>
        <li>I solemnly declare that the above facts are true to the best of my knowledge and brief and nothing has been concealed therein.
          I undertake to abide by the rules and regulations of college.
        </li>
        <li>I seek admission with the permission of my Parents/Guardian, 
          who agree to be jointly responsible for prompt payment of dues and for my  conduct.
        </li>
        <li>I will not take part, instigate or induce other students to stage strike, agitation or create indiscipline. If I do so, I may be fined, 
          expelled or rusticated for any activity subversive to the college discipline.
        </li>
        <li>I am fully aware that ragging, smoking and drinking liquor is strictly prohibited in the college/Hostel. If I am found guilty of indulging in these activities, 
          I shall be liable to punishment and expulsion from hostel/college.</li>
        <li>I shall not use mobile phone in the college.</li>
        <li>I have not been involved in any criminal activity and have never been convicted under any criminal offence.
          No criminal proceedings are pending against me at the time of submission of the application. Further, I will not posses or carry any weapon on the college campus and if any weapon is recovered from me, 
          I under stand that I can be rusticated for such an offence.</li>
      </ol>
      <p>( Any mis-statement/concealment of facts by the applicant will result in cancellation of admission, no refund will be made and appropriate action will be taken against the applicant )</p>
      <div class="row">
        <div class="col-sm-4">
          <p><strong>Dated: ...................</strong></p>
        </div>
        <div class="col-sm-5">
          <p><strong>Full Signature Of Parents/Guardian</strong></p>
        </div>
        <div class="col-sm-3">
          <p><strong>Signature Of Student</strong></p>
          <p><strong>Email: ...................</strong></p>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
@stop