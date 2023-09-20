<div class="form-group">
    {!! Form::label('release_amt','Release Amount',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('release_amt',null, ['class' => 'form-control','v-model'=>'form.release_amt']) !!}
        <span v-if="hasError('release_amt')" class="text-danger" v-html="errors['release_amt'][0]"></span>
    </div>
    {!! Form::label('release_remarks','Remarks:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::textarea('release_remarks',null, ['class' => 'form-control','v-model'=>'form.release_remarks']) !!}
        <span v-if="hasError('release_remarks')" class="text-danger" v-html="errors['release_remarks'][0]"></span>
    </div>
</div>
<div class="form-group">
<span style="display:none">
    {!! Form::label('release_date','End Date:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
        {!! Form::text('release_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.release_date','disabled' => 'true']) !!}
    </div>
    </span>
</div>
<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Save</button>
    <button class="btn btn-primary" @click.prevent="reset()">Cancel</button>
</div>