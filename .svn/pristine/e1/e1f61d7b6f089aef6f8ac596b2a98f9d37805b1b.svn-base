<div class="form-group">
    {!! Form::label('act_grp_id','Activity Group',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-2">
        {!! Form::select('act_grp_id',['0'=>'Select']+getActGroup(),null, ['class' => 'form-control','v-model'=>'form.act_grp_id']) !!}
        <span v-if="hasError('act_grp_id')" class="text-danger" v-html="errors['act_grp_id'][0]"></span>
    </div>
    {!! Form::label('start_date','Start Date:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
        {!! Form::text('start_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.start_date']) !!}
        <span v-if="hasError('start_date')" class="text-danger" v-html="errors['start_date'][0]"></span>
        <span v-if="hasError('date')" class="text-danger" v-html="errors['date'][0]"></span>
    </div>

    {!! Form::label('end_date','End Date:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
        {!! Form::text('end_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.end_date']) !!}
        <span v-if="hasError('end_date')" class="text-danger" v-html="errors['end_date'][0]"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('org_by',' Organized By',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            {!! Form::select('org_by',['0'=>'Select']+getOrgBy(),null, ['class' => 'form-control', 'v-model' => 'org_by', '@change'=>'getOrgnization']) !!}
            <span v-if="hasError('org_agency_id')" class="text-danger" v-html="errors['org_agency_id'][0]"></span>
        </div>
    {!! Form::label('org_agency_id',' Organization',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-6">
        <select  class="form-control select-form" v-model="form.org_agency_id">
            <option v-for="org in orgnisations" :value="org.id">@{{org.name}} </option>
        </select>
        <span v-if="hasError('org_agency_id')" class="text-danger" v-html="errors['org_agency_id'][0]"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('collo_by','Convener/Coordinator/Co-coordinator',['class' => 'col-md-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('convener',null, ['class' => 'form-control','v-model'=>'form.convener','placeholder' => 'Name of Convener, Coordinator, Co-coordinator']) !!}
    <span v-if="hasError('guest_name')" class="text-danger" v-html="errors['guest_name'][0]"></span>
</div>


<div class="form-group">
    {!! Form::label('internal','Collaboration Type',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-4"  v-bind:class="{ 'has-error': errors['medium'] }">
            <label class="radio-inline" >
                {!! Form::radio('internal', 'Internal',null, ['class' => 'minimal','v-model'=>'form.internal', '@change'=>'setCollo']) !!}
                Internal
            </label>
            <label class="radio-inline">
                {!! Form::radio('internal', 'External',null, ['class' => 'minimal','v-model'=>'form.internal', '@change'=>'setCollo']) !!}
                External
            </label>
            <label class="radio-inline">
                {!! Form::radio('internal', 'Not Any',null, ['class' => 'minimal','v-model'=>'form.internal', '@change'=>'setCollo']) !!}
                None
            </label>
            <span id="basic-msg" v-if="errors['internal']" class="help-block">@{{ errors['internal'][0] }}</span>
        </div>
</div>

<div class="form-group" v-show="form.internal == 'Internal' || form.internal == 'External'">
    {!! Form::label('colloboration_with_id',' Collaboration With',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-2">
            {!! Form::select('colloboration_with_id',['0'=>'Select']+ getOrgBy(),null, ['class' => 'form-control', 'v-model' => 'form.colloboration_with_id', '@change'=>'getColloboration']) !!}
            <span v-if="hasError('colloboration_with_id')" class="text-danger" v-html="errors['colloboration_with_id'][0]"></span>
        </div>
    {!! Form::label('agency_id',' Organization',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-6" v-if="form.internal == 'External'">
        {!! Form::text('agency_name',null, ['class' => 'form-control','v-model'=>'form.agency_name']) !!}
        <span v-if="hasError('agency_name')" class="text-danger" v-html="errors['agency_name'][0]"></span>
    </div>
    <div class="col-sm-6" v-if="form.internal == 'Internal'">
        <select id="agency_id" class="form-control select-form" v-model="form.agency_id">
            <option v-for="collo in colloboration" :value="collo.id">@{{collo.name}} </option>
        </select>
        <span v-if="hasError('agency_id')" class="text-danger" v-html="errors['agency_id'][0]"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('act_type_id','Activity',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-2">
        {!! Form::select('act_type_id',['0'=>'Select']+getActivity(),null, ['class' => 'form-control','v-model'=>'form.act_type_id']) !!}
        <span v-if="hasError('act_type_id')" class="text-danger" v-html="errors['act_type_id'][0]"></span>
    </div>
    {!! Form::label('topic','Topic:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('topic', null, ['class' => 'form-control','size' => '30x2','v-model'=>"form.topic"]) !!}
        <span v-if="hasError('topic')" class="text-danger" v-html="errors['topic'][0]"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('sponsor_by_id','Sponsored/Funded By:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
        {!! Form::select('sponsor_by_id',['0'=>'Select']+getSponsor(),null, ['class' => 'form-control', 'v-model' => 'form.sponsor_by_id']) !!}
        <span v-if="hasError('sponsor_by_id')" class="text-danger" v-html="errors['sponsor_by_id'][0]"></span>
    </div>
    {!! Form::label('sponsor_address','Address of Funding agency:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::textarea('sponsor_address', null, ['class' => 'form-control','size' => '30x2','v-model'=>"form.sponsor_address"]) !!}
        <span v-if="hasError('sponsor_address')" class="text-danger" v-html="errors['sponsor_address'][0]"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('sponsor_amt','Amount Sponsored:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
        {!! Form::text('sponsor_amt', null, ['class' => 'form-control','v-model'=>"form.sponsor_amt"]) !!}
        <span v-if="hasError('sponsor_amt')" class="text-danger" v-html="errors['sponsor_amt'][0]"></span>
    </div>
    {!! Form::label('aegis','Under the aegis of:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-6">
        {!! Form::text('aegis', null, ['class' => 'form-control','v-model'=>"form.aegis"]) !!}
        <span v-if="hasError('aegis')" class="text-danger" v-html="errors['aegis'][0]"></span>
    </div>
</div>

<fieldset style="margin:0 0 15px 0">
    <legend>Guest/Resource Person</legend>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Designation</th>
                <th>Affiliation</th>
                <th>Official Address</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="dets in form.guest ">
                <td> 
                    {!! Form::text('guest_name',null, ['class' => 'form-control','v-model'=>'dets.guest_name']) !!}
                    <span v-if="hasError('guest_name')" class="text-danger" v-html="errors['guest_name'][0]"></span>
                </td>
                <td>
                    {!! Form::text('guest_designation',null, ['class' => 'form-control','v-model'=>'dets.guest_designation']) !!}
                    <span v-if="hasError('guest_designation')" class="text-danger" v-html="errors['guest_designation'][0]"></span>
                </td>
                <td>
                    {!! Form::text('guest_affiliation',null, ['class' => 'form-control','v-model'=>'dets.guest_affiliation']) !!}
                    <span v-if="hasError('guest_affiliation')" class="text-danger" v-html="errors['guest_affiliation'][0]"></span>
                </td>
                <td>
                    {!! Form::text('address',null, ['class' => 'form-control','v-model'=>'dets.address']) !!}
                    <span v-if="hasError('guest_affiliation')" class="text-danger" v-html="errors['guest_affiliation'][0]"></span>
                </td>
                <td>
                    {!! Form::button('Remove',['class' => 'btn btn-success', '@click.prevent' => 'removeElement($key)']) !!}
                </td>
            </tr>
        </tbody>

        <div class="form-group">
            <div class="col-sm-12">
                {!! Form::button('Add Row',['class' => 'btn btn-success pull-right', '@click.prevent' => 'addRow']) !!}
            </div>
        </div>
    </table>
</fieldset>

<fieldset style="margin:0 0 15px 0">
    <legend>No Of Participants</legend>
    <table class="table table-striped">
        <thead>
            <tr>
                <th  width = "10%"></th>
                <th width = "13%">Students</th>
                <th width = "13%">Teachers</th>
                <th width = "13%">Non-Teaching</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> 
                    <strong>College</strong>
                </td>
                <td>
                    {!! Form::text('college_students',null, ['class' => 'form-control','v-model'=>'form.college_students']) !!}
                    <span v-if="hasError('college_students')" class="text-danger" v-html="errors['college_students'][0]"></span>
                </td>
                <td>
                    {!! Form::text('college_teachers',null, ['class' => 'form-control','v-model'=>'form.college_teachers']) !!}
                    <span v-if="hasError('college_teachers')" class="text-danger" v-html="errors['college_teachers'][0]"></span>
                </td>
                <td>
                    {!! Form::text('college_nonteaching',null, ['class' => 'form-control','v-model'=>'form.college_nonteaching']) !!}
                    <span v-if="hasError('college_nonteaching')" class="text-danger" v-html="errors['college_nonteaching'][0]"></span>
                </td>

                <td>
                    {!! Form::text('remarks',null, ['class' => 'form-control','v-model'=>'form.remarks']) !!}
                    <span v-if="hasError('remarks')" class="text-danger" v-html="errors['remarks'][0]"></span>
                </td>
            </tr>

            <tr>
                <td> 
                    <strong>Other</strong>
                </td>
                <td>
                    {!! Form::text('outsidere_students',null, ['class' => 'form-control','v-model'=>'form.outsider_students']) !!}
                    <span v-if="hasError('outsider_students')" class="text-danger" v-html="errors['outsider_students'][0]"></span>
                </td>
                <td>
                    {!! Form::text('outsider_teachers',null, ['class' => 'form-control','v-model'=>'form.outsider_teachers']) !!}
                    <span v-if="hasError('outsider_teachers')" class="text-danger" v-html="errors['outsider_teachers'][0]"></span>
                </td>
                <td>
                    {!! Form::text('outsider_nonteaching',null, ['class' => 'form-control','v-model'=>'form.outsider_nonteaching']) !!}
                    <span v-if="hasError('outsider_nonteaching')" class="text-danger" v-html="errors['outsider_nonteaching'][0]"></span>
                </td>
                <td>
                    {!! Form::text('other_remarks',null, ['class' => 'form-control','v-model'=>'form.other_remarks']) !!}
                    <span v-if="hasError('other_remarks')" class="text-danger" v-html="errors['other_remarks'][0]"></span>
                </td>
            </tr>
        </tbody>
    </table>
</fieldset>

<!-- <div class="form-group">
    {!! Form::label('college_teachers','College Teachers:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        {!! Form::text('college_teachers',null, ['class' => 'form-control','v-model'=>'form.college_teachers']) !!}
        <span v-if="hasError('college_teachers')" class="text-danger" v-html="errors['college_teachers'][0]"></span>
    </div>

    {!! Form::label('college_students','College Students:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        {!! Form::text('college_students',null, ['class' => 'form-control','v-model'=>'form.college_students']) !!}
        <span v-if="hasError('college_students')" class="text-danger" v-html="errors['college_students'][0]"></span>
    </div>
    
</div>

<div class="form-group">
    {!! Form::label('college_nonteaching','College Non-teaching:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        {!! Form::text('college_nonteaching',null, ['class' => 'form-control','v-model'=>'form.college_nonteaching']) !!}
        <span v-if="hasError('college_nonteaching')" class="text-danger" v-html="errors['college_nonteaching'][0]"></span>
    </div>

    {!! Form::label('outsider_teachers','Outsider Teachers:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        {!! Form::text('outsider_teachers',null, ['class' => 'form-control','v-model'=>'form.outsider_teachers']) !!}
        <span v-if="hasError('outsider_teachers')" class="text-danger" v-html="errors['outsider_teachers'][0]"></span>
    </div>
</div> -->

<div class="form-group">
    {!! Form::label('details','Short Report:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
    {!! Form::textarea('details', null, ['class' => 'control-label area col-sm-12','v-model'=>"form.details", "rows"=>"2"]) !!}
        <span v-if="hasError('details')" class="text-danger" v-html="errors['details'][0]"></span>
    </div>

</div> 

<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update Activity</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Add Activity</button>
</div>

<style>
    .area{
        text-align:left !important;
    }
</style>



