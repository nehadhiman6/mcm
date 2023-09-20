<!DOCTYPE html>
<html>
@include('partials.head')

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      @if(auth('students')->check() && $this_adm_form = auth('students')->user()->adm_form)
      <a href="{{url('/admforms').'/' .$this_adm_form->id.'/details'}}" class="logo">
        <span class="logo-mini"><img src="{{ asset('dist/img/small-logo.png')}}"></span>
        <span class="logo-lg">MCM</span>
      </a>
      @else
      <a href="{{url('/')}}" class="logo">
        <span class="logo-mini"><img src="{{ asset('dist/img/small-logo.png')}}"></span>
        <span class="logo-lg">MCM</span>
      </a>
      @endif
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          @if(auth('students')->check())
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ auth('students')->user()->email }} <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ url('student.logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                    Logout
                  </a>
                  <form id="logout-form" action="{{ url('student/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </li>
              </ul>
            </li>
            {{-- <li class="dropdown user user-menu">
                        <a class="logout" href="{{ route('student.logout') }}">Logout</a>
            </li> --}}
          </ul>
          @endif
        </div>
      </nav>
    </header>
    @if(auth('students')->check())
    <aside class="main-sidebar">
      <section class="sidebar">
        <ul class="sidebar-menu">
          @if($this_adm_form = auth('students')->user()->adm_form)
          <li class="{{ checkActive(['admforms*details']) }} treeview">
            <a href="{{url('/admforms').'/' .$this_adm_form->id.'/details'}}">
              <i class="fa fa-lg fa-home"></i> <span>Home</span>
            </a>
          </li>
          @endif
          <li class="{{ checkActive(['new-adm-form']) }} treeview">
            <a href="{{url('/new-adm-form')}}">
              <i class="fa fa-lg fa-graduation-cap"></i> <span>Admission Form</span>
            </a>
          </li>
          @if($this_adm_form = auth('students')->user()->adm_form)
          {{-- <li class="{{ checkActive(['new-adm-form/*/edit']) }} treeview">
          <a href="{{url('/new-adm-form/'.$this_adm_form->id.'/edit')}}">
            <i class="fa fa-lg fa-edit"></i> <span>Edit Admission Form</span>
          </a>
          </li> --}}
          <li class="{{ checkActive(['/']) }} treeview">
            <a href="{{url('/hostel-form/'.$this_adm_form->id) }}">
              @if($this_hostel_adm_form = auth('students')->user()->adm_form->hostelData)
              <i class="fa fa-lg fa-edit"></i> <span>Edit Hostel Form</span>
              @else
              <i class="fa fa-lg fa-edit"></i> <span>Hostel Form</span>
              @endif
            </a>
          </li>

          @if($this_adm_form->attachment_submission == 'N')
            <li class="{{ checkActive(['/new-adm-form/'.$this_adm_form->id.'/attachments']) }} treeview">
              <a href="{{url('/new-adm-form/'.$this_adm_form->id.'/attachments')}}" id="add_attachment">
                <i class="fa  fa-lg fa-chain-broken"></i> <span>Attachments</span>
              </a>
            </li> 
          @endif

          {{-- <li class="{{ checkActive(['new-adm-form/*/addattachments']) }} treeview">
          <a href="{{url('/admforms/'.$this_adm_form->id.'/addattachments')}}" id="add_attachment">
            <i class="fa  fa-lg fa-chain-broken"></i> <span>Add Attachments</span>
          </a>
          </li> --}}
          <li class="{{ checkActive(['/']) }} treeview">
            <a href="{{url('/new-adm-form/'.$this_adm_form->id)}}" target="_blank">
              <i class="fa fa-lg fa-eye"></i> <span>Preview College Form</span>
            </a>
          </li>
          @if($this_adm_form->hostel_form)
          <li class="{{ checkActive(['/']) }} treeview">
            <a href="{{url('/new-adm-form/previewhostel/'.$this_adm_form->id) }}" target="_blank">
              <i class="fa fa-lg fa-eye"></i> <span>Preview Hostel Form</span>
            </a>
          </li>
          @endif
          @if($this_adm_form->feesPaid() == false)
          <li class="{{ checkActive(['payments/prospectus']) }} treeview">
            <a href="{{ url('payments/prospectus') }}">
              <i class="far fa-credit-card fa-lg"></i> <span>College Processing Fee</span>
            </a>
          </li>
          @endif

          @if($this_adm_form->hostel_form && $this_adm_form->hostel_form->feesPaid() == false)
          <li class="{{ checkActive(['payments/pros-hostel']) }} treeview">
            <a href="{{ url('payments/pros-hostel') }}">
              <i class="far fa-credit-card fa-lg"></i><span>Hostel Processing Fee</span>
            </a>
          </li>
          @endif
         
          <li class="{{ checkActive(['final-submissions']) }} treeview">
            <a href="{{ url('final-submissions') }}">
              <i class="fa fa-lg fa-gavel"></i> <span>Final Submission</span>
            </a>
          </li>
          {{-- @if($this_adm_form->final_submission == 'Y' && $this_adm_form->admEntry) --}}
          @if($this_adm_form->final_submission == 'Y')
          @if($this_adm_form->admEntry)
          <li class="{{ checkActive('payadmfees/create') }} treeview">
            <a href="{{ url('payadmfees/create') }}">
              <i class="fas fa-credit-card fa-lg"></i><span>Admission Fee Payment</span>
            </a>
          </li>
          @endif
          <li class="{{ checkActive('penddues') }} treeview">
            <a href="{{ url('penddues') }}">
              <i class="fas fa-credit-card fa-lg"></i><span>Pay College Dues</span>
            </a>
          </li>
          <li class="{{ checkActive('hosteldues') }} treeview">
            <a href="{{ url('hosteldues') }}">
              <i class="fas fa-credit-card fa-lg"></i><span>Pay Hostel Dues</span>
            </a>
          </li>
          @endif
          <!-- <li class="{{ checkActive('student-refund-requests') }} treeview">
            <a href="{{ url('student-refund-requests') }}">
              <i class="fas fa-credit-card fa-lg"></i><span>Refund Request</span>
            </a>
          </li> -->
          <li class="{{ checkActive(['stdpayments']) }} treeview">
            <a href="{{ url('stdpayments') }}">
              <i class="fas fa-credit-card fa-lg"></i><span>Online Payments</span>
            </a>
          </li>


          <!-- <li class="{{ checkActive(['stdpayments/create']) }} treeview">
                <a href="{{ url('stdpayments/create') }}">
                  <i class="fa fa-credit-card-alt"></i> <span>Pay Dues</span>
                </a>
              </li> -->
          @if($this_adm_form->std_id > 0)
            <li class="{{ checkActive(['new-adm-form/'.$this_adm_form->id.'/student-feedback']) }} treeview">
            <a href="{{ url('new-adm-form/'.$this_adm_form->id.'/student-feedback') }}">
              <i class="fa fa-lg fa-edit"></i><span>Student Satisfaction Survey</span>
            </a>
            </li>
            <li class="{{ checkActive(['student-timetable']) }} treeview">
              <a href="{{ url('student-timetable') }}">
                <i class="fa fa-calendar fa-lg" aria-hidden="true"></i><span>Time Table</span>
              </a>
            </li>
          @endif

          {{-- <li class="{{ checkActive(['no-dues']) }} treeview">
          <a href="{{ url('no-dues') }}">
            <i class="fa fa-calendar fa-lg" aria-hidden="true"></i><span>No Dues Print</span>
          </a>
          </li> --}}
          {{-- commented on 22-04-2020 by neha verma on sumen sir's call --}}

          {{-- <li class="{{ checkActive(['/']) }} treeview">
          <a href="{{url('/new-adm-form/leave-application/'.$this_adm_form->id) }}" target="_blank">
            <i class="fa fa-lg fa-eye"></i> <span>Preview Leave Application</span>
          </a>
          </li> --}}
          {{-- <li class="{{ checkActive(['/']) }} treeview">
          <a href="{{url('/new-adm-form/no-dues-slip/'.$this_adm_form->id) }}" target="_blank">
            <i class="fa fa-lg fa-eye"></i> <span>Preview No Dues Slip</span>
          </a>
          </li> --}}
          @endif

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
    @else
    {{-- <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="{{ checkActive(['penddues']) }} treeview">
    <a href="{{url('penddues')}}">
      <img src="{{asset('dist/img/receipts.png')}}"><span>College Dues</span>
    </a>
    </li>
    <li class="{{ checkActive(['hosteldues']) }} treeview">
      <a href="{{url('hosteldues')}}">
        <img src="{{asset('dist/img/receipts.png')}}"><span>Hostel Dues</span>
      </a>
    </li>
    <li class="{{ checkActive(['otherdues']) }} treeview">
      <a href="{{url('otherdues')}}">
        <img src="{{asset('dist/img/receipts.png')}}"><span>Hostel Dues (Others)</span>
      </a>
    </li>
    </ul>
    </section>
    </aside> --}}
    @endif
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content">
        @yield('toolbar')

        @if(session()->has('message'))
        <ul class="alert alert-warning">
          {{ session()->get('message') }}
        </ul>
        @endif

        @include('flash::message')

        @if(count($errors->all())>0)
        <ul class="alert alert-danger">
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
        @endif

        @yield('content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.3
      </div>
      <strong>Copyright &copy; 2017-2018 <a href="http://infowayindia.com">Infowayindia.com</a>.</strong> All rights
      reserved.
    </footer>
  </div>
  <!-- ./wrapper -->
  @include('partials.scripts')
  @stack('vue-components')
  @yield('script')
  @stack('pg_script')
</body>

</html>