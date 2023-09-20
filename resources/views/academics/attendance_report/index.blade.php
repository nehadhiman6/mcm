@extends('app')

@section('toolbar')
    @include('toolbars._academics_toolbar')
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
    {!! Form::open(['method' => 'GET',  'action' => ['Reports\StdStrengthController@subStdStrength'], 'class' => 'form-horizontal']) !!}
    <div class="form-group">
        {!! Form::label('month','Month',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
            {!! Form::select('month',monthsList(),null,['class' => 'form-control', 'v-model' => 'month']) !!}
            <span id="basic-msg" v-if="errors['course_id']" class="text-danger">@{{ errors['course_id'][0] }}</span>
        </div>
        {!! Form::label('year','Year',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
            {!! Form::select('year',['2018'=>'2018','2019'=>'2019'],null,['class' => 'form-control','v-model'=>'year']) !!}
            <span id="basic-msg" v-if="errors['course_id']" class="text-danger">@{{ errors['course_id'][0] }}</span>
        </div>
        {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
            {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse','v-model'=>'form.course_id',':disabled'=>'disableFields','@change' => 'getSubjectsList']) !!}
            <span id="basic-msg" v-if="errors['course_id']" class="text-danger">@{{ errors['course_id'][0] }}</span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('subject_id','Subject',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['subject_id'] }">
            <select class='form-control subjectSelect' id='subject_id' v-model='form.subject_id'  :disabled ='disableFields' @change.prevent = 'getSubjectSection'>
                <option v-for="sub in subjects | orderBy 'subject'" :value="sub.id">@{{ sub.subject }}</option>
            </select>
            <span id="basic-msg" v-if="errors['subject_id']" class="text-danger">@{{ errors['subject_id'][0] }}</span>
        </div>

        {!! Form::label('sub_sec_id','Section',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['sub_sec_id'] }">
            <select class='form-control' id='sub_sec_id' v-model='form.sub_sec_id'  :disabled ='disableFields' @change.prevent = 'getSubSubjectSection'>
                <option v-for="sub in subject_sections | orderBy 'section'" :value="sub.id">@{{ sub.section.section }}</option>
            </select>
            <span id="basic-msg" v-if="errors['sub_sec_id']" class="text-danger">@{{ errors['sub_sec_id'][0] }}</span>
        </div>

        {!! Form::label('sub_subject_sec_id','Sub Subject',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['sub_subject_sec_id'] }">
            <select class='form-control' id='sub_subject_sec_id' v-model='form.sub_subject_sec_id'  :disabled ='disableFields'  >
                <option v-for="sub in sub_subject_sections | orderBy 'subject'" :value="sub.id">@{{ sub.sub_subject_name }}</option>
            </select>
            <span id="basic-msg" v-if="errors['sub_subject_sec_id']" class="text-danger">@{{ errors['sub_subject_sec_id'][0] }}</span>
        </div>
        {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Attendance Report
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
    </table>
  </div>
</div>
<div id="subject-box"></div>
</div>
</div>
@stop
@section('script')
<script>
    function getNewForm(){
        return{
            course_id:0,
            subject_id:0,
            sub_sec_id:0,
            sub_subject_sec_id:0,
            has_sub_subjects:'N',
        }
    }
  
var dashboard = new Vue({
  el: '#app',
  data: {
        form: getNewForm(),
        tData: [],
        year: '',
        month: '',
        table: null,
        selected_course_id:0,
        errors:{},
        subjects:[],
        subject_sections:[],
        sub_subject_sections:[],
        disableFields:false,
    },
    created: function() {
        var self = this;
        var target = 0;
        $('.selectCourse').select2({
            placeholder: 'Select Course',
            width:'100%'
        });
        $('.selectCourse').on('change',function(){
            self.form.course_id = $(this).val();
            self.getSubjectsList();
            self.form.subject_id = 0;
            $('.subjectSelect').val(0).trigger('change');
        });


        $('.subjectSelect').select2({
            placeholder: 'Select Subject',
            width:'100%'
        });
        $('.subjectSelect').on('change',function(){
            self.form.subject_id = $(this).val();
            self.sub_sec_id = 0;
            self.sub_subject_sec_id = 0;
            self.getSubjectSection();
        });
        
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
            }},
            { title: 'Subjects', targets: target++, data: 'subject'},
            { title: 'Roll No', targets: target++, data: 'id',
                "render": function( data, type, row, meta) {
                    return row.student ? row.student.roll_no:'';
                }
            },
            { title: 'Name', targets: target++, data: 'id',
                "render": function( data, type, row, meta) {
                    return row.student ? row.student.name:'';
                }
            },
            
            { title: 'Present', targets: target++, data: 'presents' },
            { title: 'Absents', targets: target++, data: 'absents' },
            { title: 'Total', targets: target++, data: '' ,
                "render": function( data, type, row, meta) {
                    return row.total;
                }},
            { targets: '_all', visible: true }
            ],
            "sScrollX": true,
        });
  },
  methods: {
    getSubjectsList: function() {
        if(this.form.course_id != 0 && this.form.course_id != this.selected_course_id) {
            this.$http.get("{{ url('courses') }}/"+this.form.course_id+"/subjects_list_course")
            .then(function(response) {
                this.subjects = response.data.subjects;
                this.selected_course_id = this.form.course_id ;
            }, function(response) {
            });
        }
    },
    getSubjectSection: function() {
        var self = this;
        if(this.form.course_id != 0 && this.form.teacher_id != 0 && this.form.subject_id != 0) {
            this.$http.post("{{ url('daily-attendance/subject-section') }}",this.form)
            .then(function(response) {
                if(response.data.subject_sections){
                    self.subject_sections = response.data.subject_sections;
                }
            }, function(response) {
            });
        }
    },
    getSubSubjectSection:function(){
        console.log("here");
        var self = this;
        var selected_subject_section = self.subject_sections.find(x => x.id === this.form.sub_sec_id)
        if(selected_subject_section.has_sub_subjects == 'N'){
            self.form.has_sub_subjects = 'N';
        }
        else{
            self.form.has_sub_subjects = 'Y';
            self.sub_subject_sections = selected_subject_section.sub_sec_details;
        }

    },
    getData: function() {
        var self = this;
        data = {
            month: self.month,
            year: self.year,
            course_id: self.form.course_id,
            subject_id: self.form.subject_id,
            sub_sec_id: self.form.sub_sec_id,
            sub_subject_sec_id: self.form.sub_subject_sec_id,
        };
        self.$http.get("{{ url('attendance-report') }}", {params: data})
        .then(function (response) {
            if(response.data.success == true){
                self.tData = response.data.students;
                self.reloadTable();
            }
        }, function (error) {
            console.log(error.body);
            self.errors = error.body;
        });
},

       hasError: function(fld) {
        var error = [];
        error = false;
        $.each(Object.keys(this.errors), function(i, v) {
            if (fld == v) {
            error = true;
            }
        });
        return error;
      },
      
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
  }
  
});
</script>
@stop