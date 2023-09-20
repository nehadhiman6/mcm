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
        @include('subject_section._form')
    </div>
@stop

@section('script')
    <script>
        function getNewSubjectSection(){
            return {
                course_id:0,
                subject_id:0,
                section_id:0,
                teacher_id:0,
                students:0,
                has_sub_subjects:'N',
                sub_sec_details:[],
                
            }
        } 
        var vm = new Vue({
        el: '#app',
        data: {
            subject_section:{
                id:0,
                course_id:0,
                subject_id:0,
                section_id:0,
                teacher_id:0,
                students:0,
                has_sub_subjects:'N',
                sub_sec_details:[]
            },
            sub_subject_teachers:{
                id:0,
                sub_sec_id:0,
                teacher_id:0, 
                sub_subject_name:'',
                is_practical:'N'
            },
            addSection:false,
            showAdd:false,
            selected_course_id: 0,
            subjects: [],
            errors: {},
            subjectSectionsList:[],
            sections: {!! getSections(true) !!},
            showLists: false,
            showSubSubjectForm: false,
            ss: {},
            success:false,
            testCourses:{!! json_encode(getTeacherCourses()) !!},
            teachers:{!! json_encode(getTeachers(true)) !!},

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
            $('.selectCourse').select2({
                placeholder: 'Select Course',
                width:'100%',
            });
            $('.selectCourse').on('change',function(){
                self.subject_section.course_id = $(this).val();
                self.subject_section.subject_id = 0;
                $('.subjectSelect').val(0).trigger('change');
                self.getSubjectsList();
            });


            $('.subjectSelect').select2({
                placeholder: 'Select an option',
                width:'100%',
            });
            $('.subjectSelect').on('change',function(){
                self.subject_section.subject_id = $(this).val();
            });

            $('.select-teacher').select2({
                width:'100%',
                placeholder: 'Select an option'
            });
            $('.select-teacher').on('change',function(){
                self.subject_section.teacher_id = $(this).val();
            });

            $('.select-teacher1').select2({
                width:'100%',
                placeholder: 'Select an option'
            });
            $('.select-teacher1').on('change',function(){
                self.sub_subject_teachers.teacher_id = $(this).val();
            });
            
        },
        methods: {
            getSubjectsList: function() {
                if(this.subject_section.course_id != 0 && this.subject_section.course_id != this.selected_course_id) {
                    this.$http.get("{{ url('courses') }}/"+this.subject_section.course_id+"/subjects_list_course")
                    .then(function(response) {
                        this.subjects = response.data.subjects;
                        this.selected_course_id = this.subject_section.course_id ;
                        var courseYear = response.data.course.course_year;
                    }, function(response) {
                    });
                }
            },
            saveTeacher:function(){
                var self = this;
                this.errors = {};
                this.$http.post('subject-section',{'subject_section':self.subject_section})
                .then(function(response){
                    if(response.data.success && response.data.subject_sections){
                        self.subject_section = response.data.subject_section;
                        self.subjectSectionsList = response.data.subject_sections;
                        self.success = true;
                        setTimeout(function(){
                            self.success = false;
                            self.addSection = false;
                        }, 1000);
                    }
                },
                function(response) {
                    if(response.status == 422) {
                        $('body').scrollTop(0);
                        self.errors = response.data;
                    }    
                })
            },
          
            checkRecord:function(){
                var self = this;
                this.$http.post("{{ url('subject-section/section') }}", this.$data )
                .then(function(response){
                    if(response.data.success && response.data){
                        console.log(response.data);
                        if(response.data.subject_section){
                            self.subject_section = response.data.subject_section;
                            if(self.subject_section.has_sub_subjects == "N"){
                                // self.showDetails = true;
                                if(self.subject_section.teacher_id > 0){
                                    $('.select-teacher').val(self.subject_section.teacher_id).trigger('change');
                                    self.showSubSubjectForm = false;
                                }
                            }
                            else{
                                self.showSubSubjectForm = true;
                                // self.savedTeacher = false;
                                self.sub_subject_teachers.sub_sec_id = response.data.subject_section.id;
                            }
                            // self.disableSubSec = true;
                        }
                    }
                },
                function(response) {
                    if(response.status == 422) {
                        $('body').scrollTop(0);
                        self.errors = response.data;
                    }    
                });
            },

            addSubSubject: function(ss) {
                this.ss = $.extend({}, ss);
                this.sub_subject_teachers = {
                    id:0,
                    sub_sec_id:ss.id,
                    teacher_id:0, 
                    sub_subject_name:'',
                    is_practical:'N'
                };
                this.subject_section = $.extend({}, ss);
                this.showSubSubjectForm = true;
            },

            saveSubSubject:function(){
                var self = this;
                this.$http.post("{{ url('subject-section/sub-subject') }}", this.sub_subject_teachers )
                .then(function(response){
                    if(response.data.success && response.data.subject_section){
                        self.subject_section = response.data.subject_section;
                        self.sub_subject_teachers.sub_sec_id=0;
                        self.sub_subject_teachers.sub_subject_name='';
                        self.sub_subject_teachers.teacher_id=0;
                        self.sub_subject_teachers.id = 0;
                        self.sub_subject_teachers.is_practical='N';
                        self.success = true;
                        setTimeout(function(){
                            self.success = false;
                            self.showSubSubjectForm = false;
                        }, 1000);
                    }
                },
                function(response) {
                    if(response.status == 422) {
                        $('body').scrollTop(0);
                        self.errors = response.data;
                    }    
                });
            },

            resetData:function(){
                var self = this;
                // self.showDetails = false;
                // self.disableSubSec = false;
                // self.savedTeacher = false;
                self.showSubSubjectForm= false;
                self.subject_section = getNewSubjectSection();
                self.subject_section.course_id = 0;
                self.sub_subject_teachers.sub_sec_id = 0;
                self.subjectSectionsList =[];
                self.addSection = false;
                self.errors = {};
                self.showAdd = false;
                self.showLists = false;
                self.resetSubSubject();
                $('.subjectSelect').val(0).trigger('change');
                $('.select-teacher').val(0).trigger('change');
                $('.select-teacher1').val(0).trigger('change');
                $('.selectCourse').val(0).trigger('change');
                this.subjects=[];
                this.selected_course_id = 0 ;
            },

            editSubSubject:function(id){
                var self = this;
                this.showSubSubjectForm = true;
                this.ss = self.subject_section;
                self.subject_section.sub_sec_details.forEach(function(ele){
                    if(ele.id == id){
                        self.sub_subject_teachers.id = ele.id;
                        self.sub_subject_teachers.sub_sec_id = ele.sub_sec_id;
                        self.sub_subject_teachers.sub_subject_name = ele.sub_subject_name;
                        self.sub_subject_teachers.is_practical = ele.is_practical;
                        self.sub_subject_teachers.teacher_id = ele.teacher_id;
                        $('.select-teacher1').val(ele.teacher_id).trigger('change');
                    }
                });
            },

            resetSubSubject:function(){
                this.ss = {};
                this.sub_subject_teachers = {
                    id:0,
                    sub_sec_id:0,
                    teacher_id:0, 
                    sub_subject_name:'',
                    is_practical:'N'
                };
                this.showSubSubjectForm = false;
                console.log(this.showSubSubjectForm);
            },

            showSubjectSections:function(){
                var self =this;
                this.$http.post("{{ url('subject-section/show') }}", { 'course_id':self.subject_section.course_id, 'subject_id':self.subject_section.subject_id})
                .then(function(response){
                    if(response.data && response.data.subject_sections) {
                        self.subjectSectionsList =response.data.subject_sections;
                        // self.disableSubSec = true;
                    }
                    else{
                        self.addNewSection();
                    }
                    self.showAdd = true;
                    self.showLists = true;
                })

            },

            addNewSection:function(){
                // this.disableSubSec = false;
                $('.select-teacher').val(0).trigger('change');
                this.subject_section.id = 0;
                this.subject_section.section_id = 0;
                this.addSection = true;
            },

            editSubjectTeacher:function(subjectSection){
                this.errors = {};
                this.addSection = true;
                this.subject_section = $.extend({}, subjectSection);
                console.log(this.subject_section);
                if(this.subject_section.teacher_id > 0 ){
                    $('.select-teacher').val(this.subject_section.teacher_id ).trigger('change');
                }
                this.ss = $.extend({}, subjectSection);
                // this.showDetails = true;
                // this.savedTeacher = true;
            },

            changeHasSubSubject:function(){
                if(this.subject_section.has_sub_subjects == 'Y'){
                    this.subject_section.teacher_id = 0;
                }
            }
        }
    });
  </script>
@stop