@extends('online.dashboard')

@section('content')
{!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
{{-- <div class="alert alert-info" role="alert"> --}}
  {{-- The hostel fee for the entire session is Rs. 1,06,000 (New Students) and Rs. 1,05,000 (Old Students) including maintenance charges, 
  food charges and laundry facility. However, considering the prolonged impact of COVID-19 pandemic, College is taking an advance 
  amount of Rs. 25,000 (Old Students) and Rs. 26,000 (New Students). Whenever, the hostel becomes operational, hostel fee will be 
  proportionately adjusted/reduced. --}}
  {{-- <b>Note :</b>
  Hostel reservation charges Rs.15,000/– (non-refundable )</br>
  Annual Hostel fees 1,06,000/– (New students) and Rs.1,05,000 (Old Students).</br>
  Reservation charges will be adjusted in the total Hostel fee, within the current session only, after joining hostel. --}}
{{-- </div> --}}

<div class="alert alert-info" role="alert">
  Click on 'Show', check details and pay the fee
</div>
<div class="box box-info" id = "app" v-cloak>
  <div class="box-header with-border">
    <h3 class="box-title" >@{{ formTitle }}</h3>
  </div>
  <div class="box-body">
    <div class='form-group'>
      {!! Form::label('adm_no','Admission No.',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2" v-bind:class="{ 'has-error': errors['adm_no'] }">
        <!-- <input class="form-control" type="text" v-model="adm_no" /> -->
        <p class="form-control-static">@{{ adm_no }}</p>
        <span id="basic-msg" v-if="errors['adm_no']" class="help-block">@{{ errors['adm_no'][0] }}</span>
      </div>
      <input class="btn btn-primary" id="btnsubmit" type="submit" value="Show" @click.prevent="showDetail">
    </div>
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
          <p class="form-control-static" v-if="student.std_type_id">@{{ student.std_type_id == 1 ? 'New' : 'Old' }}</p>
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
        {!! Form::label('total_amt','Tot.Amt',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalAmount }}</p>
        </div>
        {!! Form::label('amt_paid','Amt. Payable',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalReceived }}</p>
        </div>
        <!-- {!! Form::label('bal_amt','Bal.Amt.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalBalance }}</p>
        </div> -->
      </div>
      <div class="box-scroll">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Subheads</th>
              <th>Amount</th>
              <th>Amt Payable</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr is="feehead" v-for="(fh, subheads) in pend_bal" :fh="fh" :pendbal.sync="subheads" :index="$index"></tr>
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
    <input class="btn btn-primary" id="btnsubmit" type="submit" value="PAY" :disabled="fee_rec_id > 0 || totalReceived == 0" @click.prevent="save()">
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
      adm_no: "",
      last_fbid: 0,
      response: {},
      outsider : "{!! isset($outsider) ? $outsider : 'N' !!}",
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
      this.url = this.fund_type == 'C' ? "{{ url('penddues') }}" :  (this.outsider == 'N' ? "{{ url('hosteldues') }}" : "{{ url('otherdues') }}" );
      @if(auth('students')->check())
        this.adm_no="{{ $loggedUser->student->adm_no }}";
      @endif
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

      formTitle: function() {
        if(this.fund_type == 'H' && this.outsider == 'N')
          return 'Hostel Dues';
        if(this.fund_type == 'H' && this.outsider == 'Y')
          return 'Hostel Dues (Non SGGS Students)';
        return 'College Dues';
      }

    },
    
    methods:{
      showDetail: function() {
        this.errors = {};
        this.student = {};
        this.pend_bal = {};
        this.$http.get(this.url, { params: { adm_no: this.adm_no }})
          .then(function (response) {
            this.student = response.data.student;
            this.pend_bal = response.data.pend_bal;
            this.last_fbid = response.data.last_fbid;
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
        if(this.fee_rec_id > 0 || this.totalReceived == 0)
          return;

        $('#new-form').html('');
        $('#new-form').append('<form id="pay-form" action="'+this.url+'" method="POST" >');
        $('#pay-form').append('{!! csrf_field() !!}')
            .append('<input type="hidden" name="adm_no" value="' + this.adm_no + '">')
            .append('<input type="hidden" name="last_fbid" value="' + this.last_fbid + '">')
            .append('<input type="hidden" name="amount" value="' + this.totalAmount + '">')
            .submit();
        // console.log('here');
        return;
      },
    },
  });
</script>
@stop