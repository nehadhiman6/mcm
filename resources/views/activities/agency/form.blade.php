<div class="form-group">
    {!! Form::label('name','Organization/Sponsor/Activity:',['class' => 'col-sm-3 control-label required']) !!}
    <div class="col-sm-3">
        {!! Form::text('name',null, ['class' => 'form-control','v-model'=>'form.name']) !!}
        <span v-if="hasErrors('name')" class="text-danger" v-html="errors['name'][0]"></span>
    </div>
    {!! Form::label('master_type','Agency Type:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="form.master_type">
            <option value="" Selected>Select</option>
            <option value="Organization">Organization</option>
            <option value="Activity">Activity</option>
            <option value="Sponsor">Sponsor</option>
            <option value="Activity Group">Activity Group</option>

        </select>
        <span v-if="hasError('master_type')" class="text-danger" v-html="errors['master_type'][0]" ></span>
    </div>
    <!-- <div class="col-sm-4">
        {!! Form::text('master_type',null, ['class' => 'form-control','v-model'=>'form.master_type',]) !!}
        <span v-if="hasErrors('master_type')" class="text-danger" v-html="errors['master_type'][0]"></span>
    </div> -->
</div>
<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Save</button>
</div>