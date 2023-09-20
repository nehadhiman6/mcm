<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Researches List</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Type</th>
          <th>Title1</th>
          <th>Title2</th>
          <th>Status of Paper</th>
          <th>Level</th>
          <th>Publisher</th>
          <th>Mode of publication</th>
          <th>ISBN/ISSN</th>
          <th>Affiliating institute</th>
          <th></th>
          
        </tr>
      </thead>
      <tbody>
        <tr v-for="research in researches">
          <td>@{{ $index+1 }}</td>
          <td>@{{ research.type }}</td>
          <td>@{{ research.title1 }}</td>
          <td>@{{ research.title2 }}</td>
          <td>@{{ research.paper_status }}</td>
          <td>@{{ research.level }}</td>
          <td>@{{ research.publisher }}</td>
          <td>@{{ research.pub_mode }}</td>
          <td>@{{ research.isbn }}</td>
          <td>@{{ research.institute }}</td>
            <td><button class="btn-xs btn-primary" @click.prevent="editRes(research.id)">Edit</button></td>
 
        </tr>
      </tbody>
    </table>
  </div>
</div>