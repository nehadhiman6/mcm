<header class="main-header">
  <!-- Logo -->
  <a href="{{url('/')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="{{ asset('dist/img/small-logo.jpg')}}"></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">COLLEGE</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    {{-- <div>FY: {{ get_fy_label() }}</div> --}}
    <div style="display: inline-block; font-size: 16px; background: #6e6e6e; color: #fff; padding: 14px 28px;">FY: {{ get_fy_label() }}</div>

    <div class="navbar-custom-menu">
      @if(auth()->check())
      <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              @if(!auth()->user()->image)
              <img src="{{ asset('dist/img/user.jpg') }}" class="img-circle" alt="User Image">
              @else
              <img src="{{ url('user-image').'/'. auth()->user()->image->id }}" class="img-circle" alt="User Image">
              @endif
              <p>
                {{ Auth::user()->name }}
              </p>
             
            </li>
            <li class="user-footer" style="background-color:antiquewhite;">
                <div class="pull-left">
                <a class="btn btn-primary  btn-flat" href="{{ url('user-upload')}}">Upload Image</a>
                </div>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{url('users/updtpassword')}}" class="btn btn-primary btn-flat">Update Password</a>
              </div>
              <div class="pull-right">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();" class="btn btn-primary btn-flat">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </div>
            </li>
          </ul>
        </li>
      </ul>
      <!--
              <ul class="nav navbar-nav">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }} <span class="caret"></span>
                  </a>
      
                  <ul class="dropdown-menu" role="menu">
                    <li>
                      <a href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                        Logout
                      </a>
      
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                      </form>
                    </li>
                  </ul>
                </li>
                          <li class="dropdown user user-menu">
                            <form class="form-inline" action="{{ url('logout') }}" method="POST">
                              {{ csrf_field() }}
                              <input class="logout" type="submit" value="Logout" >
                            </form>
                          </li>
      
              </ul>-->
      @endif
    </div>
  </nav>
</header>