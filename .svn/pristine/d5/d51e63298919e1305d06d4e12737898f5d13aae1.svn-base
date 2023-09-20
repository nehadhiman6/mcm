<template id="student-detail-template">
  <fieldset>
      <legend><strong>Student's Details</strong></legend>
      <!-- <div class='form-group' v-if="form_id == 0"> -->
      <div class='form-group' >
          {!! Form::label('last_exam_mcm',"If ".config('college.college_name_short')."  Student in previous semester?",['class' => 'col-sm-4 control-label required', 'v-if' => "! admForm.adm_entry_id"]) !!}
            <div class="col-sm-2" v-if = "! admForm.adm_entry_id">
              <label class="radio-inline">
                {!! Form::radio('last_exam_mcm', 'Y',null, ['class' => 'minimal','v-model'=>'last_exam_mcm','@change'=>'lastExamStatus',':disabled'=>'form_id > 0 && app_guard != "web"']) !!}
              Yes
              </label>
              <label class="radio-inline">
                {!! Form::radio('last_exam_mcm', 'N',null, ['class' => 'minimal','v-model'=>'last_exam_mcm','@change'=>'lastExamStatus',':disabled'=>'form_id > 0 && app_guard != "web"']) !!}
                No
              </label>
            </div>
            {!! Form::label('lastyr_rollno','Enter College Roll no.',['class' => 'col-sm-3 control-label required','v-if'=>'last_exam_mcm == "Y"']) !!}
            <div class="col-sm-2" v-if="last_exam_mcm =='Y'" v-bind:class="{ 'has-error': errors['lastyr_rollno'] }"> 
              {!! Form::text('lastyr_rollno',null,['class' => 'form-control','v-model'=>'lastyr_rollno','@blur'=>'getStudentDetails',':disabled'=>'form_id > 0 && app_guard != "web"']) !!}
            <span id="basic-msg" v-if="errors['lastyr_rollno']" class="help-block">@{{ errors['lastyr_rollno'][0] }}</span>
        </div>
      </div>

      <div class="form-group">
        <label  style="margin-top: -15px; margin-bottom: 20px; color:#1f86d2" class="col-sm-4 control-label">(All UG 1 and PG 1 applicants must select 'No' here)</label>
      </div>

      <div class="form-group">
        {!! Form::label('course_type','Course Type',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
          {!! Form::select('course_type',[''=>'Select','GRAD'=>'UG','PGRAD'=>'PG'],(isset($course_type) ? $course_type : ''),['class' => 'form-control','v-model'=>'course_type',':disabled'=>'oldstudentDetails.course_id || last_exam_mcm =="Y" && app_guard != "web"']) !!}
        </div>
    
        {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-lg-2 col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
          <select class="form-control" v-model="course_id" @change='showSubs' number :disabled="oldstudentDetails.course_id ||last_exam_mcm =='Y' && app_guard != 'web' ">
            <option v-for="course in getCourses" value="@{{ course.id }}">@{{ course.course_name }}</option>
          </select>
          <span id="basic-msg" v-if="errors['course']" class="help-block">@{{ errors['course'][0] }}</span>
          <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
        </div>
        {!! Form::label('course_code','Course Code',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ course_code}}</p>
        </div>
      </div>
    
      <div class='form-group'>
        {!! Form::label('loc_cat','Relevant Category',['class' => 'col-sm-2 control-label required' ,'v-if'=>'showPool']) !!}
        {{-- {!! Form::label('loc_cat','Relevant Category',['class' => 'col-sm-2 control-label required' ,'v-if'=>'course_type == "PGRAD"']) !!} --}}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['loc_cat'] }" v-if="showPool">
        {{-- <div class="col-sm-3" v-bind:class="{ 'has-error': errors['loc_cat'] }" v-if="course_type == 'PGRAD'"> --}}
          <label class="radio-inline">
            {!! Form::radio('loc_cat', 'UT',null, ['class' => 'minimal','v-model'=>'loc_cat']) !!}
            UT Pool
          </label>
          <label class="radio-inline">
            {!! Form::radio('loc_cat', 'General',null, ['class' => 'minimal','v-model'=>'loc_cat']) !!}
            General Pool
          </label>
          <span id="basic-msg" v-if="errors['loc_cat']" class="help-block">@{{ errors['loc_cat'][0] }}</span>
        </div>
        {!! Form::label('geo_cat','Area',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['loc_cat'] }">
          <label class="radio-inline">
            {!! Form::radio('geo_cat', 'Rural',null, ['class' => 'minimal','v-model'=>'geo_cat']) !!}
            RURAL
          </label>
          <label class="radio-inline">
            {!! Form::radio('geo_cat', 'Urban',null, ['class' => 'minimal','v-model'=>'geo_cat']) !!}
            URBAN
          </label>
          <span id="basic-msg" v-if="errors['geo_cat']" class="help-block">@{{ errors['geo_cat'][0] }}</span>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('minority','Minority',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['minority'] }">
          <label class="radio-inline">
            {!! Form::radio('minority', 'Y',null, ['class' => 'minimal','v-model'=>'minority']) !!}
            Yes
          </label>
          <label class="radio-inline">
            {!! Form::radio('minority', 'N',null, ['class' => 'minimal','v-model'=>'minority']) !!}
            No
          </label>
          <span id="basic-msg" v-if="errors['minority']" class="help-block">@{{ errors['minority'][0] }}</span>
        </div>
        <div  v-if="minority == 'Y'">
          {!! Form::label('religion','Religion',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-5" v-bind:class="{ 'has-error': errors['religion'] }">
            <label class="radio-inline">
              {!! Form::radio('religion', 'Sikh',null, ['class' => 'minimal','v-model'=>'religion']) !!}
              SIKH
            </label>
            <label class="radio-inline">
              {!! Form::radio('religion', 'Muslim',null, ['class' => 'minimal','v-model'=>'religion']) !!}
              MUSLIM
            </label>
            <label class="radio-inline">
              {!! Form::radio('religion', 'Christian',null, ['class' => 'minimal','v-model'=>'religion']) !!}
              CHRISTIAN
            </label>
            <label class="radio-inline">
              {!! Form::radio('religion', 'Others',null, ['class' => 'minimal','id'=>'others','v-model'=>'religion']) !!}
              OTHERS
            </label>
            
            <span id="basic-msg" v-if="errors['religion']" class="help-block">@{{ errors['religion'][0] }}</span>
          </div>
          <div v-if="religion == 'Others'" v-bind:class="{ 'has-error': errors['other_religion'] }">
              <div class="col-sm-5"></div>
              {!! Form::label('other_religion','Mention here',['class' => 'col-sm-2 control-label required']) !!}
              <div class="col-sm-3">
                {!! Form::text('other_religion',null,['class' => 'form-control','v-model'=>'other_religion']) !!}
              </div>
            <span id="basic-msg" v-if="errors['other_religion']" class="help-block">@{{ errors['other_religion'][0] }}</span>
          </div>  
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('sports_seat','Are you seeking admission against sports seat?',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-1" v-bind:class="{ 'has-error': errors['sports_seat'] }">
          <label class="col-sm-1 checkbox">
              <input type="checkbox" name="sports_seat" v-model = 'sports_seat' value='Y' class="minimal" v-bind:true-value="'Y'"
                    v-bind:false-value="'N'"> Yes
          </label>
          <span id="basic-msg" v-if="errors['sports_seat']" class="help-block">@{{ errors['sports_seat'][0] }}</span>
        </div>
        {!! Form::label('sport_name','Sport Name',['class' => ' col-sm-2 control-label required','v-if'=>"sports_seat =='Y'"]) !!}
        <div class="col-sm-3">
        {!! Form::text('sport_name',null,['class' => 'form-control','v-model'=>'sport_name','v-if'=>"sports_seat =='Y'"]) !!}
        </div>
      </div>
      <div class="form-group">
       
        <div class="col-sm-12">
            <p><i style="color: #a94442;
              font-weight: 900;">Please attach proof, if other than General category.</i></p>
        </div>
       
      </div>
      <div class="form-group">
        {!! Form::label('cat_id','Category',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['cat_id'] }">
          {!! Form::select('cat_id',getCategory(),null,['class' => 'form-control','v-model'=>'cat_id','@change'=>'isForeignNational']) !!}
          <span id="basic-msg" v-if="errors['cat_id']" class="help-block">@{{ errors['cat_id'][0] }}</span>
        </div>
        {!! Form::label('resvcat_id','Reserved Category',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['resvcat_id'] }">
          {!! Form::select('resvcat_id',getResCategory(),null,['class' => 'form-control','v-model'=>'resvcat_id','id'=>'resvcat_id']) !!}
          <span id="basic-msg" v-if="errors['resvcat_id']" class="help-block">@{{ errors['resvcat_id'][0] }}</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('nationality','Nationality',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['nationality'] }">
    <!--      <input type="text" v-model="nationality" class="form-control" null :readonly = "foreign_national=='N'" >-->
          {!! Form::text('nationality',null,['class' => 'form-control','v-model'=>'nationality',':readonly'=>'foreign_national=="N"']) !!}
          <span id="basic-msg" v-if="errors['nationality']" class="help-block">@{{ errors['nationality'][0] }}</span>
        </div>
        <span v-if="course_unq_id == 'MSC-CHEM' &&  course_year == '1' ">
            {!! Form::label('add_res_cats','Aditional Reserved Category',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4" v-bind:class="{ 'has-error': errors['add_res_cats'] }">
              <select name="add_res_cats" id="add_res_cats" class='form-control select2' multiple="multiple">
                <option v-for="res in addrescategory" :value="res.id">@{{ res.name }}</option>
              </select>
              {{-- {!! Form::select('add_res_cats',getResCategory(),null,['class' => 'form-control select2','id'=>'add_res_cats','multiple']) !!} --}}
              <span id="basic-msg" v-if="errors['add_res_cats']" class="help-block">@{{ errors['add_res_cats'][0] }}</span>
            </div>
        </span>
      </div>
      <div class="form-group">
      {!! Form::label('differently_abled','Differently Abled',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['differently_abled'] }">  
          <label class="radio-inline">
              {!! Form::radio('differently_abled', 'Y',null, ['class' => 'minimal','v-model'=>'differently_abled']) !!}
              Yes
            </label>
            <label class="radio-inline">
              {!! Form::radio('differently_abled', 'N',null, ['class' => 'minimal','v-model'=>'differently_abled']) !!}
              No
            </label>
            <span id="basic-msg" v-if="errors['differently_abled']" class="help-block">@{{ errors['differently_abled'][0] }}</span>
          </div>
        <div v-if="differently_abled == 'Y'"  v-bind:class="{ 'has-error': errors['remarks_diff_abled'] }">
            {!! Form::label('remarks_diff_abled','Please Specify',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3">
              {!! Form::text('remarks_diff_abled',null,['class' => 'form-control','v-model'=>'remarks_diff_abled']) !!}
            </div>
            <span id="basic-msg" v-if="errors['remarks_diff_abled']" class="help-block">@{{ errors['remarks_diff_abled'][0] }}</span>
          </div>
      </div>
      <div class="form-group">
       
        <div class="col-sm-12">
            <p><i style="color: #a94442;
              font-weight: 900;">The applicant's name, father's name, mother's name, and DOB should be as they appear in the records of the last class passed.</i></p>
        </div>
       
      </div>
      <div class="form-group">
        {!! Form::label('name','Name of Applicant',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['name'] }">
          {!! Form::text('name',null,['@blur' =>'uppercaseLetters()','class' => 'form-control','max-length'=>'50','v-model'=>'name' ,':disabled'=>'oldstudentDetails.name && app_guard != "web"']) !!}
          <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
        </div>
        {!! Form::label('dob','D.O.B',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['dob'] }">
          {!! Form::text('dob',null,['class' => 'form-control app-datepicker','v-model'=>'dob', ':disabled'=>'form_not_editable && oldstudentDetails.dob && inOffice == false && app_guard != "web"']) !!}
          <span id="basic-msg" v-if="errors['dob']" class="help-block">@{{ errors['dob'][0] }}</span>
        </div>
      </div>

      
      <div class='form-group'>
        {!! Form::label('father_name',"Father's Name",['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['father_name'] }">
          {!! Form::text('father_name',null,['@blur' =>'uppercaseLetters()','class' => 'form-control','v-model'=>'father_name' ,':disabled'=>'oldstudentDetails.father_name && app_guard != "web"']) !!}
          <span id="basic-msg" v-if="errors['father_name']" class="help-block">@{{ errors['father_name'][0] }}</span>
        </div>
        {!! Form::label('mother_name',"Mother's Name",['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['mother_name'] }">
          {!! Form::text('mother_name',null,['@blur' =>'uppercaseLetters()','class' => 'form-control','v-model'=>'mother_name'  ,':disabled'=>'oldstudentDetails.mother_name && app_guard != "web"']) !!}
          <span id="basic-msg" v-if="errors['mother_name']" class="help-block">@{{ errors['mother_name'][0] }}</span>
        </div>
      </div>
      <div class="form-group">
          {!! Form::label('mobile','Applicant Mobile No.',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['mobile'] }">
            {!! Form::text('mobile',null,['class' => 'form-control','max-length'=>'10','v-model'=>'mobile']) !!}
            <span id="basic-msg" v-if="errors['mobile']" class="help-block">@{{ errors['mobile'][0] }}</span>
          </div>
          {!! Form::label('gender','Gender',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-4" v-bind:class="{ 'has-error': errors['gender'] }">
              <label class="radio-inline">
                {!! Form::radio('gender', 'Female',null, ['class' => 'minimal','v-model'=>'gender']) !!}
                Female
              </label>
              <label class="radio-inline">
                {!! Form::radio('gender', 'Transgender',null, ['class' => 'minimal','v-model'=>'gender']) !!}
                Transgender
              </label>
              <span id="basic-msg" v-if="errors['gender']" class="help-block">@{{ errors['gender'][0] }}</span>
          </div>
      </div>
      <div class="form-group">
        {!! Form::label('guardian_name',"Guardian's Name (if any)",['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['guardian_name'] }">
          {!! Form::text('guardian_name',null,['@blur' =>'uppercaseLetters()','class' => 'form-control','v-model'=>'guardian_name']) !!}
          <span id="basic-msg" v-if="errors['guardian_name']" class="help-block">@{{ errors['guardian_name'][0] }}</span>
        </div>
        {!! Form::label('guardian_relationship','Relationship with Guardian (if any)',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['guardian_relationship'] }">
          {!! Form::text('guardian_relationship',null,['class' => 'form-control','v-model'=>'guardian_relationship']) !!}
          <span id="basic-msg" v-if="errors['guardian_relationship']" class="help-block">@{{ errors['guardian_relationship'][0] }}</span>
        </div>
        
      </div>
      <div class="form-group">
      {!! Form::label('aadhar_no','Aadhar No.',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['aadhar_no'] }" :disabled = "no_adhar != ''">
          {!! Form::text('aadhar_no',null,['class' => 'form-control','v-model'=>'aadhar_no' ,':disabled'=>"adhar_card == 'N'", '@blur'=>'getAadharno()']) !!}
          <input type ="checkbox" v-model = "adhar_card"  value='N' class="minimal" v-bind:true-value="'N'"
                  v-bind:false-value="'Y'"> No Aadhar
          <span id="basic-msg" v-if="errors['aadhar_no']" class="help-block">@{{ errors['aadhar_no'][0] }}</span>
        </div>
    
      {!! Form::label('epic_no','EPIC No.(Voter card number)',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['epic_no'] }">
          {!! Form::text('epic_no',null,['class' => 'form-control','v-model'=>'epic_no','pattern'=>'[0-9]',':disabled'=>"epic_card == 'N'"]) !!}
          <input type ="checkbox"  v-model = 'epic_card' value='N' class="minimal" v-bind:true-value="'N'"
                  v-bind:false-value="'Y'"> No Voter card
          <span id="basic-msg" v-if="errors['epic_no']" class="help-block">@{{ errors['epic_no'][0] }}</span>
        </div>
      </div>
    
      <div class="form-group">
          {!! Form::label('conveyance','Conveyance (Scooter/Motorcycle)',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['conveyance'] }">
            <label class="radio-inline">
              {!! Form::radio('conveyance', 'Y',null, ['class' => 'minimal','v-model'=>'conveyance']) !!}
              Yes
            </label>
            <label class="radio-inline">
              {!! Form::radio('conveyance', 'N',null, ['class' => 'minimal','v-model'=>'conveyance']) !!}
            No
            </label>
          </div>
          <span id="basic-msg" v-if="errors['conveyance']" class="help-block">@{{ errors['conveyance'][0] }}</span>
            <div v-if="conveyance == 'Y'">
            {!! Form::label('veh_no','Vehicle Number',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('veh_no',null,['class' => 'form-control','v-model'=>'veh_no']) !!}
            </div>
          </div>
      </div>
      <div class="form-group">

        <div v-show="showBoarder">
          <label for = "boarder" class="col-sm-2 control-label required">Boarder/Day Scholar</label>
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['boarder'] }" >
            <label class="radio-inline">
              {!! Form::radio('boarder', 'boarder',null, ['class' => 'minimal','v-model'=>'boarder']) !!}
              Boarder
            </label>
            <label class="radio-inline">
              {!! Form::radio('boarder', 'day',null, ['class' => 'minimal','v-model'=>'boarder']) !!}
              DayScholar
            </label>
            <span id="basic-msg" v-if="errors['boarder']" class="help-block">@{{ errors['boarder'][0] }}</span>
          </div>
        </div>


        {!! Form::label('blood_grp','Blood Group',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2" v-bind:class="{ 'has-error': errors['blood_grp'] }">
          {!! Form::select('blood_grp',getBloodGroup(),null,['class' => 'form-control','v-model'=>'blood_grp',':disabled'=>'oldstudentDetails.blood_grp && app_guard != "web"']) !!}
          <span id="basic-msg" v-if="errors['blood_grp']" class="help-block">@{{ errors['blood_grp'][0] }}</span>
        </div>
      </div>
      
    
      <div class="form-group">
        {!! Form::label('per_address','Permanent Address',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-lg-3 col-sm-4" v-bind:class="{ 'has-error': errors['per_address'] }">
          {!! Form::textarea('per_address', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'per_address']) !!}
          <span id="basic-msg" v-if="errors['per_address']" class="help-block">@{{ errors['per_address'][0] }}</span>
        </div>
        <!--    
          {!! Form::label('same_address','Same as Permanent Address',['class' => 'col-sm-1 control-label']) !!}-->
        <div class="col-sm-1">
          <label class="checkbox-inline">
            <input type="checkbox" id="same_addr" v-model = 'same_address' value="Y" class="minimal" v-bind:true-value="'Y'"
                  v-bind:false-value="'N'" @change ="copy_address" class='minimal'/>
          </label>
          <p class="text-sm">Same Address</p>
        </div>
        {!! Form::label('corr_address',' Address for Correspondence',['class' => 'col-lg-1 col-sm-2  control-label']) !!}
        <div class="col-lg-3 col-sm-3">
          {!! Form::textarea('corr_address', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'corr_address']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('city','City',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-lg-2 col-sm-4" v-bind:class="{ 'has-error': errors['city'] }">
          {!! Form::text('city',null,['class' => 'form-control','v-model'=>'city']) !!}
          <span id="basic-msg" v-if="errors['city']" class="help-block">@{{ errors['city'][0] }}</span>
        </div>
        {!! Form::label('corr_city','City',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-lg-2 col-sm-3">
          {!! Form::text('corr_city',null,['class' => 'form-control','v-model'=>'corr_city']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('state_id','State',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-lg-2 col-sm-4" v-bind:class="{ 'has-error': errors['state_id'] }">
          {!! Form::select('state_id',getStates(),null,['class' => 'form-control','v-model'=>'state_id']) !!}
          <span id="basic-msg" v-if="errors['state_id']" class="help-block">@{{ errors['state_id'][0] }}</span>
        </div>
        {!! Form::label('corr_state_id','State',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-lg-2 col-sm-3">
          {!! Form::select('corr_state_id',getStates(),null,['class' => 'form-control','v-model'=>'corr_state_id']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('pincode','Pincode',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-lg-2 col-sm-3" v-bind:class="{ 'has-error': errors['pincode'] }">
          {!! Form::text('pincode',null,['class' => 'form-control','v-model'=>'pincode']) !!}
          <span id="basic-msg" v-if="errors['pincode']" class="help-block">@{{ errors['pincode'][0] }}</span>
        </div>
        {!! Form::label('corr_pincode','Pincode',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-lg-2 col-sm-3">
          {!! Form::text('corr_pincode',null,['class' => 'form-control','v-model'=>'corr_pincode']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('abc_id','ABC ID (Academic Bank Of Credits)',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-lg-2 col-sm-3" v-bind:class="{ 'has-error': errors['abc_id'] }">
          {!! Form::text('abc_id',null,['class' => 'form-control','v-model'=>'abc_id']) !!}
          <span id="basic-msg" v-if="errors['abc_id']" class="help-block">@{{ errors['abc_id'][0] }}</span>
        </div>
      </div>

      <fieldset class="mb-3">
        <legend><strong>Hostel</strong></legend>
        <div class="form-group">
            <div class="col-sm-7">
            <p class= "control-label"><b>NOTE : Hostel seat allotment is subject to the filling of hostel form and availability of seats.</b></p>
            </div>
        </div>
        <div class='form-group'>
            {{-- {!! Form::label('hostel','Seeking Hostel Seat',['class' => 'col-sm-2 control-label','v-if'=>"getSelectedCourse && getSelectedCourse.course_year == '1'"]) !!}
            {!! Form::label('hostel','Applied for Hostel',['class' => 'col-sm-2 control-label','v-else']) !!} --}}
            {!! Form::label('hostel','Seeking Hostel Seat',['class' => 'col-sm-2 control-label']) !!}            <div class="col-sm-1">
            <label class="col-sm-1 checkbox">
                <input type="checkbox" name="hostel" v-model = 'hostel' value='Y' class="minimal" v-bind:true-value="'Y'"
                    v-bind:false-value="'N'">
            </label>
            </div>
        </div>
      </fieldset>

      {{-- <fieldset class="mb-3">
        <legend><strong>Vaccination Status</strong></legend>
        <div class="form-group">
            <div class="col-sm-6">
            <p class= "control-label required" style="text-align:left"><b>Have you been Vaccinated for COVID-19 ?</b></p>
            <!-- <p class= "control-label" style="text-align:left"><b>(Attach certificate under 'Attachments' section)</b></p> -->
          </div>
        </div>
        <div class='form-group'>
          <div class="col-sm-6">
                <label class="radio-inline">
                  {!! Form::radio('vaccinated', 'Dose 1',null, ['class' => 'minimal','v-model'=>'vaccinated','@change'=>'vacciRemarks()']) !!}
                  <b>Dose 1</b> 
                </label>
                <label class="radio-inline">
                  {!! Form::radio('vaccinated', 'Dose 2',null, ['class' => 'minimal','v-model'=>'vaccinated','@change'=>'vacciRemarks()']) !!}
                  <b>Dose 2 </b>
                </label>

                <label class="radio-inline">
                  {!! Form::radio('vaccinated', 'Dose 3',null, ['class' => 'minimal','v-model'=>'vaccinated','@change'=>'vacciRemarks()']) !!}
                  <b>Dose 3 (Precaution Dose)</b>
                </label>

                <label class="radio-inline">
                  {!! Form::radio('vaccinated', 'Not Yet',null, ['class' => 'minimal','v-model'=>'vaccinated','@change'=>'vacciRemarks()']) !!}
                  <b>Not Yet</b>
                </label>
                <span id="basic-msg" v-if="errors['vaccinated']" class="help-block">@{{ errors['vaccinated'][0] }}</span>
            </div>
        </div>

        <div class="form-group" v-if="vaccinated =='Not Yet'">
            <div class="col-sm-12 ">
            <p class= "control-label required" style="text-align:left"><b>If not vaccinated, specify reason(s):</b></p>
            <!-- (Certify the same from a qualified physician and attach proof under ''Attachments' section) -->
            </div>
        </div>
        <div class="form-group" v-if="vaccinated =='Not Yet'">
          <div class="col-lg-8 col-sm-6 vaccinated" v-bind:class="{ 'has-error': errors['vaccination_remarks'] }">
            {!! Form::textarea('vaccination_remarks',null,['class' => 'form-control','v-model'=>'vaccination_remarks']) !!}
            <span id="basic-msg" v-if="errors['vaccination_remarks']" class="help-block">@{{ errors['vaccination_remarks'][0] }}</span>
          </div>
       
      </div>
      </fieldset> --}}
      {{-- <span id="basic-msg" class="help-block">Please 'Update' data, in case of any changes, before leaving the current tab !</span> --}}
      <span id="basic-msg" class="help-block">Click the "Update" button before leaving the current tab, in case there have been any changes.</span>
      <input class="btn btn-primary"  type="button" :value="admForm.active_tab >= 1 ? 'Update' : 'Submit'" @click.prevent="submit">
      <input v-on:click="rediretNextTab" v-show="active_tab >= 1" class="btn btn-primary"  type="button" value="Next" >
    </div>
  </fieldset>
  <div>
    <ul class="alert alert-error alert-dismissible" role="alert" v-show="hasErrors">
      <li  v-for='error in errors'>@{{ error }} </li>
    </ul>
  </div>
</template>

@push('vue-components')
<script>
var studentDetail = Vue.extend({
    template: '#student-detail-template',
    props:['courses','course_id', 'active_tab', 'admForm', 'form_id', 'showIfOldStd','compSub','compGrp','optionalSub','optionalGrp','electives'],
    data: function(){
      return {
        last_exam_mcm: '',
        lastyr_rollno:'',
        same_address: "{{ $adm_form->same_address == 'Y' ? 'Y' : 'N' }}",
        // form_id: {{ $adm_form->id or 0 }},
        app_guard: "{{ isset($guard) ? $guard : '' }}",
        manual_formno: '',
        form_not_editable: {{ $adm_form->std_id > 0 ? 'false' : 'true' }},  //for dob only 
        cat_id: 0,
        resvcat_id: 0,
        other_religion:'',
        dob: '',
        loc_cat: '',
        geo_cat: '',
        nationality: '',
        religion: 'NA',
        name: '',
        mobile: '',
        aadhar_no: '',
        epic_no:'',
        father_name: "{{ $adm_form->father_name }}", 
        mother_name: '',
        guardian_name: '',
        boarder:'',
        conveyance:'',
        veh_no:'',
        hostel: 'N',
        sports_seat:"{{ $adm_form->sports_seat == 'Y' ? 'Y' : 'N' }}",
        sport_name:'',
        blood_grp: '',
        per_address: '',
        city: '',
        state_id: 0,
        pincode: '',
        abc_id:'',
        corr_address: '',
        corr_city: '',
        corr_state_id: 0,
        foreign_national: '',
        foreigner: false,
        corr_pincode: '',
        migration: "{{ $adm_form->migration == 'Y' ? 'Y' : 'N' }}" ,
        gender: '',
        sports: "{{ $adm_form->sports == 'Y' ? 'Y' : 'N' }}",
        cultural: "{{ $adm_form->cultural == 'Y' ? 'Y' : 'N' }}",
        academic: "{{ $adm_form->academic == 'Y' ? 'Y' : 'N' }}",
        course_code: "{!! isset($course) ? $course->class_code : '' !!}",
        course_type: "",
        minority:"{{ $adm_form->minority == 'Y' ? 'Y' : 'N' }}",
        differently_abled:"{{ $adm_form->differently_abled == 'Y' ? 'Y' : 'N' }}",
        remarks_diff_abled:'',
        epic_card:"{{ isset($adm_form->epic_card)? ($adm_form->epic_card == 'Y' ? 'Y' : 'N') : 'Y' }}",
        adhar_card:"{{ isset($adm_form->adhar_card) ? ($adm_form->adhar_card == 'Y' ? 'Y' : 'N') :'Y'  }}",
        guardian_relationship:'',
        vaccinated:'',
        vaccination_remarks:'',
        reservedcatList:[],
        oldstudentDetails:{
          name: false,
          mother_name: false,
          father_name: false,
          course_id: false,
          dob: false
        },
        old_subjects: [],

        //basic
        response: {},
        success: false,
        fails: false,
        msg: '',
        errors: [],
        createUrl: 'student-adm-details',
        add_res_cats:'',
		    addrescategory: {!! getAddResCategory(true) !!},
        course_unq_id:'',
        course_year:'',
        old_aadhar_no : ''
      }
    },
    ready: function(){
      var self = this;
      if(self.admForm && self.admForm.id > 0){
        self.setDataForForm(self.admForm);
      }
      
      this.addResCategorySelect();
      

    },
    computed: {
      hasErrors: function() {
        return Object.keys(this.errors).length > 0;
      },

      getCourseType: function() {
        var self = this;
        var c = self.getSelectedCourse;
        return c ? c.status : '';
      },

      getCourses: function() {
        var self = this;
        return self.courses.filter(function(course) {
          return course.status == self.course_type;
        });
      },

      inOffice: function() {
        @if(isset($guard) && $guard == 'web')
          return true;
        @else
          return false;
        @endif
      },
      
      getSelectedCourse() {
        var self = this;
        if(this.course_id == 0)
          return null;
        var c = this.courses.filter(function(course){
          return course.id == self.course_id;
        });
        return c ? c[0] : null;
      },
     
      showPool:function(){
        var self = this;
        if(self.course_type == 'PGRAD'){
          return true;
          
        }
        else{
          if(self.getSelectedCourse){
            var showPoolCourses = ['BCA','BBA','BCOM','BSC','BCOM-SF','MCOM','MSC','BSC-COMP','BSC-NMED','BSC-MED','MSC-COMP','MSC-MATH','MSC-CHEM'];
            if(showPoolCourses.includes(self.getSelectedCourse.course_id)){
              self.loc_cat = '';
            }
            else{
              self.loc_cat = ' ';
            }
            console.log(showPoolCourses.includes(self.getSelectedCourse.course_id));
            return showPoolCourses.includes(self.getSelectedCourse.course_id);
          }
          self.loc_cat = ' ';
          return false;
        }
          
      },

      showBoarder:function(){
        if(this.getSelectedCourse && this.getSelectedCourse.course_year && (this.getSelectedCourse.course_year == 2 || this.getSelectedCourse.course_year == 3)){
          return true;
        }
        return false;
      },
      
    },

    methods:{
      getAadharno: function() {
        // console.log(aadhar_no);
        var self = this; 
        var a = '';
        if(self.aadhar_no != null){
          self.old_aadhar_no = self.aadhar_no
          a = self.aadhar_no.replace(/\d(?=\d{4})/g, "•");
        }
        // console.log(aadhar_no);
        self.aadhar_no = a; 
      },
      vacciRemarks:function(){
          var self = this;
          if(self.vaccinated != 'Not Yet'){
              self.vaccination_remarks = '';
          }
      },

      uppercaseLetters:function(field){
        this.name = this.name.toUpperCase();
        this.father_name = this.father_name.toUpperCase();
        this.mother_name = this.mother_name.toUpperCase();
        this.guardian_name = this.guardian_name.toUpperCase();
      },

      rediretNextTab: function(){
        $('a[href="#parent-detail"]').click();
      },

      submit: function() {
        var self = this;
        self.errors = {};
        var data = self.setFormData();
        self.$http[self.getMethod()](self.getUrl(), data)
          .then(function (response) {
            // if(self.form_id == undefined || ! self.form_id) {
            //   window.location.href = "{{ url('/') }}/new-adm-form";
            // }
            if (response.data.success) {
              window.location.href = "{{ url('/') }}/new-adm-form";
              self.form_id = response.data.form_id;
              self.active_tab = response.data.active_tab;
              // self.admForm = response.data.adm_form;
              self.admForm.active_tab = response.data.active_tab;
              self.compSub =  response.data.compSub;
              self.compGrp =  response.data.compGrp;
              self.optionalSub =  response.data.optionalSub;
              self.optionalGrp =  response.data.optionalGrp;
              self.electives =  response.data.electives;
              self.course_type = response.data.course_type;
              
              $.blockUI({ message: '<h3> Record successfully saved !!</h3>' });
              setTimeout(function(){
                  $.unblockUI();
              },1000);
              

              // setTimeout(function() {
              //   self.success = false;
              //   window.location = self.admitUrl+'/' +self.form_id +'/details';
              // }, 3000);
            }
          }, function (response) {
            self.fails = true;
            console.log('df;hlkfdlkghfkld');
            if(response.status == 422) {
              $('body').scrollTop(0);
              self.errors = response.data;
            }              
          });
      },

      setFormData: function(){
        return {
            active_tab: this.admForm.active_tab > 0 ? this.admForm.active_tab :  1,
            foreign_national: this.foreign_national,
            course_id: this.course_id,
            last_exam_mcm: this.last_exam_mcm,
            lastyr_rollno:this.lastyr_rollno,
            same_address: this.same_address,
            form_id: this.form_id,
            app_guard:this.app_guard,
            manual_formno: this.manual_formno,
            cat_id:this.cat_id,
            resvcat_id:this.resvcat_id,
            other_religion:this.other_religion,
            dob: this.dob,
            loc_cat: this.loc_cat,
            geo_cat: this.geo_cat,
            nationality: this.nationality,
            religion:  this.religion,
            name: this.name,
            mobile: this.mobile,
            aadhar_no: this.old_aadhar_no,
            epic_no:this.epic_no,
            father_name:  this.father_name,
            mother_name: this.mother_name,
            guardian_name: this.guardian_name,
            boarder:this.boarder,
            conveyance:this.conveyance,
            veh_no:this.veh_no,
            sports_seat: this.sports_seat,
            sport_name:this.sport_name,
            blood_grp: this.blood_grp,
            per_address: this.per_address,
            city: this.city,
            state_id:this.state_id,
            pincode: this.pincode,
            abc_id: this.abc_id,
            corr_address: this.corr_address,
            corr_city: this.corr_city,
            corr_state_id:this.corr_state_id,
            corr_pincode: this.corr_pincode,
            migration:  this.migration,
            gender: this.gender,
            hostel: this.hostel,
            sports: this.sports,
            cultural:  this.cultural,
            academic: this.academic,
            course_code:  this.course_code,
            // course_type: this.getCourseType,
            minority: this.minority,
            differently_abled: this.differently_abled,
            remarks_diff_abled:this.remarks_diff_abled,
            epic_card: this.epic_card,
            adhar_card: this.adhar_card,
            guardian_relationship: this.guardian_relationship,
            vaccinated:this.vaccinated,
            vaccination_remarks:this.vaccination_remarks,
            add_res_cats:this.add_res_cats,
        }
      },

      setDataForForm: function(std_det){
            this.active_tab = std_det.active_tab,
            this.course_id = std_det.course_id;
            this.foreign_national = std_det.foreign_national;
            this.last_exam_mcm = std_det.lastyr_rollno != null ? 'Y' : 'N' ;
            this.lastyr_rollno = std_det.lastyr_rollno;
            this.same_address = std_det.same_address;
            this.form_id = std_det.id;
            this.app_guard = std_det.app_guard;
            this.manual_formno = std_det.manual_formno;
            this.cat_id = std_det.cat_id;
            this.resvcat_id = std_det.resvcat_id;
            this.other_religion = std_det.other_religion;
            this.dob = std_det.dob;
            this.loc_cat = std_det.loc_cat;
            this.geo_cat = std_det.geo_cat;
            this.nationality = std_det.nationality;
            this.religion =  std_det.religion;
            this.name = std_det.name;
            this.mobile = std_det.mobile;
            
            this.epic_no = std_det.epic_no;
            this.father_name =  std_det.father_name;
            this.mother_name = std_det.mother_name;
            this.guardian_name = std_det.guardian_name;
            this.boarder = std_det.boarder;
            this.conveyance = std_det.conveyance;
            this.veh_no = std_det.veh_no;
            this.sports_seat = std_det.sports_seat;
            this.sport_name = std_det.sport_name;
            this.blood_grp = std_det.blood_grp;
            this.per_address = std_det.per_address;
            this.city = std_det.city;
            this.state_id = std_det.state_id;
            this.pincode = std_det.pincode;
            this.abc_id = std_det.abc_id;
            this.corr_address = std_det.corr_address;
            this.corr_city = std_det.corr_city;
            this.corr_state_id = std_det.corr_state_id;
            this.corr_pincode = std_det.corr_pincode;
            this.migration =  std_det.migration;
            this.gender = std_det.gender;
            this.hostel = std_det.hostel;
            this.sports = std_det.sports;
            this.cultural =  std_det.cultural;
            this.academic = std_det.academic;
            this.course_code =  std_det.course_code;
            this.course_type = this.getCourseType;
            this.minority = std_det.minority;
            this.differently_abled = std_det.differently_abled;
            this.remarks_diff_abled = std_det.remarks_diff_abled;
            this.epic_card = std_det.epic_card;
            this.adhar_card = std_det.adhar_card;
            this.guardian_relationship = std_det.guardian_relationship;
            this.vaccinated = std_det.vaccinated;
            this.vaccination_remarks = std_det.vaccination_remarks;
            
            this.course_unq_id = std_det.course.course_id;
            this.course_year = std_det.course.course_year;
            this.aadhar_no = std_det.aadhar_no;
            var self = this;
            setTimeout(function(){
              self.addResCategorySelect();
              if(std_det.add_res_cats != null){
              var tt = std_det.add_res_cats;
              this.add_res_cats =tt.split(',');
              $('#add_res_cats').val(this.add_res_cats).trigger('change');
            }
            },400)

            self.getAadharno();
            

      },

      addResCategorySelect:function(){
        var self = this;
        var select1 = $("#add_res_cats")
        .select2({
            placeholder: "Multi Select",
            width:"100%",
        })
        .on("change", function(e) {
          // console.log(e);
          var stt = $("#add_res_cats").val();
          // console.log(stt.join());
          self.add_res_cats = stt.join();
        });
      },

      getMethod: function() {
        if(this.form_id > 0)
          return 'patch';
        else
          return 'post';
      },

      getUrl: function() {
        if(this.form_id > 0)
          return 'student-adm-details/'+this.form_id;
        else
          return 'student-adm-details';
      },

      lastExamStatus: function() {
        var self = this;
        if(self.last_exam_mcm == 'N') {
          self.lastyr_rollno = '';
          self.resetOldData();
          if(self.admForm && self.admForm.id > 0)
            self.active_tab = 0;
        }
      },

      resetOldData: function() {
        var self = this;
        self.old_subjects = [];
        self.course_id = 0;
        self.disable_pbi_in_tenth = false;
        for (let field in self.oldstudentDetails) {
          self.oldstudentDetails[field] = false;
        }
      },

      getStudentDetails: function() {
        var self = this;
        if((self.lastyr_rollno && self.lastyr_rollno.trim().length > 0 && self.form_id > 0) || (self.admForm.adm_entry && self.admForm.adm_entry.dhe_form_no.trim().length > 0)) {
          return ;
        }
        if(self.lastyr_rollno.trim().length == 0) {
          return;
        }
        self.resetOldData();
        self.$http['get']('admforms/'+ self.lastyr_rollno + '/studentinfo')
          .then(function (response) {
            var student = response.data.data;
            if(response.data.success == true){
              for (let field in student) {
                  if(self.$data.hasOwnProperty(field) && typeof(self.$data[field]) != 'function') {
                    self.$data[field] = student[field];
                  }
              }
              // disable field
              for (let field in student) {
                  if(self.$data.oldstudentDetails.hasOwnProperty(field)) {
                     if(student[field] != ""){
                       console.log(student[field]);
                       self.oldstudentDetails[field] = true;
                     }
                  }
              }
              if(student.aadhar_no){
                self.adhar_card = 'Y';
              }
              if(student.epic_no){
                self.epic_card = 'Y';
              }
              self.course_id = response.data.next_course_id;
              self.course_type = self.getCourseType;
              self.old_subjects = response.data.old_subjects;
              if(response.data.old_hon_sub && response.data.old_hon_sub.length > 0) {
                self.old_honour = response.data.old_hon_sub;
              }
              self.showSubs();
            } else{
               alert("Not a valid Roll no.");
               self.lastyr_rollno = '';
            }
          })
          .catch(function(){

          });
      },

      showSubs: function(e) {
        var self = this;
        self.$emit('updateCourseId','this.course_id');
        self.selected_ele_id = 0;
        self.$http.post("{{ url('courses/subs') }}",{'course_id': self.course_id})
          .then(function (response) {
            self.compSub = response.data['compSub'];
            // self.compGrp = response.data['compGrp'];
            self.optionalSub = response.data['optionalSub'];
            self.optionalGrp = response.data['optionalGrp'];
            self.course_code = response.data['course'].class_code;
            self.course_unq_id = response.data['course'].course_id;
            self.course_year = response.data['course'].course_year;
            self.min_optional = response.data['course'].min_optional;
            var honoursSubjects = response.data['honours'];
            $.each(honoursSubjects, function(index, hSub) {
              hSub.opted = false;
              hSub.selected = false;
              hSub.preference = 0;
            });
            self.honoursSubjects = honoursSubjects;
            var electives = response.data.electives;
            $.each(electives, function(key, elective) {
              $.each(elective.groups, function(key, grp) {
                if(typeof grp.selectedid == 'undefined') {
                  grp.selectedid = 0;
                }
              });
            });
            self.electives = electives;
            self.showOldStudentSubjects();
            setTimeout(function(){
              self.addResCategorySelect();

            },400)
          }, function (response) {
            $.each(response.data, function(key, val) {
              self.msg += key+': '+val+' ';
            });
          });
      },

      showOldStudentSubjects: function() {
        var self = this;
        self.selectedOpts = [];
        if(self.course_id) {
          if(!self.canChangeSubjects){
            self.old_subjects.forEach(function(arr){
              self.selectedOpts.push(arr.subject_id);
            });
            // self.getElectiveGrp();
            // self.getCompGrp();
          }
        }
      },

      isForeignNational: function(e){
        var self = this;
        var selected = $('#cat_id option:selected').text();
        self.foreigner = selected.toUpperCase().search('FOREIGN') > -1;
        if(self.foreigner) {
          self.foreign_national = 'Y';
          if(self.nationality == 'INDIAN') {
            self.nationality = '';
          }
          var str = [];    
          if(self.reservedcatList.length == 0){
            $("#resvcat_id option").each(function () {
              if($(this)[0].value != ''){
                  str.push({text:$(this).text(),value:$(this)[0].value});   
                }
            }); 
            self.reservedcatList= str;
          }
          self.reservedcatList.forEach(function(element) {
            if(element.text == "others" || element.text == "Others" ||element.text == "OTHERS"){
               self.resvcat_id = element.value;
              $("#resvcat_id").attr('disabled',true);
            }
          });
          
        } else {
          self.foreign_national = 'N';
          self.nationality = 'INDIAN';
          $("#resvcat_id").attr('disabled',false);
        }
      },

      copy_address: function(e){
        if(this.same_address == "Y") {
          this.corr_address = this.per_address;
          this.corr_city = this.city;
          this.corr_state_id = this.state_id;
          this.corr_pincode = this.pincode;
        } else {
          this.corr_address = '';
          this.corr_city = '';
          this.corr_state_id = 0;
          this.corr_pincode = '';
        }
      },

    }
  });
  Vue.component('student-detail', studentDetail)

</script>
@endpush