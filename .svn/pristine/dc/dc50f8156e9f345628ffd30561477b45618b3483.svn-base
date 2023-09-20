<fieldset>
    <legend>Any other information you wish to share</legend>
    <div class="form-group">
        {!! Form::label('remarks','Remarks:',['class' => 'col-sm-2 control-label ']) !!}
        <div class="col-sm-10" v-bind:class="{ 'has-error': errors['remarks'] }">
            {!! Form::textarea('remarks',null,['class' => 'form-control', 'size'=> '100x3','max-length'=>'10','v-model'=>'remarks']) !!}
            <span id="basic-msg" v-if="errors['remarks'] " class="help-block">@{{ errors['remarks']}}</span>
        </div>
    </div>           
</fieldset>