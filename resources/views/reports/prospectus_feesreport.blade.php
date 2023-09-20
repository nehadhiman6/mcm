@extends('app')
@section('toolbar')
@include('toolbars._reports_toolbar')
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
      {!! Form::label('from_date','From Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('from_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'from_date']) !!}
      </div>
      {!! Form::label('upto_date','To Date',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
      </div>
      {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    </div>
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div class="panel panel-default">
  <div class='panel-heading' id="heading">
    <strong>Online Prospectus Fees Report</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
      <tfoot><th></th><th></th><th>Total:</th><th></th></tfoot>
    </table>
  </div>
</div>
@stop
@section('script')
<script>
var dashboard = new Vue({
el: '#app',
data: {
      from_date: '',
      upto_date: '',
      table: null,
      tData: [],
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
                footer: true,
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
          { title: 'Adm.Form.No.', targets: 1, data: 'std_user.adm_form.id' },
          { title: 'Student Name', targets: 2, data: 'std_user.adm_form.name' },
          { title: 'Amount', targets: 3, data: 'amt' },
          { targets: '_all', visible: true }
        ],
        "sScrollX": true,
        "footerCallback": function (row, data, start, end, display) {
          var api = this.api();
          var colNumber = [3];
                   
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
    },
 methods: {
    getData: function() {
        var data = {
          from_date: this.from_date,
          upto_date: this.upto_date
        };
        this.$http.get("{{ url('prospectus-fees') }}", {params: data})
          .then(function (response) {
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
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
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    }
  
  });
</script>
@stop