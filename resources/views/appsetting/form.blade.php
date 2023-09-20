<fieldset style="margin:0 0 15px 0">
    <legend>College Dues</legend>
    <div class="form-group">
        {!! Form::label('key_value','Fee Status:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            <select class="form-control select-form" v-model="form.std_key.college.key_value">
                <option value="" Selected>Select</option>
                <option value="Open">Enable</option>
                <option value="Close">Disable</option>
    
            </select>
            <span v-if="hasError('std_key.college.key_value')" class="text-danger" v-html="errors['std_key.college.key_value'][0]"></span>
        </div>
        {!! Form::label('form.college.description','Message:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('form.std_key.college.description', null, ['class' => 'form-control','size' => '30x2','v-model'=>"form.std_key.college.description"]) !!}
            <span v-if="hasError('std_key.college.description')" class="text-danger" v-html="errors['std_key.college.description'][0]"></span>
        </div>
    </div>
</fieldset>

<fieldset style="margin:0 0 15px 0">
    <legend>Hostel Dues</legend>
    <div class="form-group">
        {!! Form::label('key_value','Fee Status:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            <select class="form-control select-form" v-model="form.std_key.hostel.key_value">
                <option value="" Selected>Select</option>
                <option value="Open">Enable</option>
                <option value="Close">Disable</option>
    
            </select>
            <span v-if="hasError('std_key.hostel.key_value')" class="text-danger" v-html="errors['std_key.hostel.key_value'][0]"></span>
        </div>
        {!! Form::label('description','Message:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('form.std_key.hostel.description', null, ['class' => 'form-control','size' => '30x2','v-model'=>"form.std_key.hostel.description"]) !!}
            <span v-if="hasError('std_key.hostel.description')" class="text-danger" v-html="errors['std_key.hostel.description'][0]"></span>
        
        </div>
    </div>
</fieldset>

<fieldset style="margin:0 0 15px 0">
    <legend>Payment Admission Fees</legend>
    <div class="form-group">
        {!! Form::label('key_value','Fee Status:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            <select class="form-control select-form" v-model="form.std_key.addmission.key_value">
                <option value="" Selected>Select</option>
                <option value="Open">Enable</option>
                <option value="Close">Disable</option>
    
            </select>
            <span v-if="hasError('std_key.addmission.key_value')" class="text-danger" v-html="errors['std_key.addmission.key_value'][0]"></span>
        </div>
        {!! Form::label('description','Message:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('form.std_key.addmission.description', null, ['class' => 'form-control','size' => '30x2','v-model'=>"form.std_key.addmission.description"]) !!}
            <span v-if="hasError('std_key.addmission.description')" class="text-danger" v-html="errors['std_key.addmission.description'][0]"></span>
        
        </div>
    </div>
</fieldset>

<fieldset style="margin:0 0 15px 0">
    <legend>College Processing Fees</legend>
    <div class="form-group">
        {!! Form::label('key_value','Fee Status:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            <select class="form-control select-form" v-model="form.std_key.college_process.key_value">
                <option value="" Selected>Select</option>
                <option value="Open">Enable</option>
                <option value="Close">Disable</option>
    
            </select>
            <span v-if="hasError('std_key.college_process.key_value')" class="text-danger" v-html="errors['std_key.college_process.key_value'][0]"></span>
        </div>
        {!! Form::label('description','Message:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('form.std_key.college_process.description', null, ['class' => 'form-control','size' => '30x2','v-model'=>"form.std_key.college_process.description"]) !!}
            <span v-if="hasError('std_key.college_process.description')" class="text-danger" v-html="errors['std_key.college_process.description'][0]"></span>
        
        </div>
    </div>
</fieldset>

<fieldset style="margin:0 0 15px 0">
    <legend>Hostel Processing Fees</legend>
    <div class="form-group">
        {!! Form::label('key_value','Fee Status:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            <select class="form-control select-form" v-model="form.std_key.hostel_process.key_value">
                <option value="" Selected>Select</option>
                <option value="Open">Enable</option>
                <option value="Close">Disable</option>
    
            </select>
            <span v-if="hasError('std_key.hostel_process.key_value')" class="text-danger" v-html="errors['std_key.hostel_process.key_value'][0]"></span>
        </div>
        {!! Form::label('description','Message:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('form.std_key.hostel_process.description', null, ['class' => 'form-control','size' => '30x2','v-model'=>"form.std_key.hostel_process.description"]) !!}
            <span v-if="hasError('std_key.hostel_process.description')" class="text-danger" v-html="errors['std_key.hostel_process.description'][0]"></span>
        
        </div>
    </div>
</fieldset>

<fieldset style="margin:0 0 15px 0">
    <legend>Student Satisfaction Survey</legend>
    <div class="form-group">
        {!! Form::label('key_value','Fee Status:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            <select class="form-control select-form" v-model="form.std_key.stu_satisfaction.key_value">
                <option value="" Selected>Select</option>
                <option value="Open">Enable</option>
                <option value="Close">Disable</option>
    
            </select>
            <span v-if="hasError('std_key.stu_satisfaction.key_value')" class="text-danger" v-html="errors['std_key.stu_satisfaction.key_value'][0]"></span>
        </div>
        {!! Form::label('description','Message:',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('form.std_key.stu_satisfaction.description', null, ['class' => 'form-control','size' => '30x2','v-model'=>"form.std_key.stu_satisfaction.description"]) !!}
            <span v-if="hasError('std_key.stu_satisfaction.description')" class="text-danger" v-html="errors['std_key.stu_satisfaction.description'][0]"></span>
        
        </div>
    </div>
</fieldset>

<div class="box-footer">
    <button class="btn btn-primary"  @click.prevent="submit()">Submit</button>
</div>





