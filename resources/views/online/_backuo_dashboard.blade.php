<!DOCTYPE html>
<html>
  @include('partials.head')
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="{{url('/')}}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="{{ asset('dist/img/small-logo.png')}}"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">MCM</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
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
                    <a href="{{ url('student.logout') }}"
                       onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                      Logout
                    </a>

                    <form id="logout-form" action="{{ url('student/logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </li>
                </ul>
              </li>
              <!--        `                        <li class="dropdown user user-menu">
                                                  <a class="logout" href="{{ route('student.logout') }}">Logout</a>
                                              </li>-->
            </ul>
            @endif
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      @if(auth('students')->check())
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="{{ checkActive(['admforms']) }} treeview">
              <a href="{{url('/admforms')}}">
                <i class="fa fa-lg fa-graduation-cap"></i> <span>Admission Form</span>
              </a>
            </li>
            @if($this_adm_form = auth('students')->user()->adm_form)
              <li class="{{ checkActive(['admforms/*/edit']) }} treeview">
                <a href="{{url('/admforms/'.$this_adm_form->id.'/edit')}}">
                  <i class="fa fa-lg fa-edit"></i> <span>Edit Admission Form</span>
                </a>
              </li>
             
              <li class="{{ checkActive(['/']) }} treeview">
                <a href="{{url('/hostel-form/'.$this_adm_form->id) }}" >
                @if($this_hostel_adm_form = auth('students')->user()->adm_form->hostelData)
                  <i class="fa fa-lg fa-edit"></i> <span>Edit Hostel Form</span>
                @else
                  <i class="fa fa-lg fa-edit"></i> <span>Hostel Form</span>
                @endif
                </a>
              </li>

              <li class="{{ checkActive(['admforms/*/addattachments']) }} treeview">
                <a href="{{url('/admforms/'.$this_adm_form->id.'/addattachments')}}" id="add_attachment">
                  <i class="fa  fa-lg fa-chain-broken"></i> <span>Add Attachments</span>
                </a>
              </li>
              <li class="{{ checkActive(['/']) }} treeview">
                <a href="{{url('/admforms/'.$this_adm_form->id)}}" target="_blank">
                  <i class="fa fa-lg fa-eye"></i> <span>Preview</span>
                </a>
              </li>
              @if($this_adm_form->hostel_form)
              <li class="{{ checkActive(['/']) }} treeview">
                <a href="{{url('/admforms/previewhostel/'.$this_adm_form->id) }}" target="_blank">
                  <i class="fa fa-lg fa-eye"></i> <span>Preview Hostel Form</span>
                </a>
              </li>
              @endif
              @if($this_adm_form->feesPaid() == false)
              <li class="{{ checkActive(['payments/prospectus']) }} treeview">
                <a href="{{ url('payments/prospectus') }}">
                <i class="far fa-credit-card fa-lg"></i> <span>Pay Processing Fee</span>
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
              @if($this_adm_form->final_submission == 'Y' && $this_adm_form->admEntry)
              <li class="{{ checkActive('payadmfees/create') }} treeview">
                <a href="{{ url('payadmfees/create') }}">
                <i class="fas fa-credit-card fa-lg"></i><span>Admission Payment</span>
                </a>
              </li>
              @endif
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
            @endif
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      @else
      <aside class="main-sidebar">
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
      </aside>
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
