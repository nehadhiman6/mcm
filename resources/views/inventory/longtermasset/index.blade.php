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
        {!! Form::open(['method' => 'GET',  'action' => ['Inventory\LongTermAssetController@index'], 'class' => 'form-horizontal']) !!}
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
                    {!! Form::label('item_id','Item:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-3">
                        {!! Form::select('item_id',getitems(),0,['class' => 'form-control select2item', 'v-model'=>'item_id']) !!}
                        <span id="basic-msg" class="text-danger">@{{ errors.item_id }}</span>
                    </div>

                    {!! Form::label('store_id','Store:',['class' => 'col-sm-1 control-label required'] ) !!}
                     <div class="col-sm-3">
                         {!! Form::select('store_id',getStoreLocations(),old('store_id',0), ['class' => 'form-control select2store', 'v-model'=>'store_id']) !!}
                         <span id="basic-msg" class="text-danger">@{{ errors.store_id }}</span>
                     </div>

                    {{-- {!! Form::label('loc_id','Location:',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-3">
                        {!! Form::select('loc_id',getLocations(),0,['class' => 'form-control select2']) !!}
                    </div> --}}
                </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData()']) !!}
    {!! Form::close() !!}
  </div>
</div>

<div class="box">
  <div class="box-header with-border">
        <h3 class="box-title">Long Term Asset List </h3>
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
        table: null,
        url: "{{ url('/') . '/long-term-asset/' }}",
        errors: {},
        getitems:{!! json_encode(getitems(true)) !!},
        getLocations:{!! json_encode(getLocations(true)) !!},
        getItemCategories:{!! json_encode(getItemCategories(true)) !!},
        getItemSubCategories:{!! json_encode(getItemSubCategories(true)) !!},
        title:'',
        store_name:'',
        item_name:'',
    },
    created:function(){
        var self = this;
        self.setTable();
        self.reloadTable();
        $('.select2item').select2({
            tags: "true",
            allowClear: true,
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
            allowClear: true,
            placeholder: 'Select Store'
        });
        $('.select2store').on('change',function(e){
            self.store_id = $(this).val();
        });
        $('.select2store').on('select2:select', function (e) {
            var data = e.params.data;
            self.store_name = data.text;
        });
        
       
    },

    methods:{
        getTitle:function(){
            return this.date_from+"  To  "+this.date_to +"   "+this.item_name +"    "+this.store_name;
        },
        getBlankRecord() {
            return {
                trans_date:'',
                vendor_detail:'',
                bill_details:'',
                qty:'',
                succ_tot:'',
                iss_from:'',
                iss_to:'',
                con_detail:'',
                qty_issue:'',
                bal_stock:'',
                remarks:''
            };
        },
        getData: function() {
            var self = this;
            var data = $.extend({}, {
                date_from: self.date_from,
                date_to: self.date_to,
                item_id: self.item_id,
                store_id: self.store_id,
                
            })
            self.$http.get("{{ url('long-term-asset') }}", {params: data})
            .then(function (response) {
                // console.log(response.data);
                var data = (typeof response.data) == "string" ? JSON.parse(response.data) : response.data;
                self.tData = [];
                var rec = {};
                var succ_tot = 0;
                var bal = 0;
                if(data.op_qty != 0) {
                    rec = self.getBlankRecord();
                    rec.trans_date = data.dtop;
                    rec.vendor_detail = 'Opening Stock';
                    rec.qty = data.op_qty;
                    succ_tot += data.op_qty*1;
                    bal = data.op_qty;
                    rec.succ_tot = succ_tot;
                    rec.bal_stock = bal;
                    self.tData.push(rec);
                }
                var lkey = 0;
                var rkey = 0;
                var ckey = 0;
                var dt1 = '';
                data.data.forEach(ele => {
                    if(dt1 == '' || dt1 != ele.trans_dt) {
                        dt1 = ele.trans_dt;
                        lkey = 0;
                        rkey = 0;
                    }
                    if((ele.type == 'P' && lkey == 0) || (ele.type == 'I' && rkey == 0)) {
                        rec = self.getBlankRecord();
                        ckey = 0;
                    } 
                    if(ele.type == 'P') {
                        if(lkey != 0) {
                            ckey = lkey;
                            rec = self.tData[lkey];
                        }
                        rec.trans_date = ele.trans_dt;
                        rec.vendor_detail = ele.vendor_name;
                        rec.bill_details = ele.bill_no;
                        rec.qty = ele.qty;
                        succ_tot += ele.qty*1;
                        bal = bal*1+ele.qty*1;
                        rec.succ_tot = succ_tot;
                        rec.bal_stock = bal;
                        if(ckey != 0) {
                            lkey++;
                            lkey = (self.tData.length-1 > lkey) ? lkey:0;
                        }
                    } else {
                        if(rkey != 0) {
                            ckey = rkey;
                            rec = self.tData[rkey];
                        }
                        rec.trans_date = ele.trans_dt;
                        rec.iss_from = ele.iss_from;
                        rec.iss_to = ele.iss_to;
                        rec.con_detail = ele.person;
                        rec.remarks = ele.remarks;
                        rec.qty_issue = ele.qty_iss;
                        bal = bal*1-ele.qty_iss*1;
                        rec.succ_tot = succ_tot;
                        rec.bal_stock = bal;
                        if(ckey != 0) {
                            rkey++;
                            rkey = (self.tData.length-1 > rkey) ? rkey:0;
                        }
                    }
                    if(ckey == 0) {
                        self.tData.push(rec);
                        if(ele.type == 'P' && rkey == 0) {
                            rkey = self.tData.length-1;
                        }
                        if(ele.type == 'I' && lkey == 0) {
                            lkey = self.tData.length-1;
                        }
                    } else {
                        self.tData[ckey] = rec;
                    }
                });
                self.reloadTable();
            })
            .catch(function(error){
                console.log(error.data);
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
                        //     return self.getTitle();
                        // },
                        
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
                // "ajax": {
                //     "url": '',
                //     "type": "GET",
                //     "data": function ( d ) {
                //             d.date_from = self.date_from;
                //             d.date_to = self.date_to;
                //         },
                // },
                "scrollX": true,
                columnDefs: [
                    { title: 'S.No.',targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            console.log(row);
                            return meta.row + 1;
                        }
                    },
                    { title: 'Transaction Date', targets: target++, data: 'trans_date'},
                    { title: 'Vendors Detail', targets: target++, data: 'vendor_detail'},
                    { title: 'Bill Details', targets: target++, data: 'bill_details'},
                    { title: 'Qty Purchased', targets: target++, data: 'qty'},
                    { title: 'Successive Total', targets: target++, data: 'succ_tot'},
                    { title: 'Issued From', targets: target++, data: 'iss_from'},
                    { title: 'Issued To', targets: target++, data: 'iss_to'},
                    { title: 'Concerned Per. Detail', targets: target++, data: 'con_detail'},
                    { title: 'Qty Issued', targets: target++, data: 'qty_issue'},
                    { title: 'Balance in Stock', targets: target++, data: 'bal_stock'},
                    { title: 'Remarks', targets: target++, data: 'remarks'},
                    
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
