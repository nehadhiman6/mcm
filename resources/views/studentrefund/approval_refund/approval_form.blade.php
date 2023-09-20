<div class="form-group">
    {!! Form::label('approval_remarks','Remarks:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::textarea('approval_remarks',null, ['class' => 'form-control','v-model'=>'form.approval_remarks']) !!}
        <span v-if="hasError('approval_remarks')" class="text-danger" v-html="errors['approval_remarks'][0]"></span>
    </div>
    <span style="display:none">
    {!! Form::label('approval_date','End Date:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
        {!! Form::text('approval_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.approval_date','disabled' => 'true']) !!}
    </div>
    </span>
</div>
<div class="box-footer">
    <button class="btn btn-primary" @click.prevent="submit()">Save</button>
    <button class="btn btn-primary" @click.prevent="reset()">Cancel</button>
</div>