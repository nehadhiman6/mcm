@extends('app')
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
      {!! Form::label('institution','Institution',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('institution',['sggs'=>'S.G.G.S'],request('institution'),['class' => 'form-control','v-model'=>'institution']) !!}
      </div>
      {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
      </div>
      <div class="col-sm-2">
        {!! Form::select('head_type',['College'=>'College','Hostel'=>'Hostel'],null,['class' => 'form-control','v-model'=>'head_type']) !!}
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
    <strong>Students List</strong>
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
      institution:'',
      course_id: {{ $course->id or request("course_id",0) }},
      fund_type:'',
      table: null,
      url: "{{ url('/') . 'students/' }}",
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
          { title: 'Roll No.', targets: 2, data: 'roll_no' },
          { title: 'Adm.Date', targets: 3, data: 'adm_date' },
          { title: 'Name', targets: 4, data: 'name' },
          { title: 'Father Name', targets: 5, data: 'father_name' },
          { title: 'Sports', targets: 6, data: 'sport',
          "render": function ( data, type, row, meta ) {
            return '';
          }},
          { title: 'College', targets: 7, data: 'college',
          "render": function ( data, type, row, meta ) {
            return '';
          }},
          { title: 'Remarks', targets: 8, data: 'remarks',
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
        data = $.extend({}, {
          course_id: this.course_id,
          institution:this.institution,
          fund_type:this.fund_type
        })
        this.$http.get("{{ url('students') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
//            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
        });
      },
      
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    }
  
  });
</script>
@stop