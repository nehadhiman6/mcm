<!DOCTYPE html>
<html>
  @include('partials.head')
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      @include('donation_partial.header')

      <!-- Left side column. contains the logo and sidebar -->
    

      <!-- Content Wrapper. Contains page content -->
      <div class="donation-content content-wrapper">
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
      <footer class="donation-footer main-footer">
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
