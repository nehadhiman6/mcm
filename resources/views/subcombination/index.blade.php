@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
@can('sub-combination')
<div class="box" style="background:none;box-shadow:none">
        <a href="{{url('subject-combination/create')}}">
            <button class="btn  btn-flat margin">
                <span>Add Subject Combination</span>
            </button>
        </a>
</div>
@endcan
<div id="app1" class="box">
  <div class="box-header with-border">
        <h3 class="box-title">Subject Combination</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
        <div class="table-responsive iw-table">
            <table id="sub" class="table table-bordered " width="100%">
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
        url: "{{ url('/') . '/subject-combination/' }}",
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
            self.table = $('#sub').DataTable({
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
                processing: true,
                "ajax": {
                    "url": '',
                    "type": "GET",
                    "data": function ( d ) {
                            // d.date_from = self.date_from;
                            // d.date_to = self.date_to;
                        },
                },
                buttons: [
                'pageLength',
                    {
                        extend: 'excelHtml5',
                        header: true,
                        footer: true,
                        
                    },

                ],
                "scrollX": true,
                columnDefs: [
                    { title: 'Combination Code No.', targets: target++, data: 'code'},
                    // { title: 'S.No.',targets: target++, data: 'id',
                    //     "render": function( data, type, row, meta) {
                    //         return meta.row + 1;
                    //     }
                    // },
                    { title: 'Course', targets: target++, data: 'course_id',
                    "render": function( data, type, row, meta) {
                            return row.course ? row.course.course_name : '';
                        }
                    },

                    { title: 'Combination', targets: target++, data: 'combination',
                        "render": function( data, type, row, meta) {
                            var str = '';
                            row.details.forEach(e => {
                                str += str != ''?',' : '';
                                str += e.subject ? e.subject.subject : '';
                            });
                            return str;
                    }},
                   
                    // {visible: self.checkPermision(), title: 'Action', targets: target++, data: 'id',
                    //     "render":function(data, type, row, meta){
                    //         var str= '';
                    //         if(self.permissions['sub-combination-modify']){
                    //             str += "<a href='"+self.url+data+"/edit' class='btn btn-primary'>Edit</a>";
                    //         }
                    //         return str;
                    //     }
                    // },
                ],
            });
        },

        checkPermision: function(){
            if(this.permissions['sub-combination-modify'] == 'sub-combination-modify'){
                return true;
            }else{
                return false;
            }
        },


        reloadTable: function() {
            var self = this;
            self.table.ajax.reload();
        },

        // reloadTable: function() {
        //     var self = this;
        //     this.table.clear();
        //     this.table.rows.add(this.tData).draw();
        // },

        
    }

    
});
</script>
@stop