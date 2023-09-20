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
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      <div class="form-group">
        {!! Form::label('from_date','From Date',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('from_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'from_date']) !!}
        </div>
        {!! Form::label('upto_date','To Date',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
        </div>
        {!! Form::label('user_id','User',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('user_id',getUser(),null, ['class' => 'form-control','v-model' => 'user_id']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
        </div>
        {!! Form::label('fund_type','Fund',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('fund_type',[''=>'Select','C'=>'College','H'=>'Hostel'],null,['class' => 'form-control','v-model' => 'fund_type']) !!}
        </div>
        {!! Form::label('cancelled','Cancelled',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-1 checkbox-inline">
          <input type="checkbox" name="cancelled" v-model='cancelled'>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('pay_type','Cash/Bank',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form:: select('pay_type', array('' => 'All','C'=>'Cash','B' =>'Bank'),null, ['class' => 'form-control', 'v-model' => 'pay_type']) !!}
        </div>
        {!! Form::label('scope','Scope',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
         {!! Form:: select('scope', array('all' => 'All Receipts','offline'=>'Offline Receipts','online' =>'Online Receipts'),'offline', ['class' => 'form-control', 'v-model' => 'scope']) !!}
        </div>
        {!! Form::label('sf','SF',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('sf',['Y'=>'Yes','N'=>'No'],null,['class' => 'form-control','v-model'=>'sf']) !!}
        </div>
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
</div>
<div class="panel panel-default">
  <div class='panel-heading' id="heading">
    <strong>Fee Collection Report</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
        <tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th>Total:</th><th></th><th></th><th></th><th></th></tfoot>
    
   </table>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Summary
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example2" width="100%">
      <tfoot><th></th><th></th><th></th><th></th><th></th></tfoot>
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
      course_id: {{ $course->id or request("course_id",0) }},
      fund_type: '',
      pay_type: '',
      user_id: 0,
      cancelled: false,
      scope: '',
      sf: '',
      table: null,
      url: "{{ url('/') . '/receipts/' }}",
      tData: [],
      
     },
  created: function() {
      this.from_date = moment().format('DD-MM-YYYY');
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
               footer: true
            },
            {
                extend: 'pdfHtml5',
                footer: true,
                orientation: 'landscape',
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
          { title: 'Rec. No.', targets: 1, data: 'id',
            render: function( data, type, row, meta) {
            return data + "<br><a href='" +  self.url  + row.id + "/printreceipt'" + " target='_blank' class='btn btn-primary btn-xs'>Print</a>";
            }
          },
          { title: 'Adm.No.', targets: 2, data: 'student.adm_no',
          "render": function ( data, type, row, meta ) {
            if(row.student)
              return data;
            else if(row.outsider)
              return row.outsider.adm_no;
            return '';
          }},
          { title: 'Student Name', targets: 3, data: 'student.name',
          "render": function ( data, type, row, meta ) {
            if(row.student)
              return data;
            else if(row.outsider)
              return row.outsider.name;
            return '';
          }},
          { title: 'Class', targets: 4, data: 'student.course',
          "render": function ( data, type, row, meta ) {
            if(row.student)
              return row.student.course.course_name;
            else if(row.outsider)
              return row.outsider.course_name;
            return '';
          }},
          { title: 'Payment Mode', targets: 5, data: 'pay_type',
          render: function (data, type, row, meta){
            var fld = data == 'B' ? 'Bank' : 'Cash';
            fld += row.online_trn ? '<br>Trn Code: '+row.online_trn.trcd : data;
            return fld;
          }},
          { title: 'Trn. ID', targets: 6, data: 'chqno',
          render: function (data, type, row, meta) {
            return row.online_trn ? row.online_trn.trid : '';
          }},
          { title: 'Details', targets: 7, data: 'details' },
          { title: 'Cash', targets: 8, data: 'cash', className: "sum1"},
          { title: 'Bank', targets: 9, data: 'bank', className: "sum2"},
          { title: 'Amount', targets: 10, data: 'amount', className: "sum", },
          { title: 'User', targets: 11, data: 'user_created',
          "render": function ( data, type, row, meta ) {
            return data ? data.name : '';
          }},
          { title: 'Date', "visible": false, targets: 12, data: 'rcpt_date'},
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
         "footerCallback": function (row, data, start, end, display) {
          var api = this.api();
          var colNumber = [8, 9, 10];
                   
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
          api.column(12).data().each( function ( group, x ) {
            if ( last != group ) {
              if(last != null) {
                $(rows).eq( x ).before('<tr class="group"><td colspan="8">Day Total</td><td>'+tt1+'</td><td>'+tt2+'</td><td>'+tt+'</td><td></td></tr>');
              }
//              console.log(group);
//              console.log(x);
              $(rows).eq( x ).before('<tr class="group"><td colspan="12">'+group+'</td></tr>');
              last = group;
              tt = 0; tt1 = 0; tt2 = 0;
            }
            tt += Number($(rows).eq(x).find('.sum').text());
            tt1 += Number($(rows).eq(x).find('.sum1').text());
            tt2 += Number($(rows).eq(x).find('.sum2').text());
          });
          if(tt > 0) {
            $(rows).eq(api.rows().count() - 1).after('<tr class="group"><td colspan="8">Day Total</td><td>'+tt1+'</td><td>'+tt2+'</td><td>'+tt+'</td><td></td></tr>');
          }
//          console.log(api.rows().count());
        }
      });
        this.table2 = $('#example2').DataTable({
  //      "searchDelay": 1000,
        searching: false,
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
           'pageLength',
            {
                extend: 'excelHtml5',
                footer: true
            },
            {
                extend: 'pdfHtml5',
                footer: true
            },
          ],
        "processing": true,
        "scrollCollapse": true,
        "ordering": true,
        data: [],
        columnDefs: [
          { title: 'S.No.', targets: 0, data: 'created_by',
          "render": function( data, type, row, meta) {
            return meta.row + 1;
          }},
          { title: 'User', targets: 1, data: 'user_created',
          "render": function ( data, type, row, meta ) {
            return data ? data.name : '';
          }},
          { title: 'Bank', targets: 2, data: 'bank', className: "sum"},
          { title: 'Cash', targets: 3, data: 'cash', className: "sum"},
          { title: 'Total', targets: 4, data: 'amount', className: "sum"},
          { targets: '_all', visible: true }
        ],
        "sScrollX": true,
        "footerCallback": function (row, data, start, end, display) {
          var api = this.api();
          var colNumber = [2, 3, 4];
                   
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
          // Total 
//          pageTotal = api
//              .column('.sum')
//              .data()
//              .reduce(function (a, b) {
//                  return intVal(a) + intVal(b);
//              }, 0);
//          // Update footer
//          $(api.column('.sum').footer()).html(pageTotal);
        },
        "drawCallback": function( settings ) {
//          console.log('redrawn');
        }
      });
    },
    methods: {
      getData: function() {
          data = $.extend({}, {
            course_id: this.course_id,
            pay_type: this.pay_type,
            from_date: this.from_date,
            upto_date: this.upto_date,
            cancelled: this.cancelled,
            user_id: this.user_id,
            fund_type: this.fund_type,
            scope: this.scope,
            sf: this.sf
           });
          this.$http.get("{{ url('feecollections') }}", {params: data})
            .then(function (response) {
  //            this.classes = response.data;
  //            console.log(response.data);
              this.tData = response.data.receipts;
              this.tData2 = response.data.summary;
              this.reloadTable();
            }, function (response) {
  //            console.log(response.data);
          });
        },
      
        reloadTable: function() {
          this.table.clear();
          this.table.rows.add(this.tData).draw();
          this.table2.clear();
          this.table2.rows.add(this.tData2).draw();
          $('#heading').html('<b>{{ config("college.college_name") }}<br>Fee Collection List Upto : </b>'+ this.upto_date)
        }
    }
  
  });
</script>
@stop