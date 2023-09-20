
<div class="form-group">
    {!! Form::label('drive_date','Drive Date:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        {!! Form::text('drive_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.drive_date']) !!}
        <span v-if="hasError('drive_date')" class="text-danger" v-html="errors['drive_date'][0]"></span>
    </div>
</div>
<div class="form-group">

    {!! Form::label('type','Type of Drive:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="form.type">
            <option value="" Selected>Select</option>
            <option value="P">Placement</option>
            <option value="I">Internship</option>
            <option value="E">Employability Enhancement Program</option>
        </select>
        <span v-if="hasError('type')" class="text-danger" v-html="errors['type'][0]" ></span>
    </div>

    {!! Form::label('nature','Nature of drive:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="form.nature">
            <option value="" Selected>Select</option>
            <option value="Off Campus">Off Campus</option>
            <option value="On campus">On campus</option>
            <option value="Virtual">Virtual</option>

        </select>
        <span v-if="hasError('nature')" class="text-danger" v-html="errors['nature'][0]" ></span>
    </div>
</div>
 
 
<div class="form-group">
    {!! Form::label('comp_id','Company:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('comp_id',getCompanies(),null, ['class' => 'form-control comp_id','v-model'=>'form.comp_id']) !!}
        <span v-if="hasError('comp_id')" class="text-danger" v-html="errors['comp_id'][0]"></span>
    </div>
    {!! Form::label('hr_personnel','Name of HR personnel:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('hr_personnel',null, ['class' => 'form-control','v-model'=>'form.hr_personnel']) !!}
        <span v-if="hasError('hr_personnel')" class="text-danger" v-html="errors['hr_personnel'][0]"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('contact_no','Contact Number of HR',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('contact_no',null, ['class' => 'form-control','v-model'=>'form.contact_no']) !!}
        <span v-if="hasError('contact_no')" class="text-danger" v-html="errors['contact_no'][0]"></span>
    </div>

    {!! Form::label('email','Email ID of HR',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('email',null, ['class' => 'form-control','v-model'=>'form.email']) !!}
        <span v-if="hasError('email')" class="text-danger" v-html="errors['email'][0]"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('staff_id','Coordinator (s) Name (Teacher):',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-6">
        <select id="staff_id" class="form-control select-form" multiple>
            <option v-for="value in staff" :value="value.id" :key="value.id">@{{ value.name }}  @{{ value.middle_name }}  @{{ value.last_name }}       ( @{{ value.dept.name }} )    </option>
        </select>
        {{-- {!! Form::select('staff_id',getStaff(false), null, array('required', 'class'=>'form-control staff_id','v-model'=>'form.staff_id','placeholder'=>'Select', 'multiple'=>"multiple")) !!} --}}
        <span v-if="hasError('staff_id')" class="text-danger" v-html="errors['staff_id'][0]"></span>
    </div>
   
</div>
<div class="form-group">
   
    {!! Form::label('depart','Coordinator Department:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-6">
        <textarea class="form-control" v-model="deprt" rows="3" required="required" disabled></textarea>
        <span v-if="hasError('depart')" class="text-danger" v-html="errors['depart'][0]"></span>
    </div>
</div>


<div class="form-group">
    {!! Form::label('job_profile','Job Profile:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('job_profile',null, ['class' => 'form-control','v-model'=>'form.job_profile']) !!}
        <span v-if="hasError('job_profile')" class="text-danger" v-html="errors['job_profile'][0]"></span>
    </div>
    {!! Form::label('stu_reg','No of students registered:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('stu_reg',null, ['class' => 'form-control','v-model'=>'form.stu_reg']) !!}
        <span v-if="hasError('stu_reg')" class="text-danger" v-html="errors['stu_reg'][0]"></span>
    </div>
</div>

<div class="form-group">
    {{-- {!! Form::label('stu_appear','No of students appeared:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('stu_appear',null, ['class' => 'form-control','v-model'=>'form.stu_appear']) !!}
        <span v-if="hasError('stu_appear')" class="text-danger" v-html="errors['stu_appear'][0]"></span>
    </div> --}}

    {!! Form::label('round_no','No. of Rounds (of recruitment):',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('round_no',null, ['class' => 'form-control','v-model'=>'form.round_no']) !!}
        <span v-if="hasError('round_no')" class="text-danger" v-html="errors['round_no'][0]"></span>
    </div>

    {!! Form::label('min_salary','Min. Salary offered:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('min_salary',null, ['class' => 'form-control','v-model'=>'form.min_salary']) !!}
        <span v-if="hasError('min_salary')" class="text-danger" v-html="errors['min_salary'][0]"></span>
    </div>

    
    {{-- {!! Form::label('stu_shorted','No of students shortlisted:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-2">
        {!! Form::text('stu_shorted',null, ['class' => 'form-control','v-model'=>'form.stu_shorted']) !!}
        <span v-if="hasError('stu_shorted')" class="text-danger" v-html="errors['stu_shorted'][0]"></span>
    </div>

    {!! Form::label('stu_selected','No of students selected:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-2">
        {!! Form::text('stu_selected',null, ['class' => 'form-control','v-model'=>'form.stu_selected']) !!}
        <span v-if="hasError('stu_selected')" class="text-danger" v-html="errors['stu_selected'][0]"></span>
    </div> --}}
</div>

<div class="form-group">
    {{-- {!! Form::label('min_salary','Min. Salary offered:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('min_salary',null, ['class' => 'form-control','v-model'=>'form.min_salary']) !!}
        <span v-if="hasError('min_salary')" class="text-danger" v-html="errors['min_salary'][0]"></span>
    </div> --}}
    {!! Form::label('max_salary','Max. Salary offered:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('max_salary',null, ['class' => 'form-control','v-model'=>'form.max_salary']) !!}
        <span v-if="hasError('max_salary')" class="text-danger" v-html="errors['max_salary'][0]"></span>
    </div>
</div>

<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Save</button>
</div>



