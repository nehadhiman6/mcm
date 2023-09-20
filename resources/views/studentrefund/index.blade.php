@extends('app')
@section('toolbar')
  @include('toolbars._bill_receipt_toolbar')
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
  <div class="box-body">

    {!! Form::open(['class' => 'form-horizontal',]) !!}
    <div class="form-group">
      {!! Form::label('date_from','From Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('date_from',today(),['class' => 'form-control app-datepicker', 'v-model'=>'date_from']) !!}
        <!-- <span v-if="hasError('date')" class="text-danger" v-html="errors['date'][0]"></span>   -->
    </div>
      {!! Form::label('date_to','To Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('date_to',today(),['class' => 'form-control app-datepicker', 'v-model'=>'date_to']) !!}
      </div>

    </div>
    <div class="form-group">
        {!! Form::label('course_id','Class :',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::select('course_id',['0'=>'Select Course']+getCourses(),null, ['class' => 'form-control','v-model'=>'course_id']) !!}
                <!-- <span v-if="hasError('course_id')" class="text-danger" v-html="errors['course_id'][0]"></span> -->
            </div>
    </div>
  </div>
  {!! Form::close() !!}

  <div class="box-footer">
    <input type="button" class="btn btn-primary"   value="Show" @click.prevent='reloadTable'>
  </div>
</div>
<div id="app1" class="box">
  <div class="box-header with-border">
        <h3 class="box-title">List Refund Request</h3>
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
        date_from: MCM.today,
        date_to: MCM.today,
        course_id:'',
        // url: "{{ url('/') . '/refund-requests-details/' }}",
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
                    "url":MCM.base_url + '/' +'refund-requests-details',
                    "type": "GET",
                    "data": function ( d ) {
                            d.date_from = self.date_from;
                            d.date_to = self.date_to;
                            d.course_id = self.course_id;
                        },
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
                    { title: 'Roll No', targets: target++, data: 'name',
                        "render":function(data, type, row, meta){
                            return row.student ? row.student.roll_no : '';
                        }
                    },
                    { title: 'Student Name', targets: target++, data: 'father_name',
                        "render":function(data, type, row, meta){
                            return row.student ? row.student.name : '';
                        }
                    },
                    { title: 'Father Name', targets: target++,data: 'roll_no',
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
                    { title: 'Bank Name & Branch Name', targets: target++, data: 'bank_name'},
                    { title: 'Status', targets: target++, data: 'approval'},
                    { title: 'Approved by', targets: target++, data: 'approved_by',
                        "render":function(data, type, row, meta){
                            var str='';
                            var date='';
                            str= row.approved_by ? row.approved_by.name : '';
                            date = row.approval_date;
                            return str + '('+ date +')';
                        }},
                    { title: 'Approval Date', targets: target++, data: 'approval_date'},
                    { title: 'Approval remark', targets: target++, data: 'approval_remarks'},
                    { title: 'Released Amount', targets: target++, data: 'release_amt',
                        "render":function(data, type, row, meta){
                            return row.student_refund ? row.student_refund.release_amt : '';
                        }},
                    { title: 'Release remark', targets: target++, data: 'release_remarks',
                        "render":function(data, type, row, meta){
                            return row.student_refund ? row.student_refund.release_remarks : '';
                        }},
                    { title: 'Release By', targets: target++, data: 'released_by',
                        "render":function(data, type, row, meta){
                            var str='';
                            var date='';
                            str= row.student_refund ? row.student_refund.released_by.name : '';
                            date = row.student_refund ? row.student_refund.release_date :'';
                            return str + '('+ date +')';
                        }},
                    { title: 'Action', targets: target++, data: 'id',
                        "render":function(data, type, row, meta){
                            var str= '';
                            // var display = false;
                            //     if(row.student_refund.std_ref_req_id > 0){
                                    
                            //     }
                            if(row.approval == 'pending'){
                                if(self.permissions['approve']){
                                    str+= "<a href="+MCM.base_url +'/approval-refund/'+row.id+'?approval=approved'+"  class='btn btn-info iw-btn-mt'>Approve</a><br>";
                                }
                                if(self.permissions['cancel']){
                                    str+= "<a href="+MCM.base_url +'/approval-refund/'+row.id+'?approval=canceled'+"  class='btn iw-btn-secondary iw-btn-mt'>Cancel</a><br>";
                                }
                            }
                           
                            if(row.approval == 'approved'){
                                if(row.student_refund == null)
                                {
                                    if(self.permissions['cancel']){
                                    str+= "<a href="+MCM.base_url +'/approval-refund/'+row.id+'?approval=canceled'+"  class='btn iw-btn-secondary iw-btn-mt'>Cancel</a><br>";
                                    }
                                    if(self.permissions['student-refunds']){
                                        str+= "<a href="+MCM.base_url +'/student-refunds/'+row.id+" class='btn btn-success iw-btn-mt'>Release Refund</a>";
                                    }
                                }
                                
                                
                            }
                            if(self.permissions['refund-requests-print']){
                                str+= "<a href="+MCM.base_url +'/refund-requests-print/'+row.id+"  class='btn btn-info iw-btn-mt' target='_blank'>Print</a><br>";
                            }
                            return str;
                        }

                        
                    },
                ],
            });
        },

        reloadTable: function() {
            var self = this;
            if(self.table != null) {
                    self.table.destroy();
                    $('#res').empty();
                }
            self.setTable();
            // self.table.ajax.reload();
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

<style>
.iw-btn-mt{
    margin:4px 0 ;
}

.iw-btn-secondary {
    background: #6e6e6e;
    color: #fff;
}
</style>