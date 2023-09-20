@extends('online.dashboard')

@section('content')
{!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
<div class="box box-info" id = "app" v-cloak>
  <div class="box-header with-border">
    <h3 class="box-title" v-if ="fund_type == 'C'">College Receipts</h3>
    <h3 class="box-title" v-if ="fund_type == 'H'">Hostel Receipts</h3>
  </div>
  <div class="box-body">
    <div id="student-details">
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
<!--        {!! Form::label('concession_id','Concession',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('concession_id',getConcession(),null,['class' => 'form-control', 'v-model'=>'formdata.concession_id']) !!}
        </div>-->
      </div>
      <div class='form-group'>
<!--        {!! Form::label('concession_amt','Cons.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalConcession }}</p>
        </div>-->
      </div>
      <div class='form-group'>
        {!! Form::label('total_amt','Tot.Amt',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalAmount }}</p>
        </div>
        {!! Form::label('amt_paid','Amt.Paid',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalReceived }}</p>
        </div>
        {!! Form::label('bal_amt','Bal.Amt.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalBalance }}</p>
        </div>
<!--        <div class="col-sm-1">
          <button @click.prevent='fullConcession' class="btn btn-default">Total Concession</button>
        </div>-->
      </div>
      <div class="box-scroll">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Subheads</th>
              <th>Amount</th>
<!--              <th>Charge</th>-->
<!--              <th>Concession</th>-->
              <!--<th>Net Payable</th>-->
              <th>Amt Paid</th>
              <th>Balance</th>
            </tr>
          </thead>
          <tbody>
            <tr is="feehead" v-for="(fh, subheads) in pend_bal" :fh="fh" :pendbal.sync="subheads" :index="$index"></tr>
          </tbody>
          <tfoot>
            <tr>
              <th>Totals</th>
              <th>@{{ totalAmount }}</th>
<!--              <th>Charge</th>-->
<!--              <th>@{{ totalConcession }}</th>-->
              <!--<th>@{{ totalReceivable }}</th>-->
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
    <input class="btn btn-primary" id="btnsubmit" type="submit" value="SAVE" :disabled="fee_rec_id > 0" @click.prevent="save()">
    <a href='{{ url("/") }}/receipts/@{{ response.fee_rec_id }}/printreceipt' target="_blank" v-if="response.fee_rec_id > 0"  
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
<div id="new-form"></div>

@include('payments.pending_bal')
@stop
@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      response: {},
      outsider : "{!! isset($outsider) ? 'Y' : 'N' !!}",
      fund_type : "{{ $fund_type }}",
      formdata: {
        adm_no: '',
        receipt_date: "{{ today() }}",
        concession_id: 0,
        remarks: ''
      },
      fee_bill_id: 0,
      fee_rec_id: 0,
      success: false,
      fails: false,
      saving: false,
      url: '',
      msg: '',
      pend_bal: {},
      student: {},
      errors: {},
   //   con_feeheads: [],
    },
    
    created: function() {
//         this.showDetail();
      this.url = this.fund_type == 'C' ? "{{ url('stdpayments') }}" :  (this.outsider == 'N' ? "{{ url('receipts-hostel') }}" : "{{ url('receipts-outsider') }}" );
    },
    ready: function() {
      this.showDetail();
    },
    computed: {
      totalAmount: function() {
        var t = 0;
        _.each(this.pend_bal, function(subheads, i) {
          _.each(subheads, function(sh, i) {
              t += sh.amount * 1;
          });
        });
        return t;
      },

      totalConcession: function() {
        var t = 0;
        _.each(this.pend_bal, function(subheads, i) {
          _.each(subheads, function(sh, i) {
             t += sh.concession * 1;
          });
        });
        return t;
      },

      totalReceivable: function() {
        return this.totalAmount - this.totalConcession;
      },

      totalReceived: function() {
        var t = 0;
        _.each(this.pend_bal, function(subheads, i) {
          _.each(subheads, function(sh, i) {
              t += sh.amt_rec * 1;
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
        this.$http.get(this.url+'/create')
          .then(function (response) {
            this.student = response.data.student;
            this.pend_bal = response.data.pend_bal;
            console.log('after');
          }, function(response) {
            this.fails = true;
            this.saving = false;
            if(response.status == 422)
              this.errors = response.data;
        });
      },
      
      resetForm: function() {
        this.response = {};
        this.errors = {};
        this.student = {};
        this.pend_bal = {};
        this.formdata = {
          adm_no: '',
          receipt_date: "{{ today() }}",
          concession_id: 0,
          remarks: ''
        };
        this.fee_rec_id = 0;
        this.fee_bill_id = 0;
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

        $('#new-form').html('');
        $('#new-form').append('<form id="pay-form" action="'+this.url+'" method="POST" >');
        $('#pay-form').append('{!! csrf_field() !!}')
            .append('<input type="hidden" name="form_no" value="' + this.formdata.form_no + '">')
            .append('<input type="hidden" name="amount" value="' + this.totalAmount + '">')
            .submit();
        console.log('here');
        return;

        this.errors = {};
        this.saving = true;
        var data = $.extend({}, this.$data, { total_received: this.totalReceived });
        this.$http.post(this.url, data)
          .then(function (response) {
              this.response = response.data;
              self = this;
              if (this.response['success']) {
                self = this;
                this.success = true;
                this.fee_rec_id = this.response.fee_rec_id;
                setTimeout(function() {
                  self.success = false;
                }, 3000);
              }
            }, function (response) {
              this.fails = true;
              self = this;
              this.saving = false;
            //  this.response.errors = response.data;
              if(response.status == 422) {
                this.errors = response.data;
              }
            });
      },
      fullConcession: function() {
        self = this;
        _.each(this.pend_bal, function(subheads, i) {
          if(! self.con_feeheads.includes(i)) {
            _.each(subheads, function(sh, i) {
              sh.concession = sh.amount;
              sh.amt_rec = 0;
            });
          }
        });
      }
    },
  });
</script>
@stop