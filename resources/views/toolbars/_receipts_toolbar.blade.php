<div class="toolbar">
    <nav class="tabs">
        <ul class="-primary">
            @can('COLLEGE-RECEIPT')
                <li>
                    <a class="shortcut tile {{ checkActive('receipts-college/create') }}" href='{{ url('/receipts-college/create') }}'>
                        <small class="t-overflow">College Receipts</small>
                    </a>
                </li>
            @endcan

            @can('HOSTEL-RECEIPT')
                <li>
                    <a class="shortcut tile {{ checkActive('receipts-hostel/create') }}" href='{{ url('/receipts-hostel/create') }}'>
                        <small class="t-overflow">Hostel Receipts</small>
                    </a>
                </li>
            @endcan

            @can('OUTSIDER-HOSTEL-RECEIPT')
                <li>
                    <a class="shortcut tile {{ checkActive('receipts-outsider/create') }}" href='{{ url('/receipts-outsider/create') }}'>
                        <small class="t-overflow">Outsider Hostel Receipts</small>
                    </a>
                </li>
            @endcan

            @can('MISCELLANEOUS-INSTALLMENTS')
                <li>
                    <a class="shortcut tile {{ checkActive('misc-insts/create') }}" href='{{ url('/misc-insts/create') }}'>
                        <small class="t-overflow">Misc. Installments</small>
                    </a>
                </li>
            @endcan
        </ul>
    </nav>
</div>