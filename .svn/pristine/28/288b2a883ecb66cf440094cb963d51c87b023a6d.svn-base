<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Faculty List</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Faculty</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="faculty in faculties">
          <td>@{{ $index+1 }}</td>
          <td>@{{ faculty.faculty }}</td>
          @can('faculty-modify')
            <td><button class="btn-xs btn-primary" @click.prevent="edit(faculty.id)">Edit</button></td>
          @endcan
        </tr>
      </tbody>
    </table>
  </div>
</div>