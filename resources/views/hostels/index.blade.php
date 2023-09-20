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
        {!! Form::label('upto_date','To Date',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
        </div>
        {!! Form::label('course_id','Class',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
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
    <strong>Hostel Students List</strong>
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
      course_id: {{ $course->id or request("course_id",0) }},
      from_date: '',
      upto_date: '',
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
          { title: 'Adm.Form No.', targets: 1, data: 'admission_id'},
          { title: 'Course', targets: 2, data: 'course_name'},
          { title: 'Name', targets: 3, data: 'name'},
          { title: 'Father Name', targets: 4, data: 'father_name'},
          { title: 'Roll No.', targets: 5, data: 'roll_no'},
          { title: 'Email Id', targets: 6,"render": function( data, type, row, meta) {
              return row.std_user ? row.std_user.email : '';
          }},
          { title: 'Applied for AC Room', targets: 7,"render": function( data, type, row, meta) {
              // console.log(row.adm_form.hostel_data.ac_room);
              return row.adm_form.hostel_data ? row.adm_form.hostel_data.ac_room :'';
              
          }},
          { title: 'Hostel Dues', targets: 8, data: 'amount'},
          { title: 'Received', targets: 9, data: 'received'},
          { title: 'Balance', targets: 10, data: 'pending'},
          { targets: '_all', visible: true }
        ],
        "sScrollX": true,
      });
    },
  methods: {
    getData: function() {
        this.errors = {};
        this.fails = false;
        data = $.extend({}, {
          course_id: this.course_id,
          from_date: this.from_date,
          upto_date: this.upto_date
        })
        this.$http.get("{{ url('hostels') }}", {params: data})
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