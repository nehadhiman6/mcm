@extends($dashboard)
@section('content')
<div id='app'>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Admission Entry</h3>
    </div>
    {!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
    <div class="box-body">
      <div class="form-group">
        {!! Form::label('admission_id','Online Form No',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <input type="text" v-model="admission_id" :disabled='form_loaded' number placeholder="Enter Online Form No." name="admission_id" class="form-control">
        </div>
        {!! Form::label('manual_formno','Manual Form No',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <input type="text" v-model="manual_formno" :disabled='form_loaded' number placeholder="ManualForm No." name="manual_formno" class="form-control">
        </div>
        <div class="col-sm-2">
          <label class="control-label">
            Centralized  
            <input type='checkbox' v-model="centralized"  v-bind:true-value="'Y'"  v-bind:false-value="'N'" :disabled='form_loaded' name='centralized'  class="checkbox-inline">
          </label>
        </div>
      </div>
      <div class="form-group" v-if="centralized=='Y'">
        {!! Form::label('adm_rec_no','Adm. Receipt NO. ',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('adm_rec_no',null,['class' => 'form-control','v-model'=>'adm_rec_no']) !!}
        </div>
        {!! Form::label('rcpt_date','Receipt Date',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('rcpt_date',null,['class' => 'form-control app-datepicker','v-model'=>'rcpt_date']) !!}
        </div>
         {!! Form::label('amount','Amount',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-1">
          {!! Form::text('amount',null,['class' => 'form-control','v-model'=>'amount']) !!}
        </div>
      </div>
    </div>
    <div class="box-footer">
      {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent' => 'showDetail',':disabled'=>'form_loaded']) !!}
      {!! Form::submit('RESET',['class' => 'btn btn-primary','@click.prevent' => 'resetForm','v-if'=>'form_loaded && admission_id == 0']) !!}
    </div>
    {!! Form::close() !!}
  </div>
  
  <div class="box box-primary" v-if="form_loaded">
    <div class="box-header with-border">
      <h3 class="box-title">Student Details</h3>
    </div>
    @if(isset($student_det))
    {!! Form::model($student_det, ['method' => 'PATCH', 'action' => ['Admissions\AdmEntryController@update', $student_det->id], 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
    @else
    {!! Form::model($student_det = new \App\AdmissionEntry(),['url' => 'adm-entries', 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
    @endif
    <div class="box-body">
      <fieldset class="student-detail">
        <legend>Student Details</legend>
        <div class='form-group'>
          {!! Form::label('loc_cat','Relevant Category',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['loc_cat'] }">
            <label class="radio-inline">
              {!! Form::radio('loc_cat', 'UT', null, ['class' => 'minimal','v-model'=>'student_det.loc_cat']) !!}
              UT Pool
            </label>
            <label class="radio-inline">
              {!! Form::radio('loc_cat', 'General', null, ['class' => 'minimal','v-model'=>'student_det.loc_cat']) !!}
              General Pool
            </label>
            <span id="basic-msg" v-if="errors['loc_cat']" class="help-block">@{{ errors['loc_cat'][0] }}</span>
          </div>
          {!! Form::label('geo_cat','For Information',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['loc_cat'] }">
            <label class="radio-inline">
              {!! Form::radio('geo_cat', 'Rural',null, ['class' => 'minimal','v-model'=>'student_det.geo_cat']) !!}
              RURAL
            </label>
            <label class="radio-inline">
              {!! Form::radio('geo_cat', 'Urban',null, ['class' => 'minimal','v-model'=>'student_det.geo_cat']) !!}
              URBAN
            </label>
            <span id="basic-msg" v-if="errors['geo_cat']" class="help-block">@{{ errors['geo_cat'][0] }}</span>
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('cat_id','Category',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['cat_id'] }">
            {!! Form::select('cat_id',getCategory(),null,['class' => 'form-control','v-model'=>'student_det.cat_id']) !!}
            <span id="basic-msg" v-if="errors['cat_id']" class="help-block">@{{ errors['cat_id'][0] }}</span>
          </div>
          {!! Form::label('resvcat_id','Reserved Category',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['resvcat_id'] }">
            {!! Form::select('resvcat_id',getResCategory(),null,['class' => 'form-control','v-model'=>'student_det.resvcat_id']) !!}
            <span id="basic-msg" v-if="errors['resvcat_id']" class="help-block">@{{ errors['resvcat_id'][0] }}</span>
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('nationality','Nationality',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['nationality'] }">
            {!! Form::text('nationality',null,['class' => 'form-control','v-model'=>'student_det.nationality']) !!}
            <span id="basic-msg" v-if="errors['nationality']" class="help-block">@{{ errors['nationality'][0] }}</span>
          </div>
          {!! Form::label('religion','Religion',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-5" v-bind:class="{ 'has-error': errors['religion'] }">
            <label class="radio-inline">
              {!! Form::radio('religion', 'Hindu',null, ['class' => 'minimal','v-model'=>'student_det.religion']) !!}
              HINDU
            </label>
            <label class="radio-inline">
              {!! Form::radio('religion', 'Sikh',null, ['class' => 'minimal','v-model'=>'student_det.religion']) !!}
              SIKH
            </label>
            <label class="radio-inline">
              {!! Form::radio('religion', 'Muslim',null, ['class' => 'minimal','v-model'=>'student_det.religion']) !!}
              MUSLIM
            </label>
            <label class="radio-inline">
              {!! Form::radio('religion', 'Christian',null, ['class' => 'minimal','v-model'=>'student_det.religion']) !!}
              CHRISTIAN
            </label>
            <label class="radio-inline">
              {!! Form::radio('religion', 'Others',null, ['class' => 'minimal','id'=>'others','v-model'=>'student_det.religion']) !!}
              OTHERS
            </label>
            <span id="basic-msg" v-if="errors['religion']" class="help-block">@{{ errors['religion'][0] }}</span>
          </div>
          <div id="checked" class='col-sm-4' style="display:none">
            {!! Form::label('other_religion','Mention here',['class' => 'col-sm-5 control-label']) !!}
            <div class="col-sm-6">
              {!! Form::text('other_religion',null,['class' => 'form-control','v-model'=>'student_det.other_religion']) !!}
            </div>
          </div>  
        </div>
        <div class="form-group">
          {!! Form::label('name','Name',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['name'] }">
            {!! Form::text('name',null,['class' => 'form-control','max-length'=>'50','v-model'=>'student_det.name']) !!}
            <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
          </div>
          {!! Form::label('dob','D.O.B',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['dob'] }">
            {!! Form::text('dob',null,['class' => 'form-control app-datepicker','v-model'=>'student_det.dob']) !!}
            <span id="basic-msg" v-if="errors['dob']" class="help-block">@{{ errors['dob'][0] }}</span>
          </div>
          {!! Form::label('email','Email',['class' => 'col-sm-1 control-label required']) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['email'] }">
            {!! Form::text('email',null,['class' => 'form-control','v-model'=>'email']) !!}
            <span id="basic-msg" v-if="errors['email']" class="help-block">@{{ errors['email'][0] }}</span>
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('mobile','Mobile',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['mobile'] }">
            {!! Form::text('mobile',null,['class' => 'form-control','max-length'=>'10','v-model'=>'student_det.mobile']) !!}
            <span id="basic-msg" v-if="errors['mobile']" class="help-block">@{{ errors['mobile'][0] }}</span>
          </div>
          {!! Form::label('aadhar_no','AAdhar No.',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3">
            {!! Form::text('aadhar_no',null,['class' => 'form-control','v-model'=>'student_det.aadhar_no']) !!}
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('father_name','Father',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['father_name'] }">
            {!! Form::text('father_name',null,['class' => 'form-control','v-model'=>'student_det.father_name']) !!}
            <span id="basic-msg" v-if="errors['father_name']" class="help-block">@{{ errors['father_name'][0] }}</span>
          </div>
          {!! Form::label('mother_name','Mother',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['mother_name'] }">
            {!! Form::text('mother_name',null,['class' => 'form-control','v-model'=>'student_det.mother_name']) !!}
            <span id="basic-msg" v-if="errors['mother_name']" class="help-block">@{{ errors['mother_name'][0] }}</span>
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('guardian_name','Guardian',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
            {!! Form::text('guardian_name',null,['class' => 'form-control','v-model'=>'student_det.guardian_name']) !!}
          </div>

          {!! Form::label('gender','Gender',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-4" v-bind:class="{ 'has-error': errors['gender'] }">
            <label class="radio-inline">
              {!! Form::radio('gender', 'Male',null, ['class' => 'minimal','v-model'=>'student_det.gender']) !!}
              Male
            </label>
            <label class="radio-inline">
              {!! Form::radio('gender', 'Female',null, ['class' => 'minimal','v-model'=>'student_det.gender']) !!}
              Female
            </label>
            <label class="radio-inline">
              {!! Form::radio('gender', 'Transgender',null, ['class' => 'minimal','v-model'=>'student_det.gender']) !!}
              Transgender
            </label>
            <span id="basic-msg" v-if="errors['gender']" class="help-block">@{{ errors['gender'][0] }}</span>
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('per_address','Permanent Address',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-4" v-bind:class="{ 'has-error': errors['per_address'] }">
            {!! Form::textarea('per_address', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'student_det.per_address']) !!}
            <span id="basic-msg" v-if="errors['per_address']" class="help-block">@{{ errors['per_address'][0] }}</span>
          </div>
          {!! Form::label('city','City',['class' => 'col-sm-1 control-label']) !!}
          <div class="col-sm-2">
            {!! Form::text('city',null,['class' => 'form-control','v-model'=>'student_det.city']) !!}
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('state_id','State',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
            {!! Form::select('state_id',getStates(),null,['class' => 'form-control','v-model'=>'student_det.state_id']) !!}
          </div>
          {!! Form::label('pincode','Pincode',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['pincode'] }">
            {!! Form::text('pincode',null,['class' => 'form-control','v-model'=>'student_det.pincode']) !!}
            <span id="basic-msg" v-if="errors['pincode']" class="help-block">@{{ errors['pincode'][0] }}</span>
          </div>
        </div>
      </fieldset>
      <fieldset>
        <legend>Subjects/Options You Want to Study</legend>
        <div class="form-group">
          {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-2">
            {!! Form::select('course_id',\App\Course::pluck('course_name','id'),null,['class' => 'form-control','v-model'=>'student_det.course_id','@change'=>'showSubs']) !!}
          </div>
          {!! Form::label('course_code','Course Code',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
            <p class="form-control-static">@{{ course_code}}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-offset-2 col-sm-10" id="course-det"></div>
        </div>
        <div class='form-group'>
          {!! Form::label('comp_subject','Compulsory Subjects:',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-10">
            <span class="control-label" v-for='ss in compSub'>
              @{{ $index+1 }}) @{{ ss.subject }} &nbsp;&nbsp;
            </span>
              <!--<strong> @{{ showCompSubs }} </strong>-->
          </div>
        </div>
        <ul class = ""><comp-grps v-for="cgrp in compGrp" :cgrp='cgrp' type='C'></comp-grps></ul>
        <div class="col-sm-8">
          <p><strong>Elective Subjects :</strong><span v-if = "course_id >0 ">Select Any Of The Following</span></p>
        </div>
        <div class="form-group">
          <div class="col-sm-8 col-sm-offset-2">
            <div v-for="sub in optionalSub">
              <div class="col-sm-12">
                <label class="checkbox">
                  <input type="checkbox" value= "@{{ sub.id }}" number v-model="selectedOpts">
                  @{{ sub.subject }}      
                </label>
              </div>
            </div>
          </div>
        </div>
        <ul class = ""> <comp-grps v-for="cgrp in optionalGrp" :cgrp='cgrp' type='O'></comp-grps></ul>
      </fieldset>
    </div>
    <div class="box-footer">
      <input class="btn btn-primary" id="btnsubmit" type="submit" value="SAVE" @click.prevent="admit">
    </div>
    {!! Form::close() !!}
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
 var no = 1000;
 var vm = new Vue({
    el: '#app',
    data: {
      response: {},
      student_det: {!! isset($student_det) ? json_encode($student_det) : '{}' !!},
      email: '{{ $student_user->email or "" }}',
      form_loaded: false,
      counter: 1,
      admission_id: {{ $adm_entry->id or 0 }},
      manual_formno: '',
      centralized: 'N',
      adm_rec_no: '',
      rcpt_date: '',
      amount: '',
      success: false,
      fails: false,
      msg: '',
      errors: {},
      
      compSub: {!! isset($compSubs) ? json_encode($compSubs) : '{}' !!},
      compGrp: {!! isset($compGrps) ? json_encode($compGrps) : '{}' !!},
      optionalSub: {!! isset($optionalSubs) ? json_encode($optionalSubs) : '{}' !!},
      optionalGrp: {!! isset($optionalGrps) ? json_encode($optionalGrps) : '{}' !!},
      selectedOpts: {!! isset($selectedOpts) ? json_encode($selectedOpts) : '[]' !!},
      
      course_id: 0,
      course_code: "{!! isset($course) ? $course->class_code : '' !!}",
      admitUrl: "{{  url('adm-entries') }}"
    },
    created: function() {
//      console.log("here");
//      console.log(this.compSub);
      if(this.admission_id > 0)
        this.form_loaded = true;
    },

    methods: {
      showDetail: function() {
        this.form_loaded = false;
        this.errors = {};
        data = {
          admission_id: this.admission_id,
          manual_formno: this.manual_formno,
          centralized: this.centralized,
          adm_rec_no: this.adm_rec_no,
          rcpt_date: this.rcpt_date,
          amount:this.amount,
          email: this.email,
        };
        this.$http.get("{{ url('adm-entries/create') }}", {params: data})
          .then(function (response) {
            if(response.data.success) {
              this.form_loaded = true;
              this.student_det = response.data.student_det;
              this.compSub = response.data.compSubs;
              this.compGrp = response.data['compGrps'];
              this.optionalSub = response.data['optionalSubs'];
              this.optionalGrp = response.data['optionalGrps'];
              this.selectedOpts = response.data['selectedOpts'] ? response.data['selectedOpts'] : [];
//              this.course_code = response.data['course'].class_code;
            }
          }, function(response) {
            this.fails = true;
            this.saving = false;
            if(response.status == 422)
              this.errors = response.data;
        });
      },
      
      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
      
      resetForm: function() {
        this.form_loaded = false;
        this.admission_id = '';
      },
      
      showSubs: function(e) {
        console.log(this.course_id);
        this.$http.post("{{ url('courses/subs') }}",{'course_id': this.student_det.course_id})
            .then(function (response) {
              //$('#').blockUI();
              this.compSub = response.data.compSubs;
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
      
      getAdmitUrl: function() {
        if(this.admission_id > 0)
           return this.admitUrl+'/'+this.admission_id;
        else
          return this.admitUrl;
      },
      
      admit: function() {
        this.errors = {};
        this.$http[this.getMethod()](this.getAdmitUrl(), this.$data)
          .then(function (response) {
            this.admission_id = response.data.admission_id;
            self = this;
            if (response.data.success) {
              self = this;
              this.success = true;
              setTimeout(function() {
                self.success = false;
//                console.log(self.admitUrl+'/' +self.admission_id +'/details');
               // window.location = self.admitUrl+'/' +self.admission_id +'/details';
              }, 3000);
            }
          }, function (response) {
            this.fails = true;
            self = this;
            if(response.status == 422) {
              $('body').scrollTop(0);
              this.errors = response.data;
            }              
          });
      },
      
      getMethod: function() {
        if(this.admission_id > 0)
          return 'patch';
        else
          return 'post';
      },
    },
    
    computed: {
      showCompSubs: function() {
      var compSubs = '';
      $.each(this.compSub, function(key, val) {
        compSubs += val.subject+' , ';
      });
//      console.log("Comp Subjects");
//      console.log(compSubs);
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
//            this.cgrp.selectedid = this.id;
          },
          unselected: function(e) {
            if(! this.checked) {
              $('.sub_'+this.cgrp.id).attr('checked', false);
            }
            this.checked = false;
            this.cgrp.selectedid = 0;
          },
        },
      },
    }
  });
</script>
@stop
