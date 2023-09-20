@extends('app')
@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='datesheet' v-cloak>
    <div class="box">
        <div class="box-header with-border">
            Seating Plan For
        </div>
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('course', 'Course', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    <p class="form-control-static">@{{ date_sheet.course.course_name }}</p>
                </div>
                {!! Form::label('subject', 'Subject', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    <p class="form-control-static">@{{ date_sheet.subject.subject }}</p>
                </div>
                {!! Form::label('date', 'Date', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    <p class="form-control-static">@{{ date_sheet.date }}</p>
                </div>
            </div>
            <div class="form-group">
                
                {!! Form::label('session', 'Session', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    <p class="form-control-static">{{ getSessionName($date_sheet->session) }}</p>
                </div>
                {!! Form::label('exam_name', 'Examination', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    <p class="form-control-static">{{ getExamName($date_sheet->exam_name) }}</p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="box">
            <div class="box-header with-border">
                Seating Plan Details
            </div>
            <div class="box-body">
                <div class="form-group row">
                    {!! Form::label('section_id', 'Section', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['seating_plan.sub_sec_id'] }">
                        <select class="form-control" v-model="seating_plan.sub_sec_id" @change="sectionChanged">
                            <option value="0">Select</option>
                            <option v-for="sec in subject_sections" :value="sec.id">@{{ sec.section.section }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['seating_plan.sub_sec_id']" class="help-block">@{{ errors['seating_plan.sub_sec_id'][0] }}</span>
                    </div>
                    {!! Form::label('section', 'Section Total Strength', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        <p class="form-control-static">@{{ sec_total_strength }}</p>
                    </div>
                    {!! Form::label('section', 'Section Pending Strength', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['students'] }">
                        <p class="form-control-static">@{{ sec_pending_strength }}</p>
                        <span id="basic-msg" v-if="errors['students']" class="help-block">@{{ errors['students'][0] }}</span>
                    </div>

                </div>
                <div class="form-group row">
                    {!! Form::label('center','Center',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['center'] }">
                        {!! Form::select('center', getCenters(), null, ['class' => 'form-control','v-model'=>'center' ,'@change'=>'getLocations']) !!}
                        <span id="basic-msg" v-if="errors['center']" class="help-block">@{{ errors['center'][0] }}</span>
                    </div>
                    {!! Form::label('loc_id', 'Location', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-6" v-bind:class="{ 'has-error': errors['seating_plan.exam_loc_id'] }">
                        <select class="form-control selectLocation" v-model="seating_plan.exam_loc_id">
                            <option value="0">Select</option>
                            <option v-for="loc in locations" :value="loc.id">@{{ loc.location.location }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['seating_plan.exam_loc_id']" class="help-block">@{{ errors['seating_plan.exam_loc_id'][0] }}</span>
                    </div>
                </div>
                <div class="form-group row" v-show="seating_plan.exam_loc_id >0">
                    {!! Form::label('loc_id', 'Location Total Seats', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        <p class="form-control-static">@{{ location.seating_capacity }}</p>
                    </div>
                    {!! Form::label('loc_id', 'No. of Rows', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        <p class="form-control-static">@{{ location.no_of_rows }}</p>
                    </div>
                    {!! Form::label('loc_id', 'Location Vacant Seats', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['vacant_seats'] }">
                        <p class="form-control-static">@{{ location.vacant_seats }}</p>
                        <span id="basic-msg" v-if="errors['vacant_seats']" class="help-block">@{{ errors['vacant_seats'][0] }}</span>
                    </div>
                </div>
                <div class="form-group row" >
                    {!! Form::label('loc_id', 'Location Assigned Teachers', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        <p class="form-control-static" v-for="staff in staff_assigned">@{{ staff.name }}  @{{ staff.last_name }}</p>
                    </div>
                    {!! Form::label('teacher_id', 'Teachers', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-6" v-bind:class="{ 'has-error': errors['seating_plan_staff'] }">
                        <select class="form-control selectStaff">
                            <option v-for="staff in staffs" :value="staff.id">@{{ staff.name }} @{{ staff.last_name }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['seating_plan_staff']" class="help-block">@{{ errors['seating_plan_staff'][0] }}</span>
                    </div>
                </div>
                <div class="form-group row">
                    {!! Form::label('sec_pending_strength', 'Section Pending Strength', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        <p class="form-control-static">@{{ sec_pending_strength }}</p>
                    </div>
                    {!! Form::label('occupied_seats', 'How Many Seats to be filled?', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['seating_plan.occupied_seats'] }">
                        {!! Form::text('occupied_seats',null,['class' => 'form-control','v-model'=>'seating_plan.occupied_seats']) !!}
                        <span id="basic-msg" v-if="errors['seating_plan.occupied_seats']" class="help-block">@{{ errors['seating_plan.occupied_seats'][0] }}</span>
                    </div>
                    {!! Form::label('gap_seats', 'No. of Gap Seats ', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['seating_plan.gap_seats'] }">
                        {!! Form::text('gap_seats',null,['class' => 'form-control','v-model'=>'seating_plan.gap_seats']) !!}
                        <span id="basic-msg" v-if="errors['seating_plan.gap_seats']" class="help-block">@{{ errors['seating_plan.gap_seats'][0] }}</span>
                        
                    </div>

                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-2 pull-right" v-else >
                        {!! Form::submit('Allot Seats',['class' => 'btn btn-primary','@click.prevent'=>'saveData()']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
</div>
@stop
@section('script')
  <script>
    var datesheet = new Vue({
        el:"#datesheet",
            data:{
                errors: {},
                date_sheet :{!! json_encode($date_sheet)!!},
                course_id:'{{ $date_sheet->course_id}}',
                subject_id:'{{ $date_sheet->subject_id}}',
                center:'',
                seating_plan:{
                    date_sheet_id:"{{$date_sheet->id}}",
                    exam_loc_id:0,
                    sub_sec_id:0,
                    total_seats:0,
                    occupied_seats:0,
                    gap_seats:0,
                },
                students:[],
                locations:[],
                staffs:[],
                location:{},
                seating_plan_staff:[],
                staff_assigned:[],
                sec_pending_strength:0,
                sec_total_strength:0,
                subject_sections:[],
                errors:{}
            },
            created:function(){
                var self = this;
                this.getSubjectSection();
                $('.selectLocation').select2({
                    placeholder: 'Select Location',
                    width:'100%'
                });
                $('.selectLocation').on('change',function(){
                    self.seating_plan.exam_loc_id = $(this).val();
                    self.getLocationSeats();
                });

                $('.selectStaff').select2({
                    placeholder: 'Select Location',
                    multiple:true,
                    width:'100%'
                });
                $('.selectStaff').on('change',function(){
                    var staff_ids = $(this).val();
                    if(staff_ids){
                        if(staff_ids.length <= 2){
                            self.seating_plan_staff = staff_ids;
                        }
                        else{
                            staff_ids.splice(2, 1);
                            $('.selectStaff').val(staff_ids).trigger('change');
                        }
                    }
                });
            },
            methods: {
                getSubjectSection: function() {
                    var self = this;
                    if(this.course_id != 0  && this.subject_id != 0) {
                        this.$http.post("{{ url('daily-attendance/subject-section') }}",{'course_id':this.course_id,'subject_id':this.subject_id})
                            .then(function(response) {
                                if(response.data.subject_sections){
                                    self.subject_sections = response.data.subject_sections;
                                }
                            }, function(response) {
                        });
                    }
                },

                sectionChanged:function(){
                    var self = this;
                    this.$http.post("{{ url('seating-plan/subject-section') }}",{'sub_sec_id':this.seating_plan.sub_sec_id})
                    .then(function(response){
                        if(response.data.success == true)
                        this.sec_pending_strength = response.data.section_pending_strength;
                        this.sec_total_strength = response.data.section_strength;
                        this.students = response.data.students;
                    })
                    .catch(function(){

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
                getLocationSeats:function(){
                    this.$http.post("{{ url('seating-plan/location-seats') }}",{'exam_loc_id':this.seating_plan.exam_loc_id,
                    'date_sheet_id':this.seating_plan.date_sheet_id})
                    .then(function(response){
                        if(response.data.success == true){
                            this.location = response.data.location;
                            this.location.vacant_seats =  response.data.vacant_seats;
                            this.staff_assigned = response.data.seating_plan_staff;
                            var staff_ids = [];
                            this.staff_assigned.forEach(element => {
                                staff_ids.push(element.id);
                            });
                            setTimeout(function(){
                                $('.selectStaff').val(staff_ids).trigger('change');
                            },200);
                            this.staffs = response.data.staff;
                        }
                    })
                    .catch(function(){
                    });
                },
                saveData:function(){
                    var self = this;
                    this.$http.post("{{ url('seating-plan') }}",{'seating_plan':this.seating_plan,
                    'students':this.students,'seating_plan_staff':this.seating_plan_staff,
                    'vacant_seats':this.location.vacant_seats,'location':this.location})
                    
                    .then(function(response){
                        if(response.data.success == true){
                            window.location.href = MCM.base_url+ "/seating-plan/"+this.seating_plan.date_sheet_id
                        }
                    })
                    .catch(function(error){
                        if(error.status == 422) {
                            $('body').scrollTop(0);
                            self.errors = error.data;
                        } 
                    });
                }
            }
    });
  </script>
@stop
