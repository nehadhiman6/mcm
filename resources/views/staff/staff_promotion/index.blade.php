<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Promotion List</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Promotion Date</th>
          <th>Old Designation</th>
          <th>New Designation</th>
          
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="prom in promotion">
          <td>@{{ $index+1 }}</td>
          <td>@{{ prom.promotion_date }}</td>
          <td>@{{ prom.old_desig.name }}</td>
          <td>@{{ prom.new_desig.name }}</td>
                   
        <td><a href="#prom"><button class="btn-xs btn-primary" @click="edit(prom.id)">Edit</button></a></td>
        
        </tr>
      </tbody>
    </table>
  </div>
</div>