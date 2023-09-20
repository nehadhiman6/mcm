<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Department List</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Name</th>
          <th>Faculty</th>
          @if(auth()->user()->hasRole('TEACHERS'))
          @else
          <th></th>
          @endif
        </tr>
      </thead>
      <tbody>
        <tr v-for="dept in departments">
          <td>@{{ $index+1 }}</td>
          <td>@{{ dept.name }}</td>
          <td>@{{ dept.faculty ? dept.faculty.faculty : ''}}</td>          
        @can('department-modify')
          @if(auth()->user()->hasRole('TEACHERS'))
          @else
            <td><a href="#department"><button class="btn-xs btn-primary" @click="edit(dept.id)">Edit</button></a></td>
          @endif
        @endcan
        </tr>
      </tbody>
    </table>
  </div>
</div>