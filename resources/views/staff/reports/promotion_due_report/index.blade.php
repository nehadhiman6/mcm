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
                    {!! Form::label('as_on','As On',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('as_on',today(),['class' => 'form-control app-datepicker', 'v-model'=>'as_on']) !!}
                        <span id="basic-msg" class="text-danger">@{{ errors.as_on }}</span>
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

                    {!! Form::label('exam','Qualification',['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-4" >
                            <select v-model="exam" class="form-control select2Qualify" id="getqual">
                                <option v-for="c in ugpg" :value="c.class">@{{ c.display }}</option>
                            </select>
                        </div>
                </div>

                <div class="form-group">
                    {!! Form::label('pay_scale','Current Pay Scale', ['class' => ' control-label col-sm-2'])!!}
                    <div class="col-md-4"> 
                        {!! Form::select('pay_scale',getPayScale(),null, array('required', 'class'=>'form-control','v-model'=>'pay_scale')) !!}
                        <span id="basic-msg" v-if="errors['pay_scale']" class="help-block">@{{ errors['pay_scale'][0] }}</span>
                    </div>

                    {!! Form::label('year','Minimum working years', ['class' => ' control-label col-sm-2'])!!}
                    <div class="col-md-4 "> 
                    {!! Form::text('year',null, array( 'class'=>'form-control','v-model'=>'year')) !!}
                    <span id="basic-msg" v-if="errors['year']" class="help-block">@{{ errors['year'][0] }}</span>
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
        <h3 class="box-title">Promotion Due Report</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
        <div class="table-responsive iw-table">
            <table id="activity" class="table table-bordered " width="100%">
            </table>
        </div>
  </div>
  <div id="ledger-link"></div>
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
        source:'',
        as_on:'',
        exam:'',
        pay_scale:'',
        year:'',
        table: null,
        url: "{{ url('/') . '/promotion-due-report/' }}",
        errors: {},
        types: {!! getResearchType(true) !!} ,
        // deparments: {!! getDepartments(true) !!},
        deparments:[],
        faculty: {!! getFaculty(true) !!},
        ugpg: {!! json_encode(getUGPGExams()) !!},

    },

    ready:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
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

        $('.select2Qualify').select2({
            placeholder: 'Select',
            tags: "true",
            allowClear: true,
        });
        $('.select2Qualify').on('change',function(e){
            self.exam = $(this).val();
            self.getDepart();
        });


        $('body').on('click', '.nameitem', function(e) {
            var item_id = '';
                item_id = $(this).data('item_id');
            var type = $(this).data('type');
            $('#ledger-link').html('');
            $('#ledger-link').append('<form id="pdf-form" action="'+MCM.base_url+'/course-attended-report" method="GET" target="_blank">');
                $('#pdf-form').append('<input type="hidden" name="item_id" value="' + item_id + '">')
                .append('<input type="hidden" name="as_on" value="' + self.as_on + '">')
                .append('<input type="hidden" name="year" value="' + self.year + '">')
                .append('<input type="hidden" name="type" value="'+type+'">')
                .submit();
        });

        $('body').on('click', '.researchitem', function(e) {
            var item_id = '';
                item_id = $(this).data('item_id');
            var facultyid = $(this).data('facultyid');
            $('#ledger-link').html('');
            $('#ledger-link').append('<form id="pdf-form" action="'+MCM.base_url+'/research-report" method="GET" target="_blank">');
                $('#pdf-form').append('<input type="hidden" name="item_id" value="' + item_id + '">')
                .append('<input type="hidden" name="as_on" value="' + self.as_on + '">')
                .append('<input type="hidden" name="year" value="' + self.year + '">')
                .append('<input type="hidden" name="faculty_id" value="'+facultyid+'">')
                .submit();
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
                faculty_id:self.faculty_id,
                depart_id:self.depart_id,
                source:self.source,
                as_on:self.as_on,
                exam:self.exam,
                pay_scale:self.pay_scale,
                year:self.year
            })
            self.$http.get("{{ url('promotion-due-report') }}", {params: data})
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
                buttons: [
                'pageLength',
                    {
                        extend: 'excelHtml5',
                        header: true,
                        footer: true,
                    },

                    {
                        
                        header: true,
                        footer: true,
                        extend: 'pdfHtml5',
                        download: 'open',
                    
                    }
                ],
                "scrollX": true,
                columnDefs: [
                    { title: 'S.No.',targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { title: 'Teacher Name', targets: target++, data: 'full_name'},
                    { title: 'Faculty', targets: target++, data: 'faculty'},
                    { title: 'Department', targets: target++, data: 'depart'},
                    { title: 'Nature of Appointment', targets: target++, data: 'source'},
                    { title: 'Qualification', targets: target++, data: 'qualification'},
                    { title: 'Current pay scale', targets: target++, data: 'pay_scale'},
                    { title: 'Date of joining', targets: target++, data:'doj',
                        "render": function( data, type, row, meta) {
                            return moment(data,'YYYY-MM-DD').format('DD-MM-YYYY');
                        }
                    },
                    { title: 'Working years (As on Date)', targets: target++, data:'doj',
                        "render": function( data, type, row, meta) {
                            if(row.doj) {
                                var dt1 = moment(self.as_on,'DD-MM-YYYY');
                                var dt2 = moment(row.doj,'YYYY-MM-DD');
                                var years = dt1.diff(dt2,'years');
                                dt2 = dt2.add(years,'years');
                                var months = dt1.diff(dt2,'months');
                                dt2 = dt2.add(months,'months');
                                var days = dt1.diff(dt2,'days');
                                return years+' Year(s) '+months+' month(s) '+days+' day(s)';
                            };
                        }
                    },
                    { title: 'Orientation', targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return '<a href ="#" class="nameitem" data-type="Orientation program" data-item_id="'+row.id+'" >Details</a>';
                        }
                    },
                    { title: 'Refresher', targets: target++, data:'id',
                        "render": function( data, type, row, meta) {
                            return '<a href ="#" class="nameitem" data-type="Refresher Course" data-item_id="'+row.id+'" >Details</a>';

                        }
                    },
                    { title: 'Short Term Course', targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return '<a href ="#" class="nameitem" data-type="Short Term Course" data-item_id="'+row.id+'" >Details</a>';

                        }
                    },
                    { title: 'FDP', targets: target++, data:'id',
                        "render": function( data, type, row, meta) {
                            return '<a href ="#" class="nameitem" data-type="FDP" data-item_id="'+row.id+'" >Details</a>';

                        }
                    },
                    { title: 'Research', targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return '<a href ="#" class="researchitem" data-facultyid ="'+self.faculty_id+'" data-item_id="'+row.id+'" >Details</a>';
                            // return '';
                        }
                    },
                    { title: 'Courses Attended', targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return '<a href ="#" class="nameitem" data-item_id="'+row.id+'" >Details</a>';
                            // return '';
                        }
                    },
                  
                ],
            });

            
        },
        reloadTable: function() {
            var self = this;
            this.table.clear();
            this.table.rows.add(this.tData).draw();
        },

    }

    
});
</script>
@stop
