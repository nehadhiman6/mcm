<div class="form-group row">
  {!! Form::label('courses','Courses',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
      <select class="form-control select-form" v-model="course_form.courses" v-bind:class="{ 'has-error': errors['course.courses'] }">
          <option value="" Selected>Select</option>
          <option value="Orientation program">Orientation program</option>
          <option value="Refresher Course">Refresher Course</option>
          <option value="Short Term Course">Short Term Course</option>
          <option value="FDP">FDP</option>
          <option value="Conference">Conference</option>
          <option value="Workshop">Workshop</option>
          <option value="Seminar">Seminar</option>
          <option value="Symposium">Symposium</option>
          <option value="Extension Lecture">Extension Lecture</option>
          <option value="Webinar">Webinar</option>
          <option value="Any Other">Any Other</option>
          
      </select>
    <span id="basic-msg" v-if="errors['course.courses']" class="help-block">@{{ errors['course.courses'][0] }}</span>

      <!-- <span v-if="hasError('course.courses')" class="text-danger" v-html="errors['course.courses'][0]" ></span> -->
  </div>
  <div class="col-sm-6" v-bind:class="{ 'has-error': errors['course.other_course'] }" v-if="course_form.courses == 'Any Other' ">
    {!! Form::text('other_course',null, ['class' => 'form-control','v-model'=>'course_form.other_course']) !!}
    <span id="basic-msg" v-if="errors['course.other_course']" class="help-block">@{{ errors['course.other_course'][0] }}</span>
  </div>
</div>
   
<div class="form-group row">
  {!! Form::label('level','Level',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
        <select class="form-control select-form" v-model="course_form.level" v-bind:class="{ 'has-error': errors['course.level'] }">
            <option value="" Selected>Select</option>
            <option value="International">International</option>
            <option value="National">National</option>
            <option value="State">State</option>
            <!-- <option value="Regional">Regional</option> -->
            <option value="Local">Local</option>
        </select>
      <span id="basic-msg" v-if="errors['course.level']" class="help-block">@{{ errors['course.level'][0] }}</span>
    </div>
  {!! Form::label('topic','Topic',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4" v-bind:class="{ 'has-error': errors['course.topic'] }">
    {!! Form::text('topic',null, ['class' => 'form-control','v-model'=>'course_form.topic']) !!}
    <span id="basic-msg" v-if="errors['course.topic']" class="help-block">@{{ errors['course.topic'][0] }}</span>
  </div>
</div>
<div class="form-group row">
    {!! Form::label('begin_date','Begin Date', ['class' => ' control-label col-sm-2 required'])!!}
    <div class="col-md-4" v-bind:class="{ 'has-error': errors['course.begin_date'] }" > 
       {!! Form::text('begin_date',null, array('required', 'class'=>'form-control app-datepicker','v-model'=>'course_form.begin_date')) !!}
      <span id="basic-msg" v-if="errors['course.begin_date']" class="help-block">@{{ errors['course.begin_date'][0] }}</span>
    </div>
    {!! Form::label('end_date','End Date', ['class' => ' control-label col-sm-2 required'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['course.end_date'] }" > 
       {!! Form::text('end_date',null, array('required', 'class'=>'form-control app-datepicker','v-model'=>'course_form.end_date')) !!}
      <span id="basic-msg" v-if="errors['course.end_date']" class="help-block">@{{ errors['course.end_date'][0] }}</span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('duration_days','Duration (in days)',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['course.duration_days'] }">
      {!! Form::text('duration_days',null, ['class' => 'form-control','v-model'=>'course_form.duration_days']) !!}
      <span id="basic-msg" v-if="errors['course.duration_days']" class="help-block">@{{ errors['course.duration_days'][0] }}</span>
    </div>
    {!! Form::label('org_by','Organized by',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['course.org_by'] }">
      {!! Form::text('org_by',null, ['class' => 'form-control','v-model'=>'course_form.org_by']) !!}
      <span id="basic-msg" v-if="errors['course.org_by']" class="help-block">@{{ errors['course.org_by'][0] }}</span>
    </div>
</div>

<div class="form-group row">
  {!! Form::label('sponsored_by','Sponsored by',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
        <select class="form-control select-form" v-model="course_form.sponsored_by" v-bind:class="{ 'has-error': errors['course.sponsored_by'] }">
            <option value="" Selected>Select</option>
            <option value="RUSA">RUSA</option>
            <option value="UGC">UGC</option>
            <option value="DST">DST</option>
            <option value="DBT">DBT</option>
            <option value="ICSSR">ICSSR</option>
            <option value="PMMMNMTT-MHRD">PMMMNMTT-MHRD</option>
            <option value="Any Other">Any Other</option>
        </select>
        <span id="basic-msg" v-if="errors['course.sponsored_by']" class="help-block">@{{ errors['course.sponsored_by'][0] }}</span>
    </div>
    <div class="col-sm-6" v-bind:class="{ 'has-error': errors['course.other_sponsor'] }" v-if="course_form.sponsored_by == 'Any Other' ">
      {!! Form::text('other_sponsor',null, ['class' => 'form-control','v-model'=>'course_form.other_sponsor']) !!}
      <span id="basic-msg" v-if="errors['course.other_sponsor']" class="help-block">@{{ errors['course.other_sponsor'][0] }}</span>
    </div>
</div>

<div class="form-group row">
    {!! Form::label('collaboration_with','In Collaboration with (if any)', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['course.collaboration_with'] }" > 
      {!! Form::text('collaboration_with',null, ['class' => 'form-control','v-model'=>'course_form.collaboration_with']) !!}
      <span id="basic-msg" v-if="errors['course.collaboration_with']" class="help-block">@{{ errors['course.collaboration_with'][0] }}</span>
    </div>
    {!! Form::label('aegis_of','Under the aegis of', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['course.aegis_of'] }" > 
      {!! Form::text('aegis_of',null, ['class' => 'form-control','v-model'=>'course_form.aegis_of']) !!}
      <span id="basic-msg" v-if="errors['course.aegis_of']" class="help-block">@{{ errors['course.aegis_of'][0] }}</span>
    </div>
</div>

<div class="form-group row">
  {!! Form::label('participate_as','Participated as',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
        <select class="form-control select-form" v-model="course_form.participate_as" v-bind:class="{ 'has-error': errors['course.participate_as'] }">
            <option value="" Selected>Select</option>
            <option value="Resource Person">Resource Person</option>
            <option value="Chair Person">Chair Person</option>
            <option value="Attendee">Attendee</option>
            <option value="Delegate">Delegate</option>
            <option value="Key Speakers">Key Speaker</option>
        </select>
        <span id="basic-msg" v-if="errors['course.participate_as']" class="help-block">@{{ errors['course.participate_as'][0] }}</span>

    </div>
    {!! Form::label('affi_inst','Affiliating institute of the participant', ['class' => ' control-label col-sm-2 required'])!!}
    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['course.affi_inst'] }" >
      {!! Form::text('affi_inst',null, ['class' => 'form-control','v-model'=>'course_form.affi_inst','placeholder' => 'At the time of participation']) !!}
      <span id="basic-msg" v-if="errors['course.affi_inst']" class="help-block">@{{ errors['course.affi_inst'][0] }}</span>
    </div>
</div>

<div class="form-group row">
  {!! Form::label('mode','Mode of Delivery',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
        <select class="form-control select-form" v-model="course_form.mode" v-bind:class="{ 'has-error': errors['course.mode'] }">
            <option value="" Selected>Select</option>
            <option value="Online">Online</option>
            <option value="Offline">Offline</option>
        </select>
        <span id="basic-msg" v-if="errors['course.mode']" class="help-block">@{{ errors['course.mode'][0] }}</span>
        <!-- <span v-if="hasError('course.mode')" class="text-danger" v-html="errors['course.mode'][0]" ></span> -->
    </div>
</div>

<div class='form-group row'>
  {!! Form::label('university_id','Board/University',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-4">
  <select v-model="course_form.university_id" class="form-control" v-bind:class="{ 'has-error': errors['course.university_id'] }" >
    <option value="" selected>Select</option>
    <option v-for="board in boards" :value="board.id">@{{ board.name }}</option>
    <option value="0">Others</option>
  </select>
      <span id="basic-msg" v-if="errors['course.university_id']" class="help-block">@{{ errors['course.university_id'][0] }}</span>

  </div>
  <div class="col-sm-6" v-if="course_form.university_id == 0">
    <input type="text"  v-model='course_form.other_university' class="form-control" placeholder="Enter Board/University (If Others)"/>
    <span id="basic-msg" v-if="errors['course.other_university']" class="help-block">@{{ errors['course.other_university'][0] }}</span>
  
  </div>
</div>

<div class="form-group row">
    {!! Form::label('certificate','Certificate', ['class' => ' control-label col-sm-2 '])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['course.certificate'] }" > 
      {!! Form::text('certificate',null, ['class' => 'form-control','v-model'=>'course_form.certificate','placeholder' => 'Provide Google Drive Link']) !!}
      <span id="basic-msg" v-if="errors['course.certificate']" class="help-block">@{{ errors['course.certificate'][0] }}</span>
    </div>
    {!! Form::label('remarks','Remarks (if any)', ['class' => ' control-label col-sm-2 '])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['course.remarks'] }" > 
      {!! Form::text('remarks',null, ['class' => 'form-control','v-model'=>'course_form.remarks']) !!}
      <span id="basic-msg" v-if="errors['course.remarks']" class="help-block">@{{ errors['course.remarks'][0] }}</span>
    </div>
</div>