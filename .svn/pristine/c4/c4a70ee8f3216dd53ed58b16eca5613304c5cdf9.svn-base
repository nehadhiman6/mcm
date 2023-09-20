<fieldset>
    <legend>Basic Details</legend>
    <div class="form-group">
        {!! Form::label('passout_year','Passing Year',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['passout_year'] }">
            {!! Form::text('passout_year',null,['class' => 'form-control','max-length'=>'50','v-model'=>'passout_year']) !!}
            <span id="basic-msg" v-if="errors['passout_year']" class="help-block">@{{ errors['passout_year'][0] }}</span>
        </div>
    </div>
    <div class="form-group">
      {!! Form::label('name','Name',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-3" v-bind:class="{ 'has-error': errors['name'] }">
        {!! Form::text('name',null,['class' => 'form-control','max-length'=>'50','v-model'=>'name']) !!}
        <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
      </div>
      {!! Form::label('dob','D.O.B',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-3" v-bind:class="{ 'has-error': errors['dob'] }">
        {!! Form::text('dob',null,['class' => 'form-control app-datepicker','v-model'=>'dob']) !!}
        <span id="basic-msg" v-if="errors['dob']" class="help-block">@{{ errors['dob'][0] }}</span>
      </div>
    </div>
    <div class='form-group'>
      {!! Form::label('father_name','Father',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-3" v-bind:class="{ 'has-error': errors['father_name'] }">
        {!! Form::text('father_name',null,['class' => 'form-control','v-model'=>'father_name']) !!}
        <span id="basic-msg" v-if="errors['father_name']" class="help-block">@{{ errors['father_name'][0] }}</span>
      </div>
      {!! Form::label('mother_name','Mother',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-sm-3" v-bind:class="{ 'has-error': errors['mother_name'] }">
        {!! Form::text('mother_name',null,['class' => 'form-control','v-model'=>'mother_name']) !!}
        <span id="basic-msg" v-if="errors['mother_name']" class="help-block">@{{ errors['mother_name'][0] }}</span>
      </div>
    </div>
    <div class="form-group">
        {!! Form::label('mobile','Mobile',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['mobile'] }">
          {!! Form::text('mobile',null,['class' => 'form-control','max-length'=>'10','v-model'=>'mobile']) !!}
          <span id="basic-msg" v-if="errors['mobile']" class="help-block">@{{ errors['mobile'][0] }}</span>
        </div>
        {!! Form::label('email','Email',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['email'] }">
          {!! Form::text('email',null,['class' => 'form-control','max-length'=>'10','v-model'=>'email']) !!}
          <span id="basic-msg" v-if="errors['email']" class="help-block">@{{ errors['email'][0] }}</span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('pu_pupin','PU Pupin No',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['pu_pupin'] }">
          {!! Form::text('pu_pupin',null,['class' => 'form-control','max-length'=>'10','v-model'=>'pu_pupin']) !!}
          <span id="basic-msg" v-if="errors['pu_pupin']" class="help-block">@{{ errors['pu_pupin'][0] }}</span>
        </div>
        {!! Form::label('pu_regno','PU Reg No',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['pu_regno'] }">
          {!! Form::text('pu_regno',null,['class' => 'form-control','max-length'=>'10','v-model'=>'pu_regno']) !!}
          <span id="basic-msg" v-if="errors['pu_regno']" class="help-block">@{{ errors['pu_regno'][0] }}</span>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('gender','Gender',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['gender'] }">
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
      {!! Form::label('per_address','Permanent Address',['class' => 'col-sm-2 control-label required']) !!}
      <div class="col-lg-3 col-sm-4" v-bind:class="{ 'has-error': errors['per_address'] }">
        {!! Form::textarea('per_address', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'per_address']) !!}
        <span id="basic-msg" v-if="errors['per_address']" class="help-block">@{{ errors['per_address'][0] }}</span>
      </div>
    </div>
  </fieldset>
