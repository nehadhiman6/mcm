<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('inv-vendor')
                <li>
                    <a class="shortcut tile {{ checkActive('vendors') }}" href='{{ url('vendors') }}'>
                        <small class="t-overflow">Vendor List</small>
                    </a>
                </li>
            @endcan

            {{-- @can('add-inv-vendor')
                <li>
                    <a class="shortcut tile {{ checkActive('vendors/create') }}" href='{{ url('vendors/create') }}'>
                        <small class="t-overflow">Add Vendor</small>
                    </a>
                </li>
            @endcan --}}
        </ul>
    </nav>
</div>