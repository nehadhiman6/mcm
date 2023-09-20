<div class="form-group">
    {!! Form::label('code','Combination Code No.',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['code'] }">
        {!! Form::text('code',null, ['class' => 'form-control','v-model'=>'form.code',]) !!}
        <span id="basic-msg" v-if="errors['code']" class="help-block">@{{ errors['code'][0] }}</span>
    </div>
    {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['course_id'] }">
        {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse','v-model'=>'form.course_id','@change' => 'getSubjectsList']) !!}
        <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
    </div>
   
    
</div>

<div class="form-group">
    {!! Form::label('subject_ids','Subject',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-10" v-bind:class="{ 'has-error': errors['msg'] }">
        <select class="form-control selectSub" id='indexing' v-model="form.subject_ids"  multiple="multiple">
            <option v-for="(key,value) in subjects" :key="key" :value="key" >@{{value}}</option>
        </select>
        <span id="basic-msg" v-if="errors['msg']" class="help-block">@{{ errors['msg'][0] }}</span>
    </div>
   
    
</div>

<div class="form-group">
    {!! Form::label('combination','Combination',['class' => 'col-sm-2 control-label ']) !!}
    <div class="col-sm-10" v-bind:class="{ 'has-error': errors['comb_msg'] }">
        {!! Form::textarea('combination',null, ['class' => 'form-control','v-model'=>'form.combination','disabled'=>'true']) !!}
        <span id="basic-msg" v-if="errors['comb_msg']" class="help-block">@{{ errors['comb_msg'][0] }}</span>
    </div>
    
</div>
<div class="box-footer">
    <button class="btn btn-primary" v-if="form.form_id > 0" @click.prevent="submit()">Update</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Save</button>
    <button class="btn btn-primary" v-else  @click.prevent="cancel()">Cancel</button>
</div>