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
    <div class='form-group'>
      {!! Form::label('course_id','Class Of Adm.',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
      </div>
      {!! Form::label('feehead_id','FeeHead',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('feehead_id',getFeeHead(),null,['class' => 'form-control','v-model'=>'feehead_id']) !!}
      </div>
      {!! Form::label('subhead_id','SubHead',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('subhead_id',getSubheads(),null,['class' => 'form-control','v-model'=>'subhead_id']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('subgroup','Sub Group',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('subgroup',null,['class' => 'form-control','v-model'=>'subgroup']) !!}
      </div>
      {!! Form::label('who_paid','Who Has Paid',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-1 checkbox-inline">
        <input type="checkbox" name="who_paid" v-model='who_paid'>
      </div>
      {!! Form::label('feehead_id','IInd FeeHead',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('feehead_id',getFeeHead(),null,['class' => 'form-control','v-model'=>'feehead_id']) !!}
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
    <strong>Student Wise Fee Details</strong>
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
      feehead_id: {{ $feehead->id or request("feehead_id",0) }},
      subhead_id: {{ $subhead->id or request("subhead_id",0) }},
      subgroup: '',
      who_paid: false,
      table: null,
      url: "{{ url('/') . 'stdwise-feedetails/' }}",
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
          { title: 'Adm.No.', targets: 1, data: 'adm_no' },
          { title: 'Student Name', targets: 2, data: 'Name' },
          { title: 'SubHead', targets: 3, data: '' },
          { title: 'Amount', targets: 4, data: '' },
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
      });
    },
 methods: {
    getData: function() {
        data = $.extend({}, {
          course_id: this.course_id,
          feehead_id: this.feehead_id,
          subhead_id: this.subhead_id,
          subgroup: this.subgroup,
          who_paid: this.who_paid
        })
        this.$http.get("{{ url('stdwise-feedetails') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
        });
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