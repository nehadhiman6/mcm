@extends('app')
@section('content')
<div class="box box-info" id='app'>
  <div class="box-header with-border">
    <h2 class="box-title">Edit</h2>
  </div>
  {!! Form::open(['method' => 'PATCH',  'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['student.course_id'] }">
        {!! Form::select('course_id',\App\Course::pluck('course_name','id'),null,['class' => 'form-control','v-model'=>'course_id','@change'=>'showSubs']) !!}
      </div>
      {!! Form::label('course_code','Course Code',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">@{{ course_code}}</p>
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('subject_id','Subjects : ',['class' => 'col-sm-2 control-label']) !!}
      {!! Form::label('comp_subject','Compulsory Groups : ',['class' => 'col-sm-2 control-label']) !!}
      <ul class = ""><comp-grps v-for="cgrp in compGrp" :cgrp='cgrp' type='C'></comp-grps></ul>
    </div>
    <div class="form-group">
      <div v-bind:class="{ 'has-error': errors['opt_subs_count'] }">
        <div class="col-sm-8">
          <p><strong>Elective Subjects:</strong><span v-if = "min_optional >0 "> Select Any <strong>@{{ min_optional}} </strong>Of The Following</span></p>
        </div>
        <div class="form-group" >
          <div class="col-sm-8 col-sm-offset-2" >
            <div v-for="sub in optionalSub">
              <div class="col-sm-12">
                <label class="checkbox">
                  <input type="checkbox" name= "optional_sub[]" value= "@{{ sub.id }}" number v-model="selectedOpts" class="">
                  @{{ sub.subject }}      
                </label>
              </div>
            </div>
          </div>
        </div>
        <ul class = ""> <comp-grps v-for="cgrp in optionalGrp" :cgrp='cgrp' type='O'></comp-grps></ul>
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('Update',['class' => 'btn btn-primary','@click.prevent'=>'updateCourse']) !!}
  </div>
  {!! Form::close() !!}
  <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
  {{ getVueData() }}
</div>
<template id="comp-grp-template" >
  <div class="col-sm-10 col-sm-offset-2">
    <li>
      <div class='form-group'>
        <div class="input-group">
          <label class="checkbox-inline" >
            <input type="checkbox" name='grps[@{{ type }}][@{{ cgrp.id }}]' value="" @change='unselected' v-model='checked'>

            <label class="radio-inline radio-margin" v-for="sub in cgrp.details" >
              <input type="radio" name="cmp_grp[@{{ cgrp.id }}]'" class="sub_@{{ cgrp.id }}" value="@{{ sub.id }}" v-model="cgrp.selectedid" @click='selected'>
              <!--{!! Form::radio('cmp_grp[@{{ cgrp.id }}]',"@{{ sub.id }}" ,null, ['@click'=>'selected', 'class' => 'sub_@{{ cgrp.id }}']) !!}-->
              @{{ sub.subject }}
            </label>
          </label>
        </div>
      </div>
    </li>

  </div>
</template>
@stop
@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      student_id: {{ $student->id }},
      course_id : {{ $student->course_id or 0}},
     // min_optional: "{!! isset($course) ? $course->min_optional : '' !!}",
      compSub: {!! isset($compSubs) ? json_encode($compSubs) : '{}' !!},
      compGrp: {!! isset($compGrps) ? json_encode($compGrps) : '{}' !!},
      optionalSub: {!! isset($optionalSubs) ? json_encode($optionalSubs) : '{}' !!},
      optionalGrp: {!! isset($optionalGrps) ? json_encode($optionalGrps) : '{}' !!},
      selectedOpts: {!! isset($selectedOpts) ? json_encode($selectedOpts) : '[]' !!},
      course_code: "{!! isset($course) ? $course->class_code : '' !!}",
      response: {},
      success: false,
      fails: false,
      msg: '',
      errors: [],
    },
    created: function() {
      //  this.showDetail();
    },
    methods: {
      showSubs: function(e) {
          console.log(this.course_id);
          this.selectedOpts = [];
          this.$http.post("{{ url('courses/subs') }}",{'course_id': this.course_id})
              .then(function (response) {
                //$('#').blockUI();
                this.compSub = response.data.compSub;
                this.compGrp = response.data['compGrp'];
                this.optionalSub = response.data['optionalSub'];
                this.optionalGrp = response.data['optionalGrp'];
                this.course_code = response.data['course'].class_code;
  //              console.log(this.course_code = response.data['course']);
                self = this;
              }, function (response) {
                self = this;
                $.each(response.data, function(key, val) {
                  self.msg += key+': '+val+' ';
                });
              });
      },
      
      updateCourse: function() {
        console.log('here');
          this.errors = {};
          this.$http['post']("{{ url('students/') .'/' . $student->id .'/course'}}", this.$data)
            .then(function (response) {
              self = this;
              if(response.data.success) {
                this.response = response.data;
                this.success = true;
                setTimeout(function() {
                  self.success = false;
                }, 3000);
              }
            }, function (response) {
              this.fails = true;
              self = this;
              if(response.status == 422) {
                this.errors = response.data;
              }              
            });
      },
      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
    },
    
    computed: {
      showCompSubs: function() {
      var compSubs = '';
      $.each(this.compSub, function(key, val) {
        compSubs += val.subject+' , ';
      });
      return compSubs;
     },
    },
    components: {
      'comp-grps': {
        template: "#comp-grp-template",
        props: ['cgrp', 'type'],
        data: function() {
          return {
            checked: false,
          };
        },
        ready: function() {
          if(this.cgrp.selectedid > 0) {
            this.checked = true;
            self = this;
            var chks = $('.sub_'+this.cgrp.id);
            $(chks).each(function(index,value){
              if($(this).val() == self.cgrp.selected){
                $(this).attr('checked',true);
              }
            });
          }
        },
        methods: {
          selected: function(e) {
            this.checked = true;
          },
          unselected: function(e) {
            if(! this.checked) {
              $('.sub_'+this.cgrp.id).attr('checked', false);
            }
            this.checked = false;
            this.cgrp.selectedid = 0;
          },
        },
      }
    }
  });
</script>
@stop