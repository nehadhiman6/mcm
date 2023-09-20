@extends('app')
@section('toolbar')
@include('toolbars._fees_reports_toolbar')
@stop
@section('content')
<div class="box box-default box-solid" id='app'>
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
        {!! Form::label('fund_id','Fund',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::select('fund_id',getFunds(),null,['class' => 'form-control','v-model' => 'fund_id']) !!}
        </div>
      </div>
    </div>
    <div class="box-footer">
      {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
      {!! Form::close() !!}
    </div>
  </div>
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Feehead wise Balance Outstanding</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
      <tfoot><th></th><th>Total:</th><th></th></tfoot>
    </table>
  </div>
</div>
@stop
@section('script')
<script>
var dashboard = new Vue({
  el: '#app',
  data: {
    fund_id: {{ $fund_id }},
    fund_type: "{{ $fund_type }}",
    table: null,
    tData: [],
    success: false,
    fails: false,
    errors: {},
    funds: {!! \App\Fund::get(['id', 'name'])->toJson() !!},
  },
  created: function() {
    self = this;
    this.table = $('#example1').DataTable({
//      "searchDelay": 1000,
      dom: 'Bfrtip',
      lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
         'pageLength',
          {
              extend: 'excelHtml5',
              footer: true,
              filename: 'fund_wise_collection',
              exportOptions: { orthogonal: 'export' }
          },
        ],
      "processing": true,
      "scrollCollapse": true,
//      "serverSide": true,
      "ordering": true,
      data: [],
      columnDefs: [
         { title: 'S.No.', targets: 0, data: 'id',
        "render": function( data, type, row, meta) {
          return meta.row + 1;
        }},
        { title: 'Feeheads Name', targets: 1, data: 'name'},
        { title: 'Amount', targets: 2, data: 'bal_amt' },
        { targets: '_all', visible: true }
      ],
//      "deferRender": true,
      "sScrollX": true,
      "footerCallback": function (row, data, start, end, display) {
        var api = this.api();
        var colNumber = [2];

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
            return typeof i === 'string' ? 
                i.replace(/[\$,]/g, '') * 1 :
                typeof i === 'number' ?
                i : 0;
        };

        for (i = 0; i < colNumber.length; i++) {
            var colNo = colNumber[i];
//              console.log(colNo);
            var total2 = api
                    .column(colNo)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            $(api.column(colNo).footer()).html(total2);
        }
      }
    });
    if(this.fund_id > 0)
      this.getData();
  },
  methods: {
    getData: function() {
        this.errors = {};
        this.fails = false;
        data = {
          fund_id: this.fund_id,
          fund_type: this.fund_type
        };
        this.$http.get("{{ url('feeheadbalance') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
//            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
            this.fails = true;
            this.errors = response.data;
        });
      },
      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
  }
  
  });
</script>
@stop