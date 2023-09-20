@if(auth()->check())
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      
      @can('edit-own-staff-details')
      @if(auth()->user()->staff)
        <li class = "{{ checkActive(['staff/*/edit']) }}">
          <a href="{{url('staff') .'/'.auth()->user()->staff->id .'/edit'}}"><img src="{{asset('dist/img/user-rights.png')}}"><span>My Details</span></a>
        </li>
        @endif
      @endcan

      <li class = "{{ checkActive(['allot-section', 'stdsublist', 'attendance']) }}">
        <a href="{{ url('allot-section')}}"><img src="{{asset('dist/img/reports.png')}}"><span>Academics</span></a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
@endif