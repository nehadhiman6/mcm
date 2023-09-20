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
        {!! Form::open(['method' => 'GET',  'action' => ['Reports\Placement\PlacementRecordStdWiseReportController@index'], 'class' => 'form-horizontal']) !!}
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('year','Year',['class' => 'col-sm-1 control-label required']) !!}
                <div class="col-sm-3">
                    {!! Form::select('year',['20182019'=>'2018-2019','20192020'=>'2019-2020','20202021'=>'2020-2021','20212022'=>'2021-2022','20222023'=>'2022-2023'],null,['class' => 'form-control','v-model'=>'year']) !!}
                    <span id="basic-msg" class="text-danger">@{{ errors.year }}</span>
                </div>

                {!! Form::label('comp_id','Company:',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::select('comp_id',getCompanies(),null, ['class' => 'form-control comp_id','v-model'=>'comp_id']) !!}
                    <span v-if="hasError('comp_id')" class="text-danger" v-html="errors['comp_id'][0]"></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('course_id','Class',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
                </div>
                {!! Form::label('type','Type of Drive ',['class' => 'col-sm-2 control-label ']) !!}
                <div class="col-sm-4">
                    <select class="form-control select-form" v-model="type" v-bind:class="{ 'has-error': errors['type'] }">
                            <option value="P">Placement Drive</option>
                            <option value="I">Internship Program</option>
                            <option value="A">All</option>
                        </select>
                    <span v-if="hasError('type')" class="text-danger" v-html="errors['type'][0]"></span>
                </div>
            </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData()']) !!}
    {!! Form::close() !!}
  </div>
</div>

<div class="box">
  <div class="box-header with-border">
        <h3 class="box-title">Placement Record(Student wise)</h3>
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
        type:'A',
        course_id:'',
        comp_id:'',
        table: null,
        url: "{{ url('/') . '/placement-std-wise-report/' }}",
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

        // $('.select2faculty').select2({
        //     placeholder: 'Select faculty',
        //     tags: "true",
        //     allowClear: true,
        // });
        // $('.select2faculty').on('change',function(e){
        //     self.faculty_id = $(this).val();
        //     self.getDepart();
        // });

            $(document).on('click', '.show-file', (function() {
                    self.showImage($(this).data('place-std-id'));
            }));

       
    },

    methods:{

        getData: function() {
            var self = this;
            var data = $.extend({}, {
                year: self.year,
                course_id: self.course_id,
                comp_id:self.comp_id,
                type:self.type
                
                
            })
            self.$http.get("{{ url('placement-std-wise-report') }}", {params: data})
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
                    { title: 'Student Name', targets: target++, data: 'name'},
                    { title: 'Stream/ Class', targets: target++, data: 'class'},
                    { title: 'Roll Number', targets: target++, data: 'roll_no'},
                    { title: 'Drive Date', targets: target++, data: 'date'},
                    { title: 'Student Session', targets: target++, data: 'session'},
                    { title: 'Company Name', targets: target++, data: 'comp_name'},
                    { title: 'Package Offered', targets: target++, data: 'pack_offer'},
                    { title: 'Post Offered', targets: target++, data:'post' },
                    { title: 'Letter Type', targets: target++, data: 'letter_type',
                        "render": function( data, type, row, meta) {
                            var str = '';
                            if(data == "O"){
                                str +=  'Offer Letter';
                            }
                            else if(data == "E"){
                                str +=  'Selection E-Mail';
                            }
                            
                            return str;
                        }
                    },
                    // { title: 'Selection E-Mail', targets: target++, data:'sel_email' },
                    { title: 'Nature of Drive(Off campus/On campus)', targets: target++, data: 'nature_drive'},
                    { title: 'Whether Placement Drive/Internship Program', targets: target++, data:'wether', 
                        "render": function( data, type, row, meta) {
                            return data == "I" ? 'Internship' : 'Placement';
                        }},
                    { title: 'Minimum Salary Offered', targets: target++, data: 'mini_salary'},
                    { title: 'Maximum Salary Offered', targets: target++, data:'max_salary' },
                    { title: 'Student Contact Details', targets: target++, data: 'contact_detail'},
                    { title: 'Student Email', targets: target++, data:'email' },
                    { title: 'Offer letter(attachment)', targets: target++,  "render": function( data, type, row, meta) {
                        var str="";
                        if(row.resourceable_id){
                            str += '<a href="#" class="show-file" data-place-std-id="'+row.place_std_id+'">Attachment</a>'

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
