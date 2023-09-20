<div class="form-group">
    {!! Form::label('name','Organizational Unit:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('name',null, ['class' => 'form-control','v-model'=>'form.name']) !!}
        <span v-if="hasError('name')" class="text-danger" v-html="errors['name'][0]"></span>
    </div>
    {!! Form::label('external_agency','Organizing Unit:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="form.external_agency" Disabled>
            <option value="Y">Yes</option>
            <option value="N">No</option>
        </select>
        <span v-if="hasError('external_agency')" class="text-danger" v-html="errors['external_agency'][0]" ></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('agency_type_id','Organization Type:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('agency_type_id',['0'=>'Select']+getOrgBy(),null, ['class' => 'form-control','v-model'=>'form.agency_type_id']) !!}
        <span v-if="hasError('agency_type_id')" class="text-danger" v-html="errors['agency_type_id'][0]"></span>
    </div>
    {!! Form::label('department','Parent Unit(Department):',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('dept_id',['0'=>'Select Dept or use College Campus']+getDepartments(),null, ['class' => 'form-control','v-model'=>'form.dept_id']) !!}
        <span v-if="hasError('dept_id')" class="text-danger" v-html="errors['dept_id'][0]"></span>
    </div>
</div>

<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update Organization</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Add Organization</button>
</div>

