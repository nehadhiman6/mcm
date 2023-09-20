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
        <div class="box-body">
                {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('exam_name','Examination',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['exam_name'] }">
                    {!! Form::select('exam_name',['0'=>'Select']+getExaminations(), null, ['class' => 'form-control', 'v-model' => 'exam_name']) !!}
                    <span id="basic-msg" v-if="errors['exam_name']" class="help-block">@{{ errors['exam_name'][0] }}</span>
                </div>
                {!! Form::label('center','Center',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['center'] }">
                    {!! Form::select('center', getCenters(), null, ['class' => 'form-control', 'v-model' => 'center']) !!}
                    <span id="basic-msg" v-if="errors['center']" class="help-block">@{{ errors['center'][0] }}</span>
                </div>
                {!! Form::label('session','Session',['class' => 'col-sm-1 control-label ']) !!}
                <div class="col-sm-2">
                    {!! Form::select('session',['0'=>'All']+getSessions(),null,['class' => 'form-control', 'v-model' => 'session']) !!}
                    <span id="basic-msg" v-if="errors['session']" class="help-block">@{{ errors['session'][0] }}</span>
                </div>
            </div>

            <div class="form-group col-sm-12">
                {!! Form::label('date','Date',['class' => 'col-sm-2 control-label ']) !!}
                <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['date'] }">
                    {!! Form::text('date','All',['class' => 'form-control app-datepicker', 'v-model' => 'date']) !!}
                    <span id="basic-msg" v-if="errors['date']" class="help-block">@{{ errors['date'][0] }}</span>
                </div>
                <div class="pull-right">
                    {!! Form::submit('Show',['class' => 'btn btn-primary','@click.prevent'=>'showData()']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            Seating Plans 
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="seats" class="table table-bordered" width="100%">
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
                errors:{},
                sessions:{!! json_encode(getSessions(true)) !!},
                centers:{!! json_encode(getCenters(true)) !!},
                
            },

            created:function(){
                var self = this;
                this.setTable();
                
            },

            methods: {
                setTable:function(){
                    var self= this;
                    var target = 0;
                    self.table = $('#seats').DataTable({
                        serverSide: true,
                        dom: 'Bfrtip',
                        lengthMenu: [
                            [ 10, 25, 50, -1 ],
                            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                        ],
                        buttons: [
                            'pageLength',
                            {
                                extend: 'excelHtml5',
                                exportOptions: { orthogonal: 'export' }
                            },
                            {
                                extend: 'pdfHtml5',
                                orientation: 'landscape',
                            },
                        ],
                        // scrollY:        "300px",
                        // scrollX:         true,
                        // rowsGroup:      [3,1,2],
                        // scrollCollapse:  true,
                        // pageLength:      "10",
                        // paging:          true,
                        "ajax": {
                            "url": MCM.base_url+'/seating-plan-list',
                            "type": "POST",
                            'headers': {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            'data': function(data) {
                                data.date = self.date,
                                data.session = self.session,
                                data.exam_name = self.exam_name,
                                data.center = self.center
                            },
                            "error": function(error) {
                                if(error.status == 422){
                                    self.errors = error.responseJSON;
                                }
                                // parse "reason" here and take appropriate action
                            }
                        },
                        "scrollX": true,
                        // buttons: ['pdf'],
                        columnDefs: [
                            { title: 'Sr.',width:50, targets: target++, data: 'id',
                                "render": function( data, type, row, meta) {
                                    return meta.row +1;
                                }
                            },
                            { title: 'Center', targets:target++, data:'exam_loc_id',
                                "render":function(data, type, row, meta){
                                    var str ='';
                                    if(row.exam_location && row.exam_location.center){
                                        $.each(self.centers,function(key ,val){
                                            if(row.exam_location.center == key){
                                                str+= val;
                                            }
                                        });
                                    }
                                    return str;
                                }
                            },
                            { title: 'Date', targets:target++, data:'date',
                                "render": function( data, type, row, meta) {
                                    return row.date;
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
                            { title: 'Location', targets:target++, data:'exam_loc_id',
                                "render":function(data, type, row, meta){
                                    var str ='';
                                    if(row.exam_location && row.exam_location.location){
                                        str += row.exam_location.location.location;
                                    }
                                    return str;
                                }
                            },
                            
                            { title: 'Course', targets:target++, data:'id',
                                "render":function(data, type, row, meta){
                                    var str ='';
                                    if(row.subject_section && row.subject_section.course){
                                        str += row.subject_section.course.course_name;
                                    }
                                    return str;
                                }
                            },

                            { title: 'Sec', targets:target++, data: 'id',
                                "render":function(data, type, row, meta){
                                    var str ='';
                                    if(row.subject_section && row.subject_section.section){
                                        str += row.subject_section.section.section;
                                    }
                                    return str;
                                }
                            },
                            { title: 'Subject', targets:target++,
                                "render":function(data, type, row, meta){
                                    var str ='';
                                    if(row.subject_section && row.subject_section.subject){
                                        str += row.subject_section.subject.subject;
                                    }
                                    return str;
                                }
                            },
                            { title: 'Seats', targets:target++,data: 'occupied_seats'
                            },
                            { title: 'Gap Seats', targets:target++,data: 'gap_seats'
                            },
                            { title: 'Seat Nos. & Roll no.', targets:target++, data: 'occupied_seats',
                                "render":function(data, type, row, meta){
                                    var str ='';
                                    if(row.seating_plan_details && row.seating_plan_details){
                                        row.seating_plan_details.forEach((element,index) => {
                                            str += '[Seat No. ' + element.seat_no+ " ";
                                            str += 'Row no. ' +element.row_no +',';
                                            str += 'Roll no. ' +element.student.roll_no;
                                            str+=']';
                                            if(row.seating_plan_details.length-1 != index){
                                                str+=', ';
                                            }
                                        });
                                    }
                                    return str;
                                }
                            }
                        ],
                    });
                },

                showData:function(){
                    this.table.ajax.reload();
                }
            
            }
    });
  </script>
@stop
