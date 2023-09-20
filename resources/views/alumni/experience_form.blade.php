<fieldset>
    <legend>Work Experience </legend>
        <div v-for="exp in experience" class="academics">
            <div class="form-group">
                {!! Form::label('emp_type','Employment Type:',['class' => 'col-sm-2 control-label ']) !!}
                <div class="col-sm-5"  v-bind:class="{ 'has-error': errors['experience.'+$index+'.emp_type'] }">
                    <label class="radio-inline">
                        <label class="radio-inline">
                            <input type="radio" :name="'emp_type'+$index" value="self-employed" @change="currentlyWorkingChanged($index)" v-model="exp.emp_type"> Self Employed <br>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" :name="'emp_type'+$index" value="salaried" @change="currentlyWorkingChanged($index)" v-model="exp.emp_type"> Salaried <br>
                        </label>
                        <label class="radio-inline">
                            <input type="radio" :name="'emp_type'+$index" value="charity" @change="currentlyWorkingChanged($index)" v-model="exp.emp_type"> Charity/NGO <br>
                        </label>
                    </label>
                    <span id="basic-msg" v-if="errors['experience.'+$index+'.emp_type'] " class="help-block">@{{ errors['experience.'+$index+'.emp_type']}}</span>
                </div>
                {!! Form::label('org_name','Organisation Name',['class' => 'col-sm-2 control-label ']) !!}
                <div class="col-sm-3" v-bind:class="{ 'has-error': errors['experience.'+$index+'.org_name'] }">
                    {!! Form::text('org_name',null,['class' => 'form-control','max-length'=>'10','v-model'=>'exp.org_name']) !!}
                    <span id="basic-msg" v-if="errors['experience.'+$index+'.org_name'] " class="help-block">@{{ errors['experience.'+$index+'.org_name']}}</span>
                </div>
            </div>
            <div class="form-group" v-if="exp.emp_type =='salaried'">
                    {!! Form::label('designation','Designation:',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['experience.'+$index+'.designation'] }">
                        {!! Form::text('designation',null,['class' => 'form-control','max-length'=>'10','v-model'=>'exp.designation']) !!}
                        <span id="basic-msg" v-if="errors['experience.'+$index+'.designation'] " class="help-block">@{{ errors['experience.'+$index+'.designation']}}</span>
                    </div>
            </div>
            <div class="form-group" v-if="exp.emp_type =='charity'">
                    {!! Form::label('area_of_work','Area of work',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['experience.'+$index+'.area_of_work'] }">
                        {!! Form::text('area_of_work',null,['class' => 'form-control','max-length'=>'10','v-model'=>'exp.area_of_work']) !!}
                        <span id="basic-msg" v-if="errors['experience.'+$index+'.area_of_work'] " class="help-block">@{{ errors['experience.'+$index+'.area_of_work']}}</span>
                    </div>
            </div>
            <div class="form-group"  v-if="exp.emp_type =='self-employed'">
                    {!! Form::label('org_address','Organisation Address:',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['experience.'+$index+'.org_address'] }">
                        {!! Form::textarea('org_address',null,['size' => '30x2','class' => 'form-control','max-length'=>'10','v-model'=>'exp.org_address']) !!}
                        <span id="basic-msg" v-if="errors['experience.'+$index+'.org_address'] " class="help-block">@{{ errors['experience.'+$index+'.org_address']}}</span>
                    </div>
                    {!! Form::label('num_of_employees','Number of Employees',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-3" v-bind:class="{ 'has-error': errors['experience.'+$index+'.num_of_employees'] }">
                        {!! Form::text('num_of_employees',null,['class' => 'form-control','max-length'=>'10','v-model'=>'exp.num_of_employees']) !!}
                        <span id="basic-msg" v-if="errors['experience.'+$index+'.num_of_employees']" class="help-block">@{{ errors['experience.'+$index+'.num_of_employees'] }}</span>
                    </div>
            </div>
            
            <div class="form-group">
                {!! Form::label('currently_working','Currently working with the above mentioned organisation?',['class' => 'col-sm-5 control-label ']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['experience.'+$index+'.currently_working'] }">
                    <label class="radio-inline">
                            <label class="radio-inline">
                                <input type="radio" :name="'currently_working'+$index" value="Y" @change="currentlyWorkingChanged($index)" v-model="exp.currently_working"> Yes<br>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" :name="'currently_working'+$index" value="N" @change="currentlyWorkingChanged($index)" v-model="exp.currently_working">No<br>
                            </label>
                        {{-- {!! Form::radio('currently_working', 'Y',null, ['class' => 'minimal','v-model'=>'exp.currently_working', '@change'=>'currentlyWorkingChanged($index)']) !!}
                        Yes
                        </label>
                        <label class="radio-inline">
                        {!! Form::radio('currently_working', 'N',null, ['class' => 'minimal','v-model'=>'exp.currently_working', '@change'=>'currentlyWorkingChanged($index)']) !!}
                        No --}}
                    </label>
                    <span id="basic-msg" v-if="errors['experience.'+$index+'.currently_working']" class="help-block">@{{ errors['experience.'+$index+'.currently_working'] }}</span>
                </div>
            </div>
            
            <div class="form-group">
                <div>
                    {!! Form::label('start_date','From:',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['experience.'+$index+'.start_date'] }">
                        {!! Form::text('start_date',null,['class' => 'form-control  app-datepicker','max-length'=>'10','v-model'=>'exp.start_date']) !!}
                        <span id="basic-msg" v-if="errors['experience.'+$index+'.start_date']" class="help-block">@{{ errors['experience.'+$index+'.start_date'] }}</span>
                    </div>
                    {!! Form::label('end_date','To',['class' => 'col-sm-1 control-label ','v-if'=>"exp.currently_working =='N'"]) !!}
                    <div class="col-sm-2" v-bind:class="{ 'has-error': errors['experience.'+$index+'.end_date'] }"v-if="exp.currently_working =='N'">
                        {!! Form::text('end_date',null,['class' => 'form-control app-datepicker','max-length'=>'10','v-model'=>'exp.end_date']) !!}
                        <span id="basic-msg" v-if="errors['experience.'+$index+'.end_date']"  class="help-block">@{{ errors['experience.'+$index+'.end_date'] }}</span>
                    </div>
                </div>
                <div class="col-sm-12" v-if="$index > 0">
                        {!! Form::button('Remove',['class' => 'btn btn-success pull-right' , '@click.prevent' => 'removeRow($index,"exp")']) !!}
                </div>
            </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            {!! Form::button('Add Another',['class' => 'btn btn-success pull-right', '@click' => 'addRow("exp")']) !!}
        </div>
    </div>
</fieldset>