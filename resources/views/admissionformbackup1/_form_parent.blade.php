<fieldset>
  <legend>Parent's Details</legend>
  <div class="row">
    <div class="col-lg-4 col-sm-12">
     <legend><h4> Father's Details</h4></legend>
      <div class='form-group'>
        {!! Form::label('father_occup','Occupation',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::text('father_occup',null,['class' => 'form-control','v-model'=>'father_occup']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('father_desig','Designation',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::text('father_desig',null,['class' => 'form-control','v-model'=>'father_desig']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('father_phone','Phone No.(with STD Code).',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::text('father_phone',null,['class' => 'form-control','v-model'=>'father_phone']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('father_mobile','Mobile No.',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['father_mobile'] }">
          {!! Form::text('father_mobile',null,['class' => 'form-control','v-model'=>'father_mobile']) !!}
          <span id="basic-msg" v-if="errors['father_mobile']" class="help-block">@{{ errors['father_mobile'][0] }}</span>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('father_email','Email',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['father_email'] }">
          {!! Form::text('father_email',null,['class' => 'form-control','v-model'=>'father_email']) !!}
          <span id="basic-msg" v-if="errors['father_email']" class="help-block">@{{ errors['father_email'][0] }}</span>
        </div>
      </div>
      <div class="form-group">
          {!! Form::label('father_address','Address',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7">
            {!! Form::textarea('father_address', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'father_address']) !!}
          </div>
      </div>
      <div class="form-group">
        {!! Form::label('f_office_addr','Office Address',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['f_office_addr'] }">
          {!! Form::textarea('f_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'f_office_addr']) !!}
          <span id="basic-msg" v-if="errors['f_office_addr']" class="help-block">@{{ errors['f_office_addr'][0] }}</span>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4 col-sm-12">
       <legend><h4>Mother's Details</h4></legend>
      <div class='form-group'>
        {!! Form::label('mother_occup','Occupation',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::text('mother_occup',null,['class' => 'form-control','v-model'=>'mother_occup']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('mother_desig','Designation',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::text('mother_desig',null,['class' => 'form-control','v-model'=>'mother_desig']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('mother_phone','Phone No.(with STD Code).',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::text('mother_phone',null,['class' => 'form-control','v-model'=>'mother_phone']) !!}
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('mother_mobile','Mobile No.',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['mother_mobile'] }">
          {!! Form::text('mother_mobile',null,['class' => 'form-control','v-model'=>'mother_mobile']) !!}
          <span id="basic-msg" v-if="errors['mother_mobile']" class="help-block">@{{ errors['mother_mobile'][0] }}</span>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('mother_email','Email',['class' => 'col-sm-4 control-label required']) !!}
        <div class="col-sm-7" v-bind:class="{ 'has-error': errors['mother_email'] }">
          {!! Form::text('mother_email',null,['class' => 'form-control','v-model'=>'mother_email']) !!}
          <span id="basic-msg" v-if="errors['mother_email']" class="help-block">@{{ errors['mother_email'][0] }}</span>
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('mother_address','Address',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::textarea('mother_address', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'mother_address']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('m_office_addr','Office Address',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">
          {!! Form::textarea('m_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'m_office_addr']) !!}
        
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-sm-12">
    <legend><h4>Guardian's Details</h4></legend>
        <div class='form-group'>
          {!! Form::label('guardian_occup','Occupation',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7">
          {!! Form::text('guardian_occup',null,['class' => 'form-control','v-model'=>'guardian_occup']) !!}
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('guardian_desig','Designation',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7">
          {!! Form::text('guardian_desig',null,['class' => 'form-control','v-model'=>'guardian_desig']) !!}
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('guardian_phone','Phone No.(with STD Code).',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7">
          {!! Form::text('guardian_phone',null,['class' => 'form-control','v-model'=>'guardian_phone']) !!}
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('guardian_mobile','Mobile No.',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7"  v-bind:class="{ 'has-error': errors['guardian_mobile'] }">
          {!! Form::text('guardian_mobile',null,['class' => 'form-control','v-model'=>'guardian_mobile']) !!}
          <span id="basic-msg" v-if="errors['guardian_mobile']" class="help-block">@{{ errors['guardian_mobile'][0] }}</span>
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('guardian_email','Email',['class' => 'col-sm-4 control-label ']) !!}
          <div class="col-sm-7">
          {!! Form::text('guardian_email',null,['class' => 'form-control','v-model'=>'guardian_email']) !!}
          </div>
        </div>
        <div class="form-group" >
          {!! Form::label('guardian_address','Address',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7" v-bind:class="{ 'has-error': errors['guardian_address'] }">
            {!! Form::textarea('guardian_address', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'guardian_address']) !!}
          <span id="basic-msg" v-if="errors['guardian_address']" class="help-block">@{{ errors['guardian_address'][0] }}</span>
            
          </div>
        </div>
        <div class="form-group">
          {!! Form::label('g_office_addr','Office Address',['class' => 'col-sm-4 control-label']) !!}
          <div class="col-sm-7">
          {!! Form::textarea('g_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'g_office_addr']) !!}
          </div>
        </div>
    </div>
  </div>
 
  <hr>
  <div class='form-group'>
    {!! Form::label('annual_income','Annual Income From All Sources',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-lg-3 col-sm-5" v-bind:class="{ 'has-error': errors['annual_income'] }">
      {!! Form::select('annual_income',getAnnualIncome(),null,['class' => 'form-control','v-model'=>'annual_income','@change'=>'annualIncomeChanged']) !!}
      <span id="basic-msg" v-if="errors['annual_income']" class="help-block">@{{ errors['annual_income'][0] }}</span>
    </div>
  </div>
  <div class='form-group'>
    {!! Form::label('belongs_bpl','Belongs to BPL(Below Poverty Line)',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['belongs_bpl'] }">
      <label class="radio-inline">
        {!! Form::radio('belongs_bpl', 'Y',null, ['class' => 'minimal','v-model'=>'belongs_bpl','disabled']) !!}
        Yes
      </label>
      <label class="radio-inline">
        {!! Form::radio('belongs_bpl', 'N',null, ['class' => 'minimal','v-model'=>'belongs_bpl','disabled']) !!}
        No
      </label>
      <span id="basic-msg" v-if="errors['belongs_bpl']" class="help-block">@{{ errors['belongs_bpl'][0] }}</span>
    </div>
</div>
</fieldset>