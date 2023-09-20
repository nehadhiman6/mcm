@extends('app')
@section('toolbar')
@include('toolbars._fees_reports_toolbar')
@stop
@section('content')
<div id="app">
  <div class="box default box-solid">
    <div class="box-header with-border">
      Filter
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      {!! Form::open(['url'=>'', 'class' => 'form-horizontal']) !!}
      <div class='form-group'>
        {!! Form::label('fund_type','Fund Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('fund_type',[''=>'All','C'=>'College','H'=>'Hostel'],null,['class' => 'form-control','v-model' => 'fund_type']) !!}
        </div>
      </div>
    </div>
    <div class="box-footer">
      {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Fund wise Balance Outstanding</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1" width="100%">
      <tfoot><th></th><th>Total:</th><th></th></tfoot>
    </table>
  </div>
</div>
<div id="feehead-box"></div>
@stop
@section('script')
<script>
  $(document).on('click','.feehead-link',function(e) {
    e.preventDefault();
    $('#feehead-box').html('');
    if($(this).data('type') == 'feehead') {
      $('#feehead-box').append('<form id="feehead-form" action=\'{{ url("feeheadbalance") }}\' method="GET" target="_blank">');
      $('#feehead-form').append('<input type="hidden" name="fund_id" value="' + $(this).data('fundid') + '">')
        .append('<input type="hidden" name="fund_type" value="' + dashboard.fund_type + '">')
        .submit();
    } else {
      $('#feehead-box').append('<form id="feehead-form" action=\'{{ url("subheadbalance") }}\' method="GET" target="_blank">');
      $('#feehead-form').append('<input type="hidden" name="fund_id" value="' + $(this).data('fundid') + '">')
        .append('<input type="hidden" name="fund_type" value="' + dashboard.fund_type + '">')
        .submit();
    }
  });
  
  var dashboard = new Vue({
    el: '#app',
    data: {
      tData: [],
      fund_type: '',
      table: null,
      url: "{{ url('/') . 'pendbalance/' }}",
    },
    
    created: function() {
      self = this;
      this.table = $('#example1').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
           'pageLength',
           {
                extend: 'excelHtml5',
                exportOptions: { orthogonal: 'export' }
            },
        ],
        "processing": true,
        "scrollCollapse": true,
        "ordering": true,
        data: [],
        columnDefs: [
          { title: 'S.No.', targets: 0, data: '',
            "render": function( data, type, row, meta) {
              return meta.row + 1;
            }},
          { title: 'Fund', targets: 1, data: 'name' },
          { title: 'Pending', targets: 2, data: 'bal_amt'},
          { title: '', targets: 3, data: 'name',
            "render": function( data, type, row, meta) {
            return "<button class='btn btn-primary btn-xs feehead-link' data-type='feehead' data-fundid='"+row.id+"' >Feehead Wise Details</button><br> \
              <button class='btn btn-primary btn-xs feehead-link' data-type='subhead' data-fundid='"+row.id+"' >Subhead Wise Details</button>";
          }},
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
        "footerCallback": function (row, data, start, end, display) {
          var api = this.api();
          var colNumber = [4];
                   
          // Remove the formatting to get integer data for summation
          var intVal = function (i) {
              return typeof i === 'string' ? 
                  i.replace(/[\$,]/g, '') * 1 :
                  typeof i === 'number' ?
                  i : 0;
          };

//          for (i = 0; i < colNumber.length; i++) {
//              var colNo = colNumber[i];
//              var total2 = api
//                      .column(colNo)
//                      .data()
//                      .reduce(function (a, b) {
//                          return intVal(a) + intVal(b);
//                      }, 0);
//          }
          var tot = 0.00;
          $.each(self.tData, function(index, row){
//            $.each(row.fee_bills, function(index, fee_bill){
              tot += intVal(row.bal_amt);
//            });
          });
          $(api.column(2).footer()).html(tot);
          
        }
      });
    },
    
    methods: {
      getData: function() {
        data = $.extend({}, {
          fund_type: this.fund_type
        })
        this.$http.get("{{ url('fundbalance') }}", {params: data})
          .then(function (response) {
//            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
        });
      },
      reloadTable: function() {
        console.log('here');
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    }
  });

  $('#class_ids').on('change',function(){
    dashboard['class_ids'] = $(this).val();
  });
</script>
@stop
