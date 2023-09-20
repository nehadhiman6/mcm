<header class="main-header">
  <nav class="donation-header navbar navbar-static-top">
    <div class="navbar-custom-menu">
        <a class="logo">
          <span class="logo-lg">Donation</span>
        </a>
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
              <img src="{{ asset('dist/img/user.jpg') }}" class="img-circle" alt="User Image">
              <p>
                {{ Auth::user()->name }}
              </p>
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
      @endif
    </div>
  </nav>
</header>