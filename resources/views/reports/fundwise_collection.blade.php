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
  {!! Form::open(['method' => 'GET',  'action' => ['Reports\FundWiseRepController@index'], 'class' => 'form-horizontal']) !!}
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
      {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('fund_type','Fund Type',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('fund_type',['C'=>'College','H'=>'Hostel'],null,['class' => 'form-control','v-model' => 'fund_type']) !!}
      </div>
      {!! Form::label('scope','Scope',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form:: select('scope', array('all'=>'All Receipts','offline'=>'Offline Receipts','online' =>'Online Receipts'),'offline', ['class' => 'form-control', 'v-model' => 'scope']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!}
    <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
      <li v-for='error in errors'>@{{ error[0] }}<li>
    </ul>
  </div>
  {!! Form::close() !!}
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Fund Wise Collection
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
      <tfoot><th></th><th></th><th>Total:</th><th></th></tfoot>
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
      $('#feehead-box').append('<form id="feehead-form" action=\'{{ url("funds/details") }}\' method="GET" target="_blank">');
      $('#feehead-form').append('<input type="hidden" name="fund_id" value="' + $(this).data('fundid') + '">')
        .append('<input type="hidden" name="scope" value="' + dashboard.scope + '">')
        .append('<input type="hidden" name="from_date" value="' + dashboard.from_date + '">')
        .append('<input type="hidden" name="upto_date" value="' + dashboard.upto_date + '">')
        .append('<input type="hidden" name="fund_type" value="' + dashboard.fund_type + '">')
        .append('<input type="hidden" name="course_id" value="' + dashboard.course_id + '">')
        .submit();
    } else {
      $('#feehead-box').append('<form id="feehead-form" action=\'{{ url("funds/shdetails") }}\' method="GET" target="_blank">');
      $('#feehead-form').append('<input type="hidden" name="fund_id" value="' + $(this).data('fundid') + '">')
        .append('<input type="hidden" name="scope" value="' + dashboard.scope + '">')
        .append('<input type="hidden" name="from_date" value="' + dashboard.from_date + '">')
        .append('<input type="hidden" name="upto_date" value="' + dashboard.upto_date + '">')
        .append('<input type="hidden" name="fund_type" value="' + dashboard.fund_type + '">')
        .append('<input type="hidden" name="course_id" value="' + dashboard.course_id + '">')
        .submit();
    }
  });
  
var dashboard = new Vue({
  el: '#app',
  data: {
      from_date: '',
      upto_date: '',
      fund_type: 'C',
      scope: '',
      table: null,
      tData: [],
      success: false,
      fails: false,
      errors: {},
      url: "{{ url('/') . '/funds/' }}",
      course_id: 0,
      permissions: {!! json_encode(getPermissions()) !!},
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
          { title: 'Fund Name', targets: 1, data: 'name'},
          { title: '', targets: 3, data: 'name',
            "render": function( data, type, row, meta) {
              var str = '';
              if(self.permissions['FEEHEAD-WISE-DETAIL-FUND-WISE-COLLECTION']){
                str += "<button class='btn btn-primary btn-xs feehead-link' data-type='feehead' data-fundid='"+row.id+"' >Feehead Wise Details</button>";
              }
              return str;
            }
          },
          { title: '', targets: 4, data: 'name',
            "render": function( data, type, row, meta) {
              var str = '';
              if(self.permissions['SUBHEAD-WISE-DETAIL-FUND-WISE-COLLECTION']){
                str += "<button class='btn btn-primary btn-xs feehead-link' data-type='subhead' data-fundid='"+row.id+"' >Subhead Wise Details</button>";
              }
              return str;
            }
          },
          { title: 'Amount', targets: 2, data: 'amount' },
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
    },
  methods: {
    getData: function() {
        this.errors = {};
        this.fails = false;
        var data = {
          from_date: this.from_date,
          upto_date:this.upto_date,
          fund_type: this.fund_type,
          scope: this.scope,
          course_id: this.course_id
        };
        this.$http.get("{{ url('fundwise-collection') }}", {params: data})
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
      showFeeHeadDet: function(fund_id){
        console.log(fund_id);
//        this.$http.get("{{ url('funds') }}"+'/'+this.fund_id+'/details', {params: data})
//          .then(function (response) {
//            this.tData = response.data;
//          //  this.reloadTable();
//          }, function (response) {
//            this.fails = true;
//            this.errors = response.data;
//        });
      },
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
  }
  
  });
</script>
@stop