<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('USERS')
                <li>
                    <a class="shortcut tile {{ checkActive('users') }}" href='{{ url('/users') }}'>
                    <small class="t-overflow">Users</small>
                    </a>
                </li>
            @endcan

            @can('ROLES')
                <li>
                    <a class="shortcut tile {{ checkActive('roles') }}" href='{{ url('/roles') }}'>
                    <small class="t-overflow">Roles</small>
                    </a>
                </li>
            @endcan

            @can('GROUPS')
                <li>
                    <a class="shortcut tile {{ checkActive('groups') }}" href='{{ url('/groups') }}'>
                    <small class="t-overflow">Groups</small>
                    </a>
                </li>
            @endcan

            @can('PERMISSIONS')
                <li>
                    <a class="shortcut tile {{ checkActive('permissions') }}" href='{{ url('/permissions') }}'>
                        <small class="t-overflow">Permissions</small>
                    </a>
                </li>
            @endcan
        </ul>
    </nav>
</div>