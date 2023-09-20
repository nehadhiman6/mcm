<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('placement-std-wise-report')
                <li>
                    <a class="shortcut tile {{ checkActive('placement-std-wise-report') }}" href='{{ url('placement-std-wise-report') }}'>
                        <small class="t-overflow">Placement Record(Student wise)</small>
                    </a>
                </li>
            @endcan
            @can('placement-drive-wise-report')
                <li>
                    <a class="shortcut tile {{ checkActive('placement-drive-wise-report') }}" href='{{ url('placement-drive-wise-report') }}'>
                        <small class="t-overflow">Placement Record(Drive wise)</small>
                    </a>
                </li>
            @endcan
           
        </ul>
    </nav>
</div>