@extends('app')
@section('toolbar')
@include('toolbars._hostels_toolbar')
@stop
@section('content')
<div class="box box-default box-solid" id='app' v-cloak>
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
        {!! Form::label('from_date','From Date',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('from_date',startDate(),['class' => 'form-control app-datepicker', 'v-model' => 'from_date']) !!}
        </div>
        {!! Form::label('upto_date','To Date',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
        </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div class="panel panel-default">
  <div class='panel-heading'>
    <strong>Outsider List</strong>
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
      from_date: '',
      upto_date: '',
      table: null,
      url: "{{ url('/') . '/hostels/outsiders/' }}",
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
          { title: 'Adm.No.', targets: 1, data: 'adm_no'},
//           "render": function( data, type, row, meta){
//             if(type == 'export')
//              return data;
//            return data + "<br><a href='" + self.url + row.id + "/edit'" + " class='btn btn-primary btn-xs' target = _blank>Edit</a>";
//          }},
          { title: 'Adm.Date', targets: 2, data: 'adm_date' },
          { title: 'Name', targets: 3, data: 'name'},
          { title: 'Father Name', targets: 4, data: 'father_name' },
          { title: 'Course', targets: 5, data: 'course_name'},
          { title: 'Roll No', targets: 6, data: 'roll_no'},
          { title: 'Remarks', targets: 7, data: 'remarks',
          "render": function ( data, type, row, meta ) {
            return '';
          }},
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
      });
    },
 methods: {
    getData: function() {
        this.errors = {};
        this.fails = false;
        data = $.extend({}, {
          from_date: this.from_date,
          upto_date: this.upto_date
        })
        this.$http.get("{{ url('hostels/outsiders') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
//            console.log(response.data);
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