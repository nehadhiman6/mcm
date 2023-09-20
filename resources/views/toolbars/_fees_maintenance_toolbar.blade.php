<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('FEE-STRUCTURE')
                <li>
                    <a class="shortcut tile {{ checkActive('feestructure') }}" href='{{ url('/feestructure') }}'>
                        <small class="t-overflow">Fee Structure</small>
                    </a>
                </li>
            @endcan

            @can('SUBJECT-CHARGES')
                <li>
                    <a class="shortcut tile {{ checkActive('subcharges') }}" href='{{ url('/subcharges') }}'>
                        <small class="t-overflow">Subject Charges</small>
                    </a>
                </li>
            @endcan

            @can('INSTALLMENTS')
                <li>
                    <a class="shortcut tile {{ checkActive('installments') }}" href='{{ url('/installments') }}'>
                        <small class="t-overflow">Installments</small>
                    </a>
                </li>
            @endcan

            @can('FEEHEADS')
                <li>
                    <a class="shortcut tile {{ checkActive('feeheads') }}" href='{{ url('/feeheads') }}'>
                        <small class="t-overflow">FeeHeads</small>
                    </a>
                </li>
            @endcan
            
            @can('CONCESSIONS')
                <li>
                    <a class="shortcut tile {{ checkActive('concessions') }}" href='{{ url('/concessions') }}'>
                        <small class="t-overflow">Concessions</small>
                    </a>
                </li>
            @endcan

            @can('SUBHEAD-FEE-STRUCTURE')
                <li>
                    <a class="shortcut tile {{ checkActive('feestructure/subheads') }}" href='{{ url('feestructure/subheads') }}'>
                        <small class="t-overflow">Subhead Fee Structure</small>
                    </a>
                </li>
            @endcan

            @can('COPY-FEE-STRUCTURE')
                <li>
                    <a class="shortcut tile {{ checkActive('feestructure/copy') }}" href='{{ url('feestructure/copy') }}'>
                        <small class="t-overflow">Copy Fee Structure</small>
                    </a>
                </li>
            @endcan

            @can('app-setting')
                <li>
                    <a class="shortcut tile {{ checkActive('app-setting/create') }}" href='{{ url('/app-setting/create') }}'>
                        <small class="t-overflow">Student college/hostel fee Control</small>
                    </a>
                </li>
            @endcan
        </ul>
    </nav>
</div>