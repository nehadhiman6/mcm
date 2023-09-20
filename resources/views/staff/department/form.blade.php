<div class="form-group">
  {!! Form::label('name','Name',['class' => 'col-sm-1 control-label required']) !!}
  <div class="col-sm-4" v-bind:class="{ 'has-error': errors['name'] }">
    {!! Form::text('name',null,['class' => 'form-control' ,'v-model'=>'name']) !!}
    <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
  </div>

  {!! Form::label('faculty_id','Under Faculty',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4" v-bind:class="{ 'has-error': errors['faculty_id'] }">
    {!! Form::select('faculty_id',getFaculty(),null,['class' => 'form-control select2' ,'v-model'=>'faculty_id']) !!}
    <span id="basic-msg" v-if="errors['faculty_id']" class="help-block">@{{ errors['faculty_id'][0] }}</span>
  </div>
</div>