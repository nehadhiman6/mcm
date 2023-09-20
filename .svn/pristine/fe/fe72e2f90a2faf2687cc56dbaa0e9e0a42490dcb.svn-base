@extends('app')

@section('toolbar')
  @include('toolbars.staff_report_toolbar')
@stop
@section('content')
<div class="box box-default box-solid " id='filter'>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
        {!! Form::open(['method' => 'GET',  'action' => ['Reports\Staff\CourseAttendedReportController@index'], 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('date_from','From:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('date_from',null,['class' => 'form-control app-datepicker', 'v-model'=>'date_from']) !!}
                        <span id="basic-msg" class="text-danger">@{{ errors.date_from }}</span>
                    </div>
                    {!! Form::label('date_to','To:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('date_to',null,['class' => 'form-control app-datepicker', 'v-model'=>'date_to']) !!}
                        <span id="basic-msg" class="text-danger">@{{ errors.date_to }}</span>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('courses','Course',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-4">
                        <select class="form-control select-form select2Course" v-model="courses" multiple="multiple" v-bind:class="{ 'has-error': errors['courses'] }">
                                <option value="Orientation program">Orientation program</option>
                                <option value="Refresher Course">Refresher Course</option>
                                <option value="Short Term Course">Short Term Course</option>
                                <option value="FDP">FDP</option>
                                <option value="Conference">Conference</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Symposium">Symposium</option>
                                <option value="Extension Lecture">Extension Lecture</option>
                                <option value="Webinar">Webinar</option>
                                <option value="All">All</option>
                                
                            </select>
                        <span v-if="hasError('courses')" class="text-danger" v-html="errors['courses'][0]"></span>
                    </div>
                    {!! Form::label('faculty_id','Faculty',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-4">
                        <select class="form-control select2faculty" type="text" v-model="faculty_id" >
                            <option v-for="(key,value) in faculty" :value="key">@{{value}}</option>
                            <!-- <option v-for="(value,key) in faculty" :value="key" :key="key">@{{ value.faculty }} </option> -->
                        </select>
                        <span v-if="hasError('faculty_id')" class="text-danger" v-html="errors['faculty_id'][0]"></span>
                    </div>
                   
                </div>
                <div class="form-group">
                    {!! Form::label('depart_id','Department',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-4">
                        <select class="form-control select2deprt" type="text" v-model="depart_id">
                            <!-- <option v-for="(key,value) in items" :value="key">@{{value}}</option> -->
                            <option v-for="value in deparments" :value="value.id" :key="value.id">@{{ value.name }} </option>
                        </select>
                        <span v-if="hasError('depart_id')" class="text-danger" v-html="errors['depart_id'][0]"></span>
                    </div>

                    {!! Form::label('source','Nature of Appointment', ['class' => ' control-label col-sm-2'])!!}
                    <div class="col-sm-4">
                        {!! Form::select('source',getStaffSource(), null, array('required', 'class'=>'form-control select2source','v-model'=>'source','placeholder'=>'Select')) !!}
                        <span id="basic-msg" v-if="errors['source']" class="help-block">@{{ errors['source'][0] }}</span>
                    
                    </div>
                </div>
               
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData()']) !!}
    {!! Form::close() !!}
  </div>
</div>

<div class="box">
  <div class="box-header with-border">
        <h3 class="box-title">Course Attended Report</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
        <div class="table-responsive iw-table">
            <table id="activity" class="table table-bordered " width="100%">
            </table>
        </div>
  </div>

</div>
@stop

@section('script')
<script>
var vm = new Vue({
    el:"#filter",
    data:{
        tData:[],
        date_from: '',
        date_to: '',
        type:[],
        faculty_id:'',
        depart_id:'',
        courses:[],
        table: null,
        url: "{{ url('/') . '/course-attended-report/' }}",
        errors: {},
        types: {!! getResearchType(true) !!} ,
        // deparments: {!! getDepartments(true) !!},
        faculty: {!! getFaculty(true) !!},
        // faculty:'',
        deparments:[],
        source:'',
        form_data: {!! json_encode($form_data) !!},
        staff_id :'0'

    },

    created:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
        $('.select2Course').select2({
            placeholder: 'Select'
        });
        $('.select2Course').on('change',function(e){
            self.courses = $(this).val();
            
        });

        // $('.select2item').on('select2:select', function (e) {
        //     var data = e.params.data;
        //     self.item_name = data.text;
        // });

        $('.select2faculty').select2({
            placeholder: 'Select faculty',
            tags: "true",
            allowClear: true,
        });
        $('.select2faculty').on('change',function(e){
            self.faculty_id = $(this).val();
            self.getDepart();
        });

        $('.select2deprt').select2({
            placeholder: 'Select Department',
            tags: "true",
            allowClear: true,
        });
        $('.select2deprt').on('change',function(e){
            self.depart_id = $(this).val();
           
        });

        $('.select2source').select2({
            placeholder: 'Select Department',
            tags: "true",
            allowClear: true,
        });
        $('.select2source').on('change',function(e){
            self.source = $(this).val();
           
        });
        console.log(self.form_data);
        if (self.form_data.length != 0) {
            self.date_to = self.form_data.as_on;
            self.date_from = self.form_data.date_to;
            self.staff_id = self.form_data.item_id;
            self.courses.push(self.form_data.type);
            $('.select2Course').val(self.courses).trigger('change');
            self.getData();
        }
        else{
            console.log(MCM.start_date,MCM.today);
            self.date_from = MCM.start_date;
            self.date_to = MCM.today;
        }
        
       
       
    },

    methods:{

        getDepart:function () {
                var self = this;
                axios.get('depart-list',{params:{faculty_id:[self.faculty_id]}})
                .then(function (response) {
                    if(response.data){
                        console.log(response);
                        self.deparments = response.data.depart;
                        
                    }
                })
            },
        
        // getTitle:function(){
        //     return this.date_from+"  To  "+this.date_to +"   "+this.item_name +"    "+this.store_name +"    "+this.staff_name;
        // },
        
        getData: function() {
            var self = this;
            // console.log(self.date_to,self.date_from);
            var data = $.extend({}, {
                date_from: self.date_from,
                date_to: self.date_to,
                courses: self.courses,
                faculty_id:self.faculty_id,
                depart_id:self.depart_id,
                source:self.source,
                staff_id:self.staff_id
                
                
            })
            self.$http.get("{{ url('course-attended-report') }}", {params: data})
            .then(function (response) {
                // console.log(response.data);
                self.tData = (typeof response.data) == "string" ? JSON.parse(response.data) : response.data;
                self.reloadTable();
            })
            .catch(function(error){
                self.errors = error.data;
            })
        },

        setTable:function(){
            var self= this;
            var target = 0;
            self.table = $('#activity').DataTable({
                dom: 'Bfrtip',
                ordering:        true,
                scrollY:        "300px",
                scrollX:        true,
                scrollCollapse: true,
                pageLength:    10,
                paging:         true,
                // fixedColumns:   {
                //     rightColumns: 1,
                //     leftColumns: 1
                // },
                processing: true,
                data: [],
                // "ajax": {
                //     "url": '',
                //     "type": "GET",
                //     "data": function ( d ) {
                //             d.date_from = self.date_from;
                //             d.date_to = self.date_to;
                //         },
                // },
                buttons: [
                'pageLength',
                    {
                        extend: 'excelHtml5',
                        header: true,
                        footer: true,
                        // exportOptions: { 
                        //   orthogonal: 'export' ,
                        // },
                        // messageTop: function () {
                        //     return self.title;
                        // },
                        
                    },

                    {
                        
                        header: true,
                        footer: true,
                        extend: 'pdfHtml5',
                        download: 'open',
                        // orientation: 'landscape',
                        // pageSize: 'LEGAL',
                        // title: function () {
                        //         var title = '';
                        //         // title += "Stock Register Report    ";
                        //         title = self.getTitle();
                        //         return title;
                        // },
                        
                    
                    }
                ],
                "scrollX": true,
                columnDefs: [
                    { title: 'S.No.',targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { title: 'Faculty Name', targets: target++, data: 'name'},
                    { title: 'Faculty', targets: target++, data: 'faculty'},
                    { title: 'Nature of Appointment', targets: target++, data: 'source'},
                    { title: 'Department', targets: target++, data: 'depart'},
                    { title: 'Designation', targets: target++, data: 'desig'},
                    { title: 'Course', targets: target++, data: 'course'},
                    { title: 'Topic', targets: target++, data: 'topic'},
                    { title: 'Level', targets: target++, data:'level' },
                    { title: 'Begin date', targets: target++, data: 'begin_date'},
                    { title: 'End Date', targets: target++, data:'end_date' },
                    { title: 'Duration', targets: target++, data: 'duration'},
                    { title: 'Orgnaized By', targets: target++, data:'org_by' },
                    { title: 'Sponserd by', targets: target++, data: 'spon_by'},
                    { title: 'Collaboration with', targets: target++, data:'coll_with' },
                    { title: 'Participated as', targets: target++, data: 'part_as'},
                    { title: 'Affliating Institute', targets: target++, data:'aff_inst' },
                    { title: 'Delivery mode', targets: target++, data: 'delivery_mode'},
                    { title: 'Board/university', targets: target++, data:'board_uni' },
                    { title: 'Certificate link', targets: target++, data:'cer_link' },
                    { title: 'Remarks', targets: target++, data:'remarks' },

                   
                ],
            });
        },
        // reloadTable: function() {
        //     var self = this;
        //     self.table.ajax.reload();
        // },

        reloadTable: function() {
            var self = this;
            this.table.clear();
            this.table.rows.add(this.tData).draw();
        },

        
    }

    
});
</script>
@stop
