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
    </div>
    <div class="box box-default box-solid" >
        <div class="box-header with-border">
          Examination Details
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
        <div class="box-body">
            <div class="form-group" >
                {!! Form::label('exam_name', 'Examination', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['exam_name'] }">
                    {!! Form::select('exam_name', getExaminations(), null, ['class' => 'form-control', 'v-model' => 'exam_name',':disabled'=>'saving']) !!}
                    <span id="basic-msg" v-if="errors['exam_name']" class="help-block">@{{ errors['exam_name'][0] }}</span>
                </div> {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_subject.course_id'] }">
                    {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse','v-model'=>'student_subject.course_id',':disabled'=>'saving','@change' => 'getSubjectsList']) !!}
                    <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['student_subject.course_id'][0] }}</span>
                </div>
                {!! Form::label('semester', 'Semester', ['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['semester'] }">
                    <select class='form-control' id='semester' v-model='semester'  :disabled ='saving'>
                        <option v-for="sem in semesters" :value="sem.id">@{{ sem.sem }}</option>
                    </select>
                    {{-- {!! Form::select('semester', getSemesters(), null, ['class' => 'form-control', 'v-model' => 'semester',':disabled'=>'saving']) !!} --}}
                    <span id="basic-msg" v-if="errors['semester']" class="help-block" >@{{ errors['semester'][0] }}</span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('subject_id','Subject',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_subject.subject_id'] }">
                        <select class='form-control subjectSelect' id='subject_id' v-model='student_subject.subject_id' @change.prevent="resetData" :disabled ='saving'>
                            <option v-for="sub in subjects | orderBy 'subject'" :value="sub.id">@{{ sub.subject }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['subject_id']" class="help-block">@{{ errors['student_subject.subject_id'][0] }}</span>
                    </div>
               
                {!! Form::label('section_id', 'Section', ['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['student_subject.section_id'] }">
                    {{-- {!! Form::select('section_id', getSections(), null, ['class' => 'form-control', 'v-model' => 'student_subject.section_id',':disabled'=>'saving']) !!} --}}
                    <select class='form-control'  v-model='student_subject.section_id'  :disabled ='saving'>
                        <option v-for="sub in sectionsList | orderBy 'section'" :value="sub.section.id">@{{ sub.section.section }}</option>
                    </select>
                    <span id="basic-msg" v-if="errors['section_id']" class="help-block">@{{ errors['student_subject.section_id'][0] }}</span>
                </div>
                <div class="col-sm-2">
                    {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()','v-if'=>'saving && !showMarks']) !!}
                    {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'checkRecord()','v-if'=>'!saving']) !!}
                </div>
            </div>
            
            <div class="form-group" v-if="showpaper">
                {!! Form::label('have_sub_papers','Have Sub Papers',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['have_sub_papers'] }">
                    <label class="radio-inline">
                        {!! Form::radio('have_sub_papers','Y',null, ['class' => 'minimal','v-model'=>'have_sub_papers',':disabled'=>'saving']) !!}
                        Yes
                        </label>
                    <label class="radio-inline">
                    {!! Form::radio('have_sub_papers', 'N',null, ['class' => 'minimal','v-model'=>'have_sub_papers',':disabled'=>'saving']) !!}
                        No
                    </label>
                </div>
                {!! Form::label('paper_type','Paper Type',['class' => 'col-sm-1 control-label','v-if'=>"have_sub_papers == 'Y'"]) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['paper_type'] }" v-if="have_sub_papers == 'Y'">
                    {!! Form::select('paper_type',getPaperTypes(),null,['class' => 'form-control',':disabled'=>'showMarks','v-model'=>'paper_type','@change'=>'changedPaperType']) !!}
                    <span id="basic-msg" v-if="errors['paper_type']" class="help-block">@{{ errors['paper_type'][0] }}</span>
                </div>
            </div>
            <div class="form-group"  v-if="showpaper">
                {!! Form::label('paper_code','Paper Code',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['paper_code'] }">
                    {!! Form::text('paper_code',null,['class' => 'form-control',':disabled'=>'showMarks','v-model'=>'paper_code']) !!}
                    <span id="basic-msg" v-if="errors['paper_code']" class="help-block">@{{ errors['paper_code'][0] }}</span>
                </div>
                {!! Form::label('min_marks','Pass Marks',['class' => 'col-sm-1 control-label' ]) !!}
                <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['min_marks'] }" >
                    {!! Form::text('min_marks',null,['class' => 'form-control',':disabled'=>'showMarks','v-model'=>'min_marks']) !!}
                    <span id="basic-msg" v-if="errors['min_marks']" class="help-block">@{{ errors['min_marks'][0] }}</span>
                </div>
                {!! Form::label('max_marks','Max. Marks',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['max_marks'] }" >
                    {!! Form::text('max_marks',null,['class' => 'form-control',':disabled'=>'showMarks','v-model'=>'max_marks']) !!}
                    <span id="basic-msg" v-if="errors['max_marks']" class="help-block">@{{ errors['max_marks'][0] }}</span>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <div class="col-sm-2 pull-right"  v-if="showpaper">
                        {!! Form::submit('Save & Show Marks',['class' => 'btn btn-primary','@click.prevent'=>'savePaperData()','v-if'=>"!showMarks"]) !!}
                        {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()','v-if'=>'showMarks']) !!}
                        
                </div>
            </div>
        </div>
        {!! Form::close() !!}
      </div>
      <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Successfully Saved!</strong> 
      </div>
      
      <div class="panel panel-default" v-show="showMarks">
        <div class="panel-heading">
          Students Marks
        </div>
        <div class="panel-body">
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Roll No.</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Marks</th>
                        <th>Status</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                    <tr v-for='std in student_marks' >
                        <td><span v-if="std.id > 0  && std.saved" class="fa fa-check" style="color:green" ></span> @{{ $index+1 }}</td>
                        <td width="20">@{{std.roll_no}}
                            {{-- <input type="text"  v-bind:class="{ 'table-data': errors['student_marks.'+$index+'.std_id'] }" :disabled= 'std.id > 0' placeholder="Roll No" v-model='std.roll_no' width="20" @blur="getStudent(std.roll_no, $index)" /> --}}
                            {{-- <input type="text"  v-bind:class="{ 'table-data': errors['student_marks.'+$index+'.std_id'] }" disabled placeholder="Roll No" v-model='std.roll_no' width="20" @blur="getStudent(std.roll_no, $index)" />  --}}
                        </td>
                        <td>@{{ std.name }}</td>
                        <td>@{{ std.father_name }}</td>
                        <td><input type="text" placeholder="marks"  v-bind:class="{ 'text-error': getClassByMarks(std.marks,std.std_id) }"  class = "" v-model='std.marks' @blur="addMarks($index)" /></td>
                        <td><input type = "checkbox" name= "absent" value= "A" :disabled = "std.std_id == ''" v-model="std.status" v-bind:true-value="'A'" v-bind:false-value="'P'" @change="absentEntry($index , std) ">Absent</td>
                        <td><span v-if="std.id > 0" class="fa fa-close" @click="removeEntry($index)"></span></td>
                    </tr>
                </thead>
            </table>
            {{-- <button class="fa fa-plus" @click="addNewRow"></button> --}}
        </div>
      </div>
  </div>
@stop

@section('script')
    <script>
        var vm = new Vue({
        el: '#app',
        data: {
            student_subject:{
                course_id:0,
                subject_id:0,
                section_id:0,
                teacher_id:0,
                students:0
            },
            student_marks:[],
            have_sub_papers:'N',
            exam_name: '',
            semester: '',
            selected_course_id: 0,
            paper_type:0,
            paper_code:'',
            min_marks: '',
            max_marks: '',
            subjects: [],
            students: {},
            errors: {},
            saving: false,
            semesters:[],
            showMarks:false,
            success:false,
            showpaper:false,
            sectionsList:[],
            table:null
        },
        created:function(){
            var self = this;
            this.student_marks.push({
                id:0,
                marks:'',
                roll_no:'',
                name:'',
                std_id:'',
                father_name:'',
                saved: false,
                status:'P'
            });

            $('.selectCourse').select2({
                placeholder: 'Select Course',
                width:'100%'
            });
            $('.selectCourse').on('change',function(){
                self.student_subject.course_id = $(this).val();
                self.student_subject.subject_id = 0;
                $('.subjectSelect').val(0).trigger('change');
                self.getSubjectsList();
            });

            $('.subjectSelect').select2({
                placeholder: 'Select Subject',
                width:'100%'
            });
            $('.subjectSelect').on('change',function(){
                self.student_subject.subject_id = $(this).val();
                self.getSubjectSection();
                self.resetData();
            });
        },
        computed:{
            showErrors:function(){
                if( Object.keys(this.errors).length == 0){
                    return false;
                }
                return true;
            }
        },
        methods: {
            getSubjectsList: function() {
                if(this.student_subject.course_id != 0 && this.student_subject.course_id != this.selected_course_id) {
                    this.$http.get("{{ url('courses') }}/"+this.student_subject.course_id+"/subjects_list_course")
                    .then(function(response) {
                        this.subjects = response.data.subjects;
                        this.selected_course_id = this.student_subject.course_id ;
                        var courseYear = response.data.course.course_year;
                        this.semesters = [];
                        this.semesters = [{'id' : courseYear+(courseYear - 1), 'sem': this.getSemesterName(courseYear+(courseYear - 1))},
                                          {'id' : courseYear+(courseYear-1) +1, 'sem': this.getSemesterName(courseYear+(courseYear-1) +1)}]
                        this.resetData();
                    }, function(response) {
                    });
                }
            },
            getSubjectSection: function() {
                var self = this;
                if(this.student_subject.course_id != 0 && this.student_subject.subject_id != 0) {
                    this.$http.post("{{ url('daily-attendance/subject-section') }}",{'course_id':self.student_subject.course_id ,'subject_id':self.student_subject.subject_id})
                    .then(function(response) {
                        if(response.data.subject_sections){
                            self.sectionsList = response.data.subject_sections;
                        }
                    }, function(response) {
                    });
                }
            },
            getSemesterName:function(sem){
                switch (sem)
                {
                    case 1: 
                        return "First";
                    case 2: 
                        return "Second";
                    case 3: 
                        return "Third";
                    case 4: 
                        return "Fourth";
                    case 5: 
                        return "Fifth";
                    case 6: 
                        return "Sixth";
                    default: 
                        return "Select Course First";
                }
            },
            getClassByMarks:function(marks,std_id){
                if(marks < this.min_marks && std_id != '' &&  marks!= ''){
                    return true;
                }
                return false;
            },
            getStudent: function(roll_no,index){
                var self = this;
                if(roll_no != "" && this.student_subject.course_id!= 0 ){
                    this.$http.get("{{ url('students/roll_no') }}/"+roll_no+"/"+this.student_subject.course_id)
                        .then(function(response) {
                            if(response.data.success) {
                                var student = response.data.student;
                                if(student != "" && student !=null){
                                    if (self.student_marks.filter(stu=> stu.std_id == student.id).length > 0){
                                        $.blockUI({ message: '<h4>You have already entered Marks for this Roll number above....</h4>' });
                                        setTimeout(function(){
                                            self.student_marks[index].roll_no = '';
                                            $.unblockUI();
                                        },1500);
                                    }
                                    else{
                                        self.student_marks[index].name = student.name;
                                        self.student_marks[index].father_name = student.father_name;
                                        self.student_marks[index].std_id = student.id;
                                        self.student_marks[index].status = 'P';
                                    }
                                }
                                else{
                                    self.student_marks[index].name = '';
                                    self.student_marks[index].father_name = '';
                                    self.student_marks[index].std_id = '';
                                    self.student_marks[index].status = 'P';
                                    $.blockUI({ message: '<h4>Roll Number does not belongs to selected course...</h4>' });
                                    setTimeout(function(){
                                        self.student_marks[index].roll_no = '';
                                        $.unblockUI();
                                    },1000);
                                }
                            }
                            }, function(response) {
                    });
                }
            },
            addNewRow:function(){
                if(this.student_marks[this.student_marks.length-1].roll_no > 0 && this.student_marks[this.student_marks.length-1].roll_no != '' ){
                    this.student_marks.push({
                        id:0,
                        marks:'',
                        roll_no:'',
                        name:'',
                        father_name:'',
                        std_id:'',
                        saved: false,
                        status:'P'
                    });
                    var lastInput = $("input:text:visible:last");
                    setTimeout(function(){
                        var thisIndex = $(lastInput).index('input:text');
                        var next = thisIndex + 1;
                        var nextElem = $('input:text').eq(next);
                        nextElem.focus();
                    });
                    
                }
            },
            removeEntry:function(index){
                var student = this.student_marks[index];
                var data = $.extend({}, this.$data, { student: student });
                console.log(data);
                this.$http.post("{{ url('student-marks/remove') }}", data )
                .then(function(response) {
                    if(response.data.success){
                        this.student_marks.splice(index, 1);
                    }
                });
            },
            checkRecord:function(){
                var self = this;
                this.$http.post("{{ url('student-marks/show') }}", this.$data )
                .then(function(response){
                    if(response.data.success && response.data.exam_details){
                        self.have_sub_papers = response.data.exam_details.have_sub_papers;
                        if(self.have_sub_papers  == 'N'){
                            self.max_marks =  response.data.exam_details.max_marks;
                            self.min_marks =  response.data.exam_details.min_marks;
                            self.paper_code =  response.data.exam_details.paper_code;
                        }
                        self.saving = true;
                    }
                    self.showpaper = true;
                   
                },
                function(response) {
                    if(response.status == 422) {
                        $('body').scrollTop(0);
                        self.errors = response.data;
                    }    
                });
            },
            savePaperData:function(){
                var self = this;
                    this.$http.post("{{ url('student-marks/subject') }}", this.$data )
                    .then(function(response) {
                        if(response.data.success && response.data.success == "sub-papers"){
                            alert("This Subject has sub Papers.Please Enter Paper code and paper Type");
                            self.have_sub_papers = 'Y';
                            return;
                        }
                        if(response.data.students && response.data.students.length > 0){
                            self.student_marks = [];
                                // response.data.marks.forEach(function(ele){
                                //     self.student_marks.push({
                                //         id:ele.id,
                                //         marks:ele.marks,
                                //         std_id:ele.std_id,
                                //         roll_no:ele.student.roll_no,
                                //         name:ele.student.name,
                                //         father_name:ele.student.father_name,
                                //         saved:true,
                                //         status:ele.status,
                                //     });
                                // });
                                response.data.students.forEach(function(element){
                                    self.student_marks.push({
                                        id:0,
                                        marks:'',
                                        std_id:element.std_id,
                                        roll_no:element.student.roll_no,
                                        name:element.student.name,
                                        father_name:element.student.father_name,
                                        status:'P',
                                    });
                                });
                                response.data.marks.forEach(function(element){
                                    self.student_marks.forEach(function(ele){
                                        if(element.std_id == ele.std_id)
                                        {
                                            ele.id = element.id;
                                            ele.marks = element.marks;
                                            ele.saved = true;
                                            ele.status = element.status;
                                        }
                                    });
                                });
                                // self.student_marks.sort((a, b) => parseFloat(b.id) - parseFloat(a.id));
                        }
                        else{
                            self.student_marks = [];
                            // self.student_marks.push({
                            //     id:0,
                            //     marks:'',
                            //     std_id:'',
                            //     roll_no:'',
                            //     name:'',
                            //     father_name:'',
                            //     status:'P'
                            // });
                            $.blockUI({ message: '<h4>There is no student in selected course and section...</h4>' });
                            setTimeout($.unblockUI, 2000); 
                            
                        }
                        this.saving = true;
                        this.showMarks = true;
                },
                function(response) {
                    if(response.status == 422) {
                        $('body').scrollTop(0);
                        self.errors = response.data;
                    }    
                });
            },
            saveData: function() {
                var self = this;
                this.errors ={};
                if((this.student_marks[this.student_marks.length-1].std_id =='' || this.student_marks[this.student_marks.length-1].std_id ==0) && this.student_marks.length > 1 && this.student_marks[this.student_marks.length-1].roll_no == ''){
                    this.removeEntry(this.student_marks.length-1);
                }
                this.$http.post("{{ url('student-marks') }}", this.$data )
                .then(function(response) {
                    if(response.data.success) {
                        self.student_marks = [];
                        self.student_marks.push({
                            id:0,
                            marks:'',
                            roll_no:'',
                            name:'',
                            std_id:'',
                            father_name:''
                        });
                        self.student_subject.course_id = 0;
                        self.student_subject.subject_id = 0;
                        self.student_subject.section_id = 0;
                        self.student_subject.teacher_id = 0;
                        self.student_subject.students = 0;
                        self.exam_name= '';
                        self.max_marks= '';
                        self.min_marks='';
                        self.semester= '';
                        self.paper_code = '';
                        self.paper_type= 0;
                        self.success = true;
                        $('.selectCourse').val(0).trigger('change');
                        $('.subjectSelect').val(0).trigger('change');
                        setTimeout(function(){
                            self.success = false;
                            self.saving = false;
                        },1000);
                    }
                }, function(response) {
                    if(response.status == 422) {
                    $('body').scrollTop(0);
                        self.errors = response.data;
                    }    
                });
            },
            resetData:function(){
                var self = this;
                self.student_marks = [];
                self.student_marks.push({
                    id:0,
                    marks:'',
                    roll_no:'',
                    name:'',
                    std_id:'',
                    father_name:''
                });
                
                self.max_marks = '';
                self.min_marks = '';
                this.saving = false;
                self.showpaper = false;
                self.showMarks = false;
                this.error ={};
            },
            addMarks:function(index){
                var self = this;
                var student = this.student_marks[index];
                if(student.marks.trim() === '' || student.std_id =='') {
                    return;
                }
                if(parseInt(student.marks) > parseInt(this.max_marks)){
                    $.blockUI({ message: '<h4>Obtained marks can not be greater than maximum Marks...</h4>' });
                    setTimeout(function(){
                        self.student_marks[index].marks = '';
                        $.unblockUI();
                    },1500);
                    return;
                }
                var data = $.extend({}, this.$data, { student: student });
                student.saved = false;
                this.$http.post("{{ url('student-marks') }}", data )
                .then(function(response) {
                    this.addNewRow();
                    if(response.data.success){
                        student.id = response.data.marks.id;
                        student.saved = true;
                    }
                },function(response) {
                    if(response.status == 422) {
                        $('body').scrollTop(0);
                        self.errors = response.data;
                        console.log(self.errors)
                        if(self.errors['student.std_id']){
                            if(self.errors['student.std_id'][0].indexOf("taken") >= 0){
                                $.blockUI({ message: '<h4>The student is already in another section...</h4>' });
                                setTimeout(function(){
                                    $.unblockUI();
                                },2000);
                            }
                        }
                        else if(self.errors['invalid_student']){
                            $.blockUI({ message: '<h4>Roll Number does not belongs to selected course...</h4>' });
                            setTimeout(function(){
                                $.unblockUI();
                            },2000);
                        }
                    }    
                });
            },
            absentEntry:function(index,student){
                this.student_marks[index].status == 'A' ?  this.student_marks[index].marks = "0" :'';
                this.addMarks(index);
            },
            changedPaperType:function(){
                var self = this;
                this.$http.post("{{ url('student-marks/paper-data') }}", this.$data )
                .then(function(response) {
                    this.addNewRow();
                    if(response.data.success){
                        if(response.data.paper) {
                            var paper = response.data.paper;
                            self.min_marks = paper.min_marks;
                            self.max_marks = paper.max_marks;
                            self.paper_code = paper.paper_code;
                        } else {
                            self.min_marks = '';
                            self.max_marks = '';
                            self.paper_code = '';
                        }
                    }
                });
            }
        }
    });
  </script>
@stop