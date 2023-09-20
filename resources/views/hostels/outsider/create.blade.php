@extends('app')
@section('toolbar')
@include('toolbars._hostels_toolbar')
@stop
@section('content')
<div id = "app" v-cloak>
  {!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Hostel Admission</h3>
    </div>
    <div class="box-body">
      <div class="form-group">
        {!! Form::label('institute','Institute',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.institute'] }">
          {!! Form::select('institute',getInstitutes(),null,['class' => 'form-control','v-model'=>'student_det.institute']) !!}
        </div>
        {!! Form::label('std_type_id','Student Type',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['student_det.std_type_id'] }">
          {!! Form::select('std_type_id',getStudentType(),null,['class' => 'form-control','v-model'=>'student_det.std_type_id']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('name','Name',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.name'] }">
          {!! Form::text('name',null,['class' => 'form-control','max-length'=>'50','v-model'=>'student_det.name']) !!}
        </div>
        {!! Form::label('father_name','Father',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.father_name'] }">
          {!! Form::text('father_name',null,['class' => 'form-control','v-model'=>'student_det.father_name']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('course_name','Class',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.course_name'] }">
          {!! Form::text('course_name',null,['class' => 'form-control','max-length'=>'10','v-model'=>'student_det.course_name']) !!}
        </div>
        <div>
          {!! Form::label('roll_no','Roll No.',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.roll_no'] }">
            {!! Form::text('roll_no',null,['class' => 'form-control','v-model'=>'student_det.roll_no']) !!}
          </div>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('mobile','Mobile',['class' => 'col-sm-2 control-label ']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.mobile'] }">
          {!! Form::text('mobile',null,['class' => 'form-control','max-length'=>'10','v-model'=>'student_det.mobile']) !!}
        </div>
        <div>
          {!! Form::label('email','Email',['class' => 'col-sm-2 control-label ']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.email'] }">
            {!! Form::text('email',null,['class' => 'form-control','v-model'=>'student_det.email']) !!}
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      {!! Form::submit('SHOW',['class' => 'btn btn-primary col-sm-offset-1','@click.prevent' => 'showDetail',':disabled'=>'form_loaded']) !!}
      {!! Form::submit('RESET',['class' => 'btn btn-primary','@click.prevent' => 'resetForm','v-if'=>'form_loaded']) !!}
    </div>
    <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
      <li v-for='error in errors'>@{{ error[0] }}<li>
    </ul>
  </div>
  <div class="box box-info" v-show="form_loaded">
    <div class="box-body">
      <div class='form-group'>
        <div v-bind:class="{ 'has-error': errors['formdata.receipt_date'] }">
          {!! Form::label('receipt_date','Receipt Date',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
            <p class="form-control-static">@{{ formdata.receipt_date }}</p>
            <span id="basic-msg" v-if="errors['formdata.receipt_date'] != undefined && errors['formdata.receipt_date'].length" class="help-block">@{{ errors['formdata.receipt_date'][0] }}</span>
          </div>
        </div>
        {!! Form::label('concession_id','Concession',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('concession_id',getConcession(),null,['class' => 'form-control', 'v-model'=>'formdata.concession_id']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('concession_amt','Cons.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalConcession }}</p>
        </div>
        {!! Form::label('total_amt','Tot.Amt',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ totalAmount }}</p>
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
        <div class="col-sm-1">
          <button @click.prevent='fullConcession' class="btn btn-default">Total Concession</button>
        </div>
      </div>
      <div class="box-scroll">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Subheads</th>
              <th>Amount</th>
              <th>Charge</th>
              <th>Concession</th>
              <th>Net Payable</th>
              <th>Amt Paid</th>
              <th>Balance</th>
            </tr>
          </thead>
          <tbody>
            <tr is="feehead" v-for="(fh, subheads) in fee_str" :fh="fh" :feestr.sync="subheads" :index="$index"  :formdata="formdata" :task="task" ></tr>
          </tbody>
          <tfoot>
            <tr>
              <th>Totals</th>
              <th>@{{ totalAmount }}</th>
              <th>Charge</th>
              <th>@{{ totalConcession }}</th>
              <th>@{{ totalReceivable }}</th>
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
    <div class="box-footer">
      <input class="btn btn-primary" id="btnsubmit" type="submit" value="ADMIT" v-if="form_loaded" @click.prevent="admit">
      <a href='{{ url("/") }}/receipts/@{{ response.fee_rec_id }}/printreceipt' target="_blank" v-if="response.fee_rec_id > 0"  
         class='btn btn-primary'>
        Receipt Print
      </a>
    </div>
    <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Success!</strong> @{{ response['success'] }}
    </div>
  </div>
  {!! Form::close() !!}
      {{ getVueData() }}

</div>
<template id="feehead-template">
  <tr @click="showSubHeads">
    <th>( <i class="fa" :class="{ 'fa-plus': !open, 'fa-minus': open }"></i> ) @{{ fh }}</th>
    <th>@{{ feeheadAmount }}</th>
    <th></th>
    <th>@{{ feeheadConcession }}</th>
    <th>@{{ feeheadReceivable }}</th>
    <th>@{{ feeheadReceived }}</th>
    <th>@{{ feeheadBalance }}</th>
  </tr>
  <tr is="subhead" v-for='fees in subheadsList' :fees.sync="fees" :fh="fh" :index="$index">
</template>
<template id="subhead-template">
  <tr>
    <td>@{{ fees.subhead.name }}</td>
    <td>@{{ fees.amount}}</td>
    <td style="text-align: center">
        <input type="checkbox" v-if="fees.optional == 'Y'" v-bind:true-value="'Y'" v-bind:false-value="'N'" v-model="fees.charge" @change="updateBalance"/>
    </td>
    <td v-bind:class="{ 'has-error': $root.errors['fee_str.'+fh+'.'+index+'.concession'] }">
       <input class="form-control" type="text" v-if="chargeable" number v-model="fees.concession" @change="updateBalance"/>
    </td>
    <td v-bind:class="{ 'has-error': $root.errors['fee_str.'+fh+'.'+index+'.concession'] }">
      <p class="form-control-static">@{{ receivable }}</p>
    </td>
    <td v-bind:class="{ 'has-error': $root.errors['fee_str.'+fh+'.'+index+'.amt_rec'] }">
      <input class="form-control" type="text" v-if="chargeable" number v-model="fees.amt_rec" />
    </td>
    <td v-bind:class="{ 'has-error': errors['fees.fee_amt'] }">
      <p class="form-control-static">@{{ balance }}</p>
    </td>
  </tr>
</template>
@stop
@section('script')
<script>
  var getStudentDetail = function() {
    return {
      id: 0,
      institute: '',
      std_type_id: 0,
      name: '',
      father_name: '',
      course_name: '',
      roll_no: '',
      mobile: '',
      email: ''
    };
  }
  
  var vm = new Vue({
    el: '#app',
    data: {
      response: {},
      student_det: getStudentDetail(),
      fee_str: {},
      form_loaded: false,
      formdata: {
        adm_no: '',
        receipt_date: "{{ today() }}",
        //adm_date: '',
        std_type_id: 0,
        installment_id: 0,
        concession_id: {{ $concession->id or request("concession_id",0) }},
        remarks: ''
      },
      fee_bill_id: {{ $fee_bill_id or 0 }},
      fee_rec_id: {{ $fee_rec_id or 0 }},
      success: false,
      fails: false,
      saving: false,
      msg: '',
      errors: {},
    },
    created: function() {
//         this.showDetail();
    },
    
    computed: {
      totalAmount: function() {
        var t = 0;
        _.each(this.fee_str, function(subheads, i) {
          _.each(subheads, function(sh, i) {
            if (sh.optional == 'N' || sh.charge == 'Y')
              t += sh.amount * 1;
          });
        });
        return t;
      },

      totalConcession: function() {
        var t = 0;
        _.each(this.fee_str, function(subheads, i) {
          _.each(subheads, function(sh, i) {
            if (sh.optional == 'N' || sh.charge == 'Y')
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
        _.each(this.fee_str, function(subheads, i) {
          _.each(subheads, function(sh, i) {
            if (sh.optional == 'N' || sh.charge == 'Y')
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
        this.form_loaded = false;
//        var data = { adm_no: this.formdata.adm_no };
        this.$http.get("{{ url('hostels/outsiders/create') }}", {params: { student_det: this.student_det }})
          .then(function (response) {
            this.form_loaded = true;
//            this.student_det = response.data.student_det;
            this.fee_str = response.data.fee_str;
            this.formdata.installment_id = response.data.installment_id;
          
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
        this.student_det = {};
        this.fee_str = {};
        this.formdata = {
          form_no: '',
          receipt_date: "{{ today() }}",
          std_type_id: 0,
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
      
      admit: function() {
        this.errors = {};
        this.saving = true;
        this.$http.post("{{ url('hostels/outsiders') }}", this.$data)
          .then(function (response) {
              this.response = response.data;
              self = this;
              if (this.response['success']) {
                self = this;
                this.success = true;
                setTimeout(function() {
                  self.success = false;
                }, 3000);
              }
//              window.location = "{{ url('students') }}";
            }, function (response) {
              this.fails = true;
              self = this;
              this.saving = false;
              if(response.status == 422) {
                this.errors = response.data;
              }
            });
      },
      
      getMethod: function() {
        @if(isset($student_det->id))
          return 'patch';
        @else
          return 'post';
        @endif
      },
      
      fullConcession: function() {
        _.each(this.fee_str, function(subheads, i) {
          _.each(subheads, function(sh, i) {
            sh.concession = sh.amount;
            sh.amt_rec = 0;
          });
        });
      }
    },
    components: {
      feehead: {
        template: '#feehead-template',
        props: ['fh', 'feestr', 'index', 'formdata',  'services', 'task', 'fee_rec_id'],
        data: function() {
          return {
            open: false,
            dirty: false,
            success: false,
            fails: false,
            msg: '',
            errors: '',
          }
        },
        computed: {
          subheadsList: function() {
            if (this.open)
              return this.feestr
            else
              return [];
          },
          
          feeheadAmount: function() {
            var t = 0;
            _.each(this.feestr, function(sh, i) {
              if (sh.optional == 'N' || sh.charge == 'Y')
                t += sh.amount * 1;
            });
            return t;
          },

          feeheadConcession: function() {
            var t = 0;
            _.each(this.feestr, function(sh, i) {
              if (sh.optional == 'N' || sh.charge == 'Y')
                t += sh.concession * 1;
            });
            return t;
          },

          feeheadReceivable: function() {
            return this.feeheadAmount - this.feeheadConcession;
          },

          feeheadReceived: function() {
            var t = 0;
            _.each(this.feestr, function(sh, i) {
              if (sh.optional == 'N' || sh.charge == 'Y')
                t += sh.amt_rec * 1;
            });
            return t;
          },

          feeheadReceivable: function() {
            return this.feeheadAmount - this.feeheadConcession - this.feeheadReceived;
          },

        },
        methods: {
          chkCharge: function() {
           if(this.fees.charge )
              this.fees.fee_amt = this.fees.amount;
            this.updateBalance();
          },
          
          updateBalance: function() {
            if(this.fees.charge)
              this.fees.fee_amt = this.toNumber(this.fees.amount)-this.toNumber(this.fees.concession);
            else
              this.fees.fee_amt = 0;
          },
          
          showSubHeads: function() {
            this.open = ! this.open;
          },
          
          toNumber: function(val) {
            val = parseFloat(val);
            return (isNaN(val) ? 0 : val);
          },
        },
        
        components: {
          subhead: {
            template: '#subhead-template',
            props: ['fees', 'fh', 'index'],
            
            computed: {
              chargeable: function() {
                if (this.fees.optional == 'N' || this.fees.charge == 'Y')
                  return true;
                return false;
              },
              
              receivable: function() {
                if (this.chargeable) {
                  return this.fees.amount - this.fees.concession
                }
                return 0;
              },
              
              balance: function() {
                if (this.receivable > 0) 
                  return this.receivable - this.fees.amt_rec;
                
                return 0;
              }
            },
            
            methods: {
              updateBalance: function() {
                if(this.receivable > 0 && this.fees.amt_rec > 0)
                  this.fees.amt_rec =  this.receivable;
              },
              
              toNumber: function(val) {
                val = parseFloat(val);
                return (isNaN(val) ? 0 : val);
              },
            }
          }
        }
      }
    }
    
  });
</script>
@stop