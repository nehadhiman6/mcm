<div class="toolbar">
    <nav class="tabs">
       <ul class="-primary">
           @can('inv-damage')
                <li>
                    <a class="shortcut tile {{ checkActive('damages') }}" href='{{ url('damages') }}'>
                        <small class="t-overflow">Damage List</small>
                    </a>
                </li>
            @endcan

            {{-- @can('add-inv-damage')
                <li>
                    <a class="shortcut tile {{ checkActive('damages/create') }}" href='{{ url('damages/create') }}'>
                        <small class="t-overflow">Add Damage</small>
                    </a>
                </li>
            @endcan --}}
      </ul>
    </nav>
</div>