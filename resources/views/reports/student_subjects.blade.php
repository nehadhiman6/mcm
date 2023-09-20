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
        <select class="form-control" v-model='course_id'>
          <option value="0">Select</option>
          <option v-for='course in courses' :value='course.id'>@{{ course.course_name }}</option>
        </select>
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
    <strong>Students With Subjects</strong>
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
      course_id: {{ $course->id or request("course_id",0) }},
      from_date: '',
      upto_date: '',
      table: null,
      url: "{{ url('/') . '/std-subjects/' }}",
      success: false,
      fails: false,
      errors: {},
      courses: {!! json_encode($courses) !!},
      tData: [],
      current_course_id: 0,
      comp_subjects: [],
      comp_uni_codes: []
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
            {
                header: true,
                footer: true,
                extend: 'pdfHtml5',
                download: 'open',
                title: 'Student Subjects',
                orientation: 'landscape',
                pageSize: 'LEGAL',
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
          { title: 'Adm.No.', targets: 1, data: 'adm_no'},
          { title: 'Online Form No', targets: 2, data: 'admission_id',
          "render": function ( data, type, row, meta ) {
            return (row.adm_form ? row.adm_form.id : '') ;
          }},
         { title: 'Cent. R.No / Date', targets: 3, data: 'adm_entry_id',
          "render": function ( data, type, row, meta ) {
            if(row.adm_entry && row.adm_entry.centralized == 'Y')
              return (row.adm_entry.adm_rec_no + ' / ' +row.adm_entry.rcpt_date) ;
            return '';
          }},
          { title: 'Adm.Date', targets: 4, data: 'adm_date' },
          { title: 'Name', targets: 5, data: 'name'},
          { title: 'Father Name', targets: 6, data: 'father_name' },
          { title: 'Roll No', targets: 7, data: 'roll_no'},
          { title: 'Course', targets: 8, data: 'course_name'},
          { title: 'Subject Codes', targets: 9, data: 'id',
            render: function(data, type, row, meta) {
              var subjects = [];
              var comp_subjects = [];
              $.each(row.std_subs, function(index, sub){
                subjects += (subjects.length ? ', ' : '')+ sub.subject.uni_code;
              });
//             return subjects;
             
             $.each(self.getCompUniCodes(row.course_id), function(index, sub){
                subjects += (subjects.length ? ', ' : '')+ sub;
              });
             return subjects;
             
            }},
          { title: 'Subjects', targets: 10, data: 'id',
            render: function(data, type, row, meta) {
              var subjects = [];
              var comp_subjects = [];
              $.each(row.std_subs, function(index, sub){
                subjects += (subjects.length ? ', ' : '')+ sub.subject.subject;
              });
//             return subjects;
             
             $.each(self.getCompSubjects(row.course_id), function(index, sub){
                subjects += (subjects.length ? ', ' : '')+ sub;
              });
             return subjects;
             
            }},
          { title: 'Honours', targets: 11, data: '',
            "render":function(data,type,row, meta){
               if(row.adm_entry && row.adm_entry.honour_sub){
                 return row.adm_entry.honour_sub.subject;
               }
               return "";
            }
          },
          { title: 'Add-on Course', targets: 12, data: '',
            "render":function(data,type,row, meta){
               if(row.adm_entry && row.adm_entry.add_on_course){
                 return row.adm_entry.add_on_course.course_name;
               }
               return "";
               
            }
          },
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
          course_id: this.course_id,
          from_date: this.from_date,
          upto_date: this.upto_date
        })
        this.$http.get("{{ url('std-subjects') }}", {params: data})
          .then(function (response) {
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
      
      getCompSubjects: function(course_id) {
        if(course_id == this.current_course_id)
          return this.comp_subjects;
        
        this.current_course_id = course_id;
        var course = {};
        this.comp_subjects = [];
        this.comp_uni_codes = [];
        self = this;
        
        course = _.find(this.courses, function(c) { return c.id == course_id; });
        if(course){
          console.log(course);
          $.each(course.subjects, function(i, s){
            self.comp_subjects.push(s.subject.subject);
            self.comp_uni_codes.push(s.subject.uni_code);
          });
        }
        return this.comp_subjects;
      },
      
      getCompUniCodes: function(course_id) {
        if(course_id != this.current_course_id)
          this.getCompSubjects(course_id);
        
        return this.comp_uni_codes;
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