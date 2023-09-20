<div class="form-group">
  {!! Form::label('faculty','Faculty',['class' => 'col-sm-1 control-label required']) !!}
  <div class="col-sm-4" v-bind:class="{ 'has-error': errors['faculty'] }">
    {!! Form::text('faculty',null,['class' => 'form-control' ,'v-model'=>'faculty']) !!}
    <span id="basic-msg" v-if="errors['faculty']" class="help-block">@{{ errors['faculty'][0] }}</span>
  </div>
</div>