@extends('app')

@section('toolbar')
    @include('toolbars._message_toolbar')
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
            E-mail to students
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
        <div class="box-body">
            <div class="form-group" >
                {!! Form::label('course_type','Course Type',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-3">
                    {!! Form::select('course_type',[''=>'Select','GRAD'=>'UG','PGRAD'=>'PG'],null,['class' => 'form-control','v-model'=>'course_type']) !!}
                </div>
                {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-3">
                    <select class="form-control" v-model="course_id" >
                        <option v-for="course in getCourses" :value="course.id">@{{ course.course_name }}</option>
                    </select>
                </div>
              
            </div>

            {{-- <div class="form-group" >
                {!! Form::label('status', 'Status', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                    <select class="form-control select-form" v-model="status">
                        <option value="P">Pass</option>
                        <option value="O">Other</option>
                        <option value="A">All</option>
                    </select>
                    <span v-if="hasError('status')" class="text-danger" v-html="errors['status'][0]" ></span>
                </div>
            </div>

            <div class="form-group" >
                {!! Form::label('mail_sent', 'Mail Sent', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                    <select class="form-control select-form" v-model="mail_sent">
                        <option value="S">Sent</option>
                        <option value="P">pending</option>
                        <option value="A">All</option>
                    </select>
                    <span v-if="hasError('mail_sent')" class="text-danger" v-html="errors['mail_sent'][0]" ></span>
                </div>
            </div> --}}
            
            <div class="form-group col-sm-12">
                <div class="col-sm-3 pull-right" >
                    {!! Form::submit('Show',['class' => 'btn btn-primary','@click.prevent'=>'showRecord()']) !!}
                    {{-- {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()']) !!} --}}
                        
                </div>
            </div>
        </div>
        {!! Form::close() !!}
      </div>
      <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Successfully Saved!</strong> 
      </div>

      <div class="box box-default box-solid" >
            <div class="box-header with-border">
                Message Detail
            </div>
            <div class="box-body">
                <div class="box-body">
                    {!! Form::label('','Subject',['class' => 'col-sm-3 control-label ']) !!}
                    <div class="col-sm-12">
                      {!! Form::text('',null,['class' => 'form-control','v-model' => 'subject']) !!}
                    </div>
                  </div>
                  <div class="box-body"> 
                    {!! Form::label('','Message',['class' => 'col-sm-3 control-label ']) !!}
                    <div class="col-sm-12">
                      {!! Form::textarea('',null,['class' => 'form-control txt-area','size'=>'31x4','v-model' => 'msg']) !!}
                    </div>
                  </div>
                  <div class="box-body"> 
                    {!! Form::label('','Send Mail To',['class' => 'col-sm-3 control-label ']) !!}
                    <div class="col-sm-12">
                        <select class="form-control select-form" v-model="type">
                            <option value="F">Father Email</option>
                            <option value="M">Mother Email</option>
                            <option value="G">Guardian Email</option>
                            <option value="S">Student Email</option>
                        
                        </select>
                    </div>
                  </div>
                <div class="box-footer">
                    {!! Form::submit('SEND',['class' => 'btn btn-primary','@click.prevent' => 'confirmation("few")']) !!}
                    {!! Form::submit('Reset',['class' => 'btn btn-primary','@click.prevent' => 'reset']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
      </div>
      
      <div class="panel panel-default">
        <div class="panel-heading">
          Students
            <span v-if="selectData" style="margin:0 0 0 50px">
                {!! Form::radio('radio_button', 'S',null, ['class' => 'minimal','v-model'=>'select_data_type', '@change' => "selectAll"]) !!}Select to All
                {!! Form::radio('radio_button', 'U',null, ['class' => 'minimal','v-model'=>'select_data_type', '@change' => "selectAll"]) !!}Un-Select to All
                {{-- {!! Form::label('','Select',['class' => 'col-sm-2 control-label ']) !!} --}}
                {{-- {!! Form::submit('Select to All',['class' => 'btn btn-primary','@click.prevent' => 'selectAll']) !!} --}}
                {{-- <select class="form-control select-form" v-model="select_data" @change.prevent="selectAll()">
                    <option value="S">Select to All</option>
                    <option value="U">Un-Select to All</option>
                
                </select> --}}
                    
            </span>
            <span style="margin:0 0 0 50px">
                Selected( 
                @{{count}} )
            </span>

        </div>
        <div class="panel-body">
            <table
                id="classWise"
                class="table table-striped table-bordered"
                width="100%"
            ></table>
        </div>
      </div>
      
  </div>
@stop

@section('script')
    <script>
        // $(document).ready(function() {
            
        // });
        var vm = new Vue({
        el: '#app',
        data: {
            course_id:0,
            course_type:'',
            student_marks:[],
            semester: '',
            subjects:[],
            semesters:[],
            errors:{},
            table:null,
            tData:[],
            tstudents:[],
            tdetails:[],
            table:null,
            msg: '',
            subject: '',
            std_ids: [],
            table: null,
            columnDefs: [],
            base_url: "{{ url('/')}}",
            status:'A',
            checked:false,
            type:'F',
            selectData:false,
            sel:false,
            select_data_type:'',
            count:'0',
            courses: {!! \App\Course::orderBy('sno')->get(['id', 'course_name', 'status'])->toJson() !!},

        },
        // created:function(){
        //     var self = this;
        //     $('.selectCourse').select2({
        //         placeholder: 'Select Course',
        //         width:'100%'
        //     });
        //     $('.selectCourse').on('change',function(){
        //         self.course_id = $(this).val();
        //         self.getSubjectsList();
        //     });

           
           

        // },
       
        computed:{
            getCourses: function(){
                var self = this;
                return self.courses.filter(function(course){
                    return course.status == self.course_type;
                });
            },
            showErrors:function(){
                if(Object.keys(this.errors).length == 0){
                    return false;
                }
                return true;
            },

            
        },
        ready:function(){
            var self =this;
            this.setColumns();
            this.setDatatable();
            $(document).on('click', '.checkbox', function(e) {
                // console.log(e.target.dataset.itemId);
                self.check(e.target.dataset.itemId);
            });
            var index = '';

            $('#classWise').on('page.dt', function (e) {
                if(self.sel){
                    setTimeout(function(){
                        $('.checkbox').prop('checked', true);
                    }, 500);
                   
                }
                else{
                    self.tstudents.forEach(function(ele){
                        index = self.std_ids.find(x => x == ele.id);
                        // console.log(index);
                        // if(index != undefined){
                            if(index != ele.id){
                                console.log(index);
                                setTimeout(function(){
                                    $('#std_id'+ele.id+'').prop('checked', false);
                                }, 500);
                            }
                        // }
                            else{
                                setTimeout(function(){
                                    $('#std_id'+ele.id+'').prop('checked', true);
                                }, 500);
                            }
                       
                       
                    })
                }
                
            });

            $('#classWise').on('length.dt', function (e) {
                if(self.sel){
                    setTimeout(function(){
                        $('.checkbox').prop('checked', true);
                    }, 500);
                   
                }else{
                    self.tstudents.forEach(function(ele){
                        index = self.std_ids.find(x => x == ele.id);
                        if(index != ele.id){
                            setTimeout(function(){
                                $('#std_id'+ele.id+'').prop('checked', false);
                            }, 500);
                        }
                        else{
                            setTimeout(function(){
                                    $('#std_id'+ele.id+'').prop('checked', true);
                                }, 500);
                        }
                    })
                    
                }
                
            } );
        },
        methods: {
            confirmation:function(status){
                var me = this;
                var msg = "Do you want to proceed ?";
                var r = confirm(msg);
                if (r == true) {
                    me.sendSms();
                } 
                return;
            },
            sendSms: function() {
                this.success = false;
                this.errors = [];
                var self= this;
                data = $.extend({}, {
                    msg: this.msg,
                    subject:this.subject,
                    std_ids:this.std_ids,
                    type:this.type,
                })
                this.$http.post("{{ url('send-email') }}", data)
                .then(function (response) {
                    console.log(response);
        //            this.classes = response.data;
                    if(response.status == 200){
                        alert('Sent successfully');
                        self.success = true;
                    }
                    this.std_ids = [];
                    // this.reloadTable();
                }, function (response) {
                    self.success =  false;
                    for (var key in response.body) {
                        if (response.body.hasOwnProperty(key)) {
                            self.errors.push(key + " -> " + response.body[key]);
                        }
                    }
                });
            },
            check:function(id){
                console.log(id);
                var self =this;
                var index1 = '';
                self.count = '0';
                index1 = self.std_ids.findIndex(x => x == id);
                console.log(index1);
                if(index1 == -1) {
                    self.std_ids.push(id);
                    self.std_ids.forEach(function(e){
                        self.count++;
                    })
                    $('#std_id'+id+'').prop('checked', true);
                    
                } else {
                    self.std_ids.splice(index1,1);
                    self.std_ids.forEach(function(e){
                        self.count++;
                    })
                    $('#std_id'+id+'').prop('checked', false);
                }
                self.sel = false;
            },
            selectAll:function(){
                var self = this;
                self.count = '0';
                if(self.select_data_type == 'S'){
                    self.tstudents.forEach(function(ele){
                        index = self.std_ids.find(x => x == ele.id);
                        if(index == undefined){
                            self.std_ids.push(ele.id);
                            $('.checkbox').prop('checked', true);
                            self.count++;
                        
                        }
                        else if(index != ele.id){
                            self.std_ids.push(ele.id);
                            $('.checkbox').prop('checked', true);
                            self.count++;
                        }
                    })
                    self.sel = true;
                }
                else{
                    self.std_ids = [];
                    self.std_ids.forEach(function(e){
                        self.count++;
                    })
                    $('.checkbox').prop('checked', false);
                    self.sel = false;
                }
                
            },
            // getSubjectsList: function() {
            //     if(this.course_id != 0 && this.course_id != this.selected_course_id) {
            //         this.$http.get("{{ url('courses') }}/"+this.course_id+"/subjects_list_course")
            //         .then(function(response) {
            //             this.selected_course_id = this.course_id ;
            //             var courseYear = response.data.course.course_year;
            //             this.semesters = [];
            //             this.semesters = [{'id' : courseYear+(courseYear - 1), 'sem': this.getSemesterName(courseYear+(courseYear - 1))},
            //                               {'id' : courseYear+(courseYear-1) +1, 'sem': this.getSemesterName(courseYear+(courseYear-1) +1)}]
            //         }, function(response) {
            //         });
            //     }
            // },
            // getSemesterName:function(sem){
            //     switch (sem)
            //     {
            //         case 1: 
            //             return "First";
            //         case 2: 
            //             return "Second";
            //         case 3: 
            //             return "Third";
            //         case 4: 
            //             return "Fourth";
            //         case 5: 
            //             return "Fifth";
            //         case 6: 
            //             return "Sixth";
            //         default: 
            //             return "Select Course First";
            //     }
            // },
            reset:function(){
                var self = this;
                self.msg = '';
                self.subject = '';
                self.std_ids = [];
                self.type = 'F';
                self.select_data_type = '';
                self.count='0'
            },
            showRecord:function(){
                var self= this;
                self.selectData = false;
                self.reset();
                this.$http.get("{{ url('send-email') }}",{
                    params: {
                        course_id: self.course_id,
                        course_type: self.course_type,
                        // semester: self.semester,
                        // status: self.status,
                        // mail_sent: self.mail_sent,

                    } 
                })
                .then(function(response) {
                        // self.tdetails = response.data.details;
                        self.tstudents= response.data.students;
                        self.reloadTable();
                        self.selectData = true;
                    }, function(response) {
                        if(response.status == 422) {
                            $('body').scrollTop(0);
                            self.errors = response.data;
                        }  
                });
            },

            reloadTable: function() {
                var self = this;
                if(self.table != null) {
                    self.table.destroy();
                    $('#classWise').empty();
                }
                this.setColumns();
                this.setData();
                this.setDatatable();
                this.table.clear();
                this.table.rows.add(self.tData).draw();
            },
            setData() {
                var self = this;
                self.tData = [];
                var record = {};
                self.tstudents.forEach(function(ele) {
                    // console.log(ele);
                    record = {
                        id: ele.id,
                        roll_no: ele.roll_no,
                        name: ele.name,
                        stu_mail:ele.std_user.email,
                        father_email:ele.father_email,
                        mother_email:ele.mother_email,
                        guardian_email:ele.guardian_email,
                        // result: ele.result
                    }
                    // self.tdetails.forEach(function(e){
                    //     ele.marks_details.forEach(function(mark){
                    //         if(e.id == mark.exam_det_id){
                    //             if(e.have_sub_papers == 'N'){
                    //                 record[e.subject.uni_code] = mark.marks;
                    //             }
                    //             else{
                    //                 if(mark.sub_papers_marks.length > 0){
                    //                     var marks = 0;
                    //                     mark.sub_papers_marks.forEach(element => {
                    //                         marks += parseFloat(element.marks);
                    //                     });
                    //                     record[e.subject.uni_code] = marks;
                    //                 }
                    //             }
                    //         }

                    //     })
                    // });
                    self.tData.push(record);
                });
            },

            setColumns() {
                var self = this;
                var target = 0;
                self.columnDefs = [
                    { title: "Sr No",width: "10%",targets: target++, data:'id',
                        render: function(data, type, row, meta) {
                            var str ='';
                            str += '<input type="checkbox" class="checkbox" id="std_id'+data+'" data-item-id='+data+'>';
                            return str;
                        }
                    },
                    { title: 'Roll. No.', targets: target++, data: 'roll_no'},
                    { title: 'Name', targets: target++, data: 'name'},
                    { title: 'Student Email', targets: target++, data: 'stu_mail'},
                    { title: 'Father Email', targets: target++, data: 'father_email'},
                    { title: 'Mother Email', targets: target++, data: 'mother_email'},
                    { title: 'Guardian Email', targets: target++, data: 'guardian_email'},
                    // { title: 'Result', targets: target++, data: 'result'},
                ]
                // if(self.tdetails.length > 0){
                //     self.tdetails.forEach(function(ele){
                //         self.columnDefs.push({ title:  ele.subject.uni_code,targets: target++, data:ele.subject.uni_code,
                //             render: function(data, type, row, meta) {
                //             var str ='';
                //                str = data == undefined ? '' :data;
                //             return str;
                //         }});
                //     });
                // }
                
            },

            setDatatable: function(){
                var self = this;
                var target = 0;
                self.table = $('#classWise').DataTable({
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [ 10, 25, 50, -1 ],
                        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                    ],

                    buttons: [
                        'pageLength',
                        {
                            extend: 'excelHtml5',
                            header: true,
                            footer: true,
                            exportOptions: {
                                orthogonal: 'export'
                            },
                        },
                    ],

                    data: [],
                    ordering: true,
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    pageLength: 10,
                    paging: true,
                    // fixedColumns:{
                    //     // rightColumns: 3,
                    //     leftColumns: 2
                    // },
                    "scrollX": true,
                    columnDefs: self.columnDefs,
                   
                    
                });
                

            },
        }
    });
  </script>
@stop