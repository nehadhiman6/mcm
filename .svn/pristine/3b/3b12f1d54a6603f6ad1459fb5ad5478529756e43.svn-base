@extends($dashboard)
@section('toolbar')
@include('toolbars._admentry_toolbar')
@stop
@section('content')
<div id='app' v-cloak>
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Admission Entry</h3>
    </div>
    {!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
    <div class="box-body">
      <div class="form-group">
        {!! Form::label('std_type_id','Student Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['adm_entry.std_type_id'] }">
          {!! Form::select('std_type_id',getStudentType(),null,['class' => 'form-control','v-model'=>'adm_entry.std_type_id']) !!}
          <span id="basic-msg" v-if="errors['adm_entry.std_type_id']" class="help-block">@{{ errors['adm_entry.std_type_id'][0] }}</span>
        </div>
        {!! Form::label('admission_id','Online Form No',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['adm_entry.admission_id'] }">
          <input type="text" v-model="adm_entry.admission_id" :disabled='form_loaded || adm_entry.manual_formno.length > 0' number placeholder="Enter Online Form No." name="admission_id" class="form-control">
        </div>
      </div>
      @can('MANUAL-FORM-ADM')
      <div class="form-group" >
        {!! Form::label('manual_formno','Manual Form No',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['adm_entry.manual_formno'] }">
          <input type="number" v-model="adm_entry.manual_formno" :disabled='form_loaded || adm_entry.admission_id > 0' placeholder="ManualForm No." name="manual_formno" @blur='checkManualNo' class="form-control">
        </div>
        {{-- <div class="col-sm-2 col-sm-offset-1">
          <label class="control-label">
            Centralized  
            <input type='checkbox' v-model="adm_entry.centralized"  v-bind:true-value="'Y'"  v-bind:false-value="'N'" name='centralized'  class="checkbox-inline">
          </label>
        </div> --}}
      </div>
      @endcan
      <div class="form-group" >
        {!! Form::label('dhe_form_no','DHE Form No',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['adm_entry.dhe_form_no'] }">
          <input type="text" v-model="adm_entry.dhe_form_no" :disabled='form_loaded' placeholder="DHE Form No." name="dhe_form_no" class="form-control">
        </div>
      </div>
      <div class="form-group" v-if="adm_entry.centralized=='Y'">
        {!! Form::label('adm_rec_no','Adm. Receipt NO. ',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('adm_rec_no',null,['class' => 'form-control','v-model'=>'adm_entry.adm_rec_no']) !!}
        </div>
        {!! Form::label('rcpt_date','Receipt Date',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('rcpt_date',null,['class' => 'form-control app-datepicker','v-model'=>'adm_entry.rcpt_date']) !!}
        </div>
         {!! Form::label('amount','Amount',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('amount',null,['class' => 'form-control','v-model'=>'adm_entry.amount']) !!}
        </div>
      </div>
    </div>
    <div class="box-footer">
      {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent' => 'showDetail',':disabled'=>'form_loaded','v-if'=>'form_task == "create"']) !!}
      {!! Form::submit('RESET',['class' => 'btn btn-primary','@click.prevent' => 'resetForm','v-if'=>'form_loaded && form_task == "create"']) !!}
    </div>
    {!! Form::close() !!}
  </div>
  
  <div class="box box-primary" v-show="form_loaded">
    <div class="box-header with-border">
      <h3 class="box-title">Student Details</h3>
    </div>
    @if(isset($student_det))
    {!! Form::model($student_det, ['method' => 'PATCH', 'action' => ['Admissions\AdmEntryController@update', $student_det->id], 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
    @else
    {!! Form::open(['url' => 'adm-entries', 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
    @endif
    <div class="box-body">
      <fieldset class="student-detail">
        <legend>Student Details</legend>
        <div class="form-group">
          {!! Form::label('lastyr_rollno','Roll No',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.lastyr_rollno'] }">
            {!! Form::text('lastyr_rollno',null,['class' => 'form-control','max-length'=>'50','v-model'=>'student_det.lastyr_rollno']) !!}
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
          {!! Form::label('conveyance','Conveyence (Scooter/Motorcycle)',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['conveyance'] }">
            <label class="radio-inline">
              {!! Form::radio('conveyance', 'Y',null, ['class' => 'minimal','v-model'=>'student_det.conveyance']) !!}
              Yes
            </label>
            <label class="radio-inline">
              {!! Form::radio('conveyance', 'N',null, ['class' => 'minimal','v-model'=>'student_det.conveyance']) !!}
            No
            </label>
          </div>
          <span id="basic-msg" v-if="errors['conveyance']" class="help-block">@{{ errors['conveyance'][0] }}</span>
          <div>
            {!! Form::label('veh_no','Vehicle Number',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('veh_no',null,['class' => 'form-control','v-model'=>'student_det.veh_no']) !!}
            </div>
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('mobile','Mobile',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.mobile'] }">
            {!! Form::text('mobile',null,['class' => 'form-control','max-length'=>'10','v-model'=>'student_det.mobile']) !!}
          </div>
          <div v-if="hasStdUser()">
            {!! Form::label('email','Email',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['std_user.email'] }">
              {!! Form::text('email',null,['class' => 'form-control','v-model'=>'std_user.email']) !!}
            </div>
          </div>
        </div>
         <div class='form-group'>
          {!! Form::label('loc_cat','Relevant Category',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.loc_cat'] }">
            <label class="radio-inline">
              {!! Form::radio('loc_cat', 'UT', null, ['class' => 'minimal','v-model'=>'student_det.loc_cat']) !!}
              UT Pool
            </label>
            <label class="radio-inline">
              {!! Form::radio('loc_cat', 'General', null, ['class' => 'minimal','v-model'=>'student_det.loc_cat']) !!}
              General Pool
            </label>
           </div>
          {!! Form::label('geo_cat','Area',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.geo_cat'] }">
            <label class="radio-inline">
              {!! Form::radio('geo_cat', 'Rural',null, ['class' => 'minimal','v-model'=>'student_det.geo_cat']) !!}
              RURAL
            </label>
            <label class="radio-inline">
              {!! Form::radio('geo_cat', 'Urban',null, ['class' => 'minimal','v-model'=>'student_det.geo_cat']) !!}
              URBAN
            </label>
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('cat_id','Category',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.cat_id'] }">
            {!! Form::select('cat_id',getCategory(),null,['class' => 'form-control','v-model'=>'student_det.cat_id']) !!}
           </div>
          {!! Form::label('resvcat_id','Reserved Category',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.resvcat_id'] }">
            {!! Form::select('resvcat_id',getResCategory(),null,['class' => 'form-control','v-model'=>'student_det.resvcat_id']) !!}
           </div>
        </div>
        <div class="form-group">
          {!! Form::label('nationality','Nationality',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['student_det.nationality'] }">
            {!! Form::text('nationality',null,['class' => 'form-control','v-model'=>'student_det.nationality']) !!}
          </div>
          <!-- {!! Form::label('religion','Religion',['class' => 'col-sm-2 control-label required']) !!} -->
          <!-- <div class="col-sm-5" v-bind:class="{ 'has-error': errors['student_det.religion'] }">
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
          </div> -->
        </div>
        <div class="form-group">
          {!! Form::label('gender','Gender',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-4" v-bind:class="{ 'has-error': errors['student_det.gender'] }">
            <!-- <label class="radio-inline">
              {!! Form::radio('gender', 'Male',null, ['class' => 'minimal','v-model'=>'student_det.gender']) !!}
              Male
            </label> -->
            <label class="radio-inline">
              {!! Form::radio('gender', 'Female',null, ['class' => 'minimal','v-model'=>'student_det.gender']) !!}
              Female
            </label>
            <label class="radio-inline">
              {!! Form::radio('gender', 'Transgender',null, ['class' => 'minimal','v-model'=>'student_det.gender']) !!}
              Transgender
            </label>
           </div>
        </div>
      </fieldset>
      <fieldset>
        <legend>Subjects/Options You Want to Study</legend>
        <div class="form-group">
          {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['student_det.course_id'] }">
            {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'student_det.course_id','@change'=>'showSubs']) !!}
          </div>
          <!-- {!! Form::label('course_code','Course Code',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
            <p class="form-control-static">@{{ course_code}}</p>
          </div> -->
          <div class="form-group" >
            {!! Form::label('addon_course_id','Add-On Course',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::select('addon_course_id',getAddOnCourses(),null,['class' => 'form-control','v-model'=>'adm_entry.addon_course_id']) !!}
            </div>
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('honour_sub_id','Honour Subject:',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
            <select class="form-control" v-model='adm_entry.honour_sub_id'>
              <option value="0">Select Subject</option>
              <option v-for="sub in honoursSubjects" :value="sub.subject_id">@{{ sub.subject.subject }}</option>
            </select>
              <!--<strong> @{{ showCompSubs }} </strong>-->
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
        <!-- <div class="col-sm-8">
          <p><strong>Elective Subjects :</strong><span v-if = "student_det.course_id > 0">Select Any Of The Following</span></p>
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
        <ul class = ""> <comp-grps v-for="cgrp in optionalGrp" :cgrp='cgrp' type='O'></comp-grps></ul> -->
        <div class="col-sm-12" v-if='electives.length > 0'>
          <p>
            <h4><strong>Elective Subjects:</strong></h4><span v-if="min_optional >0 ">A student is required to select <strong>@{{ min_optional}} </strong> electives.</span><br>Choose any one option from the following & select two or more electives from the given choices</h>
          </p>
        </div>
        
        <div v-for="elective in electives">
          <div v-show='elective.elective_subjects.length > 0 || elective.groups.length > 0'>
            <div class="form-group" >
              <div class='col-sm-12'>
                <button class='tooltip-btn' @click.prevent='selectElective(elective.id)'>
                  <span class="tooltiptext">Click this to select subjects from given list</span>
                  <span v-if="elective.id != student_det.selected_ele_id" ><i class="glyphicon glyphicon-unchecked"  style="font-size:20px;margin-left:20px;color:black"> </i></span>&nbsp;&nbsp;
                  <span v-if="elective.id == student_det.selected_ele_id" class="glyphicon glyphicon-ok" style="font-size:20px;margin-left:10px;;margin-right:10px;color:green" aria-hidden="true"></span>
                  @{{ elective.name }}
                </button>
              </div>
            </div>
            <div v-if='student_det.selected_ele_id == 0 || elective.id == student_det.selected_ele_id'>
              <div class="form-group"  >
                <div class="col-sm-8 col-sm-offset-2" >
                  <div v-for="sub in elective.elective_subjects">
                    <div class="col-sm-12">
                      <label class="checkbox" >
                              <input type="checkbox" name= "optional_sub[]" value= "@{{ sub.subject_id }}" number v-model="selectedOpts" class="">
                              @{{ sub.subject.subject }}      
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <ul class = ""><comp-grps v-for="cgrp in elective.groups" :cgrp='cgrp' :type='cgrp.type' :disable-subjects="form_id > 0 && canChangeSubjects == false"></comp-grps></ul>
            </div>
          </div>
        </div>
        <!-- Elective Options -->
      </fieldset>
    </div>
    <div class="box-footer">
      <input class="btn btn-primary" id="btnsubmit" type="submit" :disabled="saving == true" value="@{{ (adm_entry.id && adm_entry.id > 0) ? 'UPDATE' : 'SAVE' }}" @click.prevent="admit" >
      <a href='{{ url("/") }}/adm-entries/@{{ adm_entry.id }}/printslip' target="_blank" v-if="adm_entry.id > 0"  
       class='btn btn-primary'>Print Slip
      </a>
      <span style="margin-left: 12px;font-size: large;"><strong>Total Fees: @{{ totalFee }}</strong></span>
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
            <input type="checkbox"  name='grps[@{{ type }}][@{{ cgrp.id }}]' value="" @change='unselected' v-model='checked'>

            <label class="radio-inline radio-margin" v-for="sub in cgrp.details" >
              <input type="radio" name="cmp_grp[@{{ cgrp.id }}]'" class="sub_@{{ cgrp.id }}" value="@{{ sub.ele_group_id ? sub.subject.id : sub.id }}" v-model="cgrp.selectedid" @click='selected'>
              <!--{!! Form::radio('cmp_grp[@{{ cgrp.id }}]',"@{{ sub.id }}" ,null, ['@click'=>'selected', 'class' => 'sub_@{{ cgrp.id }}']) !!}-->
              @{{ sub.ele_group_id ? sub.subject.subject : sub.subject }}
            </div>
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
      form_task: "{{ isset($form_task) ? $form_task : 'create' }}",
      form_loaded: false,
      adm_entry: {
        id: 0,
        std_type_id: 0,
        admission_id: 0,
        addon_course_id: 0,
        honour_sub_id: 0,
        manual_formno: '',
        dhe_form_no: '',
        centralized: 'N',
        adm_rec_no: "",
        rcpt_date: "",
        amount: "",
      },
      std_user: {},
      student_det: {!! isset($student_det) ? json_encode($student_det) : '{}' !!},
      success: false,
      fails: false,
      msg: '',
      errors: {},
      compSub: {!! isset($compSubs) ? json_encode($compSubs) : '{}' !!},
      compGrp: {!! isset($compGrps) ? json_encode($compGrps) : '{}' !!},
      optionalSub: {!! isset($optionalSubs) ? json_encode($optionalSubs) : '{}' !!},
      optionalGrp: {!! isset($optionalGrps) ? json_encode($optionalGrps) : '{}' !!},
      electives: {!! isset($electives) ? json_encode($electives) : '[]' !!},
      selectedOpts: {!! isset($selectedOpts) ? json_encode($selectedOpts) : '[]' !!},
      course_code: "{!! isset($course) ? $course->class_code : '' !!}",
      course: {},
      admitUrl: "{{  url('adm-entries') }}",
      honoursSubjects: [],
      response: {},
      totalFee: 0
    },
    ready: function() {
      if(this.form_task == 'edit') {
        this.form_loaded = true;
        this.adm_entry = {!! isset($adm_entry) ? json_encode($adm_entry) : '{}' !!};
        this.showDetail();
      }
    },

    methods: {
      checkManualNo: function() {
        if(this.adm_entry.std_type_id < 1) {
          this.errors = { 'adm_entry.std_type_id': ["Student Type is Required!"] };
          return;
        }
        this.errors = {};
        data = {
          adm_entry: this.adm_entry
        };
        this.$http.get("{{ url('adm-entries/chkmanual') }}", {params: data})
          .then(function (response) {
            this.form_loaded = true;
          }, function(response) {
            this.fails = true;
            if(response.status == 422)
              this.errors = response.data;
        });
      },
      
      showDetail: function() {
        if(this.adm_entry.std_type_id < 1) {
          this.errors = { 'adm_entry.std_type_id': ["Student Type is Required!"] };
          return;
        }
        this.form_loaded = false;
        this.errors = {};
        data = {
          adm_entry: this.adm_entry
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
              this.electives = response.data['electives'];
              this.selectedOpts = response.data['selectedOpts'] ? response.data['selectedOpts'] : [];
//              this.email = response.data.student_user ? response.data.student_user.email : '';
              this.std_user = response.data.student_det.std_user ? response.data.student_det.std_user : {};
        
//              this.adm_entry_id = response.data.student_det ? response.data.student_det.adm_entry_id : 0;
//              this.manual_formno = response.data.adm_entry ? response.data.adm_entry.manual_formno : '';
//              this.centralized = response.data.adm_entry ? response.data.adm_entry.centralized : 'N';
              this.course_code = response.data['course'] ? response.data['course'].class_code : '';
              this.honoursSubjects = response.data['honoursSubjects'];
              if(this.student_det.adm_entry && this.form_task == 'create') {
                this.adm_entry = this.student_det.adm_entry;
              } 
              // if(this.student_det.selected_ele_id > 0) {
              //   this.selectElective(-1);
              // }
            }
          }, function(response) {
            this.fails = true;
            this.saving = false;
            if(response.status == 422)
              this.errors = response.data;
        });
      },
      
      hasErrors: function() {
        // console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
      
      resetForm: function() {
        this.form_loaded = false;
        this.totalFee = 0;
        this.adm_entry = {
          id: 0,
          std_type_id: 0,
          admission_id: 0,
          addon_course_id: 0,
          manual_formno: '',
          centralized: 'N',
          adm_rec_no: "",
          rcpt_date: "",
          amount: "",
        };
        this.std_user = {};
        this.student_det = {};
        this.electives = [];
        this.course_code = "";
        this.compSub = [];
        this.compGrp = [];
        this.optionalSub = [];
        this.optionalGrp = [];
        this.selectedOpts = [];
        this.honoursSubjects = [];

      },
      
      showSubs: function(e) {
        // console.log(this.course_id);
        self = this;
        this.selectedOpts = [];
        this.$http.post("{{ url('courses/subs') }}",{'course_id': this.student_det.course_id})
            .then(function (response) {
              //$('#').blockUI();
              this.compSub = response.data.compSub;
              this.compGrp = response.data['compGrp'];
              this.optionalSub = response.data['optionalSub'];
              this.optionalGrp = response.data['optionalGrp'];
              this.course_code = response.data['course'].class_code;
//              console.log(this.course_code = response.data['course']);
              var electives = response.data.electives;
              $.each(electives, function(key, elective) {
                $.each(elective.groups, function(key, grp) {
                  if(typeof grp.selectedid == 'undefined') {
                    grp.selectedid = 0;
                  }
                });
              });
              this.electives = electives;
            }, function (response) {
              self = this;
              $.each(response.data, function(key, val) {
                self.msg += key+': '+val+' ';
              });
            });
      },
      
      admit: function() {
        var self = this;
        this.errors = {};
        var data = $.extend({'elective_grps': this.elective_grps}, this.$data);
        this.$http[this.getMethod()](this.getAdmitUrl(), data)
          .then(function (response) {
//            if(this.adm_entry_id == 0)
//              this.adm_entry_id = response.data.adm_entry_id;
            
            if (response.data.success) {
              if(!this.adm_entry.id)
                this.adm_entry.id = response.data.adm_entry_id;
              this.std_user.id = response.data.std_user_id;
              this.totalFee = response.data.totalFee;
              
              this.success = true;
              setTimeout(function() {
                self.success = false;
              }, 3000);
            }
          }, function (response) {
            this.fails = true;
            if(response.status == 422) {
//              $('body').scrollTop(0);
              this.errors = response.data;
            }              
          });
      },
      
      getAdmitUrl: function() {
        if(this.adm_entry.id && this.adm_entry.id > 0)
           return this.admitUrl+'/'+this.adm_entry.id;
        else
          return this.admitUrl;
      },
      
      getMethod: function() {
        if(this.adm_entry.id && this.adm_entry.id > 0)
          return 'patch';
        else
          return 'post';
      },
      
      hasStdUser: function() {
//        ! student_det) || (student_det.student_user && student_det.student_user.std_user_id == 0)
        if((!this.std_user) || isNaN(Number(this.std_user.id)) || Number(this.std_user.id) == 0)
          return true;
        return false;
      },
      selectElective: function(ele_id) {
        if(ele_id > -1) {
          this.student_det.selected_ele_id = this.student_det.selected_ele_id != ele_id ? ele_id : 0;
          this.selectedOpts = [];
        }
        var self = this;
        $.each(this.electives, function(key, elective) {
          if(elective.id == self.student_det.selected_ele_id) {
            $.each(elective.elective_subjects, function(key1, sub) {
              if(sub.sub_type == 'C') {
                self.selectedOpts.push(sub.subject_id);
              }
            });
          }
        });
      },
    },
    
    computed: {
      showCompSubs: function() {
      var compSubs = '';
      $.each(this.compSub, function(key, val) {
        compSubs += val.subject+', ';
      });
//      console.log("Comp Subjects");
//      console.log(compSubs);
      return compSubs;
     },
     elective_grps: function() {
        var ele_grps = [];
        var self = this;
        $.each(this.electives, function(key, elective) {
          if(elective.id == self.student_det.selected_ele_id) {
            $.each(elective.groups, function(key1, grp) {
              ele_grps.push(grp);
            });
          }
        });
        return ele_grps;
      },

    },
    
    components: {
      'comp-grps': {
        template: "#comp-grp-template",
        props: ['cgrp', 'type', 'disableSubjects'],
        data: function() {
          return {
            checked: false,
          };
        },
        ready: function() {
          this.updateChkState();
        },
        watch: {
          "cgrp.selectedid": function() {
            this.updateChkState();
          }
        },
        methods: {
          updateChkState: function() {
            var self = this;
            if(this.cgrp.selectedid > 0) {
              this.checked = true;
              var chks = $('.sub_'+this.cgrp.id);
              $(chks).each(function(index,value){
                if($(this).val() == self.cgrp.selectedid){
                  $(this).attr('checked',true);
                }
              });
            }
          },
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
