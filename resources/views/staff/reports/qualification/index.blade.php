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
        {!! Form::open(['method' => 'GET',  'action' => ['Reports\Staff\QualificationReportController@index'], 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                        {!! Form::label('exam','Exam Type',['class' => 'col-sm-2 control-label required']) !!}
                        <div class="col-sm-4">
                            {!! Form::select('course_type',['0'=>'Select Type','ug' => 'UG', 'pg' => 'PG', 'others' => 'OTHERS'],null, ['class' => 'form-control', 'v-model' => 'course_type']) !!}
                        </div>

                        {!! Form::label('exam','Examination',['class' => 'col-sm-2 control-label required']) !!}
                        <div class="col-sm-4" >
                            <select v-model="exam" class="form-control selectExam" id="getqual">
                                <option v-for="c in ugpg_classes(course_type)" :value="c.class">@{{ c.display }}</option>
                            </select>
                        </div>
                      	
                </div>
                <div class="form-group">
                       
                        {!! Form::label('from_year','From Year',['class' => 'col-sm-2 control-label required']) !!}
                        <div class="col-sm-4" >
                            <!-- <input type="text"  v-model='from_year'  class="form-control"/> -->
                            {!! Form::text('from_year',startDate(),['class' => 'form-control app-datepicker', 'v-model'=>'from_year']) !!}
                        
                        </div>
                       
                        {!! Form::label('to_year','To Year',['class' => 'col-sm-2 control-label required']) !!}
                        <div class="col-sm-4" >
                            <!-- <input type="text"  v-model='to_year'  class="form-control"/> -->
                            {!! Form::text('to_year',today(),['class' => 'form-control app-datepicker', 'v-model'=>'to_year']) !!}
                        
                        </div>	
                </div>
                <div class="form-group">
                    {!! Form::label('faculty_id','Faculty',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-4">
                        <select class="form-control select2faculty" type="text" v-model="faculty_id">
                            <option v-for="(key,value) in faculty" :value="key">@{{value}}</option>
                            <!-- <option v-for="(value,key) in faculty" :value="key" :key="key">@{{ value.faculty }} </option> -->
                        </select>
                        <span v-if="hasError('faculty_id')" class="text-danger" v-html="errors['faculty_id'][0]"></span>
                    </div>
                    {!! Form::label('depart_id','Department',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-4">
                        <select class="form-control select2deprt" type="text" v-model="depart_id">
                            <!-- <option v-for="(key,value) in items" :value="key">@{{value}}</option> -->
                            <option v-for="value in deparments" :value="value.id" :key="value.id">@{{ value.name }} </option>
                        </select>
                        <span v-if="hasError('depart_id')" class="text-danger" v-html="errors['depart_id'][0]"></span>
                    </div>

                    
                </div>
                <div class="form-group">
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
        <h3 class="box-title">Qualification Report</h3>
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
        faculty_id:'',
        depart_id:'',
        course_type:'ug',
        exam:'',
        source:'',
        table: null,
        url: "{{ url('/') . '/qualification-report/' }}",
        errors: {},
        types: {!! getResearchType(true) !!} ,
        // deparments: {!! getDepartments(true) !!},
        deparments:[],
        faculty: {!! getFaculty(true) !!},
        ugpg: {!! json_encode(getUGPGExams()) !!},
        from_year:'',
        to_year:'',
        
       

    },

    ready:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
        // $('.select2item').on('select2:select', function (e) {
        //     var data = e.params.data;
        //     self.item_name = data.text;
        // });

        $('.selectExam').select2({
            placeholder: 'Select ',
            tags: "true",
            allowClear: true,
        });
        $('.selectExam').on('change',function(e){
            self.exam = $(this).val();
            
        });

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

       
    },
    methods:{
        getDepart:function () {
                var self = this;
                axios.get('depart-list',{params:{faculty_id: [self.faculty_id]}})
                .then(function (response) {
                    if(response.data){
                        console.log(response);
                        self.deparments = response.data.depart;
                        
                    }
                })
            },
        getData: function() {
            var self = this;
            var data = $.extend({}, {
                course_type: self.course_type,
                exam: self.exam,
                from_year: self.from_year,
                to_year: self.to_year,
                faculty_id:self.faculty_id,
                depart_id:self.depart_id,
                source:self.source

                
                
            })
            self.$http.get("{{ url('qualification-report') }}", {params: data})
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
                    { title: 'Department', targets: target++, data: 'depart'},
                    { title: 'Nature of Appointment', targets: target++, data: 'source'},
                    { title: 'Designation', targets: target++, data: 'desig'},
                    { title: 'Examination', targets: target++, data: 'exam',
                        "render": function( data, type, row, meta) {
                            var exam = data;
                            exam += row.other_exam && row.exam != '' ? ', '+row.other_exam:'';
                            return exam; 
                        }
                    },
                    { title: 'PG Subject', targets: target++, data:'pg_subject' },
                    { title: 'Board/university', targets: target++, data:'board_uni' },
                    { title: 'Year', targets: target++, data: 'year'},
                    { title: 'Type(per/cgpa)', targets: target++, data:'pr_cgpa' },
                    { title: 'Per/Cgpa', targets: target++, data: 'percentage'},
                    { title: 'Division', targets: target++, data:'division' },
                    { title: 'Distinction', targets: target++, data: 'distinction'},
                   
                ],
            });

            
        },
        reloadTable: function() {
                var self = this;
                this.table.clear();
                this.table.rows.add(this.tData).draw();
        },

        ugpg_classes: function(course_type) {
            console.log('sdfsdfsdf');
            var self = this;
            if(! course_type) {
                return [];
            }

            var classes = [];
            $.each(this.ugpg, function(index, val) {
                // console.log(index, val);
                if(val.grad == course_type) {
                    classes.push(val);
                }				
            });
            return classes;
        },
        // reloadTable: function() {
        //     var self = this;
        //     self.table.ajax.reload();
        // },

        
        

        
    }

    
});
</script>
@stop
