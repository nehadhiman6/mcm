@extends('app')
@section('toolbar')
@include('toolbars._placement_toolbar')
@stop
@section('content')
<div id="app1" class="box">
  <div class="box-header with-border">
        <h3 class="box-title">List Placement</h3>
        <div class="row">
            @can('add-placements')
                <a href="{{url('/placements/create')}}"><button class="btn  btn-flat margin">
                    <span>Add Placement</span>
                </button></a>
            @endcan
          </div>
  </div>
  <div class="box-body">
        <div class="table-responsive iw-table">
            <table id="res" class="table table-bordered " width="100%">
            </table>
        </div>
  </div>
  <!-- /.box-body -->
</div>
@stop

@section('script')
<script>
var vm = new Vue({
    el:"#filter",
    data:{
        tData:[],
        table: null,
        url: "{{ url('/') . '/placements/' }}",
        errors: {},
        permissions: {!! json_encode(getPermissions()) !!}

    },

    created:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
    },

    methods:{
        setTable:function(){
            var self= this;
            var target = 0;
            self.table = $('#res').DataTable({
                dom: 'Bfrtip',
                ordering:        true,
                scrollY:        "300px",
                scrollX:        true,
                scrollCollapse: true,
                pageLength:    "10",
                paging:         true,
                fixedColumns:   {
                    rightColumns: 1,
                    leftColumns: 1
                },
                buttons: [
                    'pageLength',
                    {
                        extend: 'excelHtml5',
                        exportOptions: { orthogonal: 'export' }
                    },
                ],
                processing: true,
                "ajax": {
                    "url": '',
                    "type": "GET",
                },
                "scrollX": true,
                columnDefs: [
                    { title: 'S.No.',targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { title: 'Drive Date', targets: target++, data: 'drive_date'},
                    { title: 'Type of Drive', targets: target++, data: 'type',
                    "render": function( data, type, row, meta) {
                            var str = '';
                            if(data == 'P'){
                                str = 'Placement';
                            }
                            else if(data == 'I'){
                                str = 'Internship';
                            }
                            else{
                                str = 'Employability Enhancement Program';
                            }
                            return str;
                    }}, 
                    { title: 'Nature of drive', targets: target++, data: 'nature'}, 
                    { title: 'Company', targets: target++, "render": function( data, type, row, meta) {
                            return row.company ? row.company.name:''
                    }},
                    { title: 'Name of HR personnel', targets: target++, data: 'hr_personnel'},
                    { title: 'Contact Number of HR', targets: target++, data: 'contact_no'},
                    { title: 'Email ID of HR', targets: target++, data: 'email'},
                    { title: 'Coordinator (s) Name (Teacher)', targets: target++,  
                    "render": function( data, type, row, meta) {
                        var str = '';
                            row.staff.forEach(function(ele){
                                str += str != '' ? ', ' : '';
                                str += ele.name;
                            }); 
                            return str;
                    }},
                    { title: 'Coordinator Department', targets: target++,  "render": function( data, type, row, meta) {
                        var str = '';
                            row.staff.forEach(function(ele){
                                str += str != '' ? ', ' : '';
                                str += ele.dept ? ele.dept.name :'';
                            }); 
                            return str;
                    }},
                    { title: 'Job Profile', targets: target++, data: 'job_profile'},
                    { title: 'No of students registered', targets: target++, data: 'stu_reg'},
                    { title: 'No of students appeared', targets: target++, data: 'stu_reg'},
                    { title: 'No of students shortlisted', targets: target++, "render": function( data, type, row, meta) {
                        var str = 0;
                            row.placement_students.forEach(function(ele){
                                str++
                            }); 
                            return str;
                    }},
                    { title: 'No of students selected', targets: target++, "render": function( data, type, row, meta) {
                        var str = 0;
                            row.placement_students.forEach(function(ele){
                                if(ele.status == 'Selected'){
                                    str++
                                }
                            }); 
                            return str;
                    }},
                    { title: 'Min. Salary offered', targets: target++, data: 'min_salary'},
                    { title: 'Max. Salary offered', targets: target++, data: 'max_salary'},
                    { title: 'No. of Rounds (of recruitment)', targets: target++, data: 'round_no'},
                    { title: 'Action', targets: target++, data: 'id',
                        "render":function(data, type, row, meta){
                            var str ='';
                            var ap = 'AP';
                            var sl = 'SL';
                            var selected = 'Selected';
                            if(self.permissions['placements-modify']){
                                str += "<a href='"+self.url+data+"/edit' class='btn btn-primary' style='margin:0 0 5px 0'>Edit</a></br>";
                            }
                            if(self.permissions['placement-student-details']){
                                if(row.placement_students.length > 0){
                                    str += "<a href='"+'student-details/'+data+'/'+ap+"' class='btn btn-primary' style='margin:0 0 5px 0'>Edit Appeared Students</a></br>";
                                    str += "<a href='"+'student-details/'+data+'/'+sl+"' class='btn btn-primary' style='margin:0 0 5px 0'>Shortlisted Students</a></br>";
                                    str += "<a href='"+'student-details/'+data+'/'+selected+"' class='btn btn-primary' style='margin:0 0 5px 0'>Selected Students</a>";

                                }
                                else{
                                    str += "<a href='"+'student-details/'+data+"' class='btn btn-primary' style='margin:0 0 5px 0'>Appeared Students</a>";
                                }
                            }
                            if(row.resources){
                                str += "<a href='"+'placement-upload/'+data+"' class='btn btn-primary' style='margin:0 0 5px 0'>Edit Attachment</a>";
                            }
                            else{
                                str += "<a href='"+'placement-upload/'+data+"' class='btn btn-primary' style='margin:0 0 5px 0'>Attachment</a>";
                            }
                             return str;
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