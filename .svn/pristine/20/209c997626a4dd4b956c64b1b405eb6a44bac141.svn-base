<template id="hostel-template">
    <fieldset>
        <legend>Hostel</legend>
        <div class="form-group"  v-if="hostel == 'Y'">
            <div class="col-sm-7">
            <p class= "control-label"><b>Note :Hostel seat allotment is subject to the filling of hostel form and availability of seats.</b></p>
            </div>
        </div>
        <div class='form-group'>
            {!! Form::label('hostel','Seeking Hostel Seat',['class' => 'col-sm-2 control-label','v-if'=>"getSelectedCourse && getSelectedCourse.course_year == '1'"]) !!}
            {!! Form::label('hostel','Applied for Hostel',['class' => 'col-sm-2 control-label','v-else']) !!}
            <div class="col-sm-1">
            <label class="col-sm-1 checkbox">
                <input type="checkbox" name="hostel" v-model = 'hostel' value='Y' class="minimal" v-bind:true-value="'Y'"
                    v-bind:false-value="'N'">
            </label>
            </div>
        </div>
        <div class='form-group' v-if="hostel == 'Y'">
            {!! Form::label('schedule_backward_tribe','Do you belong to Scheduled Caste/Schedule Tribe/Backward Class?',['class' => 'col-sm-6 control-label required']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['schedule_backward_tribe'] }">
                <label class="radio-inline">
                {!! Form::radio('schedule_backward_tribe', 'Y',null, ['class' => 'minimal','v-model'=>'hostel_data.schedule_backward_tribe']) !!}
                Yes
                </label>
                <label class="radio-inline">
                {!! Form::radio('schedule_backward_tribe', 'N',null, ['class' => 'minimal','v-model'=>'hostel_data.schedule_backward_tribe']) !!}
                No
                </label>
                <span id="basic-msg" v-if="errors['schedule_backward_tribe']" class="help-block">@{{ errors['schedule_backward_tribe'][0] }}</span>
            </div>
        </div>
        <div class="form-group" v-if="hostel == 'Y'">
            {!! Form::label('serious_ailment','If you have any serious ailment, give details',['class' => 'col-sm-4 control-label']) !!}
            <div class="col-sm-4">
            {!! Form::textarea('serious_ailment',null,['size' => '30x2','class' => 'form-control','v-model'=>'hostel_data.serious_ailment']) !!}
            </div>
        </div>
        <div class="form-group" v-if="hostel == 'Y'">
            {!! Form::label('hostel_data','If you were in hostel of this college earlier, give particulars:',['class' => 'col-sm-5 control-label']) !!}
        </div>
        <div class="form-group" v-if="hostel == 'Y'">
            {!! Form::label('prv_hostel_block','Hostel Block',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
            {!! Form::text('prv_hostel_block',null,['class' => 'form-control','v-model'=>'hostel_data.prv_hostel_block']) !!}
            </div>
            {!! Form::label('prv_room_no','Room No.',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
            {!! Form::text('prv_room_no',null,['class' => 'form-control','v-model'=>'hostel_data.prv_room_no']) !!}
            </div>
        </div>
        <div class="form-group" v-if="hostel == 'Y'">
            {!! Form::label('prv_class','Class',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
            {!! Form::text('prv_class',null,['class' => 'form-control','v-model'=>'hostel_data.prv_class']) !!}
            </div>
            {!! Form::label('prv_roll_no','Roll No.',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
            {!! Form::text('prv_roll_no',null,['class' => 'form-control','v-model'=>'hostel_data.prv_roll_no']) !!}
            </div>
        </div>
    </fieldset>
</template>
 

@push('vue-components')
    <script>
        var no = 1000;
        var hostelComponent = Vue.extend({
            template: '#hostel-template',
            data: function(){
                return {
                    hostel: "{{ $adm_form->hostel == 'Y' ? 'Y' : 'N' }}",
                    schedule_backward_tribe:"{{ $adm_form->schedule_backward_tribe == 'Y' ? 'Y' : 'N' }}",
                    serious_ailment:'',
                    hostel_data: {!! isset($hostel_data) ? json_encode($hostel_data) : " {serious_ailment:'',prv_hostel_block:'',prv_room_no:'', prv_class:'', prv_roll_no:'',schedule_backward_tribe:'N'}" !!},
                    //basic
                    response: {},
                    success: false,
                    fails: false,
                    msg: '',
                    errors: [],
                }
            },
        });

        Vue.component('hostel', hostelComponent)
    </script>
@endpush
