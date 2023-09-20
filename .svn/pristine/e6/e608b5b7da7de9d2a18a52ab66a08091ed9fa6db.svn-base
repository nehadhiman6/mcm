<div class="toolbar">
	<nav class="tabs">
      <ul class="-primary">
        @can('ADMISSION-FORMS')
          <li>
            <a class="shortcut tile {{ checkActive('admission-form') }}" href='{{ url('/admission-form') }}'>
              <small class="t-overflow">AdmForms</small>
            </a>
          </li>
        @endcan
        @can('NEW-ADMISSION-FORMS')
          <li>
              <a class="shortcut tile {{ checkActive('admission-form/create') }}" href='{{ url('/admission-form/create') }}'>
                <small class="t-overflow">New AdmForm</small>
              </a>
          </li>
        @endcan
        @can('SUBJECT-WISE-STRENGTH')
          <li>
            <a class="shortcut tile {{ checkActive('sub-admstrength') }}" href='{{ url('sub-admstrength') }}'>
              <small class="t-overflow">Subject wise Strength</small>
            </a>
          </li>
        @endcan
        {{-- @can('payments-report')
          <li>
              <a class="shortcut tile {{ checkActive('admission-form/payments') }}" href='{{ url('admission-form/payments') }}'>
                <small class="t-overflow">Payments</small>
              </a>
          </li>
        @endcan --}}
      </ul>
  </nav>
</div>
