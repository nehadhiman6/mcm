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
  <div class="box-body">
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
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
    <strong>Removed Students List</strong>
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
        table: null,
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
  //      "serverSide": true,
        "ordering": true,
        data: [],
        columnDefs: [
           { title: 'S.No.', targets: 0, data: 'id',
          "render": function( data, type, row, meta) {
            return meta.row + 1;
          }},
          { title: 'Admission No', targets: 1, data: 'adm_no'},
          { title: 'Name', targets: 2, data: 'name' },
          { title: 'Father Name', targets: 3, data: 'father_name' },
          { title: 'Class', targets: 4, data: 'course_name'},
          { title: 'Roll No', targets: 5, data: 'roll_no'},
          { title: 'Contact No', targets: 6, data: 'mobile'},
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
          })
          this.$http.get("{{ url('rmvstudents') }}", {params: data})
            .then(function (response) {
             this.tData = response.data;
              this.reloadTable();
            }, function (response) {
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