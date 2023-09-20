@extends('app')
@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='datesheet' v-cloak>
    <div class="box">
        <div class="box-header with-border">
            Examinations  on {{ $date}}
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
            data:{
                errors: {},
                date:"{{ $date }}",
                sessions:{!! json_encode(getSessions(true)) !!},
                exams:{!! json_encode(getExaminations(true)) !!}
            },
            created:function(){
                var self = this;
                this.setTable();
            },
            methods: {
                
                setTable:function(){
                    var self= this;
                    var target = 0;
                    self.table = $('#date-sheet').DataTable({
                        ordering:        true,
                        scrollY:        "300px",
                        scrollX:        true,
                        scrollCollapse: true,
                        pageLength:    "10",
                        paging:         true,
                        fixedColumns:   {
                            rightColumns: 1,
                            leftColumns: 0
                        },
                        "ajax": {
                            "url": MCM.base_url+'/seating-plan/exams',
                            "type": "GET",
                            "data":{
                                date:self.date,
                            }
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
                            { title: 'Action', targets:target++, data: 'id',
                                "render":function(data, type, row, meta){
                                    var str = "<a href='"+MCM.base_url+"/seating-plan?id="+row.id+"' class='btn btn-primary mr-1'>Set Seating Plan</a>";
                                    return str;
                                }
                            }
                        ],
                        // "sScrollX": true,
                    });
                },
            
            }
    });
  </script>
@stop
