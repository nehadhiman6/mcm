@extends('app')
@section('toolbar')
@include('toolbars.opening_stock_toolbar')
@stop
@section('content')
<div class="box box-info" id="app" v-cloak> 
  <div class="box-header with-border">
    <h3 class="box-title">New Opening Stock</h3>
  </div>
  {!! Form::open(['url' => 'opening-stocks', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
      @include('inventory.opening_stock._form', ['submitButtonText' => 'Add'])
    </div>
    <div class="box-footer">
      <button class="btn info-orange-btn" @click.prevent="submit()">Add Opening Stock</button>
    </div>
  {!! Form::close() !!}
</div>
@stop
@section('script')
<script>
  $('body').on('mouseenter', '.it_name', function () {
    $('.it_name').select2({
      placeholder: 'Select an option'
    });
    $('.it_name').on('change',function(e){
        vm.opening_det[e.target.id].item_id = $(this).val();
        vm.addRowItems();
    });
  });
    
  var vm = new Vue({
    el: '#app',
    data: {
      id: {!! isset($opening) ? $opening[0]->id : 0 !!},
      opening_det: [
        {
          id: 0,
          item_id: 0,
          r_qty: '',
          store_id:'',
        }
      ],
      items: {!! getNewItems(true) !!} ,
      errors: {},
      opening: {!! isset($opening) ? $opening : 0 !!},
      base_url: "{{ url('/')}}",
    },
    // ready: function() {
    //     $('.it_name').select2({
    //       placeholder: 'Select an option'
    //     });
    //     // $('.it_name0').on('change',function(e){
    //     //   console.log(vm.opening_det);
    //     //   vm.opening_det[0].item_id = $(this).val();
    //     //   console.log(e.target.id);
    //     // });
      
    // },

    methods: {
      addRowItems: function() {
        var length = this.opening_det.length-1;
          if(this.opening_det[length].item_id > 0 && this.opening_det[length].r_qty > 0 ||  length == 0){
          this.opening_det.push({
              id: 0,
              item_id: 0,
              r_qty : '',
              store_id:'',
          });
        }
      },

      submit: function() {
        var self = this;
        var length = this.opening_det.length-1;
        if(this.opening_det[length].item_id == 0 &&  length != 0){
          self.opening_det.splice(length, 1)
        }
        var form_data = {
          id: self.id,
          opening_det: self.opening_det 
        }
        self.$http.post("{{ url('opening-stocks') }}", form_data )
          .then(function(response) {
            this.saving = false;
            if(response.data.success) {
              if(response.data.id > 0){
                self.errors = {};
                window.location.href = self.base_url + '/opening-stocks';
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

      deleteRowItems: function(index) {
        var self = this;
        if(this.opening_det.length > 1){
          self.opening_det.splice(index,1);
        }

    },

    resetForm: function(){
        var self = this; 
        self.id= 0;
        self.opening_det = [];
        self.errors= {};
        self.opening=[];
        self.opening_det.push({
          id: 0,
          item_id: 0,
          r_qty: '',
          store_id: '',
        });
      },
      
    }
  });
</script>
@endsection



