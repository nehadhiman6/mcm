<div class="toolbar">
	<nav class="tabs">
        <ul class="-primary">
            @can('BILL-CANCELLATION')
                <li>
                    <a class="shortcut tile {{ checkActive('bill/cancel') }}" href='{{ url('/bill/cancel') }}'>
                        <small class="t-overflow">Bill Cancellation</small>
                    </a>
                </li>
            @endcan

            @CAN('ONLINE-TRANSACTION-STATUS')
                <li>
                    <a class="shortcut tile {{ checkActive('checktrans') }}" href='{{ url('/checktrans') }}'>
                        <small class="t-overflow">Online Trn. Status</small>
                    </a>
                </li>
            @endcan

            @can('FEE-INSTALLMENTS')
                <li>
                    <a class="shortcut tile {{ checkActive('fee-insts/create') }}" href='{{ url('/fee-insts/create') }}'>
                        <small class="t-overflow">Fee Installments</small>
                    </a>
                </li>
            @endcan

            @can('HOSTEL-FEE-INSTALLMENTS')
                <li>
                    <a class="shortcut tile {{ checkActive('host-fee-insts/create') }}" href='{{ url('/host-fee-insts/create') }}'>
                        <small class="t-overflow">Hostel Fee Inst</small>
                    </a>
                </li>
            @endcan

            @can('CENTERALIZED-FEE-INSTALLMENTS')
                <li>
                    <a class="shortcut tile {{ checkActive('cent-fee-insts/create') }}" href='{{ url('/cent-fee-insts/create') }}'>
                        <small class="t-overflow">Centeralized Installments</small>
                    </a>
                </li>
            @endcan

            @can('STUDENT-SUBJECT-CHARGES')
                <li>
                    <a class="shortcut tile {{ checkActive('stdsubcharges') }}" href='{{ url('/stdsubcharges') }}'>
                        <small class="t-overflow">Subject Charges</small>
                    </a>
                </li>
            @endcan
            @can('refund-requests-details')
            <li>
                    <a class="shortcut tile {{ checkActive('refund-requests-details') }}" href='{{ url('/refund-requests-details') }}'>
                        <small class="t-overflow">Refund Request List</small>
                    </a>
                </li>
            @endcan  
        </ul>
  </nav>
</div>