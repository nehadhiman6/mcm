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
      {!! Form::label('month','From Month',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('month',monthsList(),null,['class' => 'form-control', 'v-model' => 'month']) !!}
      </div>
      {!! Form::label('year','Year',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('year',['2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023'],null,['class' => 'form-control','v-model'=>'year']) !!}
      </div>
      {!! Form::label('fund_type','Head',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('fund_type',['C'=>'College','H'=>'Hostel'],null,['class' => 'form-control','v-model'=>'fund_type']) !!}
      </div>
      {!! Form::label('sf','SF',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('sf',['A'=>'All','Y'=>'Yes','N'=>'No'],null,['class' => 'form-control','v-model'=>'sf']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('month1','To Month',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('month1',monthsList(),null,['class' => 'form-control', 'v-model' => 'month1']) !!}
      </div>
      {!! Form::label('year1','Year',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('year1',['2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021','2022'=>'2022','2023'=>'2023'],null,['class' => 'form-control','v-model'=>'year1']) !!}
      </div>
    </div>
    <div class="form-group">

    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
</div>
<div class="panel panel-default">
  <div class='panel-heading'>
    <strong>Day Book Summary</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
@stop
@section('script')
<script>
  var dashboard = new Vue({
    el: '#app',
    data: {
      tData: [],
      user_id: {{ $user->id or request("user_id",0) }},
      fund_type: 'C',
      sf:'N',
      month: '',
      year: '',
      month1: '',
      year1: '',
      table: null,
      success: false,
      fails: false,
      errors: {},
      columnDefs: null,
      available_fields: [],
      remote_data: [],
      cols: 0,
      definedCols: 2,
      
    },
    created: function() {

      },
    methods: {

      setDataTable: function() {
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
                exportOptions: { orthogonal: 'export' },
                footer: true
              },
            ],
          "processing": true,
          "scrollCollapse": true,
          "ordering": true,
          data: [],
          columnDefs: self.columnDefs,
    //      "deferRender": true,
          "sScrollX": true,
          "footerCallback": function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? 
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            for (colNo = self.definedCols-1; colNo <= self.cols; colNo++) {
                var total2 = api
                        .column(colNo)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                $(api.column(colNo).footer()).html(total2);
            }
          },
        });
      },

      getData: function() {
        this.errors = {};
        this.fails = false;
        var data = {
          fund_type: this.fund_type,
          month: this.month,
          year: this.year,
          month1: this.month1,
          year1: this.year1,
          sf: this.sf
        };
        this.$http.get("{{ url('dbsummary') }}", {params: data})
          .then(function (response) {
            if(response.data.success) {
              this.remote_data = response.data.day_book;
              this.available_fields = response.data.sub_heads;
              this.reloadTable();
            }
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
        console.log('reloading');
        if(this.table != null) {
          this.table.destroy();
          $('#example1').empty();
        }
        if(this.remote_data.length < 1) {
          console.log('length: ', this.remote_data.length);
          return;
        }
        this.setColumns();
        this.setData();
        $('#example1').append('<tfoot>'+'<th></th>'.repeat(self.cols+1)+'</tfoot>')
        this.setDataTable();
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      },
      
      setColumns: function() {
        this.columnDefs = [
          { targets: '_all', visible: true },
          { title: 'Date', targets: 0, data: 'rcpt_date' },
          { title: 'Total', className: 'total', targets: 1, data: 'total' }
        ];
        var self = this;
        var t = self.definedCols;
        var fld_data = null;
        var fld_name = '';
        var group = '';
        $.each( this.available_fields, function( key, field ) {
          if(group == '') {
            group = field.group;
          }
          if(group != field.group) {
            self.columnDefs.push({ title: group, className: 'head-total', targets: t, data: group});
            t += 1;
            group = field.group;
          }
          fld_data = null;
          fld_name = field.name.replace(/\./g, 'aaa');
          self.columnDefs.push({ title: field.name, targets: t, data: fld_name});
          t += 1;
        });
        if(group.length > 0) {
            self.columnDefs.push({ title: group, className: 'head-total', targets: t, data: group});
        }
        // self.columnDefs.push({ title: 'Total', targets: t, data: 'total' });
        self.cols = t;
      },
      
      setData: function() {
        var rcpt_date = '';
        var record = {};
        var fld_name = '';
        this.tData = [];
        self = this;
        $.each(this.remote_data, function(key, row) {
          if(rcpt_date != row.rcpt_date) {
            rcpt_date = row.rcpt_date;
            if(record.rcpt_date)
              self.tData.push(record);
            record = {
              rcpt_date: rcpt_date,
            };
            $.each(self.available_fields, function(key, field) {
              fld_name = field.name.replace(/\./g, 'aaa');
              record[fld_name] = '';
              if(! record[field.group]) {
                record[field.group] = 0;
              }
            });
            record.total = 0;
          }
          fld_name = row.name.replace(/\./g, 'aaa');
          record[fld_name] = row.amount;
          record[row.group] += (row.amount * 1);
          record.total += (row.amount * 1);
        });
        if(record.rcpt_date)
          self.tData.push(record);
      }
    }
  
  });
</script>
@stop

@push('pg_styles')
<style>
  table tr td.total {
    background-color: #f5deb3 !important;
  }
  table tr td.head-total {
    background-color: #f5deb3 !important;
  }
</style>
@endpush
