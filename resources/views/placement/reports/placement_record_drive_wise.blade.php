@extends('app')

@section('toolbar')
  @include('toolbars.placement_report_toolbar')
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
    {!! Form::open(['method' => 'GET',  'action' => ['Reports\Placement\PlacementRecordDriveWiseReportController@index'], 'class' => 'form-horizontal']) !!}
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('year','Year',['class' => 'col-sm-1 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::select('year',['20182019'=>'2018-2019','20192020'=>'2019-2020','20202021'=>'2020-2021','20212022'=>'2021-2022','20222023'=>'2022-2023'],null,['class' => 'form-control','v-model'=>'year']) !!}
            </div>

            {!! Form::label('comp_id','Company:',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-4">
                {!! Form::select('comp_id',getCompanies(),null, ['class' => 'form-control comp_id','v-model'=>'comp_id']) !!}
                <span v-if="hasError('comp_id')" class="text-danger" v-html="errors['comp_id'][0]"></span>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData()']) !!}
        {!! Form::close() !!}
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Placement Record(Drive wise)</h3>
        </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive iw-table">
            <table id="activity" class="table table-bordered " width="100%">
            </table>
        </div>
    </div>

</div>
@stop

@section('script')
<script>
var vm = new Vue({
    el:"#filter",
    data:{
        tData:[],
        year:'',
        type:[],
        course_id:'',
        comp_id:'',
        table: null,
        url: "{{ url('/') . '/placement-drive-wise-report/' }}",
        errors: {},
        base_url: "{{ url('/')}}",
    },

    created:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
        $('.select2Course').select2({
            placeholder: 'Select'
        });
        $('.select2Course').on('change',function(e){
            self.type = $(this).val();
            
        });

        $(document).on('click', '.show-file', (function() {
                self.showImage($(this).data('place-id'));
        }));

        // $('.select2faculty').select2({
        //     placeholder: 'Select faculty',
        //     tags: "true",
        //     allowClear: true,
        // });
        // $('.select2faculty').on('change',function(e){
        //     self.faculty_id = $(this).val();
        //     self.getDepart();
        // });

       
    },

    methods:{

        getData: function() {
            var self = this;
            var data = $.extend({}, {
                year: self.year,
                comp_id:self.comp_id,
            })
            self.$http.get("{{ url('placement-drive-wise-report') }}", {params: data})
            .then(function (response) {
                // console.log(response.data);
                self.tData = (typeof response.data) == "string" ? JSON.parse(response.data) : response.data;
                self.reloadTable();
            })
            .catch(function(error){
                self.errors = error.data;
            })
        },

        setTable:function(){
            var self= this;
            var target = 0;
            self.table = $('#activity').DataTable({
                dom: 'Bfrtip',
                ordering:        true,
                scrollY:        "300px",
                scrollX:        true,
                scrollCollapse: true,
                pageLength:    10,
                paging:         true,
                // fixedColumns:   {
                //     rightColumns: 1,
                //     leftColumns: 1
                // },
                processing: true,
                data: [],
                // "ajax": {
                //     "url": '',
                //     "type": "GET",
                //     "data": function ( d ) {
                //             d.date_from = self.date_from;
                //             d.date_to = self.date_to;
                //         },
                // },
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
                        // orientation: 'landscape',
                        // pageSize: 'LEGAL',
                        // title: function () {
                        //         var title = '';
                        //         // title += "Stock Register Report    ";
                        //         title = self.getTitle();
                        //         return title;
                        // },
                        
                    
                    }
                ],
                "scrollX": true,
                columnDefs: [
                    { title: 'S.No.',targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { title: 'Session', targets: target++, data: 'session'},
                    { title: 'Company Name', targets: target++, data: 'comp_name'},
                    { title: 'Drive Date', targets: target++, data: 'drive_date'},
                    { title: 'Company Personnel Name & Designation', targets: target++, data: 'per_desig'},
                    { title: 'Company Personnel Phone Number', targets: target++, data: 'phone'},
                    { title: 'Company Personnel Email Address', targets: target++, data: 'email'},
                    { title: 'No. of Registered Students', targets: target++, data: 'reg_stu'},
                    { title: 'No. of Appeared students', targets: target++, data:'ap'},
                    { title: 'No. of Shortlisted Students', targets: target++, data:'tot_sl'
                    },
                    { title: 'No. of Selected Students', targets: target++,data:'sel'
                     },
                    { title: 'Turnover of the Company', targets: target++, data: 'comp_turnover'},
                    { title: 'Address of the Company', targets: target++, data:'comp_add' },
                    { title: 'Type', targets: target++, data: 'type'},
                    { title: 'Nature of company', targets: target++, data:'comp_nature' },
                    { title: 'Drive atachment', targets: target++,  "render": function( data, type, row, meta) {
                        var str="";
                        if(row.resourceable_id){
                            str += '<a href="#" class="show-file" data-place-id="'+row.place_id+'">Attachment</a>'

                        }

                        return str;
                    }},
                ],
            });
        },
        // reloadTable: function() {
        //     var self = this;
        //     self.table.ajax.reload();
        // },

        showImage: function(id) {
            console.log(id);
            self = this;
            window.open(self.base_url+'/upload-thumbnail/'+id,'_blank');
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
