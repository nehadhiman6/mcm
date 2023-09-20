@extends('app')
@section('content')
{!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
<div class="box box-info" id = "app">
  <div class="box-header with-border">
    <h3 class="box-title">Admission</h3>
  </div>
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('form_no','Form No',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        <input type="text" v-model="formdata.form_no" :disabled='form_loaded' number placeholder="Enter Form No." name="form_no" class="form-control">
      </div>
      {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent' => 'showDetail',':disabled'=>'form_loaded']) !!}
      {!! Form::submit('RESET',['class' => 'btn btn-primary','@click.prevent' => 'resetForm','v-if'=>'form_loaded']) !!}
    </div>
    <div id="student-details" v-if="form_loaded">
      <div class='form-group'>
        {!! Form::label('name','Student Name',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student_det.name }}</p>
        </div>
        {!! Form::label('father_name','Father Name',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student_det.father_name}}</p>
        </div>
        {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student_det.course ? student_det.course.course_name : '' }}</p>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('receipt_date','Receipt Date',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('receipt_date',today(),['class' => 'form-control app-datepicker','v-model'=>'formdata.receipt_date']) !!}
        </div>
        {!! Form::label('std_type_id','Student Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('std_type_id',[''=>'New'],null,['class' => 'form-control','v-model'=>'formdata.std_type_id']) !!}
        </div>
        {!! Form::label('installment_id','Installment',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::select('installment_id',['3'=>'Admission Installment'],3,['class' => 'form-control', 'v-model'=>'formdata.installment_id']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('total_amt','Tot.Amt',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('total_amt',null,['class' => 'form-control','v-model'=>'total_amt']) !!}
        </div>
        {!! Form::label('concession_amt','Cons.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('concession_amt',null,['class' => 'form-control','v-model'=>'concession_amt']) !!}
        </div>
        {!! Form::label('prv_dues','Prv.Dues',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('prv_dues',null,['class' => 'form-control','v-model'=>'prv_dues']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('amt_paid','Amt.Paid',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('amt_paid',null,['class' => 'form-control','v-model'=>'amt_paid']) !!}
        </div>
        {!! Form::label('bal_amt','Bal.Amt.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('bal_amt',null,['class' => 'form-control','v-model'=>'bal_amt']) !!}
        </div>
      </div>
      <div class="box-scroll">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Fee Head</th>
            <th>Amount</th>
            <th>Subheads</th>
            <th>Bill No.</th>
            <th>Amount</th>
            <th>Charge</th>
            <th>Concession</th>
            <th>Net Payable</th>
            <th>Amt Paid</th>
          </tr>
        </thead>
        <tbody>
          <tr is="feehead" v-for="fees in fee_str" :fees.sync="fees" :index="$index"  :formdata="formdata" :task="task" ></tr>
        </tbody>
      </table>
      </div>
      <fieldset>
        <legend>Mode Of Payment And Bank Details</legend>
        <div class="form-group" >
          {!! Form::label('pay_type','Payment Type',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4"  v-bind:class="{ 'has-error': errors['formdata.pay_type'] }">
            <label class="radio-inline" >
              <input name="pay_type" type="radio" value="C" v-model="formdata.pay_type" >
              Cash
            </label>
            <label class="radio-inline" >
              <input name="pay_type" type="radio" value="B" v-model="formdata.pay_type" >
              Bank
            </label>
            <span id="basic-msg" v-if="errors['formdata.pay_type']" class="help-block">@{{ errors['formdata.pay_type'][0] }}</span>
          </div>
        </div>
        <div class="form-group" v-show='formdata.pay_type == "B"'>
          {!! Form::label('pay_mode','Payment Mode',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
            {!! Form:: select('pay_mode', array('' => 'Select','Cheque' => 'Cheque', 'Credit Card' => 'Credit Card','Debit Card' => 'Debit Card','Net Banking'=>'Net Banking'),null, ['class' => 'form-control','v-model'=>"formdata.pay_mode"]) !!}
          </div>
          {!! Form::label('chqno','Cheque/DD No.',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
            {!! Form::text('chqno',null,['class' => 'form-control','v-model'=>'formdata.chqno']) !!}
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('remarks','Details',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4">
            {!! Form::textarea('remarks', null, ['class' => 'form-control','size' => '30x2','v-model'=>"formdata.remarks"]) !!}
          </div>
        </div>
      </fieldset>
    </div>
  </div>
  <div class="box-footer">
    <input class="btn btn-primary" id="btnsubmit" type="submit" value="ADMIT" v-if="form_loaded" @click.prevent="admit">
  </div>
  {{ getVueData() }}
</div>
{!! Form::close() !!}


<template id="feehead-template">
  <tr>
    <td>@{{ fees.subhead.feehead.name }}</td>
    <td></td>
    <td>@{{ fees.subhead.name }}</td>
    <td></td>
    <td>@{{ fees.amount}}</td>
    <td style="text-align: center">
        <input type="checkbox" v-if="fees.optional == 'Y'" :checked="fees.charge == 'Y'" v-model="fees.charge" @change="chkCharge"/>
    </td>
    <td v-bind:class="{ 'has-error': errors['fees.concession'] }">
       <input class="form-control" type="text" number v-model="fees.concession" @change="updateBalance"/>
    </td>
    <td v-bind:class="{ 'has-error': errors['fees.fee_amt'] }">
         <input class="form-control" type="text" number v-model="fees.fee_amt" />
    </td>
    <td v-bind:class="{ 'has-error': errors['fees.amt_rec'] }">
      <input class="form-control" type="text" number v-model="fees.amt_rec"/>
    </td>
  </tr>
</template>
@stop
@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      student_det: {},
      fee_str: {},
      form_loaded: false,
      formdata: {
        form_no: '',
        receipt_date: '',
        std_type_id: '',
        installment_id: '',
        pay_type: '',
        pay_mode: '',
        chqno: '',
        remarks: ''
      },
      //fees_paying:{},
      success: false,
      fails: false,
      saving: false,
      msg: '',
      errors: [],
    },
    created: function() {
//         this.showDetail();
    },
    methods:{
      showDetail: function() {
        this.form_loaded = false;
        var data = { form_no: this.formdata.form_no };
        this.$http.get("{{ url('admissions/create') }}", {params: data})
          .then(function (response) {
            this.form_loaded = true;
            this.student_det = response.data.student_det;
            this.fee_str = response.data.fee_str;
          }, function(response) {
            this.fails = true;
            this.saving = false;
            if(response.status == 422)
              this.errors = response.data;
        });
      },
      
      resetForm: function() {
        this.form_loaded = false;
        this.formdata.form_no = '';
      },
      
      admit: function() {
        this.errors = {};
        this.$http[this.getMethod()](
            @if(isset($student_det->id))
              "{{ url('/admissions/'.$student_det->id) }}"
            @else
              "{{ url('/admissions') }}"
            @endif
         , this.$data)
         .then(function (response) {
                var response = response.data;
                self = this;
                if (response['success']) {
                  self = this;
                  this.success = true;
                  setTimeout(function() {
                    self.success = false;
                  }, 3000);
                }
               // window.location = "{{ url('/') }}";
                // console.log(response);
              }, function (response) {
                this.fails = true;
                self = this;
                this.errors = response.data;
                  console.log(response.data);              
              });
      },
      getMethod: function() {
        @if(isset($student_det->id))
          return 'patch';
        @else
          return 'post';
        @endif
      },
    },
    components: {
      feehead: {
        template: '#feehead-template',
        props: ['fees', 'index', 'formdata',  'services', 'task', 'fee_rec_id'],
        data: function() {
          return {
            dirty: false,
            success: false,
            fails: false,
            msg: '',
            errors: '',
          }
        },
        events: {
          'data-dirty': function(state) {
            this.dirty = state;
          }
        },
        methods: {
          chkCharge: function() {
           if(this.fees.charge )
              this.fees.fee_amt = this.fees.amount;
            this.updateBalance();
          },
          
          updateBalance: function() {
//            console.log('update:'+this.fees.charge);
            if(this.fees.charge)
              this.fees.fee_amt = this.toNumber(this.fees.amount)-this.toNumber(this.fees.concession);
            else
              this.fees.fee_amt = 0;
          },
          
          toNumber: function(val) {
            val = parseFloat(val);
            return (isNaN(val) ? 0 : val);
          },
        }
      }
    }
    
  });
</script>
@stop