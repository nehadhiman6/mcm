<fieldset>
        <legend>Awards and Achievements</legend>
            <div class="form-group">
                {!! Form::label('award_yes_no','Have You been awarded ?',['class' => 'col-sm-4 control-label required']) !!}
                <div class="col-sm-4">
                    <label class="radio-inline">
                        <input type="radio" name="award_yes_no" value="Y" v-model="award_yes_no" @change="showHidePgRecPro('award')">Yes<br>
                    </label>
                    <label class="radio-inline">
                            <input type="radio" name="award_yes_no" value="N" v-model="award_yes_no" @change="showHidePgRecPro('award')">No<br>
                    </label>
                    {{-- <label class="col-sm-2 checkbox">
                    <input type="checkbox" name="award_yes_no"  v-model='award_yes_no' v-bind:true-value="'Y'"
                            v-bind:false-value="'N'" class="minimal" @change="showHidePgRecPro('award')" />Yes
                    </label> --}}
                </div>
            </div>
            <div v-for="exp in awards" class="academics" v-show="showAwardSection">
                <div class="form-group">
                    {!! Form::label('award_name','Name of the award and organisation',['class' => 'col-sm-4 control-label ']) !!}
                    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['awards.'+$index+'.award_name'] }">
                        {!! Form::text('award_name',null,['class' => 'form-control','max-length'=>'10','v-model'=>'exp.award_name']) !!}
                        <span id="basic-msg" v-if="errors['awards.'+$index+'.award_name'] " class="help-block">@{{ errors['awards.'+$index+'.award_name']}}</span>
                    </div>
                    {!! Form::label('award_field','Field:',['class' => 'col-sm-1 control-label ']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['awards.'+$index+'.award_field'] }">
                        {!! Form::text('award_field',null,['class' => 'form-control','max-length'=>'10','v-model'=>'exp.award_field']) !!}
                        <span id="basic-msg" v-if="errors['awards.'+$index+'.award_field'] " class="help-block">@{{ errors['awards.'+$index+'.award_field']}}</span>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('award_year','Year',['class' => 'col-sm-4 control-label ']) !!}
                    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['awards.'+$index+'.award_year'] }">
                        {!! Form::text('award_year',null,['class' => 'form-control','max-length'=>'10','v-model'=>'exp.award_year']) !!}
                        <span id="basic-msg" v-if="errors['awards.'+$index+'.award_year'] " class="help-block">@{{ errors['awards.'+$index+'.award_year']}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12" v-if="$index > 0">
                        {!! Form::button('Remove',['class' => 'btn btn-success pull-right' , '@click.prevent' => 'removeRow($index,"award")']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group" v-show="showAwardSection">
                <div class="col-sm-12">
                    {!! Form::button('Add Another',['class' => 'btn btn-success pull-right', '@click' => 'addRow("award")']) !!}
                </div>
            </div>
    </fieldset>