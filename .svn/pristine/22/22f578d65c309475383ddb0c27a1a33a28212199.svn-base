@extends('app')

{{-- @section('toolbar') @include('toolbars._academics_toolbar') @stop --}}

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
    {!! Form::open(['url'=>'', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('course','Course',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">@{{ course.course_name }}</p>
      </div>
      {!! Form::label('subject','Subject ',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-4">
        <p class="form-control-static">@{{ subject.subject }}</p>
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('scheme','Odd/Even/All',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('scheme',['odd' => 'Odd','even' => 'Even','all' => 'All'],null,['class' => 'form-control ','v-model' => 'scheme']) !!}
      </div>
      {!! Form::label('students','No.of Students ',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('',null,['class' => 'form-control ','v-model' => 'students']) !!}
      </div>
      {!! Form::label('section_id','Section',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-1">
        {!! Form::select('section_id',getSections(),null,['class' => 'form-control ','v-model' => 'section_id']) !!}
      </div>
      {!! Form::submit('Allot Section',['class' => 'btn btn-primary','@click.prevent'=>'allotSection']) !!}
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
      course: {!! $course or '{}' !!},
      subject_id: {{ $subject_id or 0 }},
      subject: {!! $subject or "{}" !!},
      subjects: [],
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
          { title: 'Student Name', targets: 1, data: 'name'},
          { title: 'Adm No.', targets: 2, data: 'adm_no' },
          { title: 'Roll No.', targets: 3, data: 'roll_no' },
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
     }); 
     this.getData();
    },
  methods: {
    getData: function() {
      this.errors = {};
      this.fails = false;
      data = {
        course_id: this.course.id,
        subject_id: this.subject.id
      };
      this.$http.get("{{ url('secallot') }}", {params: data})
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
      self = this;
      data = {
        course_id: this.course.id,
        subject_id: this.subject.id,
        scheme: this.scheme,
        students: this.students,
        section_id: this.section_id,
      };
      this.$http.post("{{ url('secallot') }}", data)
        .then(function (response) {
          this.success = true;
          this.response = response.data;
          setTimeout(() => {
            self.success = false;
          }, 3000);
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