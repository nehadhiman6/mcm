<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('inv-issue')
                <li>
                    <a class="shortcut tile {{ checkActive('issues') }}" href='{{ url('issues') }}'>
                        <small class="t-overflow">Issue List</small>
                    </a>
                </li>
            @endcan

            {{-- @can('add-inv-issue')
                <li>
                    <a class="shortcut tile {{ checkActive('issues/create') }}" href='{{ url('issues/create') }}'>
                        <small class="t-overflow">Add Issue</small>
                    </a>
                </li>
            @endcan --}}
        </ul>
    </nav>
</div>