<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('opening-stocks')
                <li>
                    <a class="shortcut tile {{ checkActive('opening-stocks') }}" href='{{ url('opening-stocks') }}'>
                        <small class="t-overflow">Opening Stocks List</small>
                    </a>
                </li>
            @endcan

            {{-- @can('add-opening-stocks')
                <li>
                    <a class="shortcut tile {{ checkActive(['opening-stocks/create', 'opening-stocks/*/edit']) }}" href='{{ url('opening-stocks/create') }}'>
                        <small class="t-overflow">Add Opening Stocks</small>
                    </a>
                </li>
            @endcan --}}
        </ul>
    </nav>
</div>