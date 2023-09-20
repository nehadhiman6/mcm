<div class="form-group">
  {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-2">
    {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id','@change'=>'getSubjects']) !!}
  </div>
  {!! Form::label('subject_code','Subject Code',['class' => 'col-sm-2 control-label ']) !!}
  <div class="col-sm-2">
    {!! Form::text('subject_code',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
    {!! Form::label('subject_id','Subject',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
      <select class="form-control" name='subject_id' v-model='subject_id' >
              <option v-for="s in subjects" :value='s.id' >
                @{{ s.subject }}
              </option>
      </select>
    </div>

</div>
<div class="form-group">
   {!! Form::label('pract_fee','Pract. Fee',['class' => 'col-sm-2 control-label ']) !!}
  <div class="col-sm-2">
    {!! Form::text('pract_fee',null,['class' => 'form-control']) !!}
  </div>
   {!! Form::label('pract_exam_fee','Pract. Exam Fee',['class' => 'col-sm-2 control-label ']) !!}
  <div class="col-sm-2">
    {!! Form::text('pract_exam_fee',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
   {!! Form::label('hon_fee','Hon. Fee',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::text('hon_fee',null,['class' => 'form-control']) !!}
  </div>
   {!! Form::label('hon_exam_fee','Hon. Exam Fee',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::text('hon_exam_fee',null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('pract_id','Pract. Head',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-4">
    {!! Form::select('pract_id',getSubheads(),null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('exam_id','Exam Head',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-4">
    {!! Form::select('exam_id',getSubheads(),null,['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('hon_id','Honours Head',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-4">
    {!! Form::select('hon_id',getSubheads(),null,['class' => 'form-control']) !!}
  </div>
</div>