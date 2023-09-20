@extends('app')

@section('toolbar')
  @include('toolbars.staff_report_toolbar')
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
        {!! Form::open(['method' => 'GET',  'action' => ['Reports\Staff\ResearchReportController@index'], 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('date_from','From:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('date_from',null,['class' => 'form-control app-datepicker', 'v-model'=>'date_from']) !!}
                        <span id="basic-msg" class="text-danger">@{{ errors.date_from }}</span>
                    </div>
                    {!! Form::label('date_to','To:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('date_to',null,['class' => 'form-control app-datepicker', 'v-model'=>'date_to']) !!}
                        <span id="basic-msg" class="text-danger">@{{ errors.date_to }}</span>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('faculty_id','Faculty',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-4">
                        <select class="form-control select2faculty" type="text" v-model="faculty_id" multiple="multiple">
                            <option v-for="(key,value) in faculty" :value="key">@{{value}}</option>
                            <!-- <option v-for="(value,key) in faculty" :value="key" :key="key">@{{ value.faculty }} </option> -->
                        </select>
                        <span v-if="hasError('faculty_id')" class="text-danger" v-html="errors['faculty_id'][0]"></span>
                    </div>
                    {!! Form::label('depart_id','Department',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-4">
                        <select class="form-control select2deprt" type="text" v-model="depart_id" multiple="multiple">
                            <!-- <option v-for="(key,value) in items" :value="key">@{{value}}</option> -->
                            <option v-for="value in deparments" :value="value.id" :key="value.id">@{{ value.name }} </option>
                        </select>
                        <span v-if="hasError('depart_id')" class="text-danger" v-html="errors['depart_id'][0]"></span>
                    </div>

                    
                </div>
                <div class='form-group' >
                    {!! Form::label('type','Types', ['class' => 'control-label col-sm-2'])!!} 
                    <div class="col-sm-4">
                        <select class="form-control select2type" type="text" v-model="type" multiple="multiple" >
                            <!-- <option v-for="(key,value) in items" :value="key">@{{value}}</option> -->
                            <option v-for="value in types" :value="value" :key="value">@{{ value }}</option>
                        </select>
                        <span id="basic-msg" v-if="errors['research.type']" class="help-block">@{{ errors['research.type'][0] }}</span>

                    </div>

                    {!! Form::label('indexing','Indexing',['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-4">
                            <select class="form-control select2" id='indexing'  multiple="multiple">
                                <option value="Scopus">Scopus</option>
                                <option value="Web of Science">Web of Science</option>
                                <option value="SCI">SCI</option>
                                <option value="ESCI">ESCI</option>
                                <option value="MEDLINE">MEDLINE</option>
                                <option value="Others">Others</option>
                            </select>
                            <span id="basic-msg" v-if="errors['indexing']" class="help-block">@{{ errors['indexing'][0] }}</span>
                            <span style="color:red;"> Multi Select *</span>
                        </div>
                </div>
                <div class='form-group' >
                    {!! Form::label('level','Level', ['class' => ' control-label col-sm-2'])!!}
                        <div class="col-sm-4" v-bind:class="{ 'has-error': errors['level'] }">
                            <select class="form-control select-form select2level" v-model="level" multiple="multiple">
                                <option value="International">International</option>
                                <option value="National">National</option>
                                <option value="State">State</option>
                                <option value="Local">Local</option>
                                <!-- <option value="Regional">Regional</option> -->
                            </select>
                            <span id="basic-msg" v-if="errors['level']" class="help-block">@{{ errors['level'][0] }}</span>
                        </div>
                        {!! Form::label('source','Nature of Appointment', ['class' => ' control-label col-sm-2'])!!}
                        <div class="col-sm-4">
                            {!! Form::select('source',getStaffSource(), null, array('required', 'class'=>'form-control select2source','v-model'=>'source','placeholder'=>'Select')) !!}
                            <span id="basic-msg" v-if="errors['source']" class="help-block">@{{ errors['source'][0] }}</span>
                        
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
        <h3 class="box-title">Research Report</h3>
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
        date_from: '',
        date_to: '',
        type:[],
        faculty_id:[],
        depart_id:[],
        table: null,
        url: "{{ url('/') . '/item-staff-loc-stock/' }}",
        errors: {},
        types: {!! getResearchType(true) !!} ,
        // deparments: {!! getDepartments(true) !!},
        faculty: {!! getFaculty(true) !!},
        indexing:'',
        level:[],
        deparments:[],
        // faculty:'',
        source:'',
        form_data: {!! json_encode($form_data) !!},
        staff_id:'0'
       

    },

    created:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
        if (self.form_data.length != 0) {
            self.date_to = self.form_data.as_on;
            self.date_from = self.form_data.date_to;
            self.staff_id = self.form_data.item_id;
            self.faculty_id.push(self.form_data.faculty_id);
            setTimeout(() => {
                $('.select2faculty').val(self.faculty_id).trigger('change');
            }, 300);
            // self.faculty_id.push(self.form_data.faculty_id);
            self.getData();
        }
        else{
            console.log(MCM.start_date,MCM.today);
            self.date_from = MCM.start_date;
            self.date_to = MCM.today;
        }

        $('.select2type').select2({
            placeholder: 'Select Type'
        });
        $('.select2type').on('change',function(e){
            self.type = $(this).val();
            
        });

        // $('.select2item').on('select2:select', function (e) {
        //     var data = e.params.data;
        //     self.item_name = data.text;
        // });

        $('.select2faculty').select2({
            placeholder: 'Select faculty',
        });
        $('.select2faculty').on('change',function(e){
            self.faculty_id = $(this).val();
            self.getDepart();
        });

        $('.select2deprt').select2({
            placeholder: 'Select Department',
        });
        $('.select2deprt').on('change',function(e){
            self.depart_id = $(this).val();
           
        });

        var select1 = $("#indexing")
            .select2({
                placeholder: "Multi Select",
                width:"100%",
            })
            .on("change", function(e) {
				// console.log(e);
				var stt = $("#indexing").val();
				
				self.indexing = stt.join();
				
			});

            $('.select2level').select2({
                placeholder: 'Select level'
            });
            $('.select2level').on('change',function(e){
                self.level = $(this).val();
                
            });

            $('.select2source').select2({
                placeholder: 'Select Department',
                tags: "true",
                allowClear: true,
            });
            $('.select2source').on('change',function(e){
                self.source = $(this).val();
            
            });
        

           
       
       
    },

    methods:{
        getDepart:function () {
                var self = this;
                axios.get('depart-list',{params:{faculty_id: self.faculty_id}})
                .then(function (response) {
                    if(response.data){
                        console.log(response);
                        self.deparments = response.data.depart;
                        
                    }
                })
            },
        // getTitle:function(){
        //     return this.date_from+"  To  "+this.date_to +"   "+this.item_name +"    "+this.store_name +"    "+this.staff_name;
        // },
        
        getData: function() {
            var self = this;
            var data = $.extend({}, {
                date_from: self.date_from,
                date_to: self.date_to,
                type: self.type,
                faculty_id:self.faculty_id,
                depart_id:self.depart_id,
                indexing:self.indexing,
                level:self.level,
                source:self.source,
                staff_id:self.staff_id,

                
            })
            self.$http.get("{{ url('research-report') }}", {params: data})
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
                    { title: 'Name of Teacher', targets: target++, data: 'name'},
                    { title: 'Department', targets: target++, data: 'depart_name'},
                    { title: 'Nature of Appointment', targets: target++, data: 'source'},
                    { title: 'Type', targets: target++, data: 'type'},
                    { title: 'Title of Book/BookChapter/Journal/Conf.Paper', targets: target++, data: 'title'},
                    { title: 'Title of Paper', targets: target++, data: 'paper_title'},
                    { title: 'Title of Proceedings of the conference', targets: target++, data: 'title_pro'},
                    { title: 'Level', targets: target++, data: 'level'},
                    { title: 'Publisher', targets: target++, data: 'publisher'},
                    { title: 'Month&Year of Publication', targets: target++, data:'month_year' },
                    { title: 'Mode of Publication', targets: target++, data: 'mode'},
                    { title: 'ISBN/ISSN', targets: target++, data:'isbn' },
                    { title: 'Authorship', targets: target++, data: 'authorship'},
                    { title: 'Affilating Institute', targets: target++, data:'institute' },
                    { title: 'UGC Approved', targets: target++, data: 'ugc_approved'},
                    { title: 'Peer Reviewed', targets: target++, data:'peer_review' },
                    { title: 'Indexing', targets: target++, data: 'indexing'},
                    { title: 'DOI No.', targets: target++, data:'doi_no' },
                    { title: 'Impact Factor', targets: target++, data: 'impact_factor'},
                    { title: 'Citations (Excluding self-citations)', targets: target++, data:'citations' },
                    { title: 'H-index', targets: target++, data:'h_index' },
                    { title: 'i10 index', targets: target++, data:'i10_index' },
                    { title: 'Award (if any)', targets: target++, data:'res_award' },
                    { title: 'Relevent link', targets: target++, data:'relevant_link' },
                   
                ],
            });
        },
        // reloadTable: function() {
        //     var self = this;
        //     self.table.ajax.reload();
        // },

        reloadTable: function() {
            var self = this;
            this.table.clear();
            this.table.rows.add(this.tData).draw();
        },

        
    }

    
});
</script>
@stop
