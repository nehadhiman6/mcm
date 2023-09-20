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
      <div class="form-group">
        {!! Form::label('feehead_id','FeeHead',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3">
          <select class="form-control" name="feehead_id" v-model="feehead_id" @change='updateTotals'>
            <option value='0'>Select</option>
            <option v-for="head in filtered_feeheads" :value='head.id'>@{{ head.name }}</option>
          </select>
        </div>
      </div>
      <table class="table table-bordered" id="example1">
        <thead>
          <tr>
          <th>Fees Feehead</th>
            <th>Fees Subhead</th>
            <th v-for="c in courses">@{{ c.name }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in getFeeChart">
          <td>@{{ row.feehead }}</td>
            <td>@{{ row.sh }}</td>
            <td v-for="c in courses">@{{ row[c.id] }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
          <th></th>
            <th>Total:</th>
            <th id='@{{ "tot-"+c.id }}' v-for="c in courses">@{{ courseTotal(c.id) }}</th>
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
      fee_chart: [],
      std_type_id: {{ $stdtype->id or request("std_type_id", 0) }},
      installment_id: {{ request("installment_id", 0) }},
      report_inst_id: 0,
      feehead_id: {{ request("feehead_id", 0) }},
      type: 'All',
      courses: [
          @foreach($courses as $course){
            id: {{ $course->id }},
            name: "{{ $course->course_name }}",
           },
          @endforeach
      ],
      feeheads: {!! getFeehead(true) !!},
      subheads: {!! getSubHeadsJson(true) !!},
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
        if(this.report_inst_id == 0) {
          return [];
        }
        return this.feeheads.filter(function(h) {
          return h.fund == self.selected_installment.head_type;
        });
      },
      filtered_subheads: function() {
        var self = this;
        if(this.report_inst_id == 0) {
          return this.subheads;
        }
        return this.subheads.filter(function(h) {
          $cond = h.feehead.fund == self.selected_installment.head_type;
          if($cond && self.feehead_id > 0) {
            $cond = h.feehead.id == self.feehead_id;
          }
          return $cond;
        });
      },
      selected_installment: function() {
        var self = this;
        if(this.report_inst_id == 0) {
          return {};
        }
        var installment = this.installments.filter(function(inst) {
          return inst.id == self.report_inst_id;
        });
        return installment ? installment[0] : {};
      },
      selected_feehead: function() {
        var self = this;
        if(this.feehead_id == 0) {
          return {};
        }
        var feehead = this.feeheads.filter(function(fh) {
          return self.feehead_id == fh.id;
        });
        return feehead ? feehead[0] : {};
      },
      getFeeChart: function() {
        var self = this;
        var fee_chart = [];
        $.each(this.filtered_subheads, function(index, sh) {
          var row = {};
          row.sh = sh.name;
          row.feehead = sh.feehead.name;
          $.each(self.fee_str, function(index, fee_row) {
              if (sh.id == fee_row.subhead_id) {
                  row[fee_row.course_id] = fee_row.amount;
              }
          })
          fee_chart.push(row);
        });
        return fee_chart;
      },
    },
    methods: {
      showFees: function(e) {
        this.errors = {};
        this.saving = true;
        this.$http.get("{{ url('feestructure/subheads') }}",{ params: { std_type_id: this.std_type_id, installment_id: this.installment_id, type: this.type }})
          .then(function (response) {
            self = this;
            if (response.data['success']) {
              console.log('updating str...');
              this.report_inst_id = this.installment_id;
              this.fee_str = response.data.fee_str;
              // this.set_fee_chart();
              self = this;
              this.success = true;
              setTimeout(function() {
                self.success = false;
              }, 2000);
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
        console.log('for subhead is: '+fhId);
        var fee = _.where(this.fee_str, { "course_id": courseId, "subhead_id": fhId });
        if(fee.length > 0)
          return fee[0].amount;
        return '';
      },

      set_fee_chart: function() {
        var self = this;
        var fee_chart = [];
        $.each(this.filtered_subheads, function(index, sh) {
          var row = {};
          row.sh = sh.name;
          $.each(self.fee_str, function(index, fee_row) {
              if (sh.id == fee_row.subhead_id) {
                  row[fee_row.course_id] = fee_row.amount;
              }
          })
          // $.each(self.courses, function(index, course) {
          //   row[course.id] = 0;
          // });
          // console.log(row);
          fee_chart.push(row);
        });
        this.fee_chart = fee_chart;
      },
      
      courseTotal: function(courseId) {
//        console.log(courseId);
        var fees = _.where(this.fee_str, { "course_id": courseId });
        var t = 0;
        var self = this;
        var cond = this.feehead_id > 0 ? { feehead_id: this.feehead_id } : {};
        _.each(fees, function(ele, index) {
          cond.id = ele.subhead_id;
          if(!isNaN(ele.amount) && _.where(self.filtered_subheads, cond).length > 0)
            t += parseFloat(ele.amount);
        });
        this.$nextTick(function() {
          $('#tot-'+courseId).text(t);
        })
        return t;
      },
      updateTotals: function() {
        var self = this;
        this.courses.filter(function(c) {
          self.courseTotal(c.id);
        });
      }
    }
  });
</script>
@stop

