@extends('online.dashboard')

@section('content')
{!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
<div class="box box-info" id = "app" v-cloak>
  <div class="box-header with-border">
    <h3 class="box-title">Admission</h3>
  </div>
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('form_no','Online Form No',['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-3">
        <input v-show="!has_form_no" type="text" v-model="formdata.form_no" :disabled='form_loaded' number placeholder="Enter Form No." name="form_no" class="form-control">
        <p v-else class=form-control-static>@{{ formdata.form_no }}</p>
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
        <div v-bind:class="{ 'has-error': errors['formdata.receipt_date'] }">
          {!! Form::label('receipt_date','Receipt Date',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
            <p class="form-control-static">@{{ formdata.receipt_date }}</p>
          </div>
        </div>
      </div>
      <div class="box-scroll">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Particulars</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="fh in fee_str">
              <td>@{{ fh.feehead }}</td>
              <td>@{{ fh.amount }}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th>Total</th>
              <th>@{{ totalAmount }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <input class="btn btn-primary" id="btnsubmit" type="submit" value="PAY Rs. @{{ totalAmount }}/-" v-if="form_loaded" @click.prevent="admit">
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
@stop

@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      response: {},
      student_det: {},
      fee_str: [],
      adm_entry: [],
      misc_charges: [],
      other_charges: [],
      subheads: {!! json_encode($subheads) !!},
      form_loaded: false,
      has_form_no: {{ isset($adm_form) && $adm_form ? 'true' : 'false' }},
      formdata: {
        form_no: "{{ isset($adm_form) && $adm_form ? $adm_form->id : ''}}",
        receipt_date: '{{ today() }}',
        adm_date: '',
        std_type_id: 0,
        installment_id: 0,
      },
      //fees_paying:{},
      fee_bill_id: 0,
      fee_rec_id: 0,
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
        _.each(this.fee_str, function(fh, i) {
          t += fh.amount * 1;
        });
        return t;
      },

    },
    
    methods:{
      showDetail: function() {
        var self = this;
        this.errors = {};
        this.form_loaded = false;
        var data = { form_no: this.formdata.form_no };
        var mc_exam_fee_obj = null;
        var exam_fee = 0;
        var exam_fee_type = '';
        this.$http.get("{{ url('payadmfees/create') }}", {params: data})
          .then(function (response) {
            this.form_loaded = true;
            this.student_det = response.data.student_det;
            this.fee_str = response.data.fee_str;
            this.misc_charges = response.data.misc_charges;
            this.other_charges = response.data.other_charges;
            var sh = null;
            $.each(this.misc_charges, function(i, mc) {
              if(mc.hon_exam_fee && mc.hon_exam_fee > exam_fee) {
                exam_fee = mc.hon_exam_fee;
                mc_exam_fee_obj = mc;
                exam_fee_type = 'H';
              }
              if(mc.pract_exam_fee && mc.pract_exam_fee > exam_fee) {
                exam_fee = mc.pract_exam_fee;
                mc_exam_fee_obj = mc;
                exam_fee_type = 'P';
              }
            })
            $.each(this.misc_charges, function(i, mc) {
              if(mc.hon_fee && mc.hon_fee > 0) {
                sh = self.getSubHead(mc.hon_id);
                self.fee_str.push({
                  feehead: 'Honours Fee (' + mc.subject + ')',
                  amount: mc.hon_fee
                });
              }
              if(mc_exam_fee_obj && mc_exam_fee_obj.id == mc.id) {
                sh = self.getSubHead(mc.exam_id);
                self.fee_str.push({
                  feehead: exam_fee_type == 'P' ? 'Pract. Exam. Fee':'Honours Exam. Fee',
                  amount: exam_fee
                });
              }


              // if(mc.hon_exam_fee && mc.hon_exam_fee > 0) {
              //   sh = self.getSubHead(mc.exam_id);
              //   self.fee_str.push({
              //     feehead: 'Honours Exam. Fee',
              //     amount: mc.hon_exam_fee
              //   });
              // }

              if(mc.pract_fee && mc.pract_fee > 0) {
                sh = self.getSubHead(mc.pract_id);
                self.fee_str.push({
                  feehead: 'Practical Fee (' + mc.subject + ')',
                  amount: mc.pract_fee
                });
              }

              // if(mc.pract_exam_fee && mc.pract_exam_fee > 0) {
              //   sh = self.getSubHead(mc.exam_id);
              //   self.fee_str.push({
              //     feehead: 'Pract. Exam. Fee',
              //     amount: mc.pract_exam_fee
              //   });
              // }
            });

            $.each(this.other_charges, function(i, oc) {
                sh = self.getSubHead(oc.sh_id);
                self.fee_str.push({
                  feehead: oc.name,
                  amount: oc.charges
                });
            });

          }, function(response) {
            this.fails = true;
            this.saving = false;
            if(response.status == 422)
              this.errors = response.data;
        });

        
      },

      getSubHead: function(id) {
        var sh = this.subheads.filter(function(s) {
          return s.id == id;
        });
        return sh ? sh[0] : null;
      },     
      
      resetForm: function() {
        this.form_loaded = false;
        this.student_det = {};
        this.fee_str = [];
        this.misc_charges = [];
      },

      hasErrors: function() {
        // console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
      
      admit: function() {
        $('#new-form').html('');
        $('#new-form').append('<form id="pay-form" action=\'{{ url("payadmfees") }}\' method="POST" >');
        $('#pay-form').append('{!! csrf_field() !!}')
            .append('<input type="hidden" name="form_no" value="' + this.formdata.form_no + '">')
            .append('<input type="hidden" name="amount" value="' + this.totalAmount + '">')
            .submit();
        console.log('here');
        return;
        this.errors = {};
        this.saving = true;
        this.$http.post("{{ url('payadmfees') }}", this.$data)
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
             // console.log(response);
            }, function (response) {
              this.fails = true;
              self = this;
              this.saving = false;
            //  this.response.errors = response.data;
              if(response.status == 422) {
                this.errors = response.data;
              }
//              console.log(response.data);              
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
    
    
  });
</script>
@stop
