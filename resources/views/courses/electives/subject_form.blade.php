<div>
  <div class="form-group">
  <input type="hidden" name='course_id' value="{{ $course->id or '' }}" />
  <input type="hidden" name='ele_id' value="{{ $elective->id or '' }}" />
    {!! Form::label('course_sub_id','Subject',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-5">
      {!! Form::select('course_sub_id', $course_subjects, null, ['class' => 'form-control']) !!}
    </div>
  </div>
</div>
<div class="form-group">
  {!! Form::label('sub_type','Subject Type',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    <label class="radio-inline">
      <input type="radio" name="sub_type" class="minimal" value='C' @if($elective_subject->sub_type == 'C') checked @endif>
             Compulsory
    </label>
    <label class="radio-inline">
      <input type="radio" name="sub_type" class="minimal" value='O' @if($elective_subject->sub_type == 'O') checked @endif>
             Optional
    </label>
  </div>
</div>
