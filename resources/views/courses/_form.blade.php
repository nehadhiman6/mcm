<div class='form-group'>
  {!! Form::label('sno','Serial No.',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-1">
    {!! Form::text('sno',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('class_code','Class Code',['class' => 'col-sm-3 control-label required']) !!}
  <div class="col-sm-2">
    {!! Form::text('class_code',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class='form-group'>
  {!! Form::label('course_id','Course Id',['class' => 'col-sm-2 control-label ']) !!}
  <div class="col-sm-2">
    {!! Form::text('course_id',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('course_name','Course Name',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-2">
    {!! Form::text('course_name',null,['class' => 'form-control']) !!}
  </div>

</div>
<div class='form-group'>
  {!! Form::label('parent_course_id','Parent Course',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::select('parent_course_id',getParentCourses(),null,['class' => 'form-control']) !!}
  </div>
</div>
<div class='form-group'>
  {!! Form::label('status','Status',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::select('status',['GRAD' => 'Graduate', 'PGRAD' => 'Post Graduate'],null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('course_year','Course Year',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::text('course_year',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class='form-group'>
  {!! Form::label('st_rollno','Start Rollno',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::text('st_rollno',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('end_rollno','End Rollno',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::text('end_rollno',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class='form-group'>
  {!! Form::label('sub_combination','Subject Combination',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-1">
    <label class="checkbox">
      <input type="checkbox" name="sub_combination" class="minimal" value="Y"  id='sub_combi' />
    </label>
  </div>
  <div id='subject_no' style='display:none;'>
    {!! Form::label('sub_no','No. Of Subject',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-1">
      {!! Form::text('sub_no',null,['class' => 'form-control']) !!}
    </div>
  </div>  
  {!! Form::label('min_optional','Min. Optional Subject',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-1">
    {!! Form::text('min_optional',null,['class' => 'form-control']) !!}
  </div>  
  {!! Form::label('max_optional','Max. Optional Subject',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-1">
    {!! Form::text('max_optional',null,['class' => 'form-control']) !!}
  </div> 
</div>
<div class="form-group">
  {!! Form::label('no_of_seats','No. Of Seats',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-2">
    {!! Form::text('no_of_seats',null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('adm_open','Admission Open',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-1">
    <label class="checkbox">
      <input type="checkbox" name="adm_open" class="minimal" value="Y" {{ checked('adm_open','Y') }}/>
    </label>
  </div>
  {!! Form::label('sf','SF',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
      <label class="radio-inline" >
        {!! Form::radio('sf', 'Y',null, ['class' => 'minimal']) !!}
        Yes
      </label>
      <label class="radio-inline">
        {!! Form::radio('sf', 'N',null, ['class' => 'minimal']) !!}
        No
      </label>
  </div>
  {!! Form::label('adm_close_date','Admission Closing Date',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-2">
    {!! Form::text('adm_close_date',null,['class' => 'form-control app-datepicker']) !!}
  </div>
  {!! Form::label('honours_link','Honours Link',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-1">
    <label class="checkbox">
      <input type="checkbox" name="honours_link" class="minimal" value="Y" {{ checked('honours_link','Y') }}/>
    </label>
  </div>
</div>
