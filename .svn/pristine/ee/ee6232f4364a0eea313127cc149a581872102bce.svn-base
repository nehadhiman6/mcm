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
        {!! Form::label('std_type_id','Std. Type',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('std_type_id',getStudentType(),null,['class' => 'form-control', 'v-model' => 'std_type_id']) !!}
        </div>
        {!! Form::label('installment_id','Installment',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3">
          <select class="form-control" v-model="installment_id">
            <option value='0'>Select</option>
            <option v-for="inst in installments" :value='inst.id'>@{{ inst.name }}</option>
          </select>
        </div>
        {!! Form::label('type','Fee Type',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('type',['All' => 'All', 'Compulsory' => 'Compulsory', 'Optional' => 'Optional', 'Optional Default' => 'Optional Default'],null,['class' => 'form-control', 'v-model' => 'type']) !!}
        </div>
        {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'showFees']) !!}
      </div>
      <table class="table table-bordered" id="example1">
        <thead>
          <tr>
            <th>Fees Head</th>
            <th v-for="c in courses">@{{ c.name }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for='fh in filtered_feeheads'>
            <td>@{{ fh.name }}</td>
            <td v-for="c in courses">@{{ fhAmount(fh.id, c.id) }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Total:</th>
            <th v-for="c in courses">@{{ courseTotal(c.id) }}</th>
          </tr>
        </tfoot>
      </table>
    </div>
    {!! Form::close() !!}
  </div>
  {{ getVueData() }}
</div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      fee_str: {!! isset($fee_str) ? json_encode($fee_str) : '[]' !!},
      std_type_id: {{ $stdtype->id or request("std_type_id", 0) }},
      installment_id: {{ request("installment_id", 0) }},
      type: 'All',
      courses: [
          @foreach($courses as $course){
            id: {{ $course->id }},
            name: "{{ $course->course_name }}",
           },
          @endforeach
      ],
      feeheads: {!! getFeehead(true) !!},
      installments: {!! getInstallment('', true) !!},
      saving: false,
      success: false,
      fails: false,
      errors: [],
      response: {},
      show: false
    },
    
    created: function() {
      if(this.std_type_id > 0 && this.installment_id > 0) {
        this.showFees();
      }
    },
    computed: {
      filtered_feeheads: function() {
        var self = this;
        if(this.installment_id == 0) {
          return this.feeheads;
        }
        return this.feeheads.filter(function(h) {
          return h.fund == self.selected_installment.head_type;
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
        this.$http.get("{{ url('feestructure/feeheads') }}",{ params: { std_type_id: this.std_type_id, installment_id: this.installment_id, type: this.type }})
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
      
      fhAmount: function(fhId, courseId) {
        var fee = _.where(this.fee_str, { "course_id": courseId, "feehead_id": fhId });
        if(fee.length > 0)
          return fee[0].amount;
        return '';
      },
      
      courseTotal: function(courseId) {
//        console.log(courseId);
        var fees = _.where(this.fee_str, { "course_id": courseId });
        var t = 0;
        _.each(fees, function(ele, index) {
          if(!isNaN(ele.amount))
            t += parseFloat(ele.amount);
        });
//        console.log(t);
        $('#tot-'+courseId).text(t);
        return t;
      }
    }
  });
</script>
@stop

