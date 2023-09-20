<div class="form-group">
    {!! Form::label('roll_no','College Roll No:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
    <span v-if="form.id > 0">
    {!! Form::text('roll_no',null, ['class' => 'form-control','v-model'=>'form.roll_no','disabled' => 'true']) !!}
    </span>
    <span v-else>
        {!! Form::text('roll_no',null, ['class' => 'form-control','v-model'=>'form.roll_no']) !!}
    </span>
        <span v-if="hasError('roll_no')" class="text-danger" v-html="errors['roll_no'][0]"></span>
        <span v-if="hasError('college_roll_no')" class="text-danger" v-html="errors['college_roll_no'][0]"></span>
    </div>
    <div class="col-sm-3">
        <button class="btn btn-success" v-if="form.id == 0"  @click.prevent="getStudentData()">Show</button>
    </div>
</div>
<div class="form-group">
    {!! Form::label('name','Student Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('name',null, ['class' => 'form-control','v-model'=>'form.name','disabled' => 'true']) !!}
        <span v-if="hasError('name')" class="text-danger" v-html="errors['name'][0]"></span>
    </div>

    {!! Form::label('father_name','Father Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('father_name',null, ['class' => 'form-control','v-model'=>'form.father_name','disabled' => 'true']) !!}
        <span v-if="hasError('father_name')" class="text-danger" v-html="errors['father_name'][0]"></span>
    </div>
</div>
    
<div class="form-group" >
    {!! Form::label('pupin_no','University Rollno:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        <span v-if="form.id > 0">
            <input type="text" name="pupin_no" v-model="form.pupin_no" class="form-control">
        </span>     
        <span v-else>
            <input type="text" name="pupin_no" v-model="form.pupin_no" class="form-control" :disabled="disable_uni_rollno">
        </span>      
        <!-- {!! Form::text('pupin_no',null, ['class' => 'form-control','v-model'=>'form.pupin_no']) !!} -->
        <span v-if="hasError('pupin_no')" class="text-danger" v-html="errors['pupin_no'][0]"></span>
    </div> 
    {!! Form::label('course_id','Class :',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('course_id',['0'=>'Select Course']+getCourses(),null, ['class' => 'form-control','v-model'=>'form.course_id','disabled' => 'true']) !!}
        <span v-if="hasError('course_id')" class="text-danger" v-html="errors['course_id'][0]"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('mobile_no','Mobile No.',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('mobile_no',null, ['class' => 'form-control','v-model'=>'form.mobile_no']) !!}
        <span v-if="hasError('mobile_no')" class="text-danger" v-html="errors['mobile_no'][0]"></span>
    </div>
    {!! Form::label('add','Address:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::textarea('add',null, ['class' => 'form-control','v-model'=>'form.add']) !!}
        <span v-if="hasError('add')" class="text-danger" v-html="errors['add'][0]"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('email','Email:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('email',null, ['class' => 'form-control','v-model'=>'form.email']) !!}
        <span v-if="hasError('email')" class="text-danger" v-html="errors['email'][0]"></span>
    </div>
    <!-- {!! Form::label('regional_centre','Regional Centres:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::select('regional_centre',getRegional(),null, ['class' => 'form-control','v-model'=>'form.regional_centre']) !!}
        <span v-if="hasError('regional_centre')" class="text-danger" v-html="errors['regional_centre'][0]"></span>
    </div> -->
</div>
<div>
    <span style="font-size:16px; margin-bottom:10px;"><strong>Centre Option (Provided any two)</strong></span>
</div>
<div class="form-group">
    {!! Form::label('centre1','Centre 1:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::select('centre1',getProvisionalCentre(),null, ['class' => 'form-control select2','v-model'=>'form.centre1']) !!}
        <span v-if="hasError('centre1')" class="text-danger" v-html="errors['centre1'][0]"></span>
    </div>
    
    {!! Form::label('centre2','Centre 2:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::select('centre2',getProvisionalCentre(),null, ['class' => 'form-control selectcentre2','v-model'=>'form.centre2']) !!}
        <span v-if="hasError('centre2')" class="text-danger" v-html="errors['centre2'][0]"></span>
        <span v-if="hasError('centre_re')" class="text-danger" v-html="errors['centre_re'][0]"></span>
    </div>
</div>


<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Save</button>
</div>



