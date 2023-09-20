
<div class="form-group">
    {!! Form::label('name','Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('name',null, ['class' => 'form-control','v-model'=>'form.name']) !!}
        <span v-if="hasError('name')" class="text-danger" v-html="errors['name'][0]"></span>
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
        <span v-if="hasError('state_id')" class="text-danger" v-html="errors['state_id'][0]"></span>
    </div>
    {!! Form::label('add','Address:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::textarea('add',null, ['class' => 'form-control','v-model'=>'form.add']) !!}
        <span v-if="hasError('add')" class="text-danger" v-html="errors['add'][0]"></span>
    </div>
    
    
</div>

<div class="form-group">
    {!! Form::label('comp_type','Company Type:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="form.comp_type">
            <option value="" selected>Select</option>
            <option value="National">National</option>
            <option value="International ">International </option>
        </select>
        <span v-if="hasError('comp_type')" class="text-danger" v-html="errors['comp_type'][0]"></span>
    </div>
    {!! Form::label('comp_nature','Nature Of Company:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="form.comp_nature">
            <option value="" selected>Select</option>
            <option value="Govt">Govt.</option>
            <option value="Non Govt">Non Govt.</option>
            <option value="NGO">NGO</option>
        </select>
        <span v-if="hasError('comp_nature')" class="text-danger" v-html="errors['comp_nature'][0]"></span>
    </div>
    
    
</div>

<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Save</button>
</div>



