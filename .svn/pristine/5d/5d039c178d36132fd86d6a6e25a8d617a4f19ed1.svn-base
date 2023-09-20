@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div id="app" v-cloak>
  <div class='panel panel-default'>
    <div class='panel-heading'>
      <strong>Fee Structure</strong>
    </div>
    <div class='panel-body'>
      {!! Form::open(['method' => 'GET',  'action' => ['Fees\FeeStructureController@create'], 'class' => 'form-horizontal']) !!}
      <div class="form-group">
        {!! Form::label('std_type_id','Std. Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('std_type_id',getStudentType(),null,['class' => 'form-control', 'v-model' => 'std_type_id']) !!}
        </div>
        {!! Form::label('installment_id','Installment',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::select('installment_id',getInstallment(),null,['class' => 'form-control', 'v-model' => 'installment_id']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('feehead_id','FeeHead',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          <select class="form-control" name="feehead_id" v-model="feehead_id">
            <option value='0'>Select</option>
            <option v-for="head in filtered_feeheads" :value='head.id'>@{{ head.name }}</option>
          </select>
        </div>

        <!-- {!! Form::label('fund_type','Fund Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('fund_type',['0'=>'All','College'=>'College','Hostel'=>'Hostel'],null,['class' => 'form-control','v-model' => 'fund_type']) !!}
        </div> -->
        <div class="col-sm-offset-1 col-sm-3">
          {!! Form::submit('Update',['class' => 'btn btn-primary', ':disabled' => "std_type_id == 0 || installment_id == 0 || feehead_id == 0"]) !!}
          {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'showFees', ':disabled' => "std_type_id == 0"]) !!}
        </div>
      </div>
      <table class="table table-bordered" id="example1">
        <thead>
          <tr>
            <th>Fees Type</th>
            <th v-for="c in courses">@{{ c.name }}</th>
          </tr>
        </thead>
        <tbody v-for='inst in installments'>
          <tr>
            <th colspan="@{{ courses.length+1 }}"><a href="#" data-inst-id='@{{ inst.id }}' class="btn btn-primary btn-sm" :disabled="std_type_id == 0" @click.prevent='showFeeHeadWise'>@{{ inst.name }}</a></th>
          </tr>
          <tr>
            <td>Compulsory Fees</td>
            <td v-for="c in courses">@{{ instAmount(inst.id, c.id, 'c') }}</td>
          </tr>
          <tr>
            <td>Optional Fees</td>
            <td v-for="c in courses">@{{ instAmount(inst.id, c.id, 'o') }}</td>
          </tr>
          <tr>
            <td>Opt. Default Fees</td>
            <td v-for="c in courses">@{{ instAmount(inst.id, c.id, 'd') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    {!! Form::close() !!}
  </div>
  {{ getVueData() }}
</div>
<div id='show-fee-head-wise'></div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      fee_str: {!! isset($fee_str) ? json_encode($fee_str) : '[]' !!},
      std_type_id: {{ $stdtype->id or request("std_type_id",0) }},
      installment_id: {{ request("installment_id", 0) }},
      // fund_type: {{ request("fund_type", 0) }},
      feehead_id: {{ request("feehead_id", 0) }},
      courses: [
          @foreach($courses as $course){
            id: {{ $course->id }},
            name: "{{ $course->course_name }}",
           },
          @endforeach
      ],
      installments: [
        @foreach($installments as $inst) {
          id: {{ $inst->id }},
          name: "{{ $inst->name }}",
          fund: "{{ $inst->head_type }}",
        },
        @endforeach
      ],
      feeheads: {!! getFeehead(true) !!},
      saving: false,
      success: false,
      fails: false,
      errors: [],
      response: {},
      show: false
    },
    computed: {
      filtered_feeheads: function() {
        var self = this;
        if(this.installment_id == 0) {
          return [];
        }
        return this.feeheads.filter(function(h) {
          return h.fund == self.selected_installment.fund;
        });
      },
      selected_installment: function() {
        var self = this;
        if(this.installment_id == 0) {
          return {};
        }
        var installment = this.installments.filter(function(inst) {
          return inst.id == self.installment_id;
        });
        return installment ? installment[0] : {};
      }
    },
    methods: {
      showFees: function(e) {
        this.errors = {};
        this.saving = true;
        this.$http.get("{{ url('feestructure') }}",{ params: { std_type_id: this.std_type_id }})
          .then(function (response) {
            this.fee_str = response.data;
            self = this;
            if (this.response['success']) {
              self = this;
              this.success = true;
              setTimeout(function() {
                self.success = false;
              }, 3000);
            }
            this.saving = false;
//            console.log(response);
          }, function (response) {
            this.fails = true;
            self = this;
            console.log(response.status);
            if(response.status == 422)
              this.errors = response.data;
            //console.log(response.data);              
            this.saving = false;
          });
      },
      
      showFeeHeadWise: function(e) {
        var link = e.target;
        var form = $('#show-fee-head-wise');
        $(form).html('');
        $(form).append('<form id="form-fee-head-wise" action=\'{{ url("feestructure/feeheads") }}\' method="GET" target="_blank">');
        $('#form-fee-head-wise')
            .append('<input type="hidden" name="std_type_id" value="' + this.std_type_id + '">')
            .append('<input type="hidden" name="installment_id" value="' + $(link).data('inst-id') + '">')
            .submit();
      },
      
      instAmount: function(instId, courseId, type) {
        var fee;
        if(type == 'c') {
          var fee = _.where(this.fee_str, { "course_id": courseId, "installment_id": instId, "optional": "N" });
          return fee.length > 0 ? fee[0].amount : '';
        }
        if(type == 'o') {
          var fee = _.where(this.fee_str, { "course_id": courseId, "installment_id": instId, "optional": "Y", "opt_default": "N" });
          return fee.length > 0 ? fee[0].amount : '';
        }
        if(type == 'd') {
          var fee = _.where(this.fee_str, { "course_id": courseId, "installment_id": instId, "optional": "Y", "opt_default": "Y" });
          return fee.length > 0 ? fee[0].amount : '';
        }
        return '';
      },
      
      courseTotal: function(courseId) {
//        console.log(courseId);
        var t = 0;
        _.each(this.fee_str, function(ele, index) {
          if(ele[0].course_id == courseId && !isNaN(ele[0].amount))
            t += parseFloat(ele[0].amount);
        });
//        console.log(t);
        $('#tot-'+courseId).text(t);
        return t;
      }
    }
  });
</script>
@stop

