@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
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
  {!! Form::open(['method' => 'GET',  'action' => ['Reports\StdStrengthController@stdStrength'], 'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('upto_date','To Date',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
      </div>
      {!! Form::label('adm_source','Adm. Type',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('adm_source',[''=>'All','offline'=>'Offline','online'=>'Online'],null,['class' => 'form-control','v-model'=>'adm_source']) !!}
      </div>
      {{-- {!! Form::label('centralized','Centralized',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('centralized',[''=>'All','N'=>'Exclude','Y'=>'Only Centralized'],'N',['class' => 'form-control','v-model'=>'centralized']) !!}
      </div> --}}
<!--      <div class="col-sm-2 col-sm-offset-1">
        <div class="checkbox">
          <label class="control-label">
            <input type='checkbox' v-model="centralized"  v-bind:true-value="'Y'"  v-bind:false-value="'N'" name='centralized'>
            Centralized  
          </label>
        </div>
      </div>-->
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!}
  </div>
  {!! Form::close() !!}
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Admissions
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
      <tfoot><th></th><th>Total:</th><th></th><th></th><th></th><th></th></tfoot>
    </table>
  </div>
</div>
@stop

@section('script')
<script>
var dashboard = new Vue({
  el: '#app',
  data: {
      tData: [],
      upto_date: '',
      adm_source: 'offline',
      centralized: 'N',
      table: null,
      success: false,
      fails: false,
      errors: {},
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
                filename: 'student_strength',
                exportOptions: { orthogonal: 'export' }
            },
            {
                header: true,
                footer: true,
                extend: 'pdfHtml5',
                download: 'open',
                title: 'Student Strength',
                // orientation: 'landscape',
                // pageSize: 'LEGAL',
                exportOptions: { orthogonal: 'export' }
            }
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
          { title: 'Course', targets: 1, data: 'course_name' },
          { title: 'Before', targets: 2, data: 'before_dt' },
          { title: 'On', targets: 3, data: 'on_dt' },
          { title: 'After', targets: 4, data: 'after_dt' },
          { title: 'Course Total', targets: 5, data: 'total' },
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
        "footerCallback": function (row, data, start, end, display) {
          var api = this.api();
          var colNumber = [2,3,4,5];
                   
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
        this.errors = {};
        this.fails = false;
        data = $.extend({}, {
          upto_date:this.upto_date,
          adm_source: this.adm_source,
          centralized: this.centralized
        })
        this.$http.get("{{ url('stdstrength') }}", {params: data})
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
        this.$nextTick(function() {
          $($('.dataTables_scrollHead th')[2]).text('Before '+this.upto_date);
          $($('.dataTables_scrollHead th')[3]).text('On '+this.upto_date);
          $($('.dataTables_scrollHead th')[4]).text('After '+this.upto_date);
        });
      }
  }
  
  });
</script>
@stop