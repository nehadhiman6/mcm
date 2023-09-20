<div class="toolbar">
  <nav class="tabs">
    <ul class="-primary">
      @can('prospectus-fees')
        <li>
          <a class="shortcut tile {{ checkActive('prospectus-fees') }}" href='{{ url('/prospectus-fees') }}'>
            <small class="t-overflow">Online Prospectus Fee</small>
          </a>
        </li>
      @endcan
      
      @can('online-transactions')
        <li>
          <a class="shortcut tile {{ checkActive('admission-form/payments') }}" href='{{ url('admission-form/payments') }}'>
              <small class="t-overflow">Online Payments</small>
            </a>
        </li>
      @endcan

      @can('daybook')
        <li>
          <a class="shortcut tile {{ checkActive('daybook') }}" href='{{ url('/daybook') }}'>
            <small class="t-overflow">Day Book</small>
          </a>
        </li>
      @endcan

      @can('daybook2')
        <li>
          <a class="shortcut tile {{ checkActive('daybook2') }}" href='{{ url('/daybook2') }}'>
            <small class="t-overflow">Day Book 2</small>
          </a>
        </li>
      @endcan

      @can('dbsummary')
        <li>
          <a class="shortcut tile {{ checkActive('dbsummary') }}" href='{{ url('/dbsummary') }}'>
            <small class="t-overflow">DB Summary</small>
          </a>
        </li>
      @endcan

      @can('feeheadwise-coll')
        <li>
          <a class="shortcut tile {{ checkActive('feeheadwise-coll') }}" href='{{ url('/feeheadwise-coll') }}'>
            <small class="t-overflow">FW Collection</small>
          </a>
        </li>
      @endcan

      @can('subheadwise-coll')
        <li>
          <a class="shortcut tile {{ checkActive('subheadwise-coll') }}" href='{{ url('/subheadwise-coll') }}'>
            <small class="t-overflow">SW Collection</small>
          </a>
        </li>
      @endcan
    </ul>
  </nav>
</div>