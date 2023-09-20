@extends('app')
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
    {!! Form::open(['url'=>'', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control ','v-model' => 'course_id']) !!}
      </div>
      {!! Form::label('subject_id','Subject ',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-4">
        <p class="form-control-static">@{{ subject }}</p>
      </div>
      {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!}
    </div>
    {!! Form::close() !!}
   </div>
  <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Subject Wise Student Details
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
      course_id: {{ $course_id or 0 }},
      subject_id: {{ $subject_id or 0 }},
      subject: '{{ $subject }}',
      scheme: 'all',
      students: '',
      section_id: '',
      table: null,
      tData: [],
      success: false,
      fails: false,
      errors: {},
      response: {},
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
          { title: 'Student Name', targets: 1, data: 'name'},
          { title: 'Form No.', targets: 2, data: 'id' },
          { title: 'Last Yr Roll No.', targets: 3, data: 'lastyr_rollno' },
          { targets: '_all', visible: true }
        ],
        "sScrollX": true,
     }); 
     if(this.subject_id > 0)
        this.getData();
    },
  methods: {
    getData: function() {
        this.errors = {};
        this.fails = false;
        data = {
          course_id: this.course_id,
          subject_id: this.subject_id
        };
        this.$http.get("{{ url('subwise-admdetails') }}", {params: data})
          .then(function (response) {
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
      allotSection: function() {
        this.errors = {};
        this.success = false;
        this.fails = false;

        data = {
          course_id: this.course_id,
          subject_id: this.subject_id,
          scheme: this.scheme,
          students: this.students,
          section_id: this.section_id,
        };
        this.$http.post("{{ url('secallot') }}", data)
          .then(function (response) {
            this.success = true;
            this.response = response.data;
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