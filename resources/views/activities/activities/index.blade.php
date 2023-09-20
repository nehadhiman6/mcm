@extends('app')
@section('toolbar')
@include('toolbars._activities_toolbar')
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
        {!! Form::text('date_from',startDate(),['class' => 'form-control app-datepicker', 'v-model'=>'date_from']) !!}
        <span v-if="hasError('date')" class="text-danger" v-html="errors['date'][0]"></span>  
    </div>
      {!! Form::label('date_to','To Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('date_to',today(),['class' => 'form-control app-datepicker', 'v-model'=>'date_to']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'reloadTable()']) !!}
    {!! Form::close() !!}
  </div>
</div>
@can('add-activities')
<div class="box" style="background:none;box-shadow:none">
    <a href="{{url('activities/create')}}">
        <button class="btn  btn-flat margin">
            <span>Add Activity</span>
        </button>
    </a>
</div>
@endcan
<div id="app1" class="box">
  <div class="box-header with-border">
        <h3 class="box-title">Activity</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
        <div class="table-responsive iw-table">
            <table id="activity" class="table table-bordered " width="100%">
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
        date_from: '',
        date_to: '',
        table: null,
        url: "{{ url('/') . '/activities/' }}",
        errors: {},
        permissions: {!! json_encode(getPermissions()) !!}
        

    },

    created:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
        $(document).on( 'click','.activity', function (e) {
                self.removeAct(e.target.dataset.actId, 'act');
        });
    },

    methods:{
        // getData: function() {
        //     var self = this;
        //     data = $.extend({}, {
        //         date_from: self.date_from,
        //         date_to: self.date_to,
        //     })
        //     self.$http.get("{{ url('activities') }}", {params: data})
        //     .then(function (response) {
        //         self.tData = response.data.data;
        //         self.reloadTable();
        //     }, 
        //     function (response) {
        //         //console.log(response.data);
        //     });
        // },

        setTable:function(){
            var self= this;
            var target = 0;
            self.table = $('#activity').DataTable({
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
                            d.date_from = self.date_from;
                            d.date_to = self.date_to;
                        },
                },
                buttons: [
                'pageLength',
                    {
                        extend: 'excelHtml5',
                        header: true,
                        footer: true,
                        // exportOptions: { 
                        //   orthogonal: 'export' ,
                        // },
                        // messageTop: function () {
                        //     return self.title;
                        // },
                        
                    },

                    {
                        
                        header: true,
                        footer: true,
                        extend: 'pdfHtml5',
                        download: 'open',
                        orientation: 'landscape',
                        pageSize: 'A2',
                        title: function () {
                                var title = '';
                                // title += "Stock Register Report    ";
                                title = "Activity  "+self.date_from + " To "+ self.date_to;
                                return title;
                        },
                        exportOptions: {
                                orthogonal: 'export',
                                type: 'export',
                                // modifier : {
                                //     order : ,
                                //     page : 'all',
                                //     search : 'applied',
                                //     selected: true,
                                // },
                                columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21],
                            },
                        
                    
                    }
                ],
                "scrollX": true,
                columnDefs: [
                    { title: 'S.No.',targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { title: 'Start Date', targets: target++, data: 'start_date'},
                    { title: 'End Date', targets: target++, data: 'end_date'},
                    { title: 'Convener/Coordinator/Co-coordinator', targets: target++, data: 'convener'},
                    { title: 'Organized by', targets: target++, data: 'org_by',
                        "render":function(data, type, row, meta){
                            return row.orgnization ? row.orgnization.agency.name : '';
                        }
                    },

                    { title: 'Organization', targets: target++,
                        "render":function(data, type, row, meta){
                            return row.orgnization ? row.orgnization.name : '';
                        }
                    },
                    { title: 'Collaboration Type (Internal/External)', targets: target++,
                        "render":function(data, type, row, meta){
                            str = 'None';
                            if(row.colloboration && row.colloboration.agency_id != null)
                                str = 'Internal';
                            if(row.colloboration && row.colloboration.agency_name != null)
                                str = 'External';
                            return str;
                        }
                    },
                    { title: 'Collaboration With', targets: target++,
                        "render":function(data, type, row, meta){
                            return row.colloboration ? row.colloboration.collo_organization ? row.colloboration.collo_organization.name:'' : '';
                            // return row.colloboration ? row.colloboration.collo_organization.name : '';
                        }
                    },
                    { title: 'Collaborating Organization', targets: target++,
                        "render":function(data, type, row, meta){
                            var str = '';
                            if(row.colloboration && row.colloboration.agency_id)
                                 str = row.colloboration.orgnization.name;
                            if(row.colloboration && row.colloboration.agency_name)
                                str = row.colloboration.agency_name;
                            return str;
                        }
                    },
                    { title: 'Activity Type', targets: target++,
                        "render":function(data, type, row, meta){
                            return row.acttype ? row.acttype.name : '';
                        }
                    },
                    { title: 'Activity Group', targets: target++,
                        "render":function(data, type, row, meta){
                            return row.actgrp ? row.actgrp.name : '';
                        }
                    },
                    { title: 'Topic', targets: target++, data: 'topic'},
                    { title: 'Sponser/Funded By', targets: target++,
                        "render":function(data, type, row, meta){
                            return row.sponsor ? row.sponsor.name : '';
                        }
                    },
                    { title: 'Sponser/Funding Agency Address', targets: target++,data: 'sponsor_address'},
                    { title: 'Amount Sponsored:', targets: target++,data: 'sponsor_amt'},
                    { title: 'Under the aegis of:', targets: target++,data: 'aegis'},
                    { title: 'Guest', targets: target++,
                        "render":function(data, type, row, meta){
                            var str = '';
                            row.guest.forEach(function(e,index){
                                str += index+1 + '. ' + e.guest_name + ', ';
                                if(e.guest_designation)
                                    str += e.guest_designation + ', ';
                                if(e.guest_affiliation)
                                    str += e.guest_affiliation + ', ';
                                if(e.address)
                                    str += e.address + ', ';
                                str += '<br>';
                            })
                            return str;
                        }
                    },
                    { title: 'Participants(College)', targets: target++,
                        "render":function(data, type, row, meta){
                            var str = '';
                            if(row.college_students)
                                str += 'student('+row.college_students+')<br>';
                            if(row.college_teachers)
                                str += 'Teachers('+row.college_teachers+')<br>';
                            if(row.college_nonteaching)
                                str += 'Non-Teaching('+row.college_nonteaching+')';
                            return str;
                        }
                    },
                    { title: 'Remarks', targets: target++, data: 'remarks'},
                    { title: 'Participant(Other)', targets: target++,
                        "render":function(data, type, row, meta){
                            var str = '';
                            if(row.outsider_students)
                                str += 'student('+row.outsider_students+')<br>';
                            if(row.outsider_teachers)
                                str += 'Teachers('+row.outsider_teachers+')<br>';
                            if(row.outsider_nonteaching)
                                str += 'Non-Teaching('+row.outsider_nonteaching+')';
                            return str;
                        }
                    },
                    { title: 'Remarks(Other)', targets: target++, data: 'other_remarks'},
                    { title: 'Short Report :', targets: target++, data: 'details'},
                    {visible: self.checkPermision(), title: 'Action', targets: target++, data: 'id',
                        "render":function(data, type, row, meta){
                            var str= '';
                            if(self.permissions['activities-modify']){
                                str += "<a href='"+self.url+data+"/edit' class='btn btn-primary'>Edit</a>";
                            }
                            if(self.permissions['activities-remove']){ 
                                str += "<a data-act-id="+row.id+" id='act"+row.id+"' data-act-action='act' class='btn activity iw-btn iw-btn-del mt-1 mb-2'>Delete</a>";
                            }
                                return str;
                        }
                    },
                ],
            });
        },

        checkPermision: function(){
            if(this.permissions['activities-modify'] == 'activities-modify'){
                return true;
            }else{
                return false;
            }
        },

        removeAct:function(id){
            var self= this;
            var status = confirm('Are you sure you want to delete this Activity ?');
            console.log(status);
            if(status){
                self.$http.delete(self.url+id)
                .then(function(response){
                    self.reloadTable();
                })
                .catch(function(error){

                })
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