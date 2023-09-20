@extends('app')

@section('toolbar')
  @include('toolbars._inventory_reports')
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
        {!! Form::open(['method' => 'GET',  'action' => ['Inventory\ItemStaffLocWiseStockController@index'], 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('date_from','From:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('date_from',startDate(),['class' => 'form-control app-datepicker', 'v-model'=>'date_from']) !!}
                        <span id="basic-msg" class="text-danger">@{{ errors.date_from }}</span>
                    </div>
                    {!! Form::label('date_to','To:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('date_to',today(),['class' => 'form-control app-datepicker', 'v-model'=>'date_to']) !!}
                        <span id="basic-msg" class="text-danger">@{{ errors.date_to }}</span>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('item_id','Item:',['class' => 'col-sm-2 control-label ']) !!}
                     <div class="col-sm-4">
                         {!! Form::select('item_id',getItems(),old('item_id',0), ['class' => 'select2item form-control', "data-allow-clear" => "true",'v-model'=>'item_id']) !!}
                         <span id="basic-msg" class="text-danger">@{{ errors.item_id }}</span>
                    </div>

                     {!! Form::label('type','Staff',['class' => 'col-sm-1 control-label ']) !!}
                        <div class="col-sm-4">
                            <select class="form-control select2staff" type="text" v-model="staff_id" >
                                <option value="0" selected>Select</option> 
                                <option v-for="value in staff" :value="value.id" :key="value.id">@{{ value.name }}  @{{ value.middle_name }}  @{{ value.last_name }}       ( @{{ value.dept.name }} )    </option>
                            </select>
                            <span v-if="hasError('staff_id')" class="text-danger" v-html="errors['staff_id'][0]"></span>
                        </div>
                </div>
                <div class='form-group' >
                    <!-- {!! Form::label('Type',"Type:",['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        <label class="radio-inline">
                            {!! Form::radio('radio_button', 'Y',null, ['class' => 'minimal','v-model'=>'radio_button', 'id' => 'radio_button_1', '@change' => "update"]) !!}Store
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('radio_button', 'N',null, ['class' => 'minimal','v-model'=>'radio_button', 'id' => 'radio_button_2', '@change' => "update"]) !!}Location
                        </label>
                    </div> -->
                    {!! Form::label('store_id','Store:',['class' => 'col-sm-2 control-label required'] ) !!}
                     <div class="col-sm-3">
                         {!! Form::select('store_id',getStoreLocations(),old('store_location_id',0), ['class' => 'form-control select2store','v-model' => 'store_id']) !!}
                         <span id="basic-msg" class="text-danger">@{{ errors.store_id }}</span>
                     </div>
                    <div>
                        {!! Form::label('loc_id','Location:',['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3 ">{{--v-if="radio_button == 'N'"--}}
                            {!! Form::select('loc_id',getLocations(),old('loc_id',0), ['class' => 'form-control selectlac','v-model' => 'loc_id', "data-allow-clear" => "true"]) !!}
                        </div>
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
        <h3 class="box-title">Item/Staff/Location Wise Stock Report</h3>
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
        item_id:'',
        store_id:'',
        loc_id:'',
        table: null,
        url: "{{ url('/') . '/item-staff-loc-stock/' }}",
        errors: {},
        staff_id:0,
        staff: {!! getNewStaff(true) !!} ,
        getitems:{!! json_encode(getitems(true)) !!},
        getLocations:{!! json_encode(getLocations(true)) !!},
        getItemCategories:{!! json_encode(getItemCategories(true)) !!},
        getItemSubCategories:{!! json_encode(getItemSubCategories(true)) !!},
        item_name:'',
        store_name:'',
        staff_name:'',
        loc_name:''


    },

    created:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
        $('.select2item').select2({
            placeholder: 'Select Items'
        });
        $('.select2item').on('change',function(e){
            self.item_id = $(this).val();
        });

        $('.select2item').on('select2:select', function (e) {
            var data = e.params.data;
            self.item_name = data.text;
        });

        $('.select2store').select2({
            tags: "true",
            placeholder: 'Select Store',
            allowClear: true
        });
        $('.select2store').on('change',function(e){
            self.store_id = $(this).val();
        });

        $('.select2store').on('select2:select', function (e) {
            var data = e.params.data;
            self.store_name = data.text;
        });

        $('.select2staff').select2({
            tags: "true",
            placeholder: 'Select Staff',
            allowClear: true
        });
        $('.select2staff').on('change',function(e){
            self.staff_id = $(this).val();
        });
        $('.select2staff').on('select2:select', function (e) {
            var data = e.params.data;
            self.staff_name = data.text;
        });

        $('.selectlac').select2({
            tags: "true",
            placeholder: 'Select location',
            allowClear: true
        });
        $('.selectlac').on('change',function(e){
            self.loc_id = $(this).val();
        
        });
        $('.selectlac').on('select2:select', function (e) {
            var data = e.params.data;
            self.loc_name = data.text;
        });
       
    },

    methods:{
        getTitle:function(){
            return this.date_from+"  To  "+this.date_to +"   "+this.item_name +"  -  "+this.store_name+"  -  "+this.loc_name +"    "+this.staff_name;
        },
        
        getData: function() {
            var self = this;
            var data = $.extend({}, {
                date_from: self.date_from,
                date_to: self.date_to,
                item_id: self.item_id,
                store_id: self.store_id,
                staff_id: self.staff_id,
                loc_id: self.loc_id
                
            })
            self.$http.get("{{ url('item-staff-loc-stock') }}", {params: data})
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
                        messageTop: function () {
                            return self.title;
                        },
                        
                    },

                    {
                        
                        header: true,
                        footer: true,
                        extend: 'pdfHtml5',
                        download: 'open',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title: function () {
                                var title = '';
                                // title += "Stock Register Report    ";
                                title = self.getTitle();
                                return title;
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
                    { title: 'Location Name', targets: target++, data: 'location'},
                    { title: 'Item name', targets: target++, data: 'item'},
                    { title: 'Staff name', targets: target++,
                        "render": function( data, type, row, meta) {
                            var middle_name = row.middle_name == null ? '' : row.middle_name ;
                            var first_name = row.first_name == null ? '' : row.first_name ;
                            var last_name = row.last_name == null ? '' : row.last_name ;
                            return first_name+' '+middle_name+' '+ last_name;
                        }
                    },
                    { title: 'Desig', targets: target++, data: 'desig'},
                    { title: 'Dept', targets: target++, data: 'dept'},
                    { title: 'Req for', targets: target++, data: 'req_for'},
                    { title: 'Description', targets: target++, data: 'description'},
                    { title: 'Qty', targets: target++, data:'qty' },
                   
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
