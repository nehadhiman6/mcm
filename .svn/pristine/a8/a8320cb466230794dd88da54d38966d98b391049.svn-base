<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="{{ asset('dist/img/favicon.png') }}" type="image/gif" sizes="32x32">
 
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css')}}">
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
  
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('css/skin-blue.css') }}"><!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
   <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker-bs3.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css')}}">
  <link rel="stylesheet" href="{{ asset('dist/css/style.css')}}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<section class="invoice">
    <div class ="first-page">
        <div class="header">
            <div class="logo">
                <img src="{{ asset("/dist/img/logo_2.png") }}">
            </div>
            <div class="title">
                <strong>Sri Guru Gobind Singh College, Sector 26, Chandigarh</strong><br>
                APPLICATION FORM FOR ADMISSION (SESSION 2016-17)
            </div>
            <div class="form-class">
                Form No.............................<br>
                Class.................
            </div>
        </div>
        <div class="student-info">
            New Student  <input type="checkbox" name="" value="">
            Old Student  <input type="checkbox" name="" value="">
            Old Student   ........................     
            <span>Result Verified (Pass/Comp.)  .....................</span>
        </div>
        <div class="office-use">
            <h1><strong>For Office Use Only</strong></h1>
            <ul>
                <li>Application Recieved on.............</li>
                <li>Class.........................</li>
                <li>Roll No......................</li>
                <li>Adm. No.....................</li>
                <li>Amount Recieved .............</li>
                <li>Reciept No.............</li>
                <li>Signature of Reciever.............</li>
                <li>Date.............</li>
            </ul>
        </div>
        <div class="tick-category">
            <div class="pool">
                <h1><strong>Select the relevant category</strong> </h1>
                UT POOL 
            </div>
            <div class="category-lists">
                <div class="column1">
                    <strong>Category :</strong> Foreign National <br>
                    <strong>Religion :</strong> Sikh
                </div>
                <div class="column2">
                    <strong>Reserved Category :</strong> Sports
                    <strong>Information : </strong>Urban
                </div>
                <div class="column3">
                    <strong>Nationality :</strong> Indian
                </div>
            </div>
        </div>
        <div class="column4">
          <img src="dist/img/user2-160x160.jpg" class="" alt="User Image">
        </div>
        <div class="applicant">
            <div class="row-1">
                <div class="col-sm-5 col-md-6"><span class="label-name">Name:</span>{{$student->name}}</div>
                <div class="col-sm-5 col-md-6"><span class="label-name">Phone:</span>+91-{{$student->mobile}}</div>
            </div>
        </div>
        <div class="father">
            <div class="row-2">
                <div class="col-sm-5 col-md-6"><span class="label-name">Father Name:</span>{{$student->father_name}}</div>
                <div class="col-sm-5 col-md-6"><span class="label-name">Phone No:</span>+91-{{$student->father_phone}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Occupation:</span>{{$student->father_occup}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Designation:</span>{{$student->father_desig}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Office Address:</span>{{$student->f_office_addr}}</div>
            </div>
        </div>
        <div class="mother">
            <div class="row-2">
                <div class="col-sm-5 col-md-6"><span class="label-name">Mother Name:</span>{{$student->mother_name}}</div>
                <div class="col-sm-5 col-md-6"><span class="label-name">Phone:</span>+91-{{$student->mother_phone}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Occupation:</span>{{$student->mother_occup}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Designation:</span>{{$student->mother_desig}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Office Address:</span>{{$student->m_office_addr}}</div>
            </div>
        </div>
        <div class="guardian">
            <div class="row-2">
                <div class="col-sm-5 col-md-6"><span class="label-name">Guardian Name:</span>{{$student->guardian_name}}</div>
                <div class="col-sm-5 col-md-6"><span class="label-name">Phone:</span>+91-{{$student->guardian_phone}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Occupation:</span>{{$student->guardian_occup}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Designation:</span>{{$student->guardian_desig}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Office Address:</span>{{$student->g_office_addr}}</div>
            </div>
        </div>
        <div class="permanent">
            <div class="row-1">
                <span class="label-name">
                    Address:
                </span>
                {{$student->per_address}}
            </div>
        </div>
        <div class="bio-data">
            <div class="row-2">
                <div class="col-xs-6 col-sm-4"><span class="label-name">Date Of Birth:</span>{{$student->dob}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Sex:</span>{{$student->gender}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Migration:</span>@if($student->migration=='Y')Yes @else No @endif</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Blind-Student:</span>@if($student->blind=='Y')Yes @else No @endif</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Blood-Group:</span>{{$student->blood_grp}}</div>
                <div class="col-xs-6 col-sm-4"><span class="label-name">Annual-Income:</span>{{$student->annual_income}}</div>
            </div>
        </div>
        <div class="univ-regst">
            <div class="row-1">
                <div class="col-sm-5 col-md-6">Panjab University Regst No.:<span class="label-name">{{$student->pu_regno}}</span></div>
                <div class="col-sm-5 col-md-6">Panjab University Pupin No.<span class="label-name">{{$student->pupin_no}}</span></div>
            </div>
        </div>
        <div class="subjects">
            <div class="row-2">
                <div class="col-xs-6 col-sm-4">Subject 1</div>
                <div class="col-xs-6 col-sm-4">Subject 2</div>
                <div class="col-xs-6 col-sm-4">Subject 3</div>
                <div class="col-xs-6 col-sm-4">Subject 4</div>
                <div class="col-xs-6 col-sm-4">Subject 5</div>
                <div class="col-xs-6 col-sm-4">Subject 6</div>
            </div>
        </div>
        <div class="acad_record">
            <h1><strong>Academic Records</strong></h1>
            <table class="table table-bordered">
                <tr>
                    <th>Exams</th>
                    <th>Institution</th>
                    <th>Board/Univ</th>
                    <th>Roll No</th>
                    <th>Year</th>
                    <th>Results</th>
                    <th>Marks Obtained</th>
                    <th>% age</th>
                    <th>Subject Offered</th>
                </tr>
                @foreach($student->academics as $stu)
                <tr>
                    <td>{{$stu->exam}}</td>
                    <td>{{$stu->institute}}</td>
                    <td>{{$stu->board->name or ''}}</td>
                    <td>{{$stu->rollno}}</td>
                    <td>{{$stu->year}}</td>
                    <td>{{$stu->result}}</td>
                    <td>{{$stu->marks}}</td>
                    <td>{{$stu->marks_per}}</td>
                    <td>{{$stu->subjects}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <hr>
        <div class="student-slip">
            <div class="photo">
                <h1>Photo</h1>
            </div>
            <div class="info-area">
                <h1><strong>Student Detail Slip</strong></h1>
                Form No................<br>
                <div class="left">
                    <strong>For Library Use</strong><br>
                    Name..........................<br>
                    Father's Name..........................<br>
                    Class...........................<br>
                    Address.....................<br>
                    Contact No.......................
                </div>
                <div class="right">
                    <strong>For Office Use Only</strong><br><br>
                    College Roll No...................<br>
                    Admission No...................
                </div>
            </div>
        </div>
        <hr>
        <div class="acknw-slip">
            <div class="heading">
                <h1>Acknowledgment Slip</h1>
                <h3>Form No............</h3>
            </div>
            <div class="side1">
                Name..............<br>
                Class.............
            </div>
            <div class="side2">
                Father's Name..................
            </div>
            <div class="side3">
                Signature.........
            </div>
        </div>
    </div>
    <div class="second-page">
        <div class="gap">
            <div class="col-xs-6  col-sm-3" style="padding-left:9px;">
                Gap Year and Details
            </div>
        </div>
        <div class="migration">
            <div class="col-sm-5 col-md-6" style="width:59%;padding-right:7px;">
                Migrating Details
            </div>
            <div class="col-xs-6 col-sm-4" style="width:41%;">
                Certificate Attached Yes/No
            </div>
        </div>
        <div class="foreign-student">
            <h1 style="font-size:20px;text-align:center;margin-bottom:20px;">For Foreign Students</h1>
            <div class="col-sm-5 col-md-6"  >
                Nationality
            </div>
            <div class="col-sm-5 col-md-6">
                Passport No
            </div>
            <div class="col-sm-5 col-md-6" >
                Visa Valid Upto
            </div>
            <div class="col-sm-5 col-md-6">
                Resident Permit
            </div>
        </div>
        <div class="achvment">
            <div class="col-xs-6  col-sm-3" style="padding-left:14px; padding-top:4px; width:33%;">
                Special Achievment (Academic/Sports/Cultural)
            </div>
        </div>
        <div class="disqualified">
            <div class="col-xs-6 col-sm-4" style="width:33%; ">
                Ever Disqualified Yes/No
            </div>
            <div class="col-sm-5 col-md-6" style="width:67%;padding-left:15px;">
                Qualified Details
            </div>
        </div>
        <div class="declaration">
            <h1 style="font-size:20px;text-align:center;margin-bottom:10px;">Declaration</h1>
        </div>
        <div class="sign-area">
            <div class="col-xs-6 col-sm-4" style= "background:none; border:none;">
                Dated ............
            </div>
            <div class="col-xs-6 col-sm-4" style= "background:none; border:none;">
                Full Signature Of Parents/Guardian
            </div>
            <div class="col-xs-6 col-sm-4" style= "background:none; border:none;width:30%;text-align:center;">
                Signature of Student<br>
                Email-Id : ............
            </div>
        </div>
        <div class="submission">
            <h1><strong>Documents to be Submitted With Application Form</strong></h1>
            <div class="col-sm-5 col-md-6" >
                DMC
            </div>
            <div class="col-sm-5 col-md-6">
                Migration Certificate
            </div>
            <div class="col-sm-5 col-md-6" >
                2 Photos
            </div>
            <div class="col-sm-5 col-md-6">
                Resident Proof(Adhaar Card)
            </div>
        </div>
        <div class="certified">
            <div class="sign-side">
                Certified that thr student is eligible for Admission to ....................class<br>
                Deficiency (if any)..............................................................<br><br>
                Signature of Teacher
            </div>
            <div class="governer-side">
                (Recommended for Provisional Admission)<br>
                Convener<br><br>
                (Admission Committee)
            </div>
        </div>
    </div>
</section>
</body>
</html>