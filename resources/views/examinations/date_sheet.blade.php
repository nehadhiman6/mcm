@extends('app')

@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='datesheet' v-cloak>
    @can('date-sheet-modify')
        <div class="box box-default box-solid" >
            <div class="box-header with-border">
                <h3 class="box-title" v-if="date_sheet.id">Edit Date Sheet</h3>
                <h3 class="box-title" v-else>Add Date Sheet</h3>
                <div class="box-tools pull-right">
                    <button style="margin-top: -40px;" type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {!! Form::label('date','Date',['class' => 'col-sm-1 control-label required']) !!}
                    <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['date'] }">
                        {!! Form::text('date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.date']) !!}
                        <span id="basic-msg" v-if="errors['date']" class="help-block">@{{ errors['date'][0] }}</span>
                    </div>
                    {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
                        {!! Form::select('course_id',getCourses(),0,['class' => 'form-control selectCourse','v-model'=>'form.course_id']) !!}
                        <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
                    </div>
                    {!! Form::label('subject_id','Subject',['class' => 'col-sm-1 control-label required']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['subject_id'] }">
                        <select class='form-control subjectSelect' id='subject_id' v-model='form.subject_id'  >
                            <option v-for="sub in subjects | orderBy 'subject'" :value="sub.id">@{{ sub.subject }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['subject_id']" class="help-block">@{{ errors['subject_id'][0] }}</span>
                    </div>                
                </div>
                <div class="form-group">
                    {!! Form::label('session','Session',['class' => 'col-sm-1 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::select('session',getSessions(),null,['class' => 'form-control', 'v-model' => 'form.session']) !!}
                        <span id="basic-msg" v-if="errors['session']" class="help-block">@{{ errors['session'][0] }}</span>
                    </div>
                    {!! Form::label('exam_name','Examination',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-3">
                        {!! Form::select('exam_name', getExaminations(), null, ['class' => 'form-control', 'v-model' => 'form.exam_name']) !!}
                        <span id="basic-msg" v-if="errors['exam_name']" class="help-block">@{{ errors['exam_name'][0] }}</span>
                    </div>
                </div>
                <div class="box-footer">
                    <div v-if="date_sheet.id">
                        {!! Form::submit('Update',['class' => 'btn btn-primary','@click.prevent'=>'saveData()']) !!}
                    </div>
                    <div v-else>
                        {!! Form::submit('Save',['class' => 'btn btn-primary','@click.prevent'=>'saveData()']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <div class="box">
        <div class="box-header with-border">
            Date Sheet List
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="date-sheet" class="table table-bordered" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script>
        var datesheet = new Vue({
            el:"#datesheet",
            data: {
                form:{
                    id:0,
                    date:'',
                    course_subject_id:'',
                    subject_id:0,
                    course_id:0,
                    session:'',
                    exam_name:'',
                },
                selected_course_id:0,
                subjects:[],
                table:null,
                errors: {},
                date_sheet:{!! $date_sheet or "0" !!},
                sessions:{!! json_encode(getSessions(true)) !!},
                exams:{!! json_encode(getExaminations(true)) !!},
                permissions: {!! json_encode(getPermissions()) !!},
            },
            created: function(){
                var self = this;
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
                    width:'100%',
                    placeholder: 'Select Subject'
                });
                $('.subjectSelect').on('change',function(){
                    self.form.subject_id = $(this).val();
                });
                this.setTable();
                if(this.date_sheet.id){
                    this.setdata();
                }
            },
            methods: {                
                getSubjectsList: function() {
                    var self = this;
                    if(this.form.course_id != 0 && this.form.course_id != this.selected_course_id) {
                        this.$http.get("{{ url('courses') }}/"+this.form.course_id+"/subjects_list_course")
                        .then(function(response) {
                            this.subjects = response.data.subjects;
                            this.selected_course_id = this.form.course_id ;
                            setTimeout(() => {
                                if(self.date_sheet.id){
                                $('.subjectSelect').val(this.date_sheet.subject_id).trigger('change');
                            }
                            }, 800);
                        }, function(response) {
                        });
                    }
                },

                saveData:function(){
                    var self =this;
                    this.$http.post("{{ url('date-sheets') }}", this.$data.form )
                    .then(function(response){
                        if(response.status == 200){
                            window.location.href = MCM.base_url+'/date-sheets';
                        }
                    })
                    .catch(function(error){
                        if(error.status == 422) {
                            $('body').scrollTop(0);
                            self.errors = error.data;
                        }   
                    });
                },

                setTable:function(){
                    var self= this;
                    var target = 0;
                    self.table = $('#date-sheet').DataTable({
                        ordering:        true,
                        scrollY:        "300px",
                        scrollX:        true,
                        scrollCollapse: true,
                        pageLength:    "10",
                        paging:         false,
                        fixedColumns:   {
                            rightColumns: 1,
                            leftColumns: 0
                        },
                        "ajax": {
                            "url": MCM.base_url+'/date-sheets',
                            "type": "GET",
                        },
                        "scrollX": true,
                        buttons: ['pdf'],
                        columnDefs: [
                            { title: '#',width:50, targets: target++, data: 'id',
                                "render": function( data, type, row, meta) {
                                    // var index = meta.row + parseInt(meta.settings.json.start);
                                    return meta.row +1;
                                }
                            },
                            { title: 'Date', targets:target++,data:'date'
                            },
                            { title: 'Course', targets:target++,
                                "render":function(data, type, row, meta){
                                    return  course = row.course ? row.course.course_name : '' ;
                                }
                            },
                            { title: 'Subject', targets:target++,
                                "render":function(data, type, row, meta){
                                    return subject = row.subject ? row.subject.subject : '' ;
                                }
                            },
                            { title: 'Session', targets:target++,data:'session',
                                "render":function(data, type, row, meta){
                                    var str = '';
                                    $.each(self.sessions,function(key ,val){
                                        if(data == key){
                                            str+= val;
                                        }
                                    });
                                    return str;
                                }
                            },
                            { title: 'Exam Name', targets:target++,data:'exam_name',
                                "render":function(data, type, row, meta){
                                    var str = '';
                                    $.each(self.exams,function(key ,val){
                                        if(data == key){
                                            str+= val;
                                        }
                                    });
                                    return str;
                                }
                            },
                            { visible: self.checkPermission(), title: 'Action', targets:target++, data: 'id',
                                "render":function(data, type, row, meta){
                                    var str = '';
                                    if(self.permissions['seat-plan-button']){
                                        str += "<a href='"+MCM.base_url+"/seating-plan/"+row.id+"' class='btn btn-primary mr-1'>Seating Plan</a>";
                                    }
                                    if(self.permissions['date-sheet-modify']){
                                        str+= "<a href='"+MCM.base_url+"/date-sheets/"+row.id+"/edit' class='btn btn-primary'>Edit</a>";
                                    }
                                    return str;
                                }
                            }
                        ],
                        // "sScrollX": true,
                    });
                },
                checkPermission:function(){
                    if(this.permissions['date-sheet-modify'] == 'date-sheet-modify'){
                        return true;
                    }
                    else if(this.permissions['seat-plan-button'] == 'seat-plan-button'){
                        return true;
                    }
                    else{
                        return false;
                    }
                },
                setdata:function(){
                    var self =this;
                    $.each(this.date_sheet,function(key ,val){
                        if(self.form.hasOwnProperty(key) == true && typeof(self.form[key])  != 'function' && typeof(self.form[key])  != 'object' ){
                            self.form[key] = val;
                        }
                    });
                    $('.selectCourse').val(this.date_sheet.course_id).trigger('change');
            
                },
                getSession:function(session){
                    $.each(this.sessions,function(key ,val){
                        if(session == key){
                            return val;
                        }
                    });
                    
                },

                getexams:function(exam){
                        $.each(this.exams,function(key ,val){
                            if(exam == key){
                                return val;
                            }
                        });
                }            
            }
        });
    </script>
@stop
