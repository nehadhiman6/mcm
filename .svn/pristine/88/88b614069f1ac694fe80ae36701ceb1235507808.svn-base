
<div class="form-group">
    {!! Form::label('location','Location',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('location',null,['class' => 'form-control']) !!}
    </div>

    {!! Form::label('dept_id','Department',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('dept_id',['0'=>'Select Department']+getDepartments(),null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('type','Type',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('type',['0'=>'Select Type']+getLocationTypes(),null, ['class' => 'form-control']) !!}
    </div>
    {!! Form::label('block_id','Block ',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('block_id',getBlocks(),null, ['class' => 'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('is_store','Store',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::select('is_store',['0'=>'Select Type','Y' => 'Yes', 'N' => 'No'],null, ['v-model' => 'is_store','class' => 'form-control']) !!}
    </div>
    <div v-if=" is_store == 'Y' ">
        {!! Form::label('operated_by','Operated By ',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-4">
            {!! Form::select('operated_by',getUser(),null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>