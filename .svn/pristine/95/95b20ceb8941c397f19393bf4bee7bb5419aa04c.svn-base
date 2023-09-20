<!DOCTYPE html>
<html>
    @include('partials.head')
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            @include('partials.header')
            
            <!-- Left side column. contains the logo and sidebar -->
            @include('partials.nav')
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content">
                    @yield('toolbar')
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
                <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
                reserved.
            </footer>
        </div>
        <!-- ./wrapper -->
        @include('partials.scripts')
    </body>
</html>
