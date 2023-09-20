@extends('online.dashboard')
@section('content')

<div id="app1" class="box">
  <div class="box-header with-border">
        <h3 class="box-title">List Refund Request</h3>
        <a href="{{url('student-refund-requests/create')}}">
            <button class="btn  btn-flat margin">
                <span>Add Refund Request</span>
            </button>
        </a>
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
    el:"#app1",
    data:{
        tData:[],
        table: null,
        url: "{{ url('/') . '/student-refund-requests/' }}",
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
                    { title: 'Hostel/college', targets: target++, data: 'fund_type',
                        "render":function(data, type, row, meta){
                            return row.fund_type ? row.fund_type == "C" ? "College" : "Hostel": '';
                        }},
                    { title: 'Request date', targets: target++, data: 'request_date'},
                    { title: 'Fee Deposite date', targets: target++, data: 'fee_deposite_date'},
                    { title: 'Roll No', targets: target++, data: 'roll_no',
                        "render":function(data, type, row, meta){
                            return row.student ? row.student.roll_no : '';
                            
                        }
                    },
                    { title: 'Student Name', targets: target++, data: 'name',
                        "render":function(data, type, row, meta){
                            return row.student ? row.student.name : '';
                        }
                    },
                    { title: 'Father Name', targets: target++,data: 'father_name',
                        "render":function(data, type, row, meta){
                            return row.student ? row.student.father_name : '';
                        }
                    },
                    { title: 'Class', targets: target++, data: 'course_name',
                        "render":function(data, type, row, meta){
                            return row.student ? row.student.course.course_name : '';
                        }
                    },
                    { title: 'Reason of refund', targets: target++, data: 'reason_of_refund'},
                    { title: 'Fee Deposited', targets: target++, data: 'amount'},
                    { title: 'A/C holder Name', targets: target++, data: 'account_holder_name'},
                    { title: 'IFSC', targets: target++, data: 'ifsc_code'},
                    { title: 'Account no.', targets: target++, data: 'bank_ac_no'},
                    { title: 'Bank & Branch Name', targets: target++, data: 'bank_name'},
                    { title: 'Status', targets: target++, data: 'approval'},
                    // { title: 'Approved by', targets: target++, data: 'approved_by',
                    //     "render":function(data, type, row, meta){
                    //         var str='';
                    //         var date='';
                    //         str= row.approved_by ? row.approved_by.name : '';
                    //         date = row.approval_date;
                    //         return str + '('+ date +')';
                    //     }},
                    // { title: 'Approval Date', targets: target++, data: 'approval_date'},
                    // { title: 'Status', targets: target++, data: 'approval'},
                    { title: 'Released Amount', targets: target++, data: 'release_amt',
                        "render":function(data, type, row, meta){
                            return row.student_refund ? row.student_refund.release_amt : '';
                        }},
                    // { title: 'Release remark', targets: target++, data: 'release_remarks',
                    //     "render":function(data, type, row, meta){
                    //         return row.student_refund ? row.student_refund.release_remarks : '';
                    //     }},
                    // { title: 'Release By', targets: target++, data: 'released_by',
                    //     "render":function(data, type, row, meta){
                    //         var str='';
                    //         var date='';
                    //         str= row.student_refund ? row.student_refund.released_by.name : '';
                    //         date = row.student_refund ? row.student_refund.release_date :'' ;
                    //         return str + '('+ date +')';
                    //         // return row.student_refund ? row.student_refund.released_by.name : '';
                    //     }},
                    { title: 'Action', targets: target++, data: 'id',
                        "render":function(data, type, row, meta){
                            var str= '';
                            if(row.approval == 'pending'){
                                str+= "<a href='"+self.url+data+"/edit' class='btn btn-primary'>Edit</a><br>";
                            }
                            str+= "<a href="+MCM.base_url +'/student-refund-requests-print/'+row.id+"  class='btn btn-info iw-btn-mt' target='_blank'>Preview</a><br>";
                            // str+= "<a href="+MCM.base_url +'/approval-refund/'+row.id+'?approval=approved'+"  class='btn btn-info iw-btn-mt'>Approve</a><br>";
                            // str+= "<a href="+MCM.base_url +'/approval-refund/'+row.id+'?approval=cencel'+"  class='btn iw-btn-secondary iw-btn-mt'>Cencel</a><br>";
                            // str+= "<a href="+MCM.base_url +'/student-refunds/'+row.id+" class='btn btn-success iw-btn-mt'>Release Refund</a>";
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

<style>
.iw-btn-mt{
    margin:4px 0 ;
}

.iw-btn-secondary {
    background: #6e6e6e;
    color: #fff;
}
</style>