@extends('app')
@section('toolbar')
@include('toolbars._ret_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">{{ isset($ret) ? 'Update' : 'New' }} Return</h3>
  </div>
  <div class="box-body">

    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

    @include('inventory.inv_return._form', ['submitButtonText' => 'Add ret'])

    {!! Form::close() !!}
    
  </div>
</div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el: '#app1',
    data: {
      id: {!! isset($ret) ? $ret[0]->id : 0 !!},
      trans_dt: moment(new Date()).format('DD-MM-YYYY'),
      loc_id: '',
      remarks: '',
      store_id:'',
      staff_id:0,
      ret_det: [
        {
          id: 0,
          item_id: 0,
          item_desc: '',
          qty: '',
          code: '',
        }
      ],
      items: {!! getNewItems(true) !!} ,
      staff: {!! getNewStaff(true) !!} ,
      errors: {},
      ret: {!! isset($ret) ? $ret : 0 !!},
      base_url: "{{ url('/')}}",
    },

    ready: function() {
      var self = this;
      if(this.id > 0){
        this.editRet();
      }
      $('.select2').select2({
        placeholder: 'Select Location',
      });
      $('.select2').on('change',function(e){
        self.loc_id = $(this).val();
      });

      $('.select2staff').select2({
          placeholder: 'Select Staff',
          tags: "true",
          allowClear: true,
      });
      $('.select2staff').on('change',function(e){
        self.staff_id = $(this).val();
      });
      // item
      setTimeout(function(){
        $('body').on('mouseenter', '.select2item', function () {
            $('.select2item').select2({
                placeholder: 'Select'
            }).
            on('change', function(e){
                self.ret_det[e.target.id].item_id = e.target.value;
                self.getCodeItem('item_id', e.target.id);
            });
        });
      },200);
    },

    methods: {
      
      addRowItems: function() {
        var length = this.ret_det.length-1;
        if(this.ret_det[length].qty == '' &&  length != 0){
          return;
        }
        this.ret_det.push({
            id: 0,
            item_id: 0,
            item_desc:'',
            qty : '',
            amount: '',
            code: '',
        });
        
      },

      getCodeItem: function(type, key){
        var self = this;
        if(type == 'item_code'){
          this.$http.post("{{ url('get-item') }}",{item_code: this.ret_det[key].code})
          .then(function(response) {
            if(response.data.success) {
              if(response.data.item_id != null){
                self.ret_det[key].item_id = response.data.item_id;
                $('#'+key).val(self.ret_det[key].item_id).trigger('change');
              }else{
                alert('Item Code You Entered Is Incorrect !!');
              }
            }
          }, function(response) {
            self.errors = response.body;
        });
        }
        if(type == 'item_id'){

          this.$http.post("{{ url('get-item') }}", { item_id: self.ret_det[key].item_id} )
          .then(function(response) {
            if(response.data.success) {
              if(response.data.item_code != null){
                self.ret_det[key].code = response.data.item_code;
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

      submit: function() {
        var self = this;
        var length = this.ret_det.length-1;
        if(this.ret_det[length].qty == '' &&  length != 0){
          self.ret_det.splice(length, 1)
        }
        var form_data = {
          id: self.id,
          trans_dt: self.trans_dt,
          loc_id: self.loc_id,
          store_id: self.store_id,
          staff_id: self.staff_id,
          remarks: self.remarks,
          ret_det: self.ret_det 
        }
        self.$http.post("{{ url('returns') }}", form_data )
          .then(function(response) {
            this.saving = false;
            if(response.data.success) {
              if(response.data.id > 0){
                self.errors = {};
                window.location.href = self.base_url + '/returns';
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

      editRet: function(){
        var self = this;
        var row = [];
        self.ret_det= [];
        self.trans_dt = self.ret[0].trans_dt;
        self.loc_id = self.ret[0].loc_id;
        $('.select2').val(self.loc_id).trigger('change');
        self.store_id = self.ret[0].store_id;
        self.staff_id = self.ret[0].staff_id;
        console.log(self.staff_id);
        $('.select2staff').val(self.staff_id).trigger('change');
        // $('.select2staff').val(self.staff_id).trigger('change');
        self.remarks = self.ret[0].remarks;               
        self.ret[0].ret_dets.forEach(function(e) {
          row = {
            id: e.id,
            qty: e.qty,
            item_id: e.item_id,
            item_desc: e.item_desc,
            code: e.item ? e.item.item_code : '',
          };
          self.ret_det.push(row);
        });
      },

      deleteRowItems: function(index) {
        var self = this;
        if(this.ret_det.length > 1){
          self.ret_det.splice(index,1);
        }

    },

    resetForm: function(){
        var self = this; 
        self.id = 0;
        self.trans_dt= moment(new Date()).format('DD-MM-YYYY');
        self.loc_id = '';
        $('.select2').val(self.loc_id).trigger('change');
        self.staff_id = 0;
        $('.select2staff').val(0).trigger('change');
        self.staff_id = 0;
        self.store_id ='';
        self.remarks = '';
        self.ret_det = [];
        self.errors= {};
        self.ret=[];
        self.total_amount= 0;
        self.ret_det.push({
          id: 0,
          item_id: 0,
          item_desc: '',
          qty: '',
          code: '',
        });
      },
      
    }
  });
</script>
@endsection



