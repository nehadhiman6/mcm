@extends('app')

@section('toolbar')
  @include('toolbars._admform_toolbar')
@stop

@section('content')
<div class="box box-default box-solid " id='filter'>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    {!! Form::open(['class' => 'form-horizontal',]) !!}
    <div class="form-group">
      {!! Form::label('date_from','From Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('date_from',request('date_from',startDate()),['class' => 'form-control app-datepicker', 'v-model'=>'date_from']) !!}
      </div>
      {!! Form::label('date_to','To Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('date_to',request('date_to',today()),['class' => 'form-control app-datepicker', 'v-model'=>'date_to']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('filled_by','Filled By',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('filled_by',[''=>'All', 'officials'=>'Officials', 'students'=>'Students','to_be_submitted'=>'Not Submitted'],request('filled_by'),['class' => 'form-control', 'v-model'=>'filled_by']) !!}
      </div>
      {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(),request('course_id'), ['class' => 'form-control', 'v-model' => 'course_id']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
</div>
<div class='panel panel-default' id='app'>
  <div class='panel-heading'>
    <strong>Admission Forms</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
@stop
@section('script')
<script>
  $(function() {
    $(document).on('click', '.show-file', (function() {
      dashboard.showImage($(this).data('adm-id'), $(this).data('file-type'));
    }));
  });
  var dashboard = new Vue({
    el: '#filter',
    data: {
        tData: [],
        course_id: {{ $course->id or request("course_id",0) }},
        date_from: '',
        date_to: '',
        filled_by: '',
        table: null,
        url: "{{ url('/') . '/admission-form/' }}",
        attachUrl: "{{ (isset($guard) && $guard == 'web' ? url('attachment') : url('stdattachment')).'/' }}",
        files: []  ,
        permissions: {!! json_encode(getPermissions()) !!},
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
             { "visible": false, "targets": [17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57] },
             { title: 'S.No.', targets: 0, data: 'id',
            "render": function( data, type, row, meta) {
              return meta.row + 1;
            }},
            { title: 'Form ID', targets: 1, data: 'id' ,
              "render": function( data, type, row, meta){
             if(type == 'export')
              return data;
              if(self.permissions['PREVIEW-ADMISSION-FORMS']){
                return data + "<br><a href='" + self.url + row.id +"'" + " class='btn btn-primary btn-xs' target = '_blank'>Preview</a>";
              }
            }},
            { title: 'Name', targets: 2, data: 'name',
             "render": function( data, type, row, meta){
                if(type == 'export')
                  return data;
                if(self.permissions['EDIT-ADMISSION-FORMS']){
                  return data + "<br><a href='" + self.url + row.id + "/edit'" + " class='btn btn-primary btn-xs'>Edit</a>";
                }
            }},
            { title: 'Father Name', targets: 3, data: 'father_name' },
            { title: 'Course', targets: 4, data: 'course',
              "render": function ( data, type, row, meta ) {
              return (row.course ? row.course.course_name : '') ;
            }},
            { title: 'Contact No.', targets: 5, data: 'mobile' },
            { title: 'Attachments', targets: 6, data: 'attachments',
            "render": function ( data, type, row, meta ) {
              var list = '';
              if(data.length) {
                $.each(data, function(index, file) {
                  list += '<a href="#" class="show-file" data-adm-id="'+row.id+'" data-file-type="'+file.file_type+'">'+file.file_type+'</a><br>'
                });
              }
              return list;
              return data.length ? data.file_type : '' ;
            }},
            { title: 'Exam', targets: 7, data: 'academics[0].exam' },
            { title: 'Institution', targets: 8, data: 'academics[0].institute' },
            { title: 'Board/University', targets: 9, data: 'academics[0].board.name' },
            { title: 'Roll No.', targets: 10, data: 'academics[0].roll_no' },
            { title: 'Year', targets: 11, data: 'academics[0].year' },
            { title: 'Result', targets: 12, data: 'academics[0].result' },
            { title: 'Total Marks', targets: 13, data: 'academics[0].total_marks' },
            { title: 'Marks Obtained', targets: 14, data: 'academics[0].marks_obtained' },
            { title: '%age', targets: 15, data: 'academics[0].marks_per' },
            { title: 'Subjects Offered', targets: 16, data: 'academics[0].subjects' },
            { title: 'DOB', targets: 17, data: 'dob' },
            { title: 'Nationality', targets: 18, data: 'nationality' },
            { title: 'Religion', targets: 19, data: 'religion' },
            { title: 'AAdhar No.', targets: 20, data: 'aadhar_no' },
            { title: 'Blood Group', targets: 21, data: 'blood_grp' },
            { title: 'Migration', targets: 22, data: 'migration', 
            "render": function ( data, type, row, meta ) {
              return (row.migration == 'Y' ? 'YES' : '') ;
            }},
            { title: 'Hostel', targets: 23, data: 'hostel',
            "render": function ( data, type, row, meta ) {
              return (row.hostel == 'Y' ? 'YES' : '') ;
            }},
            { title: 'Blind', targets: 24, data: 'blind', 
            "render": function ( data, type, row, meta ) {
              return (row.blind ? 'YES' : '') ;
            }},
            { title: 'Permanent Address', targets: 25, data: 'per_address' },
            { title: 'Pincode', targets: 26, data: 'pincode' },
            { title: 'Father Occupation', targets: 27, data: 'father_occup' },
            { title: 'Father Designation', targets: 28, data: 'father_desig' },
            { title: 'Father Phone', targets: 29, data: 'father_phone' },
            { title: 'Father Mobile', targets: 30, data: 'father_mobile' },
            { title: 'Father Email', targets: 31, data: 'father_email' },
            { title: 'Father Office Address', targets: 32, data: 'f_office_addr' },
            { title: 'Mother Occupation', targets: 33, data: 'mother_occup' },
            { title: 'Mother Designation', targets: 34, data: 'mother_desig' },
            { title: 'Mother Phone', targets: 35, data: 'mother_phone' },
            { title: 'Mother Mobile', targets: 36, data: 'mother_mobile' },
            { title: 'Mother Email', targets: 37, data: 'mother_email' },
            { title: 'Mother Office Address', targets: 38, data: 'm_office_addr' },
            { title: 'Guardian Occupation', targets: 39, data: 'guardian_occup' },
            { title: 'Guardian Designation', targets: 40, data: 'guardian_desig' },
            { title: 'Guardian Phone', targets: 41, data: 'guardian_phone' },
            { title: 'Guardian Mobile', targets: 42, data: 'guardian_mobile' },
            { title: 'Guardian Email', targets: 43, data: 'guardian_email' },
            { title: 'Guardian Office Address', targets: 44, data: 'g_office_addr' },
            { title: 'PU Registration No.', targets: 45, data: 'pu_regno' },
            { title: 'Pupin No.', targets: 46, data: 'pupin_no' },
            { title: 'Course', targets: 47, data: 'course',
              "render": function ( data, type, row, meta ) {
              return (row.course ? row.course.course_name : '') ;
            }},
            { title: 'Gap Year ', targets: 48, data: 'gap_year' },
            { title: 'Migrated', targets: 49, data: 'migrated',
              "render": function ( data, type, row, meta ) {
              return (row.migrated =='Y' ? 'YES' : '') ;
            }},
            { title: 'Migrate Details', targets: 50, data: 'migrate_detail' },
            { title: 'Disqualified', targets: 51, data: 'disqualified',
            "render": function ( data, type, row, meta ) {
              return (row.disqualified =='Y' ? 'YES' : '') ;
            }},
            { title: 'Disqualified Details', targets: 52, data: 'disqualify_detail' },
            { title: 'Foreign National', targets: 53, data: 'foreign_national',
            "render": function ( data, type, row, meta ) {
              return (row.foreign_national =='Y' ? 'YES' : '') ;
            }},
            { title: 'Foreign Natgionality', targets: 54, data: 'f_nationality' },
            { title: 'Passport No', targets: 55, data: 'passportno' },
            { title: 'Visa Valid Upto', targets: 56, data: 'visa' },
            { title: 'Residential Permit', targets: 57, data: 'res_permit' },
            { targets: '_all', visible: true }
          ],
          "sScrollX": true,
        });
    },
    methods: {
      getData: function() {
          data = $.extend({}, {
            course_id: this.course_id,
            date_from: this.date_from,
            date_to: this.date_to,
            filled_by: this.filled_by,
          })
          this.$http.get("{{ url('admission-form') }}", {params: data})
            .then(function (response) {
//                console.log(response.data);
              this.tData = response.data;
              this.reloadTable();
            }, function (response) {
  //            console.log(response.data);
          });
      },
      reloadTable: function() {
//          console.log('here');
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      },
      showImage: function(form_id, file_type) {
        self = this;
        window.open(
            this.attachUrl+form_id+'/'+file_type,
            '_blank'
          );
        return;
          if(this.url) {
            $.fancybox.open({
              src  : self.attachUrl+form_id+'/'+file_type,
              type : 'iframe',
              opts : {
                beforeLoad: function() {
//                    console.log(this);
                },
                iframe: {
                  css: {
                    width: '100% !important'
                  }
                }
               }
            });
          }
        }
      }
  }); 
</script>
@stop