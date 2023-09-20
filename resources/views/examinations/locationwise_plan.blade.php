@extends('app')
@section('toolbar')
    @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='app' v-cloak>
    <div class="box">
         
        <div class="box-header with-border">
            Filter
        </div>
        {!! Form::open(['url' => 'seating-plan-location/print', 'class' => 'form-horizontal' , 'target'=>"_blank"]) !!}
        
        <div class="box-body">
        
            <div class="form-group">
                {!! Form::label('exam_name','Examination',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['exam_name'] }">
                    {!! Form::select('exam_name',['0'=>'Select'] + getExaminations(), null, ['class' => 'form-control', 'v-model' => 'exam_name',':readOnly'=>'seating_plan_students.length >0']) !!}
                    <span id="basic-msg" v-if="errors['exam_name']" class="help-block">@{{ errors['exam_name'][0] }}</span>
                </div>
                {!! Form::label('center','Center',['class' => 'col-sm-1 control-label required']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['center'] }">
                    {!! Form::select('center', getCenters(), null, ['class' => 'form-control', 'v-model' => 'center' ,'@change'=>'getLocations',':readOnly'=>'seating_plan_students.length >0']) !!}
                    <span id="basic-msg" v-if="errors['center']" class="help-block">@{{ errors['center'][0] }}</span>
                </div>
                {!! Form::label('session','Session',['class' => 'col-sm-1 control-label required']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['session'] }">
                    {!! Form::select('session',['0'=>'Select']+getSessions(),null,['class' => 'form-control', 'v-model' => 'session',':readOnly'=>'seating_plan_students.length >0']) !!}
                    <span id="basic-msg" v-if="errors['session']" class="help-block">@{{ errors['session'][0] }}</span>
                </div>
            </div>

            <div class="form-group ">
                {!! Form::label('exam_loc_id', 'Exam Location', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-6" v-bind:class="{ 'has-error': errors['exam_loc_id'] }">
                    <select class="form-control selectLocation"  name="exam_loc_id" v-model="exam_loc_id" :readOnly = 'seating_plan_students.length >0'>
                        <option value="0">Select</option>
                        <option v-for="loc in locations" :value="loc.id">@{{ loc.location.location }}</option>
                    </select>
                    <span id="basic-msg" v-if="errors['exam_loc_id']" class="help-block">@{{ errors['exam_loc_id'][0] }}</span>
                </div>

                {!! Form::label('date','Date',['class' => 'col-sm-1 control-label ']) !!}
                <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['date'] }">
                    {!! Form::text('date','All',['class' => 'form-control app-datepicker', 'v-model' => 'date',':readOnly'=>'seating_plan_students.length >0']) !!}
                    <span id="basic-msg" v-if="errors['date']" class="help-block">@{{ errors['date'][0] }}</span>
                </div>
               
            </div>
            <div class="form-group">
                <div class="col-sm-11">
                    <div class=" pull-right ">
                        <button type="button" class="btn btn-primary" @click.prevent="resetData()">RESET</button>
                        <button type="button" class="btn btn-primary" @click.prevent="showData()">SHOW</button>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="box-footer">
            {!! Form::submit('Print All',['class' => 'btn btn-primary col-sm-2','v-show'=>'seating_plan_students.length >0']) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <div class="box"  v-for ="exam_location in exam_locations" >
        <div class="box-header with-border">
            Seating Plans 
        </div>
        <div class="box-body" >
            <div class="table-responsive" >
                <table id="seats" class="table table-bordered" width="100%">
                        <thead>
                        <tr><td :colspan ="exam_location.exam_location.no_of_rows"><b><p class="pull-left">@{{center_name}},&nbsp;&nbsp;&nbsp;@{{session_name}}</b></p><h4 class="pull-center">MEHR CHAND MAHAJAN DAV COLLEGE FOR WOMEN</h4></td></td></tr>
                        <tr><td :colspan ="exam_location.exam_location.no_of_rows-1"><p class="pull-left">Location: <b>@{{exam_location.exam_location.location.location}}</p><p class="pull-right"></b>(Total Seats: <b>@{{exam_location.exam_location.seating_capacity}} </b>,  Seats Occupied:<b>@{{exam_location.student_seating.length}})</b></p></td><td>Date: <b>@{{exam_location.date}}</b> </td></tr>
                            <tr><td :colspan ="Math.ceil(exam_location.exam_location.no_of_rows/2)"> <span v-for="course in exam_location.courses">Course: <b>@{{ course.course_name}} </b> &nbsp;&nbsp;&nbsp;&nbsp;Subject: <b>@{{course.subject}} </b> &nbsp;&nbsp;&nbsp;&nbsp;Section: <b>@{{course.section}} </b> <br></span></td>
                                <td :colspan ="(exam_location.exam_location.no_of_rows-(exam_location.exam_location.no_of_rows/2))"> 
                                Teachers :<span v-for="staff in exam_location.seating_plan_staff"> <b>@{{ staff.staff.name }} @{{ staff.staff.last_name }}<span><span v-if="$index != exam_location.seating_plan_staff.length - 1">, </span><b></span>
                                </td>
                            </tr>
                            <tr><td v-for="exam_loc in exam_location.exam_location.exam_loc_dets" class="center-td"  >Row no : @{{ exam_loc.row_no}}</td></tr>
                        </thead>
                       <tbody>
                            <tr>
                                <td v-for="exam_loc in exam_location.exam_location.exam_loc_dets">
                                    <table  width="100%">
                                        {{-- <tr v-for="student_seat in exam_location.student_seating">
                                            <td class="center-td" v-if="student_seat.row_no == exam_loc.row_no"><b>@{{ student_seat.student.roll_no}}</b></td>
                                        </tr> --}}
                                        <tr v-for="seat in exam_loc.seat_nos" height= "40">
                                            <td class="center-td">  
                                                <span v-for="student_seat in exam_location.student_seating">
                                                    <span v-if="student_seat.seat_no == seat"><b>@{{ student_seat.student.roll_no}}</b></span>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><td style="text-align: center;" :colspan="exam_location.exam_location.no_of_rows">  Total Students: <b>@{{exam_location.student_seating.length}}</b></td></tr>
                        </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
  <script>
    var app = new Vue({
        el:"#app",
            data:{
                session:'0',
                exam_name:'mst_1',
                date:'',
                center:0,
                table:null,
                exam_loc_id:0,
                errors:{},
                sessions:{!! json_encode(getSessions(true)) !!},
                centers:{!! json_encode(getCenters(true)) !!},
                locations:[],
                seating_plan_students:[],
                errors:{}
            },

            created:function(){
                var self = this;
                // this.setTable();
                $('.selectLocation').select2({
                    placeholder: 'Select Location',
                    width:'100%'
                });
                $('.selectLocation').on('change',function(){
                    self.exam_loc_id = $(this).val();
                });
            },
            computed:{
                exam_locations:function(){
                    var self= this;
                    var locations = [];

                    self.seating_plan_students.forEach(element => {
                        if(element.seating_plan){
                            if(locations.filter(e => {
                                return e.id === element.seating_plan.exam_loc_id && e.date === element.seating_plan.date; 
                            }) == 0){
                                locations.push({'id':element.seating_plan.exam_loc_id,'exam_location':element.seating_plan.exam_location,
                                'date':element.seating_plan.date,'student_seating':[],
                                'courses':[],'seating_plan_staff':[]});   
                            }
                        }
                    });

                    locations.forEach(element => {
                        self.seating_plan_students.forEach(function(ele){
                            if(element.date == ele.seating_plan.date && element.id == ele.seating_plan.exam_loc_id){
                                element.student_seating.push({'row_no':ele.row_no,'seat_no':ele.seat_no,'student':ele.student,'seating_plan_id':ele.seating_plan_id});
                                if(element.courses.filter(e => {
                                    return e.course_id === ele.seating_plan.subject_section.course_id && e.subject_id === ele.seating_plan.subject_section.subject_id; 
                                }) == 0){
                                    element.courses.push({'course_id':ele.seating_plan.subject_section.course_id, 'course_name':ele.seating_plan.subject_section.course.course_name,
                                        'subject_id':ele.seating_plan.subject_section.subject_id,'subject':ele.seating_plan.subject_section.subject.subject,'section':ele.seating_plan.subject_section.section.section}
                                    );
                                }
                                ele.seating_plan.seating_plan_staff.forEach(function(staff){
                                   
                                   {
                                        element.seating_plan_staff.push(staff);
                                    }
                                });
                            }
                        });
                    });

                    locations.forEach(element => {
                        var last_seat_no = 0;
                        element.exam_location.exam_loc_dets.forEach(function(det){
                            det.seat_nos = [];
                            for(var i=last_seat_no+1;i<=last_seat_no+ det.seats_in_row;i++){
                                det.seat_nos.push(i);
                            }
                            last_seat_no = last_seat_no+ det.seats_in_row ;
                        });
                    });

                    return locations;
                },
                session_name:function(){
                    var self = this;
                    var session = '';
                    $.each(self.sessions,function(key ,val){
                        if(self.seating_plan_students[0].seating_plan.session == key){
                            session+=  val;
                        }
                    });
                    return session;
                },
                center_name:function(){
                    var self = this;
                    var center = '';
                        $.each(self.centers,function(key ,val){
                            if(self.seating_plan_students[0].seating_plan.exam_location.center == key){
                                center+=  val;
                            }
                        });
                    return center;
                }
            },
            methods: {
                showData:function(){
                    var self = this;
                    this.$http.post("{{ url('seating-plan-location') }}",{ 'session':self.session, 'exam_name':self.exam_name, 'date':self.date, 'center':self.center, 'exam_loc_id':self.exam_loc_id })
                    .then(function(response){
                        self.errors = {};
                        if(response.data.success == true){
                            self.seating_plan_students = response.data.seating_plan_students;
                            if(self.seating_plan_students.length  == 0){
                                $.blockUI({
                                    message:"<h3>No record found for the provided inputs</h3>"
                                });
                                setTimeout(() => {
                                    $.unblockUI();
                                }, 2000);
                            }
                        }
                    })
                    .catch(function(error){
                        if(error.status == 422){
                            console.log(error.data);
                            self.errors = error.data;
                        }
                    });
                },
                getLocations:function(){
                    this.$http.post("{{ url('exam-locations/center-wise') }}",{'center':this.center})
                    .then(function(response){
                        if(response.data.success == true)
                        this.locations = response.data.locations;
                    })
                    .catch(function(){
                    });
                },
                resetData:function(){
                    this.session='0';
                    this.exam_name='mst_1';
                    this.date='';
                    this.center=0;
                    this.exam_loc_id=0;
                    this.seating_plan_students=[];
                }
            }
    });
  </script>
@stop
