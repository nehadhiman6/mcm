<div class="form-group">
  {!! Form::label('name','Name',['class' => 'col-sm-1 control-label']) !!}
  <div class="col-sm-4" v-bind:class="{ 'has-error': errors['name'] }">
    {!! Form::text('name',null,['class' => 'form-control' ,'v-model'=>'name']) !!}
    <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
  </div>
</div>