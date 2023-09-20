@extends('app')
@section('content') 

<div class="box box-default box-solid " id='app'>
  <div class="box-header with-border">
    Fee Structure
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('std_type_id','Student Type',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('std_type_id',getStudentType(),null,['class' => 'form-control','v-model'=>'std_type_id']) !!}
      </div>
      {!! Form::label('installment_id','Installment',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('installment_id',getInstallment(),null,['class' => 'form-control','v-model'=>'installment_id']) !!}
      </div>
    </div>
    <div class='form-group'>
      {!! Form::label('head_type','Head Type',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('head_type',['College'=>'College','Hostel'=>'Hostel'],null,['class' => 'form-control','v-model'=>'head_type']) !!}
      </div>
      {!! Form::label('fund_id','Fund',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('fund_id',getFunds(),null,['class' => 'form-control','v-model'=>'fund_id']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
     {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
      {!! Form::close() !!}
  </div>
  
</div>
<div class="panel panel-default">
  <div class='panel-heading'>
    <strong>Fee Structure Report</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
@stop
@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
       tData: [],
       std_type_id: {{ $stdtype->id or request("std_type_id",0) }},
       installment_id: {{ $installment->id or request("installment_id",0) }},
       head_type: '{{ $head_type or request("head_type")  }}',
       fund_id: {{ $fund->id or request("fund_id",0) }},
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
          { title: 'SubHead', targets: 1, data: '' },
          { title: 'Amount', targets: 2, data: '' },
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
      });
    },
  methods: {
    getData: function() {
        data = $.extend({}, {
          std_type_id: this.std_type_id,
          installment_id: this.installment_id,
          fund_id: this.fund_id,
          head_type: this.head_type,
        })
        this.$http.get("{{ url('feestr-report') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
        });
      },
      
      reloadTable: function() {
        console.log('here');
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    }
  
  });
</script>
@stop