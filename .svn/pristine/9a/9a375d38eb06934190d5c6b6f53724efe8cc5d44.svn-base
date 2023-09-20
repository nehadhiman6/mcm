@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<a href="{{ url('/feestructure') }}" class="btn btn-primary" style="margin-bottom: 10px;">Back</a>
<!--<h3>Use Alt+c to copy the fee into same rows for zero values.</h3>-->
<div class="alert alert-info" role="alert">
  <strong>Use Alt+c to copy the fee into same rows for zero values.</strong>
</div>
<div class='panel panel-default' id="app" v-cloak>
  <div class='panel-heading'>
    <strong>Fee Structure</strong>
  </div>
  <div class="panel-body">
    {!! Form::open(['url' => 'feestructure', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('std_type_id','Student Type',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">{{$stdtype->name}}</p>
      </div>
      {!! Form::label('installment_id','Installment',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">{{$installment->name}}</p>
      </div>
      {!! Form::label('feehead_id','FeeHead',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">{{$feehead->name}}</p>
      </div>
    </div>
    <table class="table table-bordered" id="example1">
      <thead>
        <tr>
          <th>Sub FeeHeads</th>
          <th v-for='course in courses'>@{{ course.name }}</th>
         </tr>
      </thead>
      <tbody>
        <tr v-for='sh in subheads'>
          <td>@{{ sh.name }}</td>
          <td v-for='course in courses'>
          <div class="on-focus clearfix" style="position: relative; padding: 0px; margin: 10px auto; display: table; float: left">
          <input type="text" class=" form-control" v-model="fee_str[sh.id+'_'+course.id][0]['amount']" @change="courseTotal(course.id)" number @keyup.alt.67="updateFees(sh.id,course.id)">
          <div class="tool-tip slideIn top">
            Course: @{{ course.name}} <br>Subhead: @{{ sh.name }}</div>
          </div>
            <strong>Optional: </strong><input type="checkbox" class="minimal" :true-value="'Y'" :false-value="'N'" v-model="fee_str[sh.id+'_'+course.id][0]['optional']" >
            <div  v-if="fee_str[sh.id+'_'+course.id][0]['optional']=='Y'">
              <strong>Default: </strong><input type="checkbox" class="minimal" :true-value="'Y'" :false-value="'N'" v-model="fee_str[sh.id+'_'+course.id][0]['opt_default']">
            </div>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th>Totals</th>
          <th id="tot-@{{ course.id }}" v-for='course in courses'>@{{ courseTotal(course.id) }}</th>
         </tr>
      </tfoot>
    </table>
  </div>
  <div class="panel-footer">
      <input type="submit" class = "btn btn-primary" :disabled="saving" value="SAVE"  @click.prevent="saveFees">
       {!! Form::close() !!}
  </div>
  <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="fails">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
  {{ getVueData() }}
</div>
@stop
@section('script')
<script>
var vm = new Vue({
    el: '#app',
    data: {
      fee_str: {!! json_encode($fee_str) !!},
      std_type_id: {{ $stdtype->id or request("std_type_id",0) }},
      installment_id: {{ $install->id or request("installment_id",0) }},
      feehead_id: {{ $feehead->id or request("feehead_id",0) }},
      subheads:[
        @foreach($feehead->subHeads as $subhead){
            id: {{ $subhead->id }},
            name: "{{ $subhead->name }}",
           },
        @endforeach
      ],
      courses: [
          @foreach($courses as $course){
            id: {{ $course->id }},
            name: "{{ $course->course_name }}",
           },
          @endforeach
      ],
      saving: false,
      success: false,
      fails: false,
      errors: [],
      response: {},
      show: false
    },
    methods: {
      saveFees: function(e) {
        this.errors = {};
        this.saving = true;
        this.$http.post("{{ url('/feestructure') }}", this.$data)
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
      },
      updateFees: function(subhead_id, course_id) {
        self = this;
        var this_ele = {};
        _.each(this.fee_str, function(ele, index) {
          if(ele[0].subhead_id == subhead_id && ele[0].course_id == course_id) {
            this_ele = ele;
          }
        });
        if(_.isEmpty(this_ele) || isNaN(this_ele[0].amount) || this_ele[0].amount <= 0)
          return;
        _.each(this.fee_str, function(ele, index) {
          if(ele[0].subhead_id == subhead_id && ele[0].course_id != course_id) {
            if(isNaN(ele[0].amount) || ele[0].amount <= 0)
              ele[0].amount = this_ele[0].amount;
          }
        });
        
      }
    }
  });
</script>
@stop
