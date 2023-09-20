@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
@stop
@section('content')
<div id="app1" class="box">
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
              <span v-if="hasError('date')" class="text-danger" v-html="errors['date'][0]"></span>  
          </div>
            {!! Form::label('date_to','To Date',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
              {!! Form::text('date_to',today(),['class' => 'form-control app-datepicker', 'v-model'=>'date_to']) !!}
            </div>

            {!! Form::label('status','Report',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                <select class="form-control select-form" v-model="status">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                    
                </select>
            </div>
          </div>
        </div>
        <div class="box-footer">
          {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'reloadTable()']) !!}
          {!! Form::close() !!}
        </div>
    </div>
  <div class="box-header with-border">
        <strong>List Student Certificate Pass</strong>
        <div class="row">
            @can('add-stu-crt-passes')
                <a href="{{url('/stu-crt-passes/create')}}"><button class="btn  btn-flat margin">
                    <span>Add Student Certificate Pass</span>
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
        url: "{{ url('/') . '/stu-crt-passes/' }}",
        errors: {},
        date_from: '',
        date_to: '',
        status:'N',
        columnDefs: [],
        permissions: {!! json_encode(getPermissions()) !!}
        

    },

    created:function(){
        var self = this;
        // self.setColumns();
        // self.setTable();
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
                    {
                        header: true,
                        footer: true,
                        extend: 'pdfHtml5',
                        download: 'open',
                        // orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title: function () {
                            var title = '';
                            title = 'Record to be maintained by the designated officer';
                            return title;
                        },
                    },
                ],
                processing: true,
                "ajax": {
                    "url": '',
                    "type": "GET",
                    "data": function ( d ) {
                            d.date_from = self.date_from;
                            d.date_to = self.date_to;
                        },
                },
                "scrollX": true,
                columnDefs: self.columnDefs,
            });
        },

        setColumns: function() {
            var self = this;
            var target = 0;
            if(self.status == 'N'){
                self.columnDefs=[
                    { title: 'S.No.',targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { title: 'Date', targets: target++, data: 'req_date'},
                    { title: 'student Name', targets: target++, data: 'stu_name'}, 
                    { title: 'Class', targets: target++, data: 'class'}, 
                    { title: 'College Roll No', targets: target++, data: 'roll_no'},
                    { title: 'Contact No', targets: target++, data: 'contact_no'},
                    { title: 'Email', targets: target++, data: 'email'},
                    { title: 'Address', targets: target++, data: 'add'},
                    { title: 'session', targets: target++, data: 'session'},
                    { title: 'Issue Date', targets: target++, 
                    "render":function(data, type, row, meta){
                            return row.issue_date == null ? '' : row.issue_date;
                                
                    }},
                    { title: 'Particular', targets: target++, data: 'type'},
                    { title: 'Remarks', targets: target++, data: 'remarks'},
                    { title: 'Action', targets: target++, data: 'id',
                        "render":function(data, type, row, meta){
                            var str ='';
                            var urlIssueDate = 'issue-date/';
                            var urlRejected = 'stu-crt-pass-reject/';
                            if(row.rejected == 'N' && row.issue_date == ''){
                                if(self.permissions['stu-crt-passes-modify']){
                                    str += "<a href='"+self.url+data+"/edit' class='btn btn-primary' style='margin:0 0 5px 0'>Edit</a></br>";
                                }
                                if(self.permissions['issue-date']){
                                    str += "<a href='"+urlIssueDate+data+"' class='btn btn-primary' style='margin:0 0 5px 0'>Issue</a></br>";
                                }
                                if(self.permissions['stu-crt-pass-reject']){
                                    str += "<a href='"+urlRejected+data+"' class='btn btn-primary' style='margin:0 0 5px 0'>Reject</a></br>";
                                }
                            }
                            else{
                                if(row.issue_date){
                                    str += '<strong>Issued</strong>';
                                }else{
                                    str += '<strong>Rejected</strong>';
                                }
                                
                            }
                            
                            
                                
                                return str;
                        }
                    },
                ];
            }else{
                self.columnDefs=[
                    { title: 'S.No.',targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { title: 'Name Of Applicant with Contact No./Email/Address', targets: target++,"render":function(data, type, row, meta){
                            var str = "";
                            str += row.stu_name;
                            str += row.contact_no == null ? '' : ',' +row.contact_no;
                            str += row.email == null ? '' :',' +row.email;
                            str += row.add == null ? '' :',' +row.add;
                            return str;
                                
                    }},
                    { title: 'Name Of Sevice Applied for', targets: target++, 
                    "render":function(data, type, row, meta){
                            return row.type;
                    }}, 
                    { title: 'Date Of Receipt Of Applicant', targets: target++, data: 'req_date'}, 
                    { title: 'Date Of Disposal Of Applicant', targets: target++, data: 'issue_date'},
                    { title: 'Remarks:Whether service provided or Application Rejected(with Reasons)', targets: target++,
                    "render":function(data, type, row, meta){
                           var str = '';
                           if(row.issue_date){
                                str+= 'Issued :';
                                str+=  row.remarks == null ? '' : row.remarks;
                           }
                           else if(row.rejected == 'Y'){
                                str+= 'rejected :';
                                str+=  row.remarks;
                           }
                           return str;
                                
                    }},
                    
                ];
            }
            

        },

        reloadTable: function() {
            var self = this;
            if(self.table != null) {
                self.table.destroy();
                $('#res').empty();
            }
            self.setColumns();
            self.setTable();
            this.table.clear();
            this.table.rows.add(this.tData).draw();
        },
    }

    
});
</script>
@stop