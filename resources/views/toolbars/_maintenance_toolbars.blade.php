<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('CATEGORIES')
                <li>
                    <a class="shortcut tile {{ checkActive('categories') }}" href='{{ url('/categories') }}'>
                        <small class="t-overflow">Categories</small>
                    </a>
                </li>
            @endcan

            @can('RESERVED-CATEGORIES')
                <li>
                    <a class="shortcut tile {{ checkActive('resvcategories') }}" href='{{ url('/resvcategories') }}'>
                        <small class="t-overflow">Resv. Categories</small>
                    </a>
                </li>
            @endcan

            @can('BOARD-UNIV')
                <li>
                    <a class="shortcut tile {{ checkActive('boards') }}" href='{{ url('/boards') }}'>
                        <small class="t-overflow">Boards</small>
                    </a>
                </li>
            @endcan

            @can('COURSES')
                <li>
                    <a class="shortcut tile {{ checkActive('courses') }}" href='{{ url('/courses') }}'>
                        <small class="t-overflow">Courses</small>
                    </a>
                </li>
            @endcan

            @can('SUBJECTS')
                <li>
                    <a class="shortcut tile {{ checkActive('subjects') }}" href='{{ url('/subjects') }}'>
                        <small class="t-overflow">Subjects</small>
                    </a>
                </li>
            @endcan

            @can('CITIES')
                <li>
                    <a class="shortcut tile {{ checkActive('cities') }}" href='{{ url('/cities') }}'>
                        <small class="t-overflow">Cities</small>
                    </a>
                </li>
            @endcan

            @can('STATES')
                <li>
                    <a class="shortcut tile {{ checkActive('states') }}" href='{{ url('/states') }}'>
                        <small class="t-overflow">States</small>
                    </a>
                </li>
            @endcan

            @can('LOCATION-LIST')
                <li>
                    <a class="shortcut tile {{ checkActive('locations') }}" href='{{ url('/locations') }}'>
                        <small class="t-overflow">Locations</small>
                    </a>
                </li>
            @endcan

            @can('ALUMNI-EXPORT')
                <li> 
                    <a class="shortcut tile {{ checkActive('export_to_alumni') }}" href='{{ url('/export_to_alumni') }}'>
                        <small class="t-overflow">Alumni Export</small>
                    </a>
                </li>
            @endcan

            @can('FEEDBACK-SECTIONS')
                <li>
                    <a class="shortcut tile {{ checkActive('feedback-sections') }}" href='{{ url('/feedback-sections') }}'>
                        <small class="t-overflow">Feedback Section</small>
                    </a>
                </li>
            @endcan

            @can('FEEDBACK-QUESTIONS')
                <li>
                    <a class="shortcut tile {{ checkActive('feedback-questions') }}" href='{{ url('/feedback-questions') }}'>
                        <small class="t-overflow">Feedback Question</small>
                    </a>
                </li>
            @endcan

            @can('sub-combination')
                <li>
                    <a class="shortcut tile {{ checkActive('subject-combination') }}" href='{{ url('/subject-combination') }}'>
                        <small class="t-overflow">Subject Combination</small>
                    </a>
                </li>
            @endcan
        </ul>
    </nav>
</div>