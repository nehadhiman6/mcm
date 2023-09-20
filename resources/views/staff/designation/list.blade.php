<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Designations List</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Name</th>
          @if(auth()->user()->hasRole('TEACHERS'))
          @else
          <th></th>
          @endif
        </tr>
      </thead>
      <tbody>
        <tr v-for="desig in designations">
          <td>@{{ $index+1 }}</td>
          <td>@{{ desig.name }}</td>
          @can('designation-modify')
            @if(auth()->user()->hasRole('TEACHERS'))
            @else
            <td><button class="btn-xs btn-primary" @click.prevent="edit(desig.id)">Edit</button></td>
            @endif
          @endcan
        </tr>
      </tbody>
    </table>
  </div>
</div>