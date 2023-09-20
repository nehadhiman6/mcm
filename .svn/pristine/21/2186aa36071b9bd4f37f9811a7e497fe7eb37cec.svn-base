
<div class="form-group">
    {!! Form::label('promotion_date','Promotion Date', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-3 " v-bind:class="{ 'has-error': errors['promotion_date'] }" > 
       {!! Form::text('promotion_date',null, array('required', 'class'=>'form-control app-datepicker','v-model'=>'form.promotion_date')) !!}
       <span v-if="hasError('promotion_date')" class="text-danger" v-html="errors['promotion_date'][0]" ></span>
    </div>
</div>

<div class='form-group row'>
    {!! Form::label('old_desig_id','Old Designation', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['desig_id'] }"> 
        <!-- <span v-if="last_desig.id > 0">
            <input class="form-control" v-model="last_desig.new_desig.name" Disabled>
            
        </span>
        <span v-else> -->
            <input class="form-control" v-model="desig.desig.name" Disabled>
        <!-- </span> -->
        
      <!-- <span id="basic-msg" v-if="errors['old_desig_id']" class="help-block">@{{ errors['old_desig_id'][0] }}</span> -->
    </div>
    {!! Form::label('new_desig_id','New Designation', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['new_desig_id'] }"> 
      {!! Form::select('new_desig_id',getDesignations(), null, array('required', 'class'=>'form-control','v-model'=>'form.new_desig_id','placeholder'=>'Select')) !!}
      <span id="basic-msg" v-if="errors['new_desig_id']" class="help-block">@{{ errors['new_desig_id'][0] }}</span>
    </div>
  
</div>