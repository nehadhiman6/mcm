<div>
  <div class="form-group">
    {!! Form::label('subject_id','Subject',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-6">
      <select class="form-control " name='subject_id' id="subject_id"  >
        <option v-for='subject in subjects' v-bind:value="subject.id" >
          @{{ subject.subject }}
        </option>
      </select>
    </div>
    {!! Form::label('uni_code','Univ. Code',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-2">
      {!! Form::text('uni_code',null,['class' => 'form-control','v-model'=>'uni_code']) !!}
    </div>
  </div>
</div>
<div class="form-group">
  {!! Form::label('sub_type','Subject Type',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    <label class="radio-inline">
      <input type="radio" name="sub_type" class="minimal" value='C' @if($coursesubject->sub_type == 'C') checked @endif>
             Compulsory
    </label>
    <label class="radio-inline">
      <input type="radio" name="sub_type" class="minimal" value='O' @if($coursesubject->sub_type == 'O') checked @endif>
             Optional
    </label>
  </div>
  {!! Form::label('practical','Practical',['class' => 'col-sm-1 control-label']) !!}
  <div class='col-sm-1 checkbox-inline'>
    <input type="checkbox" name="practical" class="minimal" value='Y' @if($coursesubject->practical == 'Y') checked @endif>
  </div>
  {!! Form::label('honours','Honours',['class' => 'col-sm-1 control-label']) !!}
  <div class='col-sm-1 checkbox-inline'>
    <input type="checkbox" name="honours" class="minimal" value='Y' v-model='honours' v-bind:true-value="'Y'"  v-bind:false-value="'N'">
  </div>
  {!! Form::label('semester', 'Semester', ['class' => 'col-sm-1 control-label']) !!}
  <div class="col-sm-2" v-bind:class="{ 'has-error': errors['semester'] }">
      <select class='form-control' id='semester' name='semester'  :disabled ='saving'>
          <option v-for="sem in semesters" :value="sem.id">@{{ sem.sem }}</option>
      </select>
      <span id="basic-msg" v-if="errors['semester']" class="help-block" >@{{ errors['semester'][0] }}</span>
  </div>
</div>
{{-- <div class="form-group">
 
</div> --}}

  @php $course_honour = 'false' @endphp
  @if(isset($course))
    @if($course->honours_link == 'Y')
       @php $course_honour = 'true'; @endphp
    @endif
  @else
    @if($coursesubject->course->honours_link == 'Y')
      @php $course_honour = 'true'; @endphp
    @endif
  @endif

  @if($course_honour == 'true')
  <div class="form-group" v-if="honours == 'Y'">
    {!! Form::label('honours_sub_id','Honours Subject',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-5">
      {!! Form::select('honours_sub_id', $course_subjects, null, ['class' => 'form-control']) !!}
    </div>
  </div>
  @endif
