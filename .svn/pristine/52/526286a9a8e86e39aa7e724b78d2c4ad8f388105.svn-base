<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Course Attended List</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Begin Date</th>
          <th>End Date</th>
          <th>Course</th>
          <th>Topic</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="staff in courses">
          <td>@{{ $index+1 }}</td>
          <td>@{{ staff.begin_date }}</td>
          <td>@{{ staff.end_date }}</td>
          <td>@{{ staff.courses }}</td>
          <td>@{{ staff.topic}}</td>          
        <td><a href="#staff"><button class="btn-xs btn-primary" @click="editCourse(staff.id)">Edit</button></a></td>
        
        </tr>
      </tbody>
    </table>
  </div>
</div>