<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
        @can('NEW-ADMISSION')
            <li>
                <a class="shortcut tile {{ checkActive('admissions/create') }}" href='{{ url('/admissions/create') }}'>
                    <small class="t-overflow">College</small>
                </a>
            </li>
        @endcan

        @can('ADMISSION-REGISTER')
            <li>
                <a class="shortcut tile {{ checkActive('admregister') }}" href='{{ url('/admregister') }}'>
                    <small class="t-overflow">Adm Register</small>
                </a>
            </li>
        @endcan
            
        @can('CENTRALIZED-STUDENT')
            <li>
            <a class="shortcut tile {{ checkActive('centralized/students') }}" href='{{ url('/centralized/students') }}'>
                <small class="t-overflow">Centralized Student List</small>
            </a>
            </li>
        @endcan

        <!-- @can('CENTRALIZED-STUDENT') -->
            <li>
            <a class="shortcut tile {{ checkActive('pre-registration') }}" href='{{ url('/pre-registration') }}'>
                <small class="t-overflow">Pre Registration List</small>
            </a>
            </li>
        <!-- @endcan -->
        </ul>
    </nav>
</div>