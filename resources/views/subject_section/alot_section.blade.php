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
                       {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
                            {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse','v-model'=>'course_id',':disabled'=>'disableFields','@change' => 'getSubjectsList']) !!}
                            <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
                        </div>
                        {!! Form::label('subject_id','Subject',['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['subject_id'] }">
                            <select class='form-control subjectSelect' id='subject_id' v-model='subject_id'  :disabled ='disableFields'>
                                <option v-for="sub in subjects | orderBy 'subject'" :value="sub.id">@{{ sub.subject }}</option>
                            </select>
                            <span id="basic-msg" v-if="errors['subject_id']" class="help-block">@{{ errors['subject_id'][0] }}</span>
                        </div>
                    </div>
                    <div class="form-group" >
                        {!! Form::label('type','Filter By',['class' => 'col-sm-2 control-label']) !!}
                         <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
                            <select class='form-control' v-model='filter_by'  :disabled ='disableFields' >
                               <option value="all">ALL</option>
                               <option value="pending">Pending</option>
                            </select>
                         </div>
                         {!! Form::label('adm_no','Admission No',['class' => 'col-sm-2 control-label']) !!}
                         <div class="col-sm-3" v-bind:class="{ 'has-error': errors['adm_no'] }">
                            <input type="text" class="form-control" placeholder ="optional" v-model="adm_no">
                         </div>
                     </div>
                    <div class="form-group" >
                        <div class="col-sm-10 text-right">
                            {!! Form::submit('RESET',['class' => 'btn btn-primary mr-1', '@click.prevent'=>'resetFields']) !!}
                            {!! Form::submit('SHOW',['class' => 'btn btn-primary' ,'@click.prevent'=>'getStudentsList']) !!}
                        </div>
                    </div>
                    @can('assign-section-to-all')
                    <div class="form-group"  v-if="students.length > 0 && filter_by =='pending' ">
                        {!! Form::label('assign_to','Assign To',['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
                            <select class='form-control' v-model='assign_to'  :disabled ='disableFields'>
                                {{-- <option value="all">ALL</option> --}}
                                <option value="pending"> All Pending</option>
                            </select>
                            </div>
                            {!! Form::label('section','Section',['class' => 'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                            <select class="form-control" v-model="sub_sec_id">
                                <option v-for="subject_section in subject_sections"  :value="subject_section.id">@{{subject_section.section.section}}</option>
                            </select>
                            </div>
                    </div>
                    <div class="form-group"  v-if="students.length > 0 && filter_by =='pending' ">
                        <div class="col-sm-10 text-right">
                         {!! Form::submit('Assign',['class' => 'btn btn-primary' ,'@click.prevent'=>'assignSections']) !!}
                        </div>
                    </div>
                    @endcan
                </div>
              
                {!! Form::close() !!}
              </div>
                <div class="panel panel-default" v-if="students.length > 0">
                    <div class="panel-heading">
                    Alot Section
                    </div>
                    <div class="panel-body" >
                        <table class="table table-bordered" id ="alotSectionTable">
                            <thead>
                                <th>Sr. no</th>
                                <th>Roll No.</th>
                                <th>Student Name</th>
                                <th>Section</th>
                            </thead>
                            <tbody>
                                <tr v-for="std in students" :key="std.adm_no">
                                    <td><span :class="{ 'fa fa-check': std.show_green }"  style="color:green" ></span> @{{ $index+1 }}</td>
                                    <td>@{{ std.adm_no }}</td>
                                    <td>@{{ std.name }}</td>
                                    <td><select class="form-control" v-model="std.sub_sec_id" @change="setSection(std,$index)">
                                    <option v-for="subject_section in subject_sections"  :value="subject_section.id">@{{subject_section.section.section}}</option>
                                    </select></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
            subject_id:0,
            students:[],
            errors: {},
            adm_no:'',
            assign_to:'pending',
            sub_sec_id:'',
            success:false,
            filter_by:'all',
            subjects:[],
            selected_course_id:'',
            subject_sections:[],
            show:true,
            table :null,
            disableFields:false
        },
        computed:{
            showErrors:function(){
                if( Object.keys(this.errors).length == 0){
                    return false;
                }
                return true;
            }
        },
        ready:function(){
            var self = this;
            $('.subjectSelect').select2({
                width:'100%',
                placeholder: 'Select Subject'
            });
            $('.subjectSelect').on('change',function(){
                self.subject_id = $(this).val();
            });

            $('.selectCourse').select2({
                placeholder: 'Select Course',
                width:'100%'
            });
            $('.selectCourse').on('change',function(){
                self.course_id = $(this).val();
                self.subject_id = 0;
                $('.subjectSelect').val(0).trigger('change');
                self.getSubjectsList();
            });

        },
        methods: {
            getSubjectsList: function() {
                if(this.course_id != 0 && this.course_id != this.selected_course_id) {
                    this.$http.get("{{ url('courses') }}/"+this.course_id+"/subjects_list_course")
                    .then(function(response) {
                        this.subjects = response.data.subjects;
                      
                        this.selected_course_id = this.course_id ;
                    }, function(response) {
                    });
                }
            },
            getStudentsList:function(){
                var self = this;
                this.$http.post("{{ url('allot-section/subject-section') }}",{'course_id':this.course_id,'subject_id':this.subject_id,'filter_by':this.filter_by})
                .then(function(response){
                    self.subject_sections = response.data.subject_sections;
                    var students = response.data.students;
                    students.forEach(element => {
                        element.std_id = element.id;
                        element.saved = false;
                        element.show_green = false;
                        // element.sub_sec_id = 0;
                    });
                    self.students = students;
                    setTimeout(function(){
                        if(self.table != null){
                            self.table.destroy();
                        }
                        self.disableFields = true;
                        self.table = $('#alotSectionTable').DataTable();
                    },100);
                })
                .catch(function(response){
                    console.log(response);
                })
            },
            setSection:function(student,index){
                var self = this;
                this.$http.post("{{ url('allot-section') }}",{'student':student,'course_id':this.course_id,'subject_id':this.subject_id,'assign_to':'one'})
                .then(function(response){
                    // if(response.data.success) {
                        self.students[index].saved = true;
                        self.students[index].show_green = true;
                        $.blockUI({ message: '<h2 style="color:green;">Success!!</h2>' });
                        setTimeout($.unblockUI, 200); 
                        setTimeout(function(){
                            self.students[index].show_green = false;
                        }, 2000);
                    // }
                })
                .catch(function(response){
                    console.log(response);
                });
            },
            resetFields:function(){
                this.students = [];
                this.course_id= 0;
                this.subject_id= 0;
                this.adm_no= '';
                this.assign_to= 'pending';
                this.sub_sec_id= '';
                this.filter_by= 'all';
                this.subjects= [];
                this.selected_course_id= '';
                this.subject_sections= [];
                this.disableFields = false;
                $('.subjectSelect').val(0).trigger('change');
                $('.selectCourse').val(0).trigger('change');
            },
            
            assignSections:function(){
                var self= this;
                this.$http.post("{{ url('allot-section') }}",{'students':this.students,'course_id':this.course_id,
                    'subject_id':this.subject_id,'sub_sec_id':this.sub_sec_id,'assign_to':this.assign_to})
                .then(function(response){
                    self.show = false;
                    setTimeout(function(){
                        self.show = true;
                        $.blockUI({ message: '<h2 style="color:green;">Success!!</h2><h3>Selected section has been assigned to all students</h3>' });
                            setTimeout($.unblockUI, 4000); 
                            self.resetFields();
                    },100);
                })
                .catch(function(response){
                    console.log(response);
                });
            }
        }
    });
  </script>
@stop
