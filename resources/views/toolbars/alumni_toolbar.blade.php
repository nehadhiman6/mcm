<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('ALUMNI-LIST')
                <li>
                    <a class="shortcut tile {{ checkActive('alumnies') }}" href='{{ url('/alumnies') }}'>
                        <small class="t-overflow">Alumni</small>
                    </a>
                </li>
            @endcan

            @can('ALUMNI-EVENT-LIST')
                <li>
                    <a class="shortcut tile {{ checkActive('alumnies/event') }}" href='{{ url('/alumnies/event') }}'>
                        <small class="t-overflow">Alumni Meet List </small>
                    </a>
                </li>
            @endcan
        </ul>
    </nav>
</div>