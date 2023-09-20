@if(isset($alumni_meet->meet_date))
<fieldset>
    <legend>Alumni Student Meet</legend>
   
        <p>Date : <b>{{ $alumni_meet->meet_date or '' }}</b>
        Venue : <b>{{ $alumni_meet->meet_venue  or '' }}</b>
        Timing : <b>{{ $alumni_meet->meet_time  or ''}}</b></p>
    <div class="form-group">
        {!! Form::label('attending_meet','Are you willing to attend Alumni Meet?',['class' => 'col-sm-4 control-label ']) !!}
        <div class="col-sm-3" v-bind:class="{ 'has-error': errors['attending_meet'] }">
            <label class="col-sm-2 checkbox">
            <input type="checkbox" name="attending_meet"  v-model='attending_meet' v-bind:true-value="'Y'"
                    v-bind:false-value="'N'" class="minimal" @change="changedCompetitiveExam"/>Yes
            </label>
            <span id="basic-msg" v-if="errors['attending_meet']" class="help-block">@{{ errors['attending_meet'][0] }}</span>
        </div>
        
 
    </div>
    <!-- <div class="form-group">
        <div class="col-sm-4 col-md-offset-5 col-sm-offset-5" >
            <input class="btn btn-primary" id="btnsubmit" type="button" value="Pay Meet Fee" v-show="attending_meet == 'Y'">
        </div>
    </div> -->
    <div class="form-group"  v-if="attending_meet == 'Y'">
            <div class="col-sm-12"><b style="color:red;">{{ $alumni_meet->remarks or '' }}</b>
            </div>
    </div>
  </fieldset>
@endif