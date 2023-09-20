  <div class='panel-heading'>
    <strong>Sections</strong>
  </div>
  
  <div class='panel-body'>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>
        @php $i=1 @endphp
        @foreach($sections as $section)
         <tr>
          <td>{{ $i }}</td>
          <td>{{ $section->section }}</td>
          <td>
            @can('EDIT-SECTIONS')
              <a href="{{ url('section/' . $section->id . '/edit') }}" class="btn btn-primary">Edit</a>
            @endcan
          </td>
        </tr>
        @php $i++; @endphp
        @endforeach
    </table>
  </div>

