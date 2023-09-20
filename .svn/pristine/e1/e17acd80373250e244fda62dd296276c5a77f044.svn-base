@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
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
    <strong>Students List</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>

<div id="el">
  <div>
    <honour-modal></honour-modal>
  </div>
  @include('students.update_honour_sub')
  <div>
    <rno-modal></rno-modal>
  </div>
  @include('students.change_rollno')
  <div>
    <sub-modal></sub-modal>
  </div>
  @include('students.change_subjects')
  <div>
    <course-modal></course-modal>
  </div>
  @include('students.change_course')
</div>

@stop
@section('script')
<script>
  $('#example1 tbody').on( 'click', 'td', function () {
    alert( table.cell( this ).data() );
  });
  
  $(document).on('click', '.modal-link', function(e) {
    e.preventDefault();
    var student_id = $(this).data('stdid');
    var type = $(this).data('type');
    var row = $(this).data('row-index');
    var col = $(this).data('col-index');
    if(type == 'rollno')
      vm.showStudent(student_id, row, col);
    if(type == 'subjects')
      vm.showSubjects(student_id, row, col);
    if(type == 'course')
      vm.showCourse(student_id, row, col);
    if(type == 'honours')
      vm.showHonour(student_id, row, col);
  });
  
  
  var vm = new Vue({
    el: '#el',
    methods: {
      showStudent: function(student_id, row, col) {
        if(this.student_id == 0)
          return;
        this.$broadcast('show-student', student_id, row, col);
        console.log('broadcasted: '+student_id);
      },
      showSubjects: function(student_id, row, col) {
        if(this.student_id == 0)
          return;
        this.$broadcast('show-subjects', student_id, row, col);
        console.log('broadcasted: '+student_id);
      },
      showCourse: function(student_id, row, col) {
        if(this.student_id == 0)
          return;
        this.$broadcast('show-course', student_id, row, col);
        console.log('broadcasted: '+student_id);
      },
      showHonour: function(student_id, row, col) {
        if(this.student_id == 0)
          return;
        this.$broadcast('show-honour', student_id, row, col);
        console.log('broadcasted: '+student_id);
      },
    }
  });
  
  var dashboard = new Vue({
    el: '#app',
    data: {
      tData: [],
   //   institution:'',
      course_id: {{ $course->id or request("course_id",0) }},
      courseHounoursCount: 0,
   //   fund_type:'',
      from_date: '',
      upto_date: '',
      table: null,
      url: "{{ url('/') . '/students/' }}",
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
            {
                header: true,
                footer: true,
                extend: 'pdfHtml5',
                download: 'open',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: { orthogonal: 'export' }
                // title: function () {
                //       var title = '';
                //         title += "Stock Register Report    ";
                //         title += self.msg
                //       return title;
                // },
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
          { title: 'Adm.No.', targets: 1, data: 'adm_no',
           "render": function( data, type, row, meta){
             if(type == 'export')
              return data;
            return data + "<br><a href='" + self.url + row.id + "/edit'" + " class='btn btn-primary btn-xs' target = _blank>Edit</a>";
          }},
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
          { title: 'Name', targets: 5, data: 'name',
           "render": function( data, type, row, meta){
            //  if(type == 'export')
              return data;
            return data + "<br><a data-toggle='modal' data-stdid='"+row.id+"' data-row-index='"+meta.row+"' data-col-index='"+meta.col+"' data-type='subjects' class='btn btn-primary btn-xs modal-link' target = _blank>Change Subjects</a>";
           }},
          { title: 'Father Name', targets: 6, data: 'father_name' },
          { title: 'Course', targets: 7, data: 'course_name',
            "render": function( data, type, row, meta){
              if(type == 'export')
                return data;
              
              var fld = '';
              fld = data + "<br><a data-toggle='modal' data-stdid='"+row.id+"' data-row-index='"+meta.row+"' data-col-index='"+meta.col+"' data-type='course' class='btn btn-primary btn-xs modal-link' target = _blank>Change Course/Subjects</a>";
              fld += self.courseHounoursCount > 0 ? "<br><a data-toggle='modal' data-stdid='"+row.id+"' data-row-index='"+meta.row+"' data-col-index='"+meta.col+"' data-type='honours' class='btn btn-primary btn-xs modal-link' target = _blank>Update Honour Subject</a>" : '';
              return fld;
          }},
          { title: 'Roll No', targets: 8, data: 'roll_no',
            "render": function( data, type, row, meta){
             if(type == 'export')
              return data;
            return data + "<br><a data-toggle='modal' data-stdid='"+row.id+"' data-row-index='"+meta.row+"' data-col-index='"+meta.col+"' data-type='rollno' class='btn btn-primary btn-xs modal-link' target = _blank>Change RollNo</a>";
          }},
          { title: 'Remarks', targets: 9, data: 'remarks',
          "render": function ( data, type, row, meta ) {
            return '';
          }},
          { title: 'Alumni Mobile/Email Verification', targets: 10, data: 'std_user_id',
            "render": function ( data, type, row, meta ) {
              // console.log('rahul',row.std_user);
              var str = '';
              str += row.std_user ? 'Mobile = ' + row.std_user.mobile_verified : 'mob';
              str += '<br>';
              str += row.std_user ? 'Email = ' + row.std_user.email2_confirmed : 'email';
              return str;

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
        //  institution:this.institution,
        //  fund_type:this.fund_type,
          from_date: this.from_date,
          upto_date: this.upto_date
        })
        this.$http.get("{{ url('students') }}", {params: data})
          .then(function (response) {
            // this.classes = response.data;
            this.tData = response.data.students;
            this.courseHounoursCount = response.data.courseHounoursCount;
            this.$nextTick(function() {
              this.reloadTable();
            });
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
      hasErrors: function() {
        // console.log(this.errors && _.keys(this.errors).length > 0);
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