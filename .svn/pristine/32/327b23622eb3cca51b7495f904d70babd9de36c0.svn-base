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
            @if(auth('alumnies')->check())
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  {{ auth('alumnies')->user()->email }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li>
                    <a href="{{ url('alumni.logout') }}"
                       onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                      Logout
                    </a>

                    <form id="logout-form" action="{{ url('alumni/logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
            @endif
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      @if(auth('alumnies')->check())
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="{{ checkActive(['almstuform']) }} treeview">
              <a href="{{url('/alumni-student')}}">
                <i class="fa fa-lg fa-graduation-cap"></i> <span>Alumni Form</span>
              </a>
            </li>
            @if($alumni_form = auth('alumnies')->user()->almForm)
              <li class="{{ checkActive(['admforms/*/edit']) }} treeview">
                <a href="{{url('/alumni-student/'.$alumni_form->id.'/edit')}}">
                  <i class="fa fa-lg fa-edit"></i> <span>Edit Alumni Form</span>
                </a>
              </li>
              <!-- <li class="{{ checkActive(['payments/alumni-meet-fee']) }} treeview">
                <a href="{{url('/payments/alumni-meet-fee')}}">
                  <i class="fa fa-lg fa-edit"></i> <span>Alumni Meet Fee</span>
                </a>
              </li> -->
              <li class="{{ checkActive(['going-alumnies-meet']) }} treeview">
                <a href="{{ url('going-alumnies-meet') }}">
                  <i class="fa fa-lg fa-edit"></i> <span>On Going Alumni Meet</span>
                </a>
              </li>
              <li class="{{ checkActive(['payments/alumni-fee-status']) }} treeview">
                <a href="{{ url('payments/alumni-fee-status') }}">
                <i class="fas fa-credit-card fa-lg"></i><span>Online Payments</span>
                </a>
              </li>
              {{-- @if(isset($donation) && $donation = "donation") --}}
              <li class="{{ checkActive(['alumni-student/'.$alumni_form->id.'/show-donation']) }} treeview">
                <a href="{{ url('alumni-student/'.$alumni_form->id.'/show-donation') }}">
                <i class="fas fa-credit-card fa-lg"></i><span>Membership/Donation</span>
                </a>
              </li>
              {{-- @endif --}}
              {{-- <li class="{{ checkActive(['/']) }} treeview">
                <a href="{{url('/alumni-student/'.$alumni_form->id)}}" target="_blank">
                  <i class="fa fa-lg fa-eye"></i> <span>Preview</span>
                </a>
              </li> --}}
            @endif
          </ul>
        </section>
        <!-- /.sidebar -->
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
