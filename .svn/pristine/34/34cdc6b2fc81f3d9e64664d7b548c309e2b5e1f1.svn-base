@extends('app')
@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='datesheet' v-cloak>
    <div class="box">
        <div class="box-header with-border">
            <span>Exam Master List</span>
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
                table : null,
                // pu_exam:{!! isset($pu_exam) ? $pu_exam : 0 !!},
                tData:[],
                errors: {},
                createUrl:'exam-master-list',


            },
            ready:function(){
                var self = this;
                self.setDatatable();
                self.reloadTable();
               
                
            },
           
            methods: {
                

                reloadTable: function() {
                    var self = this;
                    this.table.ajax.reload();
                    // self.table.clear();
                    // console.log(self.tData);
                    // self.table.rows.add(self.tData).draw();
                },
                
                setDatatable: function(){
                    var self = this;
                    var disabled = "disabled";
                    this.table = $('#date-sheet').DataTable({
                //      "searchDelay": 1000,
                        dom: 'Bfrtip',
                        "ajax": {
                            "url": this.createUrl,
                            "type": "GET",
                       
                        },
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
                                header: true,
                                footer: true,
                                extend: 'pdfHtml5',
                                download: 'open',
                                orientation: 'landscape',
                                pageSize: 'LEGAL',
                                exportOptions: { orthogonal: 'export' }
                                // title: function () {
                                //       var title = '';
                                //         title += "Stock Register Report    ";
                                //         title += self.msg
                                //       return title;
                                // },
                            }
                        ],
                        "processing": true,
                        "scrollCollapse": true,
                //      "serverSide": true,
                        "ordering": true,
                        data: [],
                        columnDefs: [
                            { title: 'S.No.', targets: 0, data: 'id',
                            "render": function( data, type, row, meta) {
                                return meta.row + 1;
                            }},

                            { title: 'Course Name', targets: 1, 
                            "render": function( data, type, row, meta) {
                                return row.course ?  row.course.course_name : '';
                            }},

                            { title: 'Exam', targets: 2,
                            "render": function( data, type, row, meta) {
                                return row.exam_name == "pu_odd"? 'PU ODD' : 'PU EVEN';
                            }},
                            
                            
                            { targets: '_all', visible: true }
                        ],

                        "drawCallback": function( settings ) {
                           
                        }

                    });
                },

            }
    });
  </script>
@stop
