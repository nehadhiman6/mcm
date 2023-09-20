@extends('app')
@section('toolbar')
@include('toolbars._academics_toolbar')
@stop
@section('content')
    <div id="app" v-cloak>
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Upload Time Table sheet</h3>
            </div>
            <div class="box-body create_user">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                <img src="{{ asset('dist/img/upload.png') }}" height="20">
                                </span>
                                {{ Form::file('excel',['class' => 'form-control','v-model'=>'excelfile','id'=>'importFile','accept' => 'xlsx', 'placeholder' => 'Upload an Excel File*']) }}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="box-footer">
                    <input class="btn btn-primary" type="submit" value="Upload" @click.prevent="uploadExcelSheet">
                    <input :disabled = "studentsData.length ==0" type="submit" value="SAVE" class="btn btn-primary" @click="saveStudentTimeTable">
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table id="studentTimeTable" class="table table-striped " width="100%">
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
<script>
    var vm = new Vue({
        el:'#app',
        data:function(){
            return {
                excelfile:'',
                studentsData:[],
                base_url:"{{ url('/')}}",
                table:null
            }
        },
        created:function(){
            this.setDataTable();
        },
        methods:{
            uploadExcelSheet:function(){
                var self = this;
                var formdata = new FormData();
                var file = $('#importFile').prop('files');
                formdata.append("excel", file[0]);
                self.$http.post(this.base_url+'/students-timetable/import',formdata)
                .then(function(response){
                    if(response.data.success == true){
                        console.log(response.data);
                        self.studentsData = response.data.student_timetable;
                        self.reloadTable();
                    }
                });
            },
            setDataTable:function(){
                var self = this;
                var target = 0;
                self.table = $('#studentTimeTable').DataTable({
                    lengthMenu: [
                        [ 10, 25, 50, -1 ],
                        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                    'pageLength',
                    {
                        extend: 'excelHtml5',
                        header: true,
                        footer: true,
                        exportOptions: { orthogonal: 'export' },
                    },
                    ],
                    "processing": true,
                    "scrollCollapse": true,
                    "ordering": true,
                    
                    data: [],
                    columnDefs: [
                        { title: 'Sr No',targets:target++, data: 'name',
                            "render": function( data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { title: 'Roll Number', targets: target++, data: 'roll_no', 
                        },
                        { title: 'Name', targets: target++, data: 'name', 
                        },
                        { title: 'Subjects', targets: target++, data: 'subjects', 
                        },
                        { title: 'Honours', targets: target++, data: 'honours',
                            "render": function( data, type, row, meta) {
                                return data ? data :'';
                            } 
                        },
                        { title: 'Add On', targets: target++, data: 'add_on', 
                        },
                        { title: 'location', targets: target++, data: 'location', 
                        },
                        { title: 'Period 0', targets: target++, data: 'period_0', 
                        },
                        { title: 'Period 1', targets: target++, data: 'period_1', 
                        },
                        { title: 'Period 2', targets: target++, data: 'period_2', 
                        },
                        { title: 'Period 3', targets: target++, data: 'period_3', 
                        },
                        { title: 'Period 4', targets: target++, data: 'period_4', 
                        },
                        { title: 'Period 5', targets: target++, data: 'period_5', 
                        },
                        { title: 'Period 6', targets: target++, data: 'period_6', 
                        },
                        { title: 'Period 7', targets: target++, data: 'period_7', 
                        },
                        { title: 'Period 8', targets: target++, data: 'period_8', 
                        },
                        { title: 'Period 9', targets: target++, data: 'period_9', 
                        },
                        { title: 'Period 10', targets: target++, data: 'period_10', 
                        },
                    ],
                    "sScrollX": true,
                });
            },
            reloadTable: function() {
                this.table.clear();
                this.table.rows.add(this.studentsData).draw();
            },

            saveStudentTimeTable:function(){
                var self = this;
                this.$http.post('students-timetable',{'data': self.studentsData})
                .then(function(response){
                   if(response.data.success == true){
                        setTimeout(function(){
                            $.blockUI({'message':'Successfully Saved'});
                        },1500);
                        
                        setTimeout(function(){
                            $.unblockUI();
                        },4000);
                   }
                   
                })
                .catch(function(){
                });
            }
        }
    });
</script>
@stop