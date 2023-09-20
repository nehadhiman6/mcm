<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('inv-stock-register')
                <li>
                    <a class="shortcut tile {{ checkActive('stock-register') }}" href='{{ url('stock-register') }}'>
                        <small class="t-overflow">Stock Register</small>
                    </a>
                </li>
            @endcan
            @can('long-term-asset')
                <li>
                    <a class="shortcut tile {{ checkActive('long-term-asset') }}" href='{{ url('long-term-asset') }}'>
                        <small class="t-overflow">Long Term Asset</small>
                    </a>
                </li>
            @endcan

            <li>
                <a class="shortcut tile {{ checkActive('item-staff-loc-stock') }}" href='{{ url('item-staff-loc-stock') }}'>
                    <small class="t-overflow">Item/Staff/Location Wise Stock Report</small>
                </a>
            </li>
        </ul>
    </nav>
</div>