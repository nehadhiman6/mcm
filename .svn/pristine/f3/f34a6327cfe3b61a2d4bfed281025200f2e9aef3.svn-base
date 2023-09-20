<!DOCTYPE html>
<html>
  @include('partials.head')
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      @include('partials.header')

      <!-- Left side column. contains the logo and sidebar -->

      @if(auth()->user()->hasRole('TEACHERS'))
        @include('partials.teacher_nav')
      @else
        @include('partials.nav') 
      @endif

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content" id="paddingtop0">
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
                        <strong>{{ $message }}</strong>
                    @endforeach
                </div>
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
        <strong>Copyright &copy; 2017-2018 <a href="http://infowayindia.com">Infowayindia.com</a>.</strong> All rights reserved.
      </footer>
    </div>
    <!-- ./wrapper -->
    @include('partials.scripts')
    @stack('vue-components')
    @yield('script')
    @stack('pg_script')
  </body>
</html>
