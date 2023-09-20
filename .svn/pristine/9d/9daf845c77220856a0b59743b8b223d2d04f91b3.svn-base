@extends('app')

@section('content')
<div class="box" id="app">
  <div class="box-header">
    <h3 class="box-title">{{ $item }}</h3>
    <h5 class="box-title">{{ $start_date }} to {{ $end_date }},
      <span>{{ $store}}</span>

      <span>{{ $location}}</span>

    </h5>
   
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Date</th>
          <th>Particular</th>
          <th>Person </th>
          <th>Quantity Received</th>
          <th>Quantity Issued</th>
          <th>Total Balance</th>
        </tr>
      </thead>
      <!-- <tbody> -->
        
      <!-- </tbody> -->
      <tbody>
        @if(floatval($opqty) != 0)
        <tr>
          <td>{{ $start_date }}</td>
          <td>Opening Stock</td>
          <td></td>
          <td>{{ $opqty }}</td>
          <td></td>
          <td>{{ $opqty }}</td>
        </tr>
        @endif
        @foreach($stockledger as $var)
        <tr>
          <td>{{ $var->trans_date }}</td>
          <td>{{ $var->part }}</td>
          @if( $var->staff != null)
          <td>{{ $var->staff->name .' '. $var->staff->middle_name .' '. $var->staff->last_name }}</td>
          @else
          <td></td>
          @endif
          <td>{{ $var->r_qty }}</td>
          <td>{{ $var->i_qty }}</td>
          <td>{{ $var->bal }}</td>
        </tr>
        @endforeach 
      </tbody>
      <!-- <tfoot>
        <tr>
          <th></th>
        </tr>
      </tfoot> -->
    </table>
  </div>
  <!-- /.box-body -->
</div>
@stop
@section('script')
<script>
var sm = new Vue({

  el: '#app',
  data: {
      dt1 : {!! json_encode($start_date) !!},
      dt2 : {!! json_encode($end_date) !!},
      item : {!! json_encode($item) !!},
      store : {!! json_encode($store) !!},
      location : {!! json_encode($location) !!},
      msg:'',
      
  },
  ready:function(){
      var self = this;
      var item = self.item == null ? '' : self.item;
      var store = self.store == null ? '' : self.store;
      var location = self.location == null ? '' : self.location;
      
      // console.log(item);
      self.msg = self.dt1 +' to '+self.dt2+' , '+item+' , '+store+' , '+location;

      $(function () {
      // $("#example1").DataTable();
      $('#example1').DataTable({
        dom: 'Bfrtip',
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering":false,
        "info": true,
        "autoWidth": false,
        buttons: [
          'pageLength',
              {
                  extend: 'excelHtml5',
                  header: true,
                  footer: true,
                  // exportOptions: { 
                  //   orthogonal: 'export' ,
                  // },
                  messageTop: function () {
                      return self.msg;
                    },
                  
              },

              {
                  
                header: true,
                footer: true,
                extend: 'pdfHtml5',
                download: 'open',
                // orientation: 'landscape',
                // pageSize: 'LEGAL',
                title: function () {
                      var title = '';
                        // title += "Stock Register Report    ";
                        title = self.msg
                      return title;
                },
                  
                
              }
          ],
      });
    });
  },
  

});
  
</script>
@stop
