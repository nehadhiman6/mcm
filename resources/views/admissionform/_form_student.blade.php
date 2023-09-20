<fieldset>
  <legend>Student's Details</legend>
  <!-- <div class='form-group' v-if="form_id == 0"> -->
      <div class='form-group' >
          {!! Form::label('last_exam_mcm',"If ".config('college.college_name_short')."  Student in previous semester?",['class' => 'col-sm-3 control-label required']) !!}
            <div class="col-sm-2" >
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
      {!! Form::label('course_type','Course Type',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_type',[''=>'Select','GRAD'=>'UG','PGRAD'=>'PG'],(isset($course_type) ? $course_type : ''),['class' => 'form-control','v-model'=>'course_type',':disabled'=>'oldstudentDetails.course_id || last_exam_mcm =="Y" && app_guard != "web"']) !!}
      </div>
  
      {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-lg-2 col-sm-3" v-bind:class="{ 'has-error': errors['course_id'] }">
        <select class="form-control" v-model="course_id" @change='showSubs' :disabled="oldstudentDetails.course_id ||last_exam_mcm =='Y' && app_guard != 'web' ">
          <option v-for="course in getCourses" value="@{{ course.id }}">@{{ course.course_name }}</option>
        </select>
        <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
      </div>
      {!! Form::label('course_code','Course Code',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">@{{ course_code}}</p>
      </div>
    </div>

  <div class='form-group'>
    {!! Form::label('loc_cat','Relevant Category',['class' => 'col-sm-2 control-label required' ,'v-if'=>'showPool']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['loc_cat'] }" v-if="showPool">
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
    {!! Form::label('geo_cat','Area',['class' => 'col-sm-2 control-label required']) !!}
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
    {!! Form::label('minority','Minority',['class' => 'col-sm-2 control-label required']) !!}
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
    {!! Form::label('sports_seat','Do you seek admission against sports seat?',['class' => 'col-sm-4 control-label required']) !!}
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
    {!! Form::label('name','Name',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['name'] }">
      {!! Form::text('name',null,['class' => 'form-control','max-length'=>'50','v-model'=>'name' ,':disabled'=>'oldstudentDetails.name && app_guard != "web"']) !!}
      <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
    </div>
    {!! Form::label('dob','D.O.B',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['dob'] }">
      {!! Form::text('dob',null,['class' => 'form-control app-datepicker','v-model'=>'dob', ':disabled'=>'form_not_editable && oldstudentDetails.dob && inOffice == false && app_guard != "web"']) !!}
      <span id="basic-msg" v-if="errors['dob']" class="help-block">@{{ errors['dob'][0] }}</span>
    </div>
  </div>
  <div class='form-group'>
    {!! Form::label('father_name','Father',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['father_name'] }">
      {!! Form::text('father_name',null,['class' => 'form-control','v-model'=>'father_name' ,':disabled'=>'oldstudentDetails.father_name && app_guard != "web"']) !!}
      <span id="basic-msg" v-if="errors['father_name']" class="help-block">@{{ errors['father_name'][0] }}</span>
    </div>
    {!! Form::label('mother_name','Mother',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['mother_name'] }">
      {!! Form::text('mother_name',null,['class' => 'form-control','v-model'=>'mother_name'  ,':disabled'=>'oldstudentDetails.mother_name && app_guard != "web"']) !!}
      <span id="basic-msg" v-if="errors['mother_name']" class="help-block">@{{ errors['mother_name'][0] }}</span>
    </div>
  </div>
  <div class="form-group">
      {!! Form::label('mobile','Mobile',['class' => 'col-sm-2 control-label required']) !!}
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
    {!! Form::label('guardian_name','Guardian',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['guardian_name'] }">
      {!! Form::text('guardian_name',null,['class' => 'form-control','v-model'=>'guardian_name']) !!}
      <span id="basic-msg" v-if="errors['guardian_name']" class="help-block">@{{ errors['guardian_name'][0] }}</span>
    </div>
    {!! Form::label('guardian_relationship','Relationship with Guardian',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['guardian_relationship'] }">
      {!! Form::text('guardian_relationship',null,['class' => 'form-control','v-model'=>'guardian_relationship']) !!}
      <span id="basic-msg" v-if="errors['guardian_relationship']" class="help-block">@{{ errors['guardian_relationship'][0] }}</span>
    </div>
    
  </div>
  <div class="form-group">
  {!! Form::label('aadhar_no','AAdhar No.',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['aadhar_no'] }" :disabled = "no_adhar != ''">
      {!! Form::text('aadhar_no',null,['class' => 'form-control','v-model'=>'aadhar_no' ,':disabled'=>"adhar_card == 'N'"]) !!}
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
      {!! Form::label('conveyance','Conveyence (Scooter/Motorcycle)',['class' => 'col-sm-2 control-label required']) !!}
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
    {!! Form::label('boarder','Boarder/Day Scholar',['class' => 'col-sm-2 control-label required','v-if'=>'showBoarder']) !!}
      <div class="col-sm-3" v-bind:class="{ 'has-error': errors['boarder'] }"  v-if="showBoarder">
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
<!--    {!! Form::label('same_address','Same as Permanent Address',['class' => 'col-sm-1 control-label']) !!}-->
    <div class="col-sm-1">
      <label class="checkbox-inline">
        <input type="checkbox" id="same_addr" v-model = 'same_address' value="Y" class="minimal" v-bind:true-value="'Y'"
               v-bind:false-value="'N'" @change ="copy_address" class='minimal'/>
      </label>
      <p class="text-sm">Same Address</p>
    </div>
    {!! Form::label('corr_address','Corresp. Address',['class' => 'col-lg-1 col-sm-2  control-label']) !!}
    <div class="col-lg-3 col-sm-3">
      {!! Form::textarea('corr_address', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'corr_address']) !!}
    </div>
  </div>
  <div class="form-group">
    {!! Form::label('city','City',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-lg-2 col-sm-4">
      {!! Form::text('city',null,['class' => 'form-control','v-model'=>'city']) !!}
    </div>
    {!! Form::label('corr_city','City',['class' => 'col-sm-3 control-label']) !!}
    <div class="col-lg-2 col-sm-3">
      {!! Form::text('corr_city',null,['class' => 'form-control','v-model'=>'corr_city']) !!}
    </div>
  </div>
  <div class="form-group">
    {!! Form::label('state_id','State',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-lg-2 col-sm-4">
      {!! Form::select('state_id',getStates(),null,['class' => 'form-control','v-model'=>'state_id']) !!}
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
 
</fieldset>