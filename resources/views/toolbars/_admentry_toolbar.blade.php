<div class="toolbar">
	<nav class="tabs">
      <ul class="-primary">
          @can('ADMISSION-ENTRY')
            <li>
              <a class="shortcut tile {{ checkActive('adm-entries') }}" href='{{ url('/adm-entries') }}'>
                <small class="t-overflow">AdmEntries</small>
              </a>
            </li>
          @endcan
          @can('NEW-ADMISSION-ENTRY')
            <li>
                <a class="shortcut tile {{ checkActive('adm-entries/create') }}" href='{{ url('/adm-entries/create') }}'>
                  <small class="t-overflow">New AdmEntry</small>
                </a>
            </li>
          @endcan
          @can('CONSENTS')
          <li>
            <a class="shortcut tile {{ checkActive('consents') }}" href='{{ url('/consents') }}'>
              <small class="t-overflow">Consents</small>
            </a>
          </li>
        @endcan
        @can('NEW-CONSENT-ENTRY')
          <li>
              <a class="shortcut tile {{ checkActive('consents/create') }}" href='{{ url('/consents/create') }}'>
                <small class="t-overflow">New Consent</small>
              </a>
          </li>
        @endcan
        @can('discrepancy-entry')
          <li>
              <a class="shortcut tile {{ checkActive('discrepancy/create') }}" href='{{ url('/discrepancy/create') }}'>
                <small class="t-overflow">Discrepancy Form</small>
              </a>
          </li>
        @endcan
      </ul>
  </nav>
</div>