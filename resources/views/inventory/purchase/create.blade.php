@extends('app')
@section('toolbar')
@include('toolbars._purchase_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">{{ isset($purchase) ? 'Update' : 'New' }} Purchase</h3>
  </div>
  <div class="box-body">

    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

    @include('inventory.purchase._form', ['submitButtonText' => 'Add Purchase'])

    {!! Form::close() !!}
    
  </div>
</div></div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el: '#app1',
    data: {
      id: {!! isset($purchase) ? $purchase[0]->id : 0 !!},
      trans_dt: moment(new Date()).format('DD-MM-YYYY'),
      vendor_id: '',
      store_id: '',
      bill_no: '',
      bill_dt: '',
      vendor_code: '',
      grant:'',
      purchase_det: [
        {
          id: 0,
          item_id: 0,
          item_desc: '',
          qty: '',
          rate: '',
          amount: '',
          code: '',
        }
      ],
      items: {!! getNewItems(true) !!} ,
      errors: {},
      purchase: {!! isset($purchase) ? $purchase[0] : 0 !!},
      base_url: "{{ url('/')}}",
      total_amount: 0,

    },

    ready: function() {
        var self = this;
        if(this.id > 0){
            this.editPurchase();
        }
        this.addRowItems();
        
        $('.select2').select2({
            placeholder: 'Select'
        });
        $('.select2').on('change',function(e){
            self.vendor_id = $(this).val();
        });

        setTimeout(function(){
            $('body').on('mouseenter', '.select2item', function () {
                $('.select2item').select2({
                    placeholder: 'Select'
                }).
                on('change', function(e){
                    self.purchase_det[e.target.id].item_id = e.target.value;
                    console.log(self.purchase_det[e.target.id].item_id );
                    self.getCodeItem('item_id', e.target.id);
                });
            });
        },200);
    },

    methods: {      
        addRowItems: function() {
            var self = this;
            var length = self.purchase_det.length-1;
            if(self.purchase_det[length].amount == '' &&  length == 0){
            return;
            }
            self.purchase_det.push({
                id: 0,
                item_id: 0,
                item_desc:'',
                qty : '',
                rate: '',
                amount: '',
                code: '',
            });       
        },

        getCodeItem: function(type, key){
            var self = this;
            if(type == 'item_code'){
                this.$http.post("{{ url('get-item') }}",{item_code: this.purchase_det[key].code})
                .then(function(response) {
                    if(response.data.success) {
                        if(response.data.item_id != null){
                            self.purchase_det[key].item_id = response.data.item_id;
                            $('#'+key).val(self.purchase_det[key].item_id).trigger('change');
                        }else{
                            alert('Item Code You Entered Is Incorrect !!');
                        }
                    }
                }, function(response) {
                    self.errors = response.body;
                });
            }
            if(type == 'item_id'){
                this.$http.post("{{ url('get-item') }}", { item_id: self.purchase_det[key].item_id} )
                .then(function(response) {
                    if(response.data.success) {
                    if(response.data.item_code != null){
                        self.purchase_det[key].code = response.data.item_code;
                    }else{
                        alert('Item Id You Entered Is Incorrect !!');
                    }
                    }
                }, function(error) {
                    self.errors = error;
                });
            }
        },

        getCodeVendor: function(type){
            var self = this;
            if(type == 'vendor_code'){
            this.$http.post("{{ url('get-vendor') }}",{vendor_code: this.vendor_code})
            .then(function(response) {
                if(response.data.success) {
                if(response.data.vendor_id != null){
                    self.vendor_id = response.data.vendor_id;
                }else{
                    alert('Vendor Code You Entered Is Incorrect !!');
                }
                }
            }, function(response) {
                self.errors = response.body;
            });
            }
            if(type == 'vendor_id'){

            this.$http.post("{{ url('get-vendor') }}", { vendor_id: this.vendor_id} )
            .then(function(response) {
                if(response.data.success) {
                if(response.data.vendor_code != null){
                    self.vendor_code = response.data.vendor_code;
                }else{
                    alert('Vendor Id You Entered Is Incorrect !!');
                }
                }
            }, function(error) {
                self.errors = error;
            });
            }
        },

        submit: function() {
            var self = this;
            var length = this.purchase_det.length-1;
            if(this.purchase_det[length].amount == '' &&  length != 0){
            self.purchase_det.splice(length, 1)
            }
            var form_data = {
            id: self.id,
            trans_dt: self.trans_dt,
            vendor_id: self.vendor_id,
            store_id: self.store_id,
            bill_no: self.bill_no,
            bill_dt: self.bill_dt,
            grant: self.grant,
            total_amount: self.total_amount,
            purchase_det: self.purchase_det 
            }
            self.$http.post("{{ url('purchases') }}", form_data )
            .then(function(response) {
                this.saving = false;
                if(response.data.success) {
                if(response.data.prchase_id > 0){
                    self.errors = {};
                    window.location.href = self.base_url + '/purchases';
                }else{
                    self.resetForm();
                }
                }
            }, 
            function(response) {
                self.errors = response.body;
            });
        },

        hasError: function(fld) {
            var error = [];
            error = false;
            $.each(Object.keys(this.errors), function(i, v) {
                if (fld == v) {
                error = true;
                }
            });
            return error;
        },

        editPurchase: function(){
            var self = this;
            var row = [];
            self.purchase_det= [];

            self.trans_dt = self.purchase.trans_dt;
            self.bill_no = self.purchase.bill_no;
            self.grant = self.purchase.grant;
            self.bill_dt = self.purchase.bill_dt;
            self.vendor_id = self.purchase.vendor_id;
            $('.select2').val(self.vendor_id).trigger('change');
            self.trans_dt = self.purchase.trans_dt;
            self.store_id = self.purchase.store_id;
            self.vendor_code = self.purchase.vendor ? self.purchase.vendor.code : '';
            
            
            var tot_amt = 0;
            if(self.purchase.purchase_dets.length > 0){
                self.purchase.purchase_dets.forEach(function(e,key) {
                    row = {
                        id: e.id,
                        qty: e.qty,
                        item_id: e.item_id,
                        item_desc: e.item_desc,
                        rate: e.rate,
                        amount: e.qty * e.rate,
                        code: e.item ? e.item.item_code : '',
                    };
                    tot_amt = tot_amt + row.amount;
                    self.purchase_det.push(row);
                });
            }           
            else{
            row = {
                id: 0,
                item_id: 0,
                item_desc: '',
                qty: '',
                rate: '',
                amount: '',
                code: '',
            };
            tot_amt = tot_amt + row.amount;
            self.purchase_det.push(row);
            }
            self.total_amount = tot_amt;
        },
        
        getAmount: function(key){
            var self = this;
            this.purchase_det[key].amount = self.purchase_det[key].qty * self.purchase_det[key].rate; 
            var tot_amt = 0;
            self.purchase_det.forEach(function(e) {
            tot_amt = tot_amt + e.amount;
            });
            self.total_amount = tot_amt;
            if(this.purchase_det[key].amount > 0){
            self.addRowItems();
            }
        },

        resetForm: function(){
            var self = this; 
            self.id= 0;
            self.trans_dt= moment(new Date()).format('DD-MM-YYYY');
            self.vendor_id= '';
            $('.select2').val(self.vendor_id).trigger('change');
            self.bill_no= '';
            self.store_id =0;
            self.grant= 0;
            self.bill_dt= '';
            self.vendor_code= '';
            self.purchase_det = [];
            self.errors= {};
            self.purchase=[];
            self.total_amount= 0;
            self.purchase_det.push({
                id: 0,
                item_id: 0,
                item_desc:'',
                qty : '',
                rate: '',
                amount: '',
                code: '',
            });
        },

        deleteRowItems: function(index) {
            var self = this;
            if(this.purchase_det.length > 1){
            self.purchase_det.splice(index,1);
            self.getAmount(index);
            self.addRowItems();
            }

        },
    }
  });
</script>
@endsection



