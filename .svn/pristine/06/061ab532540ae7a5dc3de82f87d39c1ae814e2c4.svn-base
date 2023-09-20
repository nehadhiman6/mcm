@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
@stop
@section('content')
<div id="app1" class="box">
  <div class="box-header with-border">
        <h3 class="box-title">List Regional Centre Examination</h3>
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
        url: "{{ url('/') . '/regional-centres/' }}",
        errors: {},
        

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
                    { title: 'Student Name', targets: target++, data: 'name'},
                    { title: 'Father Name', targets: target++, data: 'father_name'},
                    { title: 'Roll No', targets: target++, data: 'roll_no'},
                    { title: 'Uni Roll No', targets: target++, data: 'pupin_no'},
                    { title: 'class', targets: target++, data: 'org_by',
                        "render":function(data, type, row, meta){
                            return row.course ? row.course.course_name : '';
                        }
                    },
                    { title: 'Mobile No', targets: target++, data: 'mobile_no'},
                    { title: 'Address', targets: target++, data: 'add'},
                    { title: 'Email', targets: target++, data: 'email'},
                    { title: 'Centre 1', targets: target++, data: 'centre1'},
                    { title: 'Centre 2', targets: target++, data: 'centre2'},
                    { title: 'Action', targets: target++, data: 'id',
                        "render":function(data, type, row, meta){
                            return "<a href='"+self.url+data+"/edit' class='btn btn-primary'>Edit</a>";
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