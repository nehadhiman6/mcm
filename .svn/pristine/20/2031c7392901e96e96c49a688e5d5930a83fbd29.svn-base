
<div class="form-group">
    {!! Form::label('name','Student Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('name',null, ['class' => 'form-control','v-model'=>'form.name']) !!}
        <span v-if="hasError('name')" class="text-danger" v-html="errors['name'][0]"></span>
    </div>

    {!! Form::label('father_name','Father Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('father_name',null, ['class' => 'form-control','v-model'=>'form.father_name']) !!}
        <span v-if="hasError('father_name')" class="text-danger" v-html="errors['father_name'][0]"></span>
    </div>
</div>
    
<div class="form-group">
    {!! Form::label('mobile_no','Mobile No.',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('mobile_no',null, ['class' => 'form-control','v-model'=>'form.mobile_no']) !!}
        <span v-if="hasError('mobile_no')" class="text-danger" v-html="errors['mobile_no'][0]"></span>
    </div>
    {!! Form::label('email','Email:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('email',null, ['class' => 'form-control','v-model'=>'form.email']) !!}
        <span v-if="hasError('email')" class="text-danger" v-html="errors['email'][0]"></span>
    </div>
    
</div>
<div class="form-group">
    {!! Form::label('add','Address:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::textarea('add',null, ['class' => 'form-control','v-model'=>'form.add']) !!}
        <span v-if="hasError('add')" class="text-danger" v-html="errors['add'][0]"></span>
    </div>
    
    {!! Form::label('city','City:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('city',null, ['class' => 'form-control','v-model'=>'form.city']) !!}
        <span v-if="hasError('city')" class="text-danger" v-html="errors['city'][0]"></span>
    </div>
</div>
<div class="form-group"> 
    {!! Form::label('state_id','State:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('state_id',getStates(),null, ['class' => 'form-control select2','v-model'=>'form.state_id']) !!}
        <!-- {!! Form::select('state_id',getStates(),null,['class' => 'form-control select2','v-model'=>'form.state_id']) !!} -->
        <span v-if="hasError('state_id')" class="text-danger" v-html="errors['state_id'][0]"></span>
    </div>
    
    {!! Form::label('hostel','Hostel Facility:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="form.hostel">
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
        <span v-if="hasError('hostel')" class="text-danger" v-html="errors['hostel'][0]" ></span>
    </div>
</div>
<div class="form-group" >
    {!! Form::label('course_id','Course :',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('course_id',getYearCourse(),null, ['class' => 'form-control','v-model'=>'form.course_id']) !!}
        <span v-if="hasError('course_id')" class="text-danger" v-html="errors['course_id'][0]"></span>
    </div>
</div>
<div class="form-group" >
    <span style="color:#972828; font-size:16px; margin-left:46px;">Click to visit subject combination for <a target="_blank" href="https://mcmdavcwchd.edu.in/ug-courses/">UG Courses</a> & <a target="_blank" href="https://mcmdavcwchd.edu.in/pg-courses/">PG Courses</a></span><br>
    <!-- <span style="color:#972828; font-size:16px; margin-left:10px;">Click to visit subject combination for <a target="_blank" href="https://mcmdavcwchd.edu.in/pg-courses/">PG Courses</a></span> -->
    
</div>

<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Save</button>
</div>



