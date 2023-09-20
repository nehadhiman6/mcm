@extends('app')

@section('toolbar')
  @include('toolbars._inventory_reports')
@stop

@section('content')
@include('inventory.stock.ledger_filter')
<div class="box" id="app">
  <div class="box-header">
    <h3 class="box-title">Stock Register</h3>
    <h5 class="box-title">{{ $dt1 }} to {{ $dt2 }},
      <span style="margin-left:10px">{{ $item}},</span>
      <span style="margin-left:10px">{{ $item_cat}}</span>
      <span style="margin-left:10px">{{ $item_sub_cat}}</span>
      <span style="margin-left:10px">{{ $store}}</span>
      <span style="margin-left:20px">{{ $location}}</span>
    </h5>

  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Opening Stock</th>
          <th>Addition</th>
          <th>Return/Issue</th>
          <th>Total</th>
          <th>Purchase Return</th>
          <th>Issue</th>
          <th>Damages</th>
          <th>Closing</th>
        </tr>
      </thead>
      <tbody>
        @foreach($stockreg as $stock)
        <tr>
          <td>{{$stock->item_code}}</td>
          {{-- <td><a href="#" class="stock-ledger" data-url="{{ url('stock/' . $stock->item_id . '/details') }}">{{$stock->item}}</a></td> --}}
        <td class="stock-ledger"><a href="#" data-item-id="{{ $stock->item_id }}" data-op-qty="{{ $stock->opening }} " class="stock-ledger">{{$stock->item}}</a></td>
          <td>{{ $stock->opening }}</td>
          <td>{{ $stock->addition }}</td>
          <td>{{ $stock->issue_return }}</td>
          <td>{{ $stock->opening+$stock->addition+$stock->issue_return }}</td>
          <td>{{ $stock->pur_return }}</td>
          <td>{{ $stock->issue }}</td>
          <td>{{ $stock->damaged }}</td>
          <td>{{ $stock->opening+$stock->addition+$stock->issue_return-$stock->pur_return-$stock->issue-$stock->damaged }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div id="item-details"></div>
  <!-- /.box-body -->
</div>
@stop

@push('pg_script')
    <script>
        var sm = new Vue({
            el: '#app',
            data: {
                dt1 : {!! json_encode($dt1) !!},
                dt2 : {!! json_encode($dt2) !!},
                item : {!! json_encode($item) !!},
                item_cat : {!! json_encode($item_cat) !!},
                item_sub_cat : {!! json_encode($item_sub_cat) !!},
                store : {!! json_encode($store) !!},
                location : {!! json_encode($location) !!},
                msg:''
                
            },
            ready: function() {
                var self = this;
                var item = self.item == null ? '' : self.item;
                var item_cat = self.item_cat == null ? '' : self.item_cat;
                var item_sub_cat = self.item_sub_cat == null ? '' : self.item_sub_cat;
                var store = self.store == null ? '' : self.store;
                var location = self.item == null ? '' : self.location;
               
                // console.log(item);
                self.msg = self.dt1 +' to '+self.dt2+' , '+item+' , '+item_cat+' , '+item_sub_cat+' , '+store+' , '+location;
                
                // item
                $('.select2item').select2({
                    placeholder: 'Select Items'
                });
                $('.select2item').on('change',function(e){
                    self.item_id = $(this).val();
                });
                // Categories
                $('.select2cat').select2({
                    placeholder: 'Select Categories'
                });
                $('.select2cat').on('change',function(e){
                    self.cat_id = $(this).val();
                });
                // Categories
                $('.select2subcat').select2({
                    placeholder: 'Select Sub Categories'
                });
                $('.select2subcat').on('change',function(e){
                    self.sub_cat_id = $(this).val();
                });

                

              $(function () {
            // $("#example1").DataTable();
                  $('#example1').DataTable({
                      dom: 'Bfrtip',
                      "paging": true,
                      "lengthChange": false,
                      "searching": true,
                      "ordering": true,
                      "info": true,
                      "autoWidth": false,
                      "scrollX": true,
                      buttons: [
                      'pageLength',
                          {
                              extend: 'excelHtml5',
                              exportOptions: { orthogonal: 'export' },
                              header: true,
                              footer: true,
                            
                          },
                          {
                              header: true,
                              footer: true,
                              extend: 'pdfHtml5',
                              download: 'open',
                              orientation: 'landscape',
                              pageSize: 'LEGAL',
                              title: function () {
                                    var title = '';
                                      title += "Stock Register Report    ";
                                      title += self.msg
                                   return title;
                              },
                          }
                      ],
                  });
              });
        
            },
            
            methods: {
                
            }
          });
     
        $('body').on('click','.stock-ledger', function (e) {
                e.preventDefault();
                $('#item-details').html('');
                console.log(vm);
                $('#item-details').append('<form id="item-form" action=\'{{ url("stock/details") }}\' method="GET" target="_blank">');
                $('#item-form').append('<input type="hidden" name="item_id" value="' + e.target.dataset.itemId + '">')
                $('#item-form').append('<input type="hidden" name="op_qty" value="' + e.target.dataset.opQty + '">')
                $('#item-form').append('<input type="hidden" name="date_from" value="' + vm.date_from + '">')
                $('#item-form').append('<input type="hidden" name="date_to" value="' + vm.date_to + '">')
                $('#item-form').append('<input type="hidden" name="loc_id" value="' + vm.loc_id + '">')
                $('#item-form').append('<input type="hidden" name="store_id" value="' + vm.store_id + '">')
                  .submit();
                  this.btn_show = true;
              });
        
        
    </script>
@endpush
