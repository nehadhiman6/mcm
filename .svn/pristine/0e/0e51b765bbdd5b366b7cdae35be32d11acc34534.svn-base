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
                </div> 
                {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
                    {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse','v-model'=>'course_id',':disabled'=>'saving','@change' => 'getSubjectsList']) !!}
                    <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
                </div>
                {!! Form::label('semester', 'Semester', ['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['semester'] }">
                    <select class='form-control' id='semester' v-model='semester'  :disabled ='saving'>
                        <option v-for="sem in semesters" :value="sem.id">@{{ sem.sem }}</option>
                    </select>
                    <span id="basic-msg" v-if="errors['semester']" class="help-block" >@{{ errors['semester'][0] }}</span>
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
        </div>
        <div class="panel-body">
            <table class="table table-bordered" id="classWise">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Roll. No.</th>
                        <th>Name</th>
                        <th>Result</th>
                        {{-- <th v-for ="data in tdetails"><span v-if="data.paper_code">@{{ data.subject.uni_code}}</span><span v-else="data.subject">@{{ data.subject.subject}}</span></th> --}}
                        <th v-for ="data in tdetails">@{{ data.subject.uni_code}}</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in tstudents">
                        <td>@{{ $index+1}}</td>
                        <td>@{{ data.roll_no}}</td>
                        <td>@{{ data.name }}</td>
                        <td>@{{getMarksResult(data.marks_details)}}</td>
                        <td v-for="det in tdetails">
                            <span v-for="mark in data.marks_details">
                                <span v-if="det.id == mark.exam_det_id">
                                    <span v-if = "det.have_sub_papers == 'N'">
                                    @{{ mark.marks}}
                                    </span>
                                    <span v-else>
                                        @{{ getTotalMarks(mark.sub_papers_marks) }}
                                    </span>
                                </span>
                            </span>
                        </td>
                    </tr>
                </tbody>
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
            student_marks:[],
            semester: '',
            subjects:[],
            semesters:[],
            errors:{},
            table:null,
            tData:[],
            tstudents:[],
            tdetails:[],
            table:null
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

        },
        computed:{
            showErrors:function(){
                if(Object.keys(this.errors).length == 0){
                    return false;
                }
                return true;
            }
        },
        methods: {
            getTotalMarks:function(sub_papers_marks){
                if(sub_papers_marks.length > 0){
                    var marks = 0;
                    sub_papers_marks.forEach(element => {
                       marks += parseFloat(element.marks);
                    });
                    return marks;
                }
            },
            getMarksResult:function(details){
                var result = "";
                details.forEach((element,ind)=> {
                    if(element.examdetail.have_sub_papers == 'N'){
                        if(parseFloat(element.examdetail.min_marks) > parseFloat(element.marks)){
                            result != "" ? result += ',':''
                            result +=  element.examdetail.subject.uni_code;
                        }
                    }
                    else if(element.examdetail.have_sub_papers == 'Y'){
                        var marks = 0;
                        if(element.sub_papers_marks && element.sub_papers_marks.length > 0){
                            element.sub_papers_marks.forEach((ele,index)=>{
                                marks += parseFloat(ele.marks);
                                console.log(ele);
                            });
                            if(marks < element.examdetail.min_marks){
                                result != "" ? result += ',':''
                                result += ' ' +element.examdetail.subject.uni_code;
                            }
                        }
                    }
                   
                });
                if(result  == ""){
                    result = "PASS";
                }
                return "[" + result + "]";
            },
            getPassResult:function(details){
                var result = "PASS";
                details.forEach(element => {
                    if(parseFloat(element.examdetail.min_marks) > parseFloat(element.marks)){
                        result = "";
                    }
                });
                return result;
               
            },
            getSubjectsList: function() {
                if(this.course_id != 0 && this.course_id != this.selected_course_id) {
                    this.$http.get("{{ url('courses') }}/"+this.course_id+"/subjects_list_course")
                    .then(function(response) {
                        this.selected_course_id = this.course_id ;
                        var courseYear = response.data.course.course_year;
                        this.semesters = [];
                        this.semesters = [{'id' : courseYear+(courseYear - 1), 'sem': this.getSemesterName(courseYear+(courseYear - 1))},
                                          {'id' : courseYear+(courseYear-1) +1, 'sem': this.getSemesterName(courseYear+(courseYear-1) +1)}]
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
            resetData:function(){
                var self = this;
                window.location.href = "{{ url('marks-report/classwise')}}";
                // this.course_id=0;
                // this.subject_id=0;
                // this.section_id=0;
                // this.exam_name='';
                // this.student_marks=[];
                // this.semester= '';
                // this.subjects=[];
                // this.semesters=[];
                // this.error ={};
                // $('.selectCourse').val(0).trigger('change');
                // $('.subjectSelect').val(0).trigger('change');
                // self.table.dataTable().fnDestroy();
            },
            showRecord:function(){
                var self= this;
                this.$http.post("{{ url('marks-report') }}/classwise",this.$data)
                    .then(function(response) {
                        self.tdetails = response.data.details;
                        self.tData = response.data.marks;
                        self.tstudents= response.data.students;
                        setTimeout(function(){
                            self.table = $('#classWise').dataTable({dom : 'Bfrtip',"pageLength": 50,buttons: [
                                    'copy', 'csv', 'excel', 'pdf', 'print'
                            ]});
                        },1000);
                    }, function(response) {
                        if(response.status == 422) {
                            $('body').scrollTop(0);
                            self.errors = response.data;
                        }  
                });
            }
        }
    });
  </script>
@stop