<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('inv-item')
                <li>
                    <a class="shortcut tile {{ checkActive('items') }}" href='{{ url('items') }}'>
                        <small class="t-overflow">Item List</small>
                    </a>
                </li>
            @endcan

            {{-- @can('add-inv-item')
                <li>
                    <a class="shortcut tile {{ checkActive('items/create') }}" href='{{ url('items/create') }}'>
                        <small class="t-overflow">Add Item</small>
                    </a>
                </li>
            @endcan --}}

            @can('inv-item-category')
                <li>
                    <a class="shortcut tile {{ checkActive('items_categories') }}" href='{{ url('items_categories') }}'>
                        <small class="t-overflow">Category </small>
                    </a>
                </li>
            @endcan

            @can('inv-sub-item-category')
                <li>
                    <a class="shortcut tile {{ checkActive('items_sub_categories') }}" href='{{ url('items_sub_categories') }}'>
                        <small class="t-overflow">Sub Category </small>
                    </a>
                </li>
            @endcan
        </ul>
    </nav>
</div>