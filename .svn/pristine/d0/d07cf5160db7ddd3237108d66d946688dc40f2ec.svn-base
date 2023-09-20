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
      {!! Form::label('upto_date','Date',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
      </div>
      {!! Form::label('fund_type','Head',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('fund_type',['C'=>'College','H'=>'Hostel'],null,['class' => 'form-control','v-model'=>'fund_type']) !!}
      </div>
      {!! Form::label('sf','SF',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('sf',[''=>'All','Y'=>'Yes','N'=>'No'],null,['class' => 'form-control','v-model'=>'sf']) !!}
      </div>
<!--      {!! Form::label('user_id','User',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('user_id',getUser(),null, ['class' => 'form-control','v-model' => 'user_id']) !!}
      </div>-->
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
    <strong>Day Book</strong>
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
      upto_date: '',
      sf:'N',
      table: null,
      success: false,
      fails: false,
      errors: {},
      columnDefs: null,
      available_fields: [],
      remote_data: [],
      cols: 0,
      definedCols: 5,
      
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

            for (colNo = self.definedCols; colNo <= self.cols; colNo++) {
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
          user_id: this.user_id,
          fund_type: this.fund_type,
          upto_date: this.upto_date,
          sf:this.sf
        };
        this.$http.get("{{ url('daybook') }}", {params: data})
          .then(function (response) {
            if(response.data.success) {
              this.remote_data = response.data.day_book;
              this.available_fields = response.data.fee_heads;
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
          { title: 'Receipt No.', targets: 0, data: 'fee_rcpt_id' },
          { title: 'Name', targets: 1, data: 'std_name' },
          { title: 'Course', targets: 2, data: 'course_name' },
          { title: 'Adm. No.', targets: 3, data: 'adm_no' },
          { title: 'Roll No.', targets: 4, data: 'roll_no' },
        ];
        var self = this;
        var t = self.definedCols;
        var fld_data = null;
        var fld_name = '';
        $.each( this.available_fields, function( key, field ) {
          fld_data = null;
          fld_name = field.name.replace(/\./g, 'aaa');
          self.columnDefs.push({ title: field.name, targets: t, data: fld_name});
          t += 1;
        });
        self.columnDefs.push({ title: 'Total', targets: t, data: 'total' });
        self.cols = t;
      },
      
      setData: function() {
        var rec_id = 0;
        var record = {};
        var fld_name = '';
        this.tData = [];
        self = this;
        $.each(this.remote_data, function(key, row) {
          if(rec_id != row.fee_rcpt_id) {
            rec_id = row.fee_rcpt_id;
            if(record.fee_rcpt_id)
              self.tData.push(record);
            record = {
              fee_rcpt_id: rec_id,
              std_name: row.std_name,
              course_name: row.course_name,
              adm_no: row.adm_no,
              roll_no: row.roll_no
            };
            $.each(self.available_fields, function(key, field) {
              fld_name = field.name.replace(/\./g, 'aaa');
              record[fld_name] = '';
            });
            record.total = row.total;
          }
          fld_name = row.name.replace(/\./g, 'aaa');
          record[fld_name] = row.amount;
        });
        if(record.fee_rcpt_id)
          self.tData.push(record);
      }
    }
  
  });
</script>
@stop
