@extends('app')
@section('toolbar')
@include('toolbars._damage_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">{{ isset($damage) ? 'Update' : 'New' }} Damage</h3>
  </div>
  <div class="box-body">

    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

    @include('inventory.damage._form', ['submitButtonText' => 'Add Damage'])

    {!! Form::close() !!}
    
  </div>
</div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el: '#app1',
    data: {
      id: {!! isset($damage) ? $damage[0]->id : 0 !!},
      trans_dt: moment(new Date()).format('DD-MM-YYYY'),
      store_id:'',
      remarks: '',
      damage_det: [
        {
          id: 0,
          item_id: 0,
          item_desc: '',
          qty: '',
          code: '',
        }
      ],
      items: {!! getNewItems(true) !!} ,
      errors: {},
      damage: {!! isset($damage) ? $damage : 0 !!},
      base_url: "{{ url('/')}}",
    },

    ready: function() {
      var self = this;
     if(this.id > 0){
       this.editDamage();
     }
      // item
      setTimeout(function(){
          $('body').on('mouseenter', '.select2item', function () {
              $('.select2item').select2({
                  placeholder: 'Select'
              }).
              on('change', function(e){
                  self.damage_det[e.target.id].item_id = e.target.value;
                  self.getCodeItem('item_id', e.target.id);
              });
          });
      },200);
    },

    methods: {
      
      addRowItems: function() {
        var length = this.damage_det.length-1;
        if(this.damage_det[length].qty == '' &&  length != 0){
          return;
        }
        this.damage_det.push({
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
          this.$http.post("{{ url('get-item') }}",{item_code: this.damage_det[key].code})
          .then(function(response) {
            if(response.data.success) {
              if(response.data.item_id != null){
                self.damage_det[key].item_id = response.data.item_id;
                $('#'+key).val(self.damage_det[key].item_id).trigger('change');
              }else{
                alert('Item Code You Entered Is Incorrect !!');
              }
            }
          }, function(response) {
            self.errors = response.body;
        });
        }
        if(type == 'item_id'){

          this.$http.post("{{ url('get-item') }}", { item_id: self.damage_det[key].item_id} )
          .then(function(response) {
            if(response.data.success) {
              if(response.data.item_code != null){
                self.damage_det[key].code = response.data.item_code;
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
        var length = this.damage_det.length-1;
        if(this.damage_det[length].qty == '' &&  length != 0){
          self.damage_det.splice(length, 1)
        }
        var form_data = {
          id: self.id,
          trans_dt: self.trans_dt,
          store_id: self.store_id,
          remarks: self.remarks,
          damage_det: self.damage_det 
        }
        self.$http.post("{{ url('damages') }}", form_data )
          .then(function(response) {
            this.saving = false;
            if(response.data.success) {
              if(response.data.id > 0){
                self.errors = {};
                window.location.href = self.base_url + '/damages';
              }else{
                self.resetForm();
              }
            }
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

      editDamage: function(){
        var self = this;
        var row = [];
        self.damage_det= [];
        self.trans_dt = self.damage[0].trans_dt;
        self.store_id = self.damage[0].store_id;
        self.remarks = self.damage[0].remarks;
        self.damage[0].damage_dets.forEach(function(e) {
          row = {
            id: e.id,
            qty: e.qty,
            item_id: e.item_id,
            item_desc: e.item_desc,
            code: e.item ? e.item.item_code : '',
          };
          self.damage_det.push(row);
        });
      },

      deleteRowItems: function(index) {
        var self = this;
        if(this.damage_det.length > 1){
          self.damage_det.splice(index,1);
        }

    },

    resetForm: function(){
        var self = this; 
        self.id= 0;
        self.trans_dt= moment(new Date()).format('DD-MM-YYYY');
        self.remarks= '';
        self.damage_det = [];
        self.errors= {};
        self.damage=[];
        self.total_amount= 0;
        self.damage_det.push({
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



