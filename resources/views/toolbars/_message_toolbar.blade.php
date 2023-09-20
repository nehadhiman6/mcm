<div class="toolbar">
  <nav class="tabs">
    <ul class="-primary">
      @can('MESSAGES')
        <li>
          <a class="shortcut tile {{ checkActive('') }}" href='{{ url('/messages') }}'>
            <small class="t-overflow">Broadcast to class</small>
          </a>
        </li>
      @endcan

      @can('MESSAGES')
        <li>
          <a class="shortcut tile {{ checkActive('') }}" href='{{ url('/messages') }}'>
            <small class="t-overflow">Message to Student</small>
          </a>
        </li>
      @endcan

      @can('MESSAGES-STAFF')
        <li>
          <a class="shortcut tile {{ checkActive('') }}"href='{{ url('/staffmsg') }}'>
            <small class="t-overflow">Message to Staff</small>
          </a>
        </li>
      @endcan

      
      @can('send-stu-result-email')
        <li>
          <a class="shortcut tile {{ checkActive('send-stu-result-email') }}" href='{{ url('/send-stu-result-email') }}'>
            <small class="t-overflow">Student Result Email</small>
          </a>
        </li>
      @endcan
      @can('send-stu-email')
        <li> 
          <a class="shortcut tile {{ checkActive('send-email') }}" href='{{ url('/send-email') }}'>
            <small class="t-overflow">Email</small>
          </a>
        </li> 
      @endcan
    </ul>
  </nav>
</div>