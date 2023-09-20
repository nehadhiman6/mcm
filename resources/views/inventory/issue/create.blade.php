@extends('app')
@section('toolbar')
@include('toolbars._issue_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">{{ isset($issue) ? 'Update' : 'New' }} Issue</h3>
  </div>
  <div class="box-body">

    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

    @include('inventory.issue._form', ['submitButtonText' => 'Add Issue'])

    {!! Form::close() !!}
  </div>
</div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el: '#app1',
    data: {
      id: {!! isset($issue) ? $issue[0]->id : 0 !!},
      issue_dt: moment(new Date()).format('DD-MM-YYYY'),
      loc_id: '',
      person: '',
      staff_id:0,
      remarks: '',
      request_no: '',
      store_id: '',
      issue_det: [
        {
          id: 0,
          item_id: 0,
          req_qty: '',
          req_for: '',
          description: ''
        }
      ],
      items: {!! getNewItems(true) !!} ,
      staff: {!! getNewStaff(true) !!} ,
      errors: {},
      issue: {!! isset($issue) ? $issue : 0 !!},
      base_url: "{{ url('/')}}"
    },

    ready: function() {
      var self = this;
      if(this.id > 0){
        this.editIssue();
      }
      $('.select2').select2({
          placeholder: 'Select Location'
      });
      $('.select2').on('change',function(e){
        self.loc_id = $(this).val();
      });    

      $('.select2staff').select2({
          tags: "true",
          allowClear: true,
          placeholder: 'Select Staff'
      });
      $('.select2staff').on('change',function(e){
        self.staff_id = $(this).val();
      });
      // item
      setTimeout(function(){
        $('body').on('mouseenter', '.select2item', function () {
            $('.select2item').select2({
                placeholder: 'Select'
            })
            .on('change', function(e){
              self.issue_det[$(this).data('key')].item_id = $(this).val();
              // console.log(self.issue_det[0].item_id);
            });
        });
      },200);
    },

    methods: {
      addRowItems: function() {
        var length = this.issue_det.length-1;
        if(this.issue_det[length].req_qty == '' &&  length != 0){
          return;
        }
        this.issue_det.push({
            id: 0,
            item_id: 0,
            req_qty : '',
            req_for: '',
            description: ''
        });
      },

      submit: function() {
        var self = this;
        var length = this.issue_det.length-1;
        if(this.issue_det[length].req_qty == '' &&  length != 0){
          self.issue_det.splice(length, 1)
        }
        var form_data = {
          id: self.id,
          issue_dt: self.issue_dt,
          loc_id: self.loc_id,
          store_id: self.store_id,
          person: self.person,
          staff_id:self.staff_id,
          remarks: self.remarks,
          request_no: self.request_no,
          issue_det: self.issue_det 
        }
        self.$http.post("{{ url('issues') }}", form_data )
          .then(function(response) {
            this.saving = false;
            if(response.data.success) {
              console.log(response.data.success);
              if(response.data.id > 0){
                self.errors = {};
                window.location.href = self.base_url + '/issues';
                // $('.select2').val(self.loc_id).trigger('change');
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

      editIssue: function(){
        var self = this;
        var row = [];
        self.issue_det= [];
        self.issue_dt = self.issue[0].issue_dt;
        self.person = self.issue[0].person;
        self.staff_id = self.issue[0].staff_id;
        $('.select2staff').val(self.staff_id).trigger('change');
        self.remarks = self.issue[0].remarks;
        self.request_no =  self.issue[0].request_no;
        self.loc_id = self.issue[0].loc_id;
        $('.select2').val(self.loc_id).trigger('change');
        self.store_id = self.issue[0].store_id;
        self.issue_dt = self.issue[0].issue_dt;
        
        self.issue[0].issue_dets.forEach(function(e) {
          row = {
            id: e.id,
            req_qty: e.req_qty,
            item_id: e.item_id,
            req_for: e.req_for,
            description: e.description
          };
          // console.log('rahul',self.issue[0].issue_dets[0].item_id]);
          // $('.select2').val(self.loc_id).trigger('change');
          self.issue_det.push(row);
        });
      },

      deleteRowItems: function(index) {
        var self = this;
        if(this.issue_det.length > 1){
          self.issue_det.splice(index,1);
        }

    },

    resetForm: function(){
        var self = this; 
        self.id= 0;
        self.issue_dt= moment(new Date()).format('DD-MM-YYYY');
        self.loc_id= '';
        self.person= '';
        self.staff_id= 0;
        $('.select2staff').val(0).trigger('change');
        self.staff_id= 0;
        self.remarks= '';
        self.store_id='';
        self.request_no= '';
        self.issue_det = [];
        self.errors= {};
        self.issue=[];
        self.total_amount= 0;
        self.issue_det.push({
          id: 0,
          item_id: 0,
          req_qty: '',
          req_for: '',
          description: ''
        });        
        $('.select2').val(0).trigger('change');
      },
    }
  });
</script>
@endsection



