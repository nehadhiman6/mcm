@extends($dashboard)
@section('toolbar')
@include('toolbars._admentry_toolbar')
@stop
@section('content')
<!--<div class="row">
  <a href="{{url('/adm-entries/create')}}">
    <button class="btn  btn-flat margin">
      <span>New Admission Entry</span>
    </button>
  </a>
</div>-->
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
      {!! Form::label('from_date','From Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('from_date',request('from_date',today()),['class' => 'form-control app-datepicker', 'v-model'=>'from_date']) !!}
      </div>
      {!! Form::label('upto_date','To Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('upto_date',request('upto_date',today()),['class' => 'form-control app-datepicker', 'v-model'=>'upto_date']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(true),request('course_id'), ['class' => 'form-control', 'v-model' => 'course_id']) !!}
      </div>
      {!! Form::label('status','Status',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('status',['Y'=>'Requested', 'A'=>'Received'],null,['class' => 'form-control', 'v-model'=>'status']) !!}
      </div>
    </div>
    <div class="form-group"  >
      {!! Form::label('entry_status','Entry Status',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('entry_status',[''=>'All', 'A'=>'Admitted', 'N'=>'Not-Admitted'],request('entry_status'),['class' => 'form-control', 'v-model'=>'entry_status']) !!}
      </div>
      {!! Form::label('status','Student Answer',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('status',['A'=>'ALL','Y'=>'Accepted', 'N'=>'Not Accepted','R'=>'Response Awaited'],null,['class' => 'form-control', 'v-model'=>'student_answer']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
</div>
<div class="panel panel-default" id='app'>
  <div class="panel-heading">
    <strong>Admission Entries</strong>
  </div>
  <div class = "panel-body">
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>

@stop
@section('script')
<script>
//$(function() {
//    $(document).on('click', '.show-file', (function() {
//      dashboard.showImage($(this).data('id'), $(this).data('email'));
//    }));
//  });
 var dashboard = new Vue({
    el: '#filter',
    data: {
      permissions: {!! json_encode(getPermissions()) !!},
        tData: [],
        from_date: '',
        upto_date: '',
        status: 'A',
        entry_status: '',
        student_answer:'Y',
        course_id: {{ $course->id or request("course_id",0) }},
        table: null,
        url: "{{ url('/') . '/consents/' }}",
      },
    created: function() {
      var self = this;
      var target = 0;
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
            { title: 'S.No.', targets: target++, data: 'id',
            "render": function( data, type, row, meta) {
                return meta.row + 1;
                var str = '';
                return str;
            }},
            { title: ' Form No', targets: target++, data: 'admission_id'},
          
            
            { title: 'Name', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
               return (row.admission_form ? row.admission_form.name : '') ;
             }},
            { title: 'Course', targets: target++, data: 'course_id',
              "render": function ( data, type, row, meta ) {
               return (row.admission_form ? row.admission_form.course.course_name : '') ;
             }},
            { title: 'Father Name', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
               return (row.admission_form ? row.admission_form.father_name : '') ;
             }},
            { title: 'Mobile', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
               return (row.admission_form ? row.admission_form.mobile : '') ;
             }},
             { title: 'Preference', targets: target++, data: 'preference_no',
             },
             { title: 'Ask Student', targets: target++, data: 'ask_student',
                "render": function ( data, type, row, meta ) {
                    return (data == 'N' ? 'No' : 'Yes');
                }
             },
             { title: 'Student Answer', targets: target++, data: 'student_answer',
                "render": function ( data, type, row, meta ) {
                    return (row.student_answer == 'R' ? 'Requested' : row.student_answer == 'Y' ? 'Accepted' : 'Not Accepted');
                }
             },
             { title: 'Upgrade later', targets: target++, data: 'upgrade_later',
                "render": function ( data, type, row, meta ) {
                    return (data == 'N' ? 'No' : 'Yes');
                }
             },
             { title: 'Subjects Assigned', targets: target++, data: 'preference_no',
             "render": function ( data, type, row, meta ) {
                var str= '';
                row.subject_selected_preferences.forEach(function(ele,index){
                    str+= index+1 +' '+ele.subject.subject+'<br>';
                });
                return str;
             }},

            { title: 'Honour', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
                return (row.honour_assigned ?( row.honour_assigned.subject ? row.honour_assigned.subject.subject:'') : '') ;
             }},
             { title: 'User', targets: target++, data: 'user_id',
              "render": function ( data, type, row, meta ) {
                return (row.user ?( row.user.name ?  row.user.name:'') : '') ;
             }},
            { targets: '_all', visible: true }
          ],
          "sScrollX": true,
        });
    },
    methods: {
      getData: function() {
          data = $.extend({}, {
            from_date: this.from_date,
            upto_date: this.upto_date,
            status: this.status,
            student_answer: this.student_answer,
            course_id: this.course_id,
            entry_status: this.entry_status
          })
          this.$http.get("{{ url('consents') }}", {params: data})
            .then(function (response) {
              this.tData = response.data;
              this.reloadTable();
            }, function (response) {
          });
      },
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      },
    }
  }); 
  
  var vm = new Vue({
    el: '#app',
    methods: {
      showForm: function() {
        console.log('here');
      }
    }
  });
</script>
@stop