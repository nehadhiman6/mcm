@extends('app')
@section('toolbar')
@include('toolbars._purchase_return_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">{{ isset($purchase) ? 'Update' : 'New' }} Purchase Return</h3>
  </div>
  <div class="box-body">

    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

    @include('inventory.pur_return._form', ['submitButtonText' => 'Add Purchase'])

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
      purchase: {!! isset($purchase) ? $purchase : 0 !!},
      base_url: "{{ url('/')}}",
      total_amount: 0,
    },

    ready: function() {
      var self = this;
     if(this.id > 0){
       this.editPurchase();
     }

      $('.select2').select2({
          placeholder: 'Select Vendors'
      });
      $('.select2').on('change',function(e){
          self.vendor_id = $(this).val();
      });
      // item
        setTimeout(function(){
          $('body').on('mouseenter', '.select2item', function () {
              $('.select2item').select2({
                  placeholder: 'Select'
              }).
              on('change', function(e){
                  self.purchase_det[e.target.id].item_id = e.target.value;
                  self.getCodeItem('item_id', e.target.id);
              });
          });
        },200);
    },
    
    methods: {
      addRowItems: function() {
        var length = this.purchase_det.length-1;
        if(this.purchase_det[length].amount == '' &&  length != 0){
          return;
        }
        this.purchase_det.push({
            id: 0,
            item_id: 0,
            item_desc: '',
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
            console.log(error);
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
            console.log(error);
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
          total_amount: self.total_amount,
          purchase_det: self.purchase_det 
        }
        self.$http.post("{{ url('purchase-returns') }}", form_data )
          .then(function(response) {
            this.saving = false;
            if(response.data.success) {
              if(response.data.id > 0){
                self.errors = {};
                window.location.href = self.base_url + '/purchase-returns';
              }else{
                self.resetForm();
              }
            }
            console.log(response.data);
          }, function(response) {
            self.errors = response.body;
            console.log(self.errors);

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
        self.trans_dt = self.purchase[0].trans_dt;
        self.bill_no = self.purchase[0].bill_no;
        self.bill_dt = self.purchase[0].bill_dt;
        self.vendor_id = self.purchase[0].vendor_id;
        $('.select2').val(self.vendor_id).trigger('change');
        self.trans_dt = self.purchase[0].trans_dt;
        self.store_id = self.purchase[0].store_id;
        self.vendor_code = self.purchase[0].vendor ? self.purchase[0].vendor.code : '';
        
        var tot_amt = 0;
        self.purchase[0].purchase_dets.forEach(function(e) {
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

      deleteRowItems: function(index) {
        var self = this;
        if(this.purchase_det.length > 1){
          self.purchase_det.splice(index,1);
        }

    },

    resetForm: function(){
        var self = this; 
        self.id= 0;
        self.trans_dt= moment(new Date()).format('DD-MM-YYYY');
        self.vendor_id= '';
        self.bill_no= '';
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
    }
  });
</script>
@endsection



