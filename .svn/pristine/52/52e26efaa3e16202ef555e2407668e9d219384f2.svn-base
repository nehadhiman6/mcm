<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body>

   <div class="page-wrapper">
      <div class="content-wrapper-index">
         {{-- @include('layouts.sidebar') --}}
         @if(auth()->user() && auth()->user()->hasRole('TEACHERS'))
         @include('layouts.teacher_sidebar')
         @else
         @include('layouts.sidebar')
         @endif
         <!-- BEGIN: Content-->
         <div class="content-area">

            @include('layouts.nav')

            <div class="page-content fade-in-up">

               <!-- BEGIN: Page heading--
                  <div class="page-heading">
                        <div class="page-breadcrumb">
                           <h1 class="page-title">Dashboard</h1>
                        </div>
                  </div>
                   BEGIN: Page heading-->
               @yield('toolbar')

               @if(session()->has('message'))
               <ul class="alert alert-warning">
                  {{ session()->get('message') }}
               </ul>
               @endif

               @include('flash::message')
               
               @if(count($errors->all())>0)
               <div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  @foreach($errors->all() as $error)
                  <strong>{{ $error }}</strong></br>
                  @endforeach
               </div>
               @endif

               @yield('content')

            </div>

            @include('layouts.footer')

         </div>
         <!-- END: Content-->
      </div><!-- content-wrapper-->
   </div>
   <!--page wrapper-->


   <!-- BEGIN: Search form-->
   <div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document" style="margin-top: 100px">
         <div class="modal-content">
            <form class="search-top-bar" action="#"><input class="form-control search-input" type="text"
                  placeholder="Search..."><button class="reset input-search-icon" type="submit"><i
                     class="ft-search"></i></button><button class="reset input-search-close" type="button"
                  data-dismiss="modal"><i class="ft-x"></i></button></form>
         </div>
      </div>
   </div>
   <!-- END: Search form-->

   <!-- BEGIN: Page backdrops-->
   <div class="sidenav-backdrop backdrop"></div>


   @include('layouts.script')
   @stack('vue-components')
   @yield('script')
   @stack('pg_script')

</body>

</html>