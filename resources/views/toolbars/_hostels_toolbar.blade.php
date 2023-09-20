<div class="toolbar">
    <nav class="tabs">
		<ul class="-primary">
			@can('HOSTEL-STUDENTS-LIST')
			<li>
				<a class="shortcut tile {{ checkActive('hostels') }}" href='{{ url('/hostels') }}'>
				<small class="t-overflow">Hostel Students List</small>
				</a>
			</li>
			@endcan
			@can('HOSTEL-OUTSIDER-LIST')
			<li>
				<a class="shortcut tile {{ checkActive('hostels/outsiders') }}" href='{{ url('/hostels/outsiders') }}'>
				<small class="t-overflow">Outsiders</small>
				</a>
			</li>
			@endcan
			@can('HOSTEL-OUTSIDER-LEDGER')
			<li>
				<a class="shortcut tile {{ checkActive('hostels/outsiders/ledger') }}" href='{{ url('/hostels/outsiders/ledger') }}'>
				<small class="t-overflow">Outsider Ledger</small>
				</a>
			</li>
			@endcan

			@can('HOSTEL-ADMISSION')
			<li>
				<a class="shortcut tile {{ checkActive('hostels/create') }}" href='{{ url('/hostels/create') }}'>
				<small class="t-overflow">Hostel Adm</small>
				</a>
			</li>
			@endcan
	
			@can('HOSTEL-OUTSIDER-FORM')
			<li>
				<a class="shortcut tile {{ checkActive('hostels/outsiders/create') }}" href='{{ url('/hostels/outsiders/create') }}'>
				<small class="t-overflow">Outsider Adm (Hostel)</small>
				</a>
			</li>
			@endcan

			@can('hostel-allocation')
			<li>
				<a class="shortcut tile {{ checkActive('hostels-allocation') }}" href='{{ url('hostels-allocation') }}'>
				<small class="t-overflow">Hostel Allocation</small>
				</a>
			</li>
			@endcan
	
			@can('hostel-allocation-list')
			<li>
				<a class="shortcut tile {{ checkActive('hostels-allocation/students') }}" href='{{ url('hostels-allocation/students') }}'>
				<small class="t-overflow">Allocated Students</small>
				</a>
			</li>
			@endcan
	
			@can('hostel-attendance')
			<li>
				<a class="shortcut tile {{ checkActive('hostel-attendance') }}" href='{{ url('hostel-attendance') }}'>
				<small class="t-overflow">Attendance</small>
				</a>
			</li>
			@endcan
	
			@can('night-out-entry')
			<li>
				<a class="shortcut tile {{ checkActive('night-out/create') }}" href='{{ url('night-out/create') }}'>
				<small class="t-overflow">Night Out Entry</small>
				</a>
			</li>
			@endcan
	
			@can('night-out-return-entry')
			<li>
				<a class="shortcut tile {{ checkActive('night-out-return') }}" href='{{ url('night-out-return') }}'>
				<small class="t-overflow">Night Out Return</small>
				</a>
			</li>
			@endcan		
		</ul>
    </nav>
</div>
