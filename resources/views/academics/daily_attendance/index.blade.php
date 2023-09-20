@extends('app')
@section('toolbar')
    @include('toolbars._academics_toolbar')
@stop

@section('content')
<div id='app' v-cloak>
    <div>
        <ul class="alert alert-error alert-dismissible" role="alert" v-show="showErrors">
            <li  v-for='key in errors'>@{{ key}} <li>
        </ul>
        <div class="box box-default box-solid" >
            <div class="box-header with-border">
                Details
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('attendance_date','Date',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3">
                        {!! Form::text('attendance_date',request('attendance_date',today()),['class' => 'form-control datepicker', 'v-model'=>'form.attendance_date',':disabled'=>'disableFields']) !!}
                    </div>
                    {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
                        {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse','v-model'=>'form.course_id',':disabled'=>'disableFields','@change' => 'getSubjectsList']) !!}
                        <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
                    </div>
                </div>
                <div class="form-group" >
                    {!! Form::label('subject_id','Subject',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['subject_id'] }">
                        <select class='form-control subjectSelect' id='subject_id' v-model='form.subject_id'  :disabled ='disableFields' @change.prevent = 'getSubjectSection'>
                           <option value="0">Select</option>
                            <option v-for="sub in subjects | orderBy 'subject'" :value="sub.id">@{{ sub.subject }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['subject_id']" class="help-block">@{{ errors['subject_id'][0] }}</span>
                    </div>
                    {!! Form::label('sub_sec_id','Section',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['sub_sec_id'] }">
                        <select class='form-control' id='sub_sec_id' v-model='form.sub_sec_id'  :disabled ='disableFields' @change.prevent = 'getSubSubjectSection'>
                            <option v-for="sub in subject_sections | orderBy 'section'" :value="sub.id">@{{ sub.section.section }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['sub_sec_id']" class="help-block">@{{ errors['sub_sec_id'][0] }}</span>
                    </div>
                </div>
                <div class="form-group" >
                    {!! Form::label('sub_subject_sec_id','Sub Subject ',['class' => 'col-sm-2 control-label','v-show'=>'form.has_sub_subjects=="Y"']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['sub_subject_sec_id'] }" v-show = "form.has_sub_subjects=='Y'">
                        <select class='form-control' id='sub_subject_sec_id' v-model='form.sub_subject_sec_id'  :disabled ='disableFields'  >
                            <option v-for="sub in sub_subject_sections | orderBy 'subject'" :value="sub.id">@{{ sub.sub_subject_name }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['sub_subject_sec_id']" class="help-block">@{{ errors['sub_subject_sec_id'][0] }}</span>
                    </div>
                </div>
                <div class="form-group" >
                    {!! Form::label('period_no','Period No.',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['period_no'] }">
                        <select class="form-control" v-model="form.period_no" placeholder='Optional'>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                        <span id="basic-msg" v-if="errors['period_no']" class="help-block">@{{ errors['period_no'][0] }}</span>
                    </div>
                    {!! Form::label('remarks','Remarks',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['remarks'] }">
                        {!! Form::textarea('others', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'form.remarks']) !!}
                        <span id="basic-msg" v-if="errors['remarks']" class="help-block">@{{ errors['remarks'][0] }}</span>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-sm-10 text-right">
                        {!! Form::submit('RESET',['class' => 'btn btn-primary mr-1', '@click.prevent'=>'resetFields']) !!}
                        {!! Form::submit('SHOW',['class' => 'btn btn-primary' ,'@click.prevent'=>'showStudents']) !!}
                    </div>
                </div>
                <div class="form-group" v-if="students.length > 0">
                        {!! Form::label('attendance_status','Mark all students attendence  ',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['attendance_status'] }">
                        <select class="form-control" v-model="attendance_status">
                            <option value='P'>Present</option>
                            <option value='A'>Absent</option>
                            <option value='TL'>Teacher Leave</option>
                        </select>
                        <span id="basic-msg" v-if="errors['attendance_status']" class="help-block">@{{ errors['attendance_status'][0] }}</span>
                    </div>
                    {!! Form::submit('SAVE ALL',['class' => 'btn btn-primary' ,'@click.prevent'=>'allStudentsAttendance']) !!}
                </div>
            </div>
        </div>
        <div class="panel panel-default" v-if="students.length > 0">
            <div class="panel-heading">
                Students
            </div>
            <div class="panel-body" >
                <table class="table table-bordered" id ="attendenceTable">
                    <thead>
                        <th>Sr. no</th>
                        <th>Adm no.</th>
                        <th>Student Name</th>
                        <th>Attendance Status</th>
                    </thead>
                    <tbody>
                        <tr v-for="std in students" :key="std.adm_no">
                            <td><span :class="{ 'fa fa-check': std.saved == true}"  style="color:green" ></span> @{{ $index+1 }}</td>
                            <td>@{{ std.adm_no }}</td>
                            <td>@{{ std.name }}</td>
                            <td>
                                <select class="form-control" v-model="std.attendance_status" @change="studentattendance(std,$index)">
                                    <option value=''>Select</option>
                                    <option value='P'>Present</option>
                                    <option value='A'>Absent</option>
                                    <option value='TL'>Teacher Leave</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div></div>
</div>
@stop

@section('script')
    <script>
        function getNewForm(){
            return{
                attendance_date:"{{ today() }}",
                course_id:0,
                subject_id:0,
                sub_sec_id:0,
                sub_subject_sec_id:0,
                period_no:'',
                remarks:'',
                has_sub_subjects:'N',
                student:{},
                table :null,
            }
        }
        var vm = new Vue({
        el: '#app',
        data: {
            form:getNewForm(),
            selected_course_id:0,
            errors:{},
            subjects:[],
            subject_sections:[],
            sub_subject_sections:[],
            disableFields:false,
            students:[],
            attendance_status:0,
        },
        computed:{
            showErrors:function(){
                if( Object.keys(this.errors).length == 0){
                    return false;
                }
                return true;
            }
        },
        created:function(){
            var self = this;
            $('#alotSectionTable').DataTable();

            $('.selectCourse').select2({
                placeholder: 'Select Course',
                width:'100%'
            });
            $('.selectCourse').on('change',function(){
                self.form.course_id = $(this).val();
                self.form.subject_id = 0;
                $('.subjectSelect').val(0).trigger('change');
                self.getSubjectsList();
            });


            $('.subjectSelect').select2({
                placeholder: 'Select Subject',
                width:'100%'
            });
            $('.subjectSelect').on('change',function(){
                self.form.subject_id = $(this).val();
                self.getSubjectSection();
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
            showStudents:function(){
                var self = this;
                this.$http.post("{{ url('daily-attendance/students-list') }}",this.form)
                .then(function(response){
                    if(response.data.students){
                        var students = response.data.students;
                        self.students= [];
                        students.forEach(element => {
                            self.students.push({'std_id':element.std_id,'name': element.student.name,
                            'attendance_status':element.attendance_status,'adm_no':element.student.adm_no,'saved':false});
                        });
                        setTimeout(function(){
                            self.disableFields = true;
                            if(self.table != null){
                                self.table.destroy();
                            }
                            self.table = $('#attendenceTable').DataTable();
                        },500);
                    }
                })
                .catch(function(error){
                    if(error.status == 422) {
                        self.errors = error.data;
                    }
                });
            },

            studentattendance:function(std,index){
                var self = this;
                this.form.student = std;
                this.$http.post("{{ url('daily-attendance') }}",this.form)
                .then(function(response){
                    if(response.data.success = 'ok'){
                        self.students[index].saved = true;
                    }
                })
                .catch(function(error){
                    if(error.status == 422) {
                        self.errors = error.data;
                    }
                });
            },
            resetFields:function(){
                this.form = getNewForm();
                this.selected_course_id=0;
                this.errors={};
                this.subjects=[];
                this.subject_sections=[];
                this.sub_subject_sections=[];
                this.disableFields=false;
                this.students = [];
                this.attendance_status = 0;
                $('.selectCourse').val(0).trigger('change');
                $('.subjectSelect').val(0).trigger('change');
                
            },
            allStudentsAttendance:function(){
                var self = this;
                var data = Object.assign({}, this.form);
                data.students = this.students;
                data.attendance_status = this.attendance_status;
                this.$http.post("{{ url('daily-attendance') }}",data)
                .then(function(response){
                    if(response.data.success = 'ok'){
                        self.students.forEach(function(ele){
                            ele.saved = true;
                            ele.attendance_status =  self.attendance_status;
                        });
                    }
                })
                .catch(function(error){
                    if(error.status == 422) {
                        self.errors = error.data;
                    }
                });
            }
        }
    });
  </script>
@stop