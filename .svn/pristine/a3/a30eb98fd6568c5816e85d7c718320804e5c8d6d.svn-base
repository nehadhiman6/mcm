@extends('app')
@section('toolbar')
@include('toolbars._receipts_toolbar')
@stop
@section('content')
{!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
<div class="box box-info" id = "app">
  <div class="box-header with-border">
    <h3 class="box-title">Misc Installments</h3>
  </div>
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('adm_no','Admission No',['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-3">
        <input type="text" v-model="formdata.adm_no" :disabled='form_loaded' number placeholder="Enter Admission No." name="adm_no" class="form-control">
      </div>
      {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent' => 'showDetail',':disabled'=>'form_loaded']) !!}
      {!! Form::submit('RESET',['class' => 'btn btn-primary','@click.prevent' => 'resetForm','v-if'=>'form_loaded']) !!}
    </div>
    <div id="student-details" v-if="form_loaded">
      <div class='form-group'>
        {!! Form::label('name','Student Name',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student.name }}</p>
        </div>
        {!! Form::label('father_name','Father Name',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student.father_name}}</p>
        </div>
        {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student.course ? student.course.course_name : '' }}</p>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('std_type_id','Student Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ formdata.std_type_id == 1 ? 'New' : 'Old' }}</p>
        </div>
        <div v-bind:class="{ 'has-error': errors['formdata.receipt_date'] }">
          {!! Form::label('receipt_date','Receipt Date',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
            <p class="form-control-static">@{{ formdata.receipt_date }}</p>
            <span id="basic-msg" v-if="errors['formdata.receipt_date'] != undefined && errors['formdata.receipt_date'].length" class="help-block">@{{ errors['formdata.receipt_date'][0] }}</span>
          </div>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('','Previou Duess',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ prv_dues }}</p>
        </div>
        {!! Form::label('','Charges',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalAmount }}</p>
        </div>
        {!! Form::label('','Total Receivable',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalReceivable }}</p>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('amt_paid','Amt.Paid',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalReceived }}</p>
        </div>
        {!! Form::label('bal_amt','Bal.Amt.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalBalance }}</p>
        </div>
      </div>
      <div class="box-scroll">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Subheads</th>
              <th>Feeheads</th>
              <th>Fund</th>
              <th>Amount</th>
              <th>Amt Paid</th>
              <th>Balance</th>
            </tr>
          </thead>
          <tbody>
            <th colspan="6">Misc. Charges</th>
            <tr is="subhead" v-for="sh in misc_fees" :sh.sync="sh" :misc_fees.sync="misc_fees" :counter.sync="counter" :subheads="subheads"></tr>
          </tbody>
        </table>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Subheads</th>
              <th>Amount</th>
              <th>Amt Paid</th>
              <th>Balance</th>
            </tr>
          </thead>
          <tbody>
             <th colspan="4">Pending Balance</th>
             <tr is="feehead" v-for="(fh, psubheads) in pend_bal" :fh="fh" :pendbal.sync="psubheads" :index="$index"></tr>
          </tbody>
          <tfoot>
            <tr>
              <th>Totals</th>
              <th>@{{ totalAmount }}</th>
              <th>@{{ totalReceived }}</th>
              <th>@{{ totalBalance }}</th>
            </tr>
          </tfoot>
        </table>
        <div class="form-group">
          {!! Form::label('remarks','Details',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-5">
            {!! Form::textarea('remarks', null, ['class' => 'form-control','size' => '30x2','v-model'=>"formdata.remarks"]) !!}
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <input class="btn btn-primary" id="btnsubmit" type="submit" value="SAVE" :disabled="fee_rec_id > 0" v-if="form_loaded" @click.prevent="save">
    <a href='{{ url("/") }}/receipts/@{{ fee_rec_id }}/printreceipt' target="_blank" v-if="fee_rec_id > 0"  
       class='btn btn-primary'>
      Receipt Print
    </a>
  </div>
  <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
  {{ getVueData() }}
</div>
{!! Form::close() !!}


@include('miscinsts.misc_fees')
@include('receipts.pending_bal')

@stop
@section('script')
<script>
  function getBlankRow() {
   return {
      "no": 1,
      "feehead_id": 0,
      "subhead_id": 0,
      "amount": 0,
      "amt_rec": 0,
      "balance": 0,
    };
  }
  var vm = new Vue({
    el: '#app',
    data: {
      counter: 1,
      response: {},
      misc_fees: {},
      pend_bal: {},
      subheads: {},
      student: {},
      form_loaded: false,
      formdata: {
        adm_no: '',
        receipt_date: "{{ today() }}",
        adm_date: '',
        installment_id: 0,
        concession_id: 0,
        remarks: ''
      },
      fee_bill_id: 0,
      fee_rec_id: 0,
      success: false,
      fails: false,
      saving: false,
      msg: '',
      errors: {},
    },
    // created: function() {
    //   this.misc_fees = [getBlankRow()];
    // },
    computed: {
      totalAmount: function() {
        var t = 0;
        _.each(this.misc_fees, function(sh, i) {
          t += sh.amount * 1;
        });
        return t;
      },
      
      totalReceivable: function() {
        return this.totalAmount + this.prv_dues;
      },
      
      totalReceived: function() {
        var t = 0;
        _.each(this.misc_fees, function(sh, i) {
          t += sh.amt_rec * 1;
        });
        _.each(this.pend_bal, function(subheads, i) {
          _.each(subheads, function(sh, i) {
              t += sh.amt_rec * 1;
          });
        });
        return t;
      },
      
      prv_dues: function() {
        var t = 0;
        _.each(this.pend_bal, function(subheads, i) {
          _.each(subheads, function(sh, i) {
              t += sh.amount * 1;
              console.log(t);
          });
        });
        return t;
      },

      totalBalance: function() {
        return this.totalReceivable  - this.totalReceived;
      },

    },
    methods:{
      showDetail: function() {
        this.errors = {};
        this.form_loaded = false;
        var data = { adm_no: this.formdata.adm_no };
        this.$http.get("{{ url('misc-insts/create') }}", {params: data})
          .then(function (response) {
            this.form_loaded = true;
            this.student = response.data.student;
            this.subheads = response.data.subheads;
            this.pend_bal = response.data.pend_bal;
            this.misc_fees = [getBlankRow()];
          //  this.formdata.installment_id = response.data.installment_id;
            console.log('after');
          }, function(response) {
            this.fails = true;
            this.saving = false;
            if(response.status == 422)
              this.errors = response.data;
        });
      },
      
      resetForm: function() {
        this.form_loaded = false;
        this.response = {};
        this.errors = {};
        this.student = {};
        this.misc_fees = {};
        this.pend_bal = {};
        this.fee_rec_id = 0;
        this.formdata = {
          adm_no: '',
          receipt_date: "{{ today() }}",
          adm_date: '',
          installment_id: 0,
          concession_id: 0,
          remarks: ''
        };
      },

      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
      
      save: function() {
        if(this.fee_rec_id > 0)
          return;
        this.errors = {};
        this.saving = true;
        var data = {
          formdata: this.formdata,
          pend_bal: this.pend_bal,
          misc_fees: this.misc_fees,
        };
        this.$http.post("{{ url('misc-insts') }}", data)
          .then(function (response) {
              this.response = response.data;
              self = this;
              if (this.response['success']) {
                this.success = true;
                this.fee_rec_id = this.response.fee_rec_id;
                setTimeout(function() {
                  self.success = false;
                }, 3000);
              }
            }, function (response) {
              this.fails = true;
              this.saving = false;
              if(response.status == 422) {
                this.errors = response.data;
              }
            });
      },
      
    },    
  });
</script>
@stop