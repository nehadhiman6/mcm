 <!-- BEGIN: Header-->
<nav class="navbar navbar-expand navbar-light fixed-top header">
    <ul class="navbar-nav mr-auto">
       <li class="nav-item"><a class="nav-link navbar-icon sidebar-toggler" id="sidebar-toggler" href="#"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a></li>
       <li class="nav-item dropdown d-none d-sm-inline-block">
          <a class="nav-link dropdown-toggle megamenu-link" href="#" data-toggle="dropdown"><span>Megamenu<i class="ti-angle-down arrow ml-2"></i></span></a>
          <div class="iw-megamenu dropdown-menu nav-megamenu">
             <div class="row m-0">
                <div class="col-sm-6">
                   <a class="mega-menu-item" href="#">
                      <i class="ft-activity item-badge mb-4"></i>
                      <h5 class="mb-2">Admission Forms</h5>
                      <div class="text-muted font-12">Lorem Ipsum dolar.</div>
                   </a>
                </div>
                <div class="col-sm-6">
                   <a class="mega-menu-item bg-primary text-white" href="#">
                      <i class="ft-globe item-badge mb-4 text-white"></i>
                      <h5 class="mb-2">Students</h5>
                      <div class="text-white font-12">Lorem Ipsum dolar.</div>
                   </a>
                </div>
                <div class="col-sm-6">
                   <a class="mega-menu-item" href="#">
                      <i class="ft-layers item-badge mb-4"></i>
                      <h5 class="mb-2">Alumni</h5>
                      <div class="text-muted font-12">Lorem Ipsum dolar.</div>
                   </a>
                </div>
                <div class="col-sm-6">
                   <a class="mega-menu-item" href="#">
                      <i class="ft-shopping-cart item-badge mb-4"></i>
                      <h5 class="mb-2">Inventory</h5>
                      <div class="text-muted font-12">Lorem Ipsum dolar.</div>
                   </a>
                </div>
             </div>
          </div>
       </li>
    </ul>
    @auth
    <ul class="navbar-nav">
        <strong>  Session: {{ substr(session()->get('fy','20192020'),0,4).'-'.substr(session()->get('fy','20192020'),4,4) }} </strong>
        <li class="nav-item"><a class="nav-link navbar-icon" href="javascript:;" data-toggle="modal" data-target="#search-modal"><i class="ft-search"></i></a></li>
   
        <li class="nav-divider"></li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle no-arrow d-inline-flex align-items-center" data-toggle="dropdown" href="#">
                <span class="position-relative d-inline-block">
                    @if(auth()->user() && !auth()->user()->image)
                    <img class="rounded-circle mr-3" src="{{ url('img/admin-image.png') }}" alt="image" width="50px" /> 
                    @else
                    <img src="{{ url('user-image').'/'. auth()->user()->image->id }}" class="rounded-circle mr-3" width="50px" alt="User Image">
                    @endif
                    {{-- <img class="rounded-circle" src="{{ url('img/admin-image.png')}}" alt="image" width="36" /> --}}
                    <span class="badge-point badge-success avatar-badge"></span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0 pb-4 iw-profile">
                <div class="p-4 mb-4 media align-items-center text-white text-center" style="background-color: #06000f;">
                    @if(!auth()->user()->image)
                    <img class="rounded-circle mr-3" src="{{ url('img/admin-image.png') }}" alt="image" width="100px" /> 
                    @else
                    <img src="{{ url('user-image').'/'. auth()->user()->image->id }}" class="rounded-circle mr-3" width="100px" alt="User Image">
                    @endif
                    {{-- <img class="rounded-circle mr-3" src="{{ url('img/admin-image.png') }}" alt="image" width="55" /> --}}
                    <div class="media-body">
                        <h5 class="mb-1" style="color: #ffaf00;">{{ Auth::user()->name }}</h5>
                        {{-- <div class="font-13">Administrator</div> --}}
                    </div>
                </div>
                <a class="dropdown-item d-flex align-items-center" href="#"><i class="ft-user mr-3 font-18 text-muted"></i>Profile</a>
                <a class="dropdown-item d-flex align-items-center" href="{{url('user-upload')}}">
                    <i class="ft-upload mr-3 font-18 text-muted"></i>Upload Image
                </a>
                <a class="dropdown-item d-flex align-items-center" href="{{url('users/updtpassword')}}">
                    <i class="ft-edit mr-3 font-18 text-muted"></i>Change Password
                </a>
                <div class="dropdown-divider my-3"></div>
                <div class="mx-4" style="background-color: #06000f;padding: 10px;text-align: center;">
                    <a class="btn btn-link p-0" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="btn-icon" style="color: #ffaf00;">
                            <i class="ft-power mr-2 font-18"></i>Logout
                        </span>
                    </a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
            </div>
        </li>
    </ul>
    @endauth
 </nav>
 <!-- END: Header-->