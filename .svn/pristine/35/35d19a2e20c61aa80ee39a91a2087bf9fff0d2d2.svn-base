@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
@stop
@section('content')
<div id = "app">
<div class="box box-default box-solid">
  <div class="box-header with-border">
    Student Ledger
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('adm_no','Admission No.',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-4">
        {!! Form::text('adm_no',null,['class' => 'form-control','v-model'=>'adm_no']) !!}
      </div>
      {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    </div>
  </div>
  <div class="box-footer">
    {!! Form::close() !!}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Student Ledger
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <p><span class="label-name">ADM NO:</span>@{{ student.adm_no }}</p>
        <p><span class="label-name">STUDENT NAME:</span>@{{ student.name }}</p>
        <p><span class="label-name">FATHER NAME:</span>@{{ student.father_name }}</p>
        <p><span class="label-name">CLASS:</span>@{{ student.course ? student.course.course_name : '' }}</p>
        <p><span class="label-name">ROLL NO:</span>@{{ student.roll_no }}</p>
        <p><span class="label-name">REMARKS:</span>
          <span v-if='student.removed == "Y"'><strong>Removed Student</strong></span>
          <span v-if='student.adm_cancelled == "Y"'><strong>Admission Cancelled </strong></span>
        </p>
      </div>
      <div class="col-sm-6">
      </div>
    </div>
    <table class="table table-bordered" id="example1" width="100%">
      <tfoot><th></th><th></th><th></th><th>Total:</th><th></th><th></th></tfoot>
    </table>
  </div>
</div>
</div>
@stop
@section('script')
<script>
var dashboard = new Vue({
  el: '#app',
  data: {
        permissions: {!! json_encode(getPermissions()) !!},
        tData: [],
        student: {},
        adm_no:'',
        table: null,
        errors: [],
        fails: false,
        stdBal: 0.00,
        url: "{{ url('/') . '/receipts/' }}"
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
                 extend: 'print',
                 footer: true,
                 exportOptions: { orthogonal: 'export' }
             },

            ],
          "processing": true,
          "scrollCollapse": true,
    //      "serverSide": true,
          "ordering": true,
          data: [],
          columnDefs: [
            { title: 'Date', targets: 0, data: 'bill_date' },
            { title: 'No.', targets: 1, data: 'billno' ,
              render: function( data, type, row, meta) {
                if(row.doc_type == 'rcpt' && self.permissions['PRINT-STUDENT-LEDGER'])
                  return data + "<br><a href='" +  self.url  + row.id + "/printreceipt'" + " target='_blank' class='btn btn-primary btn-xs'>Print Receipt</a>";
                else
                  return data ;
              }
            },
            { title: 'Particulers', targets: 2, data: 'part' },
            { title: 'Debit', targets: 3, data: 'dramt' },
            { title: 'Credit', targets: 4, data: 'cramt' },
            { title: 'Balance', targets: 5, data: 'dramt', 
              render: function( data, type, row, meta) {
                self.stdBal += (data - row.cramt);
                return self.stdBal >= 0 ? 'Dr '+self.stdBal : 'Cr '+self.stdBal;
              }},
            { targets: '_all', visible: true }
          ],
    //      "deferRender": true,
          "sScrollX": true,
           "footerCallback": function (row, data, start, end, display) {
            var api = this.api();
            var colNumber = [3, 4];

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? 
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            for (i = 0; i < colNumber.length; i++) {
                var colNo = colNumber[i];
  //              console.log('Column No: '+colNo);
                var total2 = api
                        .column(colNo)
                        .data()
                        .reduce(function (a, b) {
  //                          console.log(b);
                            return intVal(a) + intVal(b);
                        }, 0);
  //              console.log('Total Column No: '+total2);
                $(api.column(colNo).footer()).html(total2);
            }
          },
          "drawCallback": function( settings ) {
            var api = this.api();
            var rows = api.rows().nodes();
            var last = null;
            var tt = 0;
            var tt1 = 0;
            var tt2 = 0;
            //grouping

          }
        });
      },
   methods: {
      getData: function() {
         this.errors = {};
          data = { adm_no: this.adm_no };
          this.stdBal = 0.00;
          this.$http.get("{{ url('stdledger') }}", {params: data})
            .then(function (response) {
  //            this.classes = response.data;
              console.log(response.data);
              this.tData = response.data.stdlgr;
              this.student = response.data.student;
              this.reloadTable();
            }, function (response) {
              this.fails = true;
                self = this;
                if(response.status == 422) {
                  this.errors = response.data;
                }
  //            console.log(response.data);
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
          console.log('here');
          this.table.clear();
          this.table.rows.add(this.tData).draw();
        }
      }

    });
</script>
@stop