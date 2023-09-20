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
  {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
      </div>
      {!! Form::label('scope','Scope',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('scope',['C'=>'College','H'=>'Hostel'],null,['class' => 'form-control','v-model'=>'scope']) !!}
      </div>
      {!! Form::label('concession_id','Concession',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('concession_id',getConcession(),null,['class' => 'form-control','v-model'=>'concession_id']) !!}
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
    <strong>List Of Student Having Concession</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
      <tfoot><th></th><th></th><th></th><th>Total:</th><th></th><th></th></tfoot>
    </table>
  </div>
</div>
@stop
@section('script')
<script>
var vm = new Vue({
  el: '#app',
  data: {
      tData: [],
      course_id: {{ $course->id or request("course_id",0) }},
      scope: 'C',
      concession_id: {{ $concession->id or request("concession_id",0) }},
      table: null,
      success: false,
      fails: false,
      errors: {},
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
           { title: 'S.No.', targets: 0, data: 'id',
          "render": function( data, type, row, meta) {
            return meta.row + 1;
          }},
          { title: 'Admission No', targets: 1, data: 'adm_no'},
          { title: 'Student Name', targets: 2, data: 'name'},
          { title: 'Roll No', targets: 3, data: 'roll_no'},
          { title: 'Bills Detail', targets: 4, data: 'fee_bills',
            render: function(data, type, row, meta) {
              var bills = '';
              if(data) {
                $.each(data, function(index, fee_bill) {
                  bills += 'B. No. '+fee_bill.id+(fee_bill.amt_paid ? ' (Paid: '+fee_bill.amt_paid.amt_paid+') ' : '');
                  bills += (fee_bill.concession ? fee_bill.concession.name+': ' : '')+fee_bill.con_amt+'<br>';
                });
              }
              return bills;
            }
          },
          { title: 'Concession Detail', targets: 5, data: 'fee_bills',
            render: function(data, type, row, meta) {
              var bills = '';
              if(data) {
                $.each(data, function(index, fee_bill) {
                  $.each(fee_bill.fee_bill_dets, function(index, fee_bill_det) {
                    bills += fee_bill_det.feehead.name+': '+fee_bill_det.concession+'<br>';
                  });
                });
              }
              return bills;
            }
          },
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
          var con_tot = 0.00;
          $.each(self.tData, function(index, row){
            $.each(row.fee_bills, function(index, fee_bill){
              con_tot += intVal(fee_bill.con_amt);
            });
          });
          $(api.column(4).footer()).html(con_tot);
          
        }
      });
    },
  methods: {
    getData: function() {
        this.errors = {};
        this.fails = false;
        var data = {
          course_id: this.course_id,
          scope: this.scope,
          concession_id: this.concession_id,
        };
        this.$http.get("{{ url('concess-report') }}", {params: data})
          .then(function (response) {
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
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