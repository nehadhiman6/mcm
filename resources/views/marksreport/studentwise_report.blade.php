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
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
                    {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse','v-model'=>'course_id',':disabled'=>'saving','@change' => 'getSubjectsList']) !!}
                    <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
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
            <div class="form-group" >
                {!! Form::label('roll_no','Roll no',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
                    {!! Form::text('roll_no',0,['class' => 'form-control','v-model'=>'roll_no']) !!}
                    <span id="basic-msg" v-if="errors['roll_no']" class="help-block">@{{ errors['roll_no'][0] }}</span>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <div class="col-sm-3 pull-right" >
                        {!! Form::submit('Show Marks',['class' => 'btn btn-primary','@click.prevent'=>'showRecord()']) !!}
                        {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()']) !!}
                        
                </div>
            </div>
        </div>
        {!! Form::close() !!}
      </div>
      <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Successfully Saved!</strong> 
      </div>
      
      <div class="panel panel-default">
        <div class="panel-heading">
          Students Marks 
          <div style="text-align:center;font-size: 16px;"><div class="row"><div class="col-sm-6"><b>Student Name:  @{{name}}</div><div class="col-sm-6"> College Roll No. : @{{roll_no}}</b></div></div></div>
        </div>
        <div class="panel-body">
            <table class="table table-bordered" id="studentWise">
                <thead>
                    <tr>
                        <th colspan="2">Student Name:  @{{name}}</th>
                        <th colspan="3">College Roll No. : @{{roll_no}}</th>
                    </tr>
                    <tr>
                      <th>Subject</th>
                      <th>Passing Marks</th>
                      <th>Maximum Marks</th>
                      <th>Status</th>
                      <th>Obtained Marks</th>
                    </tr>
                </thead>
                <tbody>
                   <tr v-for ="detail in tdetails">
                      <td>@{{ detail.uni_code}}</td>
                      <td>@{{detail.min_marks}}</td>
                      <td>@{{detail.max_marks}}</td>
                      <td>@{{detail.status == 'P' ? 'Present' : detail.status == 'A' ? 'Absent' : ''}}</td>
                      <td>@{{getMarks(detail.id)}}</td>
                   </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td ></td>
                        <td></td>
                        <td></td>
                        <td><b>Result</b></td>
                        <td><span v-if ="tstudent[0]"><b>@{{ getPassResult(tstudent[0].marks_details,tdetails)}}</b></span></td>
                        <td style="display: none;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
      </div>
  </div>
@stop

@section('script')
    <script>
        var vm = new Vue({
        el: '#app',
        data: {
            course_id:0,
            exam_name:'',
            semester: '',
            roll_no:'',
            semesters:[],
            errors:{},
            name:'',
            table:null,
            tdetails :[],
            tstudent :[],
            course_name:''
        },
        computed:{
            showErrors:function(){
                if(Object.keys(this.errors).length == 0){
                    return false;
                }
                return true;
            }
        },
        created:function(){
            var self = this;
            $('.selectCourse').select2({
                placeholder: 'Select Course',
                width:'100%'
            });
            $('.selectCourse').on('change',function(){
                self.course_id = $(this).val();
                self.getSubjectsList();
            });
            $('.selectCourse').on('select2:select', function (e) {
                var data = e.params.data;
                self.course_name = data.text;
            });
        },

        methods: {
            getMarks:function(id){
                var self = this;
                var marks = 0;
                self.tstudent[0].marks_details.forEach(function(element){
                    if(element.id == id){
                        if(element.examdetail.have_sub_papers == 'Y'){
                            if(element.sub_papers_marks.length > 0){
                                element.sub_papers_marks.forEach(function(ele){
                                    marks += parseFloat(ele.marks);
                                });
                            }
                        }   
                        else{
                            marks = element.marks;
                        }
                    }
                });
                return marks;
            },

            getPassResult:function(marks_detail,detail){
                var result = "";
                console.log(detail);
                marks_detail.forEach((element,index)=> {
                    detail.forEach((ele,key)=>{
                        if(element.id == ele.id){
                            var min_marks = ele.min_marks;
                            if(ele.have_sub_papers == 'Y'){
                                if(element.sub_papers_marks.length > 0){
                                    var marks = 0;
                                    element.sub_papers_marks.forEach(function(ele){
                                        marks += ele.marks;
                                    });
                                    if(parseFloat(min_marks) > parseFloat(marks)){
                                        result != ""? result +=', ':'';
                                        result +=  ele.uni_code;
                                    }
                                }
                            }
                            else{
                                if(parseFloat(min_marks) > parseFloat(element.marks)){
                                    result != ""? result +=', ':'';
                                    result +=  ele.uni_code;
                                }
                            }
                        }
                        
                    })
                    
                });
                result == "" ? result = "PASS":'';
                return "[" + result + "]";
               
            },
            // getPassResult:function(marks_detail,detail){
            //     var result = "";
            //     console.log(marks_detail);
            //     marks_detail.forEach((element,index)=> {
            //         var min_marks = element.examdetail.min_marks;
            //         if(element.examdetail.have_sub_papers == 'Y'){
            //             if(element.sub_papers_marks.length > 0){
            //                 var marks = 0;
            //                 element.sub_papers_marks.forEach(function(ele){
            //                     marks += ele.marks;
            //                 });
            //                 if(parseFloat(min_marks) > parseFloat(marks)){
            //                     result != ""? result +=', ':'';
            //                     result +=  element.examdetail.subject.uni_code;
            //                 }
            //             }
            //         }
            //         else{
            //             if(parseFloat(min_marks) > parseFloat(element.marks)){
            //                 result != ""? result +=', ':'';
            //                 result +=  element.examdetail.subject.uni_code;
            //             }
            //         }
            //     });
            //     result == "" ? result = "PASS":'';
            //     return "[" + result + "]";
               
            // },
            getSubjectsList: function() {
                if(this.course_id != 0 && this.course_id != this.selected_course_id) {
                    this.$http.get("{{ url('courses') }}/"+this.course_id+"/subjects_list_course")
                    .then(function(response) {
                        this.subjects = response.data.subjects;
                        this.selected_course_id = this.course_id ;
                        var courseYear = response.data.course.course_year;
                        this.semesters = [];
                        this.semesters = [{'id' : courseYear + (courseYear - 1), 'sem': this.getSemesterName(courseYear+(courseYear - 1))},
                                          {'id' : courseYear + (courseYear-1) +1, 'sem': this.getSemesterName(courseYear+(courseYear-1) +1)}]
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
            examName:function(exam){
                var self =this;
                if(exam == 'mst_1'){
                    return 'MST ODD';
                }
                else if(exam == 'mst_2'){
                    return 'MST EVEN';
                }
                else if(exam == 'ia_1'){
                    return 'IA ODD';
                }
                else if(exam == 'ia_2'){
                    return 'IA EVEN';
                }
                
            },
            resetData:function(){
                var self = this;
                window.location.href = "{{ url('marks-report/student')}}";
                // this.course_id=0;
                // this.exam_name='';
                // this.semester= '';
                // this.semesters=[];
                // this.name = '';
                // this.roll_no = '';
                // this.tstudent = [];
                // this.tdetails = [];
                // this.error ={};
                // this.table = null;
                // $('.selectCourse').val(0).trigger('change');
                // $('.subjectSelect').val(0).trigger('change');
                // $("#studentWise").dataTable().fnDestroy()
           
            },
            showRecord:function(){
                var self= this;
                this.$http.post("{{ url('marks-report') }}/student",this.$data)
                    .then(function(response) {
                        if(response.data.student == 'invalid'){
                            $.blockUI({ message: '<h3>Roll Number does not belong to this course...</h3>' });
                            setTimeout($.unblockUI, 2000); 
                            self.roll_no = '';
                            self.name = '';
                            return;
                        }
                        if(response.data.student.length == 0){
                            $.blockUI({ message: '<h3>No marks Entry for this Roll Number...</h3>' });
                            setTimeout($.unblockUI, 2000); 
                            self.roll_no = '';
                            self.name = '';
                            self.tdetails = [];
                            return;
                        }
                      
                        // self.tdetails = response.data.details;
                        self.tstudent = response.data.student;
                        self.name = self.tstudent[0].name;
                        // setTimeout(function(){
                        //     self.table = $('#studentWise').dataTable({dom : 'Bfrtip',"pageLength": 30,buttons: [
                        //         { extend: 'copyHtml5', footer: true ,sfilename: function() {  return self.name; } },
                        //         { extend: 'excel', filename: function() {  return self.name; },footer: true },
                        //         { extend: 'csvHtml5', filename: function() {  return self.name; }, footer: true },
                        //         { extend: 'pdfHtml5',  text: 'To PDF',
                        //             download: 'open',
                        //             title: 'Examination ('+self.examName(self.exam_name)+') / Class ('+self.course_name+') / Semester ('+self.semester+') / Student Name ('+self.name+') / Roll No ('+self.roll_no+')',
                        //             customize: function ( pdf, btn, tbl ) {
                        //             delete pdf.styles.tableBodyOdd.fillColor;
                        //             },
                        //         },
                        //         { extend: 'print', filename: function() {  return self.name; },  footer:true},
                                
                        //     ]});
                        // },500);
                        self.tdetails = [];
                        var row = {};
                        // response.data.details.forEach(function(e){
                        self.tstudent.forEach(function(ele){
                            row = {
                                'uni_code': ele.uni_code ,
                                'min_marks': ele.min_marks ,
                                'max_marks': ele.max_marks ,
                                'marks': '',
                                'status': ele.status,
                                'id': ele.marks_id,
                                'exam_det_id': ele.exam_det_id,
                                'have_sub_papers': ele.have_sub_papers,
                            };
                            self.tdetails.push(row);        
                        });
                        // setTimeout(function(){
                        
                    }, function(response) {
                        console.log(response);
                        if(response.status == 422) {
                            $('body').scrollTop(0);
                            self.errors = response.data;
                        }  
                }).then(function(){
                    self.setDatatable();
                });
            },

            setDatatable: function(){
                var self = this;
                self.table = $('#studentWise').dataTable(
                        {dom : 'Bfrtip',
                        "pageLength": 30,
                        buttons: 
                        [
                            {   extend: 'copyHtml5', 
                                footer: true ,
                                sfilename: function() {  return self.name; } 
                            },
                            {   extend: 'excel',
                                filename: function() {  return self.name; },
                                footer: true 
                            },
                            {   extend: 'csvHtml5', 
                                filename: function() {  return self.name; }, 
                                footer: true 
                            },
                            {   extend: 'pdfHtml5',  
                                // text: 'To PDF',
                                download: 'open',
                                title: 'Examination - '+self.examName(self.exam_name)+'  Semester - '+self.semester+  ' Class - '+self.course_name+'                                        Student Name - '+self.name+'  Roll No - '+self.roll_no,
                               
                                customize: function ( pdf, btn, tbl ) {
                                delete pdf.styles.tableBodyOdd.fillColor;
                                },
                                footer: true
                            },
                            { extend: 'print', filename: function() {  return self.name; },  footer:true},
                        ]
                    }
                );
            }
        }
    });
  </script>
@stop