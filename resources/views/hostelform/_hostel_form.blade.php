    <div  class="col-sm-12">
        <div class="form-group">
          <div class="col-sm-12">
              <p><b>NOTE: Read the instructions given in the hostel prospectus available on the college website before filling up this form.</b>
          </div>
        </div>
        <div class='form-group' >
            {!! Form::label('schedule_backward_tribe','Do you belong to Scheduled Caste/Scheduled Tribe/Backward Class?',['class' => 'col-sm-6 control-label required']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['schedule_backward_tribe'] }">
            <label class="radio-inline">
                {!! Form::radio('schedule_backward_tribe', 'Y',null, ['class' => 'minimal','v-model'=>'schedule_backward_tribe']) !!}
                Yes
            </label>
            <label class="radio-inline">
                {!! Form::radio('schedule_backward_tribe', 'N',null, ['class' => 'minimal','v-model'=>'schedule_backward_tribe']) !!}
                No
            </label>
            <span id="basic-msg" v-if="errors['schedule_backward_tribe']" class="help-block">@{{ errors['schedule_backward_tribe'][0] }}</span>
            </div>
        </div>
        <div class="form-group">
        {!! Form::label('serious_ailment','If you have any serious ailment give details ',['class' => 'col-sm-4 control-label ']) !!}
        <div class="col-sm-4">
            {!! Form::textarea('serious_ailment',null,['size' => '30x2','class' => 'form-control','v-model'=>'serious_ailment']) !!}
        </div>
        </div>
        <div class="form-group">
        {!! Form::label('hostel_data','If you were in hostel of this college earlier, give particulars:',['class' => 'col-sm-5 control-label ']) !!}
        </div>
        <div class="form-group">
        {!! Form::label('prv_hostel_block','Hostel Block',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('prv_hostel_block',null,['class' => 'form-control','v-model'=>'prv_hostel_block']) !!}
        </div>
        {!! Form::label('prv_room_no','Room No.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('prv_room_no',null,['class' => 'form-control','v-model'=>'prv_room_no']) !!}
        </div>
        </div>
        <div class="form-group">
        {!! Form::label('prv_class','Class',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('prv_class',null,['class' => 'form-control','v-model'=>'prv_class']) !!}
        </div>
        {!! Form::label('prv_roll_no','Roll No.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('prv_roll_no',null,['class' => 'form-control','v-model'=>'prv_roll_no']) !!}
        </div>
        </div>
    </div>
    <div class="col-sm-12">
    <legend><h4><strong>Local Guardian's Details</strong></h4></legend>
         <div class='form-group'>
            {!! Form::label('guardian_name','Name ',['class' => 'col-sm-2 control-label required']) !!}
              <div class="col-sm-4"  v-bind:class="{ 'has-error': errors['guardian_name'] }">
                {!! Form::text('guardian_name',null,['class' => 'form-control','v-model'=>'guardian_name']) !!}
                <span id="basic-msg" v-if="errors['guardian_name']" class="help-block">@{{ errors['guardian_name'][0] }}</span>
              </div>
        
          {!! Form::label('guardian_relationship','Relationship with Guardian',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-4" v-bind:class="{ 'has-error': errors['guardian_relationship'] }">
          {!! Form::text('guardian_relationship',null,['class' => 'form-control','v-model'=>'guardian_relationship']) !!}
          <span id="basic-msg" v-if="errors['guardian_relationship']" class="help-block">@{{ errors['guardian_relationship'][0] }}</span>
        </div>
        </div>

        <div class='form-group'>
          {!! Form::label('guardian_phone','Phone No.(with STD Code)',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-4" v-bind:class="{ 'has-error': errors['guardian_phone'] }">
          {!! Form::text('guardian_phone',null,['class' => 'form-control','v-model'=>'guardian_phone']) !!}
          </div>
          <span id="basic-msg" v-if="errors['guardian_phone']" class="help-block">@{{ errors['guardian_phone'][0] }}</span>
       
          {!! Form::label('guardian_mobile','Mobile No.',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-4"  v-bind:class="{ 'has-error': errors['guardian_mobile'] }">
          {!! Form::text('guardian_mobile',null,['class' => 'form-control','v-model'=>'guardian_mobile']) !!}
          <span id="basic-msg" v-if="errors['guardian_mobile']" class="help-block">@{{ errors['guardian_mobile'][0] }}</span>
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('guardian_email','Email ID',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-4">
          {!! Form::text('guardian_email',null,['class' => 'form-control','v-model'=>'guardian_email']) !!}
          </div>
      
          {!! Form::label('guardian_address','Address',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-4" v-bind:class="{ 'has-error': errors['guardian_address'] }">
            {!! Form::textarea('guardian_address', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'guardian_address']) !!}
          <span id="basic-msg" v-if="errors['guardian_address']" class="help-block">@{{ errors['guardian_address'][0] }}</span>
            
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('g_office_addr','Office Address',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-10" v-bind:class="{ 'has-error': errors['g_office_addr'] }">
            {!! Form::textarea('g_office_addr', null, [ 'rows' => 4, 'cols' => 100 ,'class' => 'form-control','v-model'=>'g_office_addr']) !!}
            <span id="basic-msg" v-if="errors['g_office_addr']" class="help-block">@{{ errors['g_office_addr'][0] }}</span>
    
          </div>
        </div>

        <div class="form-group">
          {!! Form::label('room_mate','Roommates Preference(If any.)',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-10" v-bind:class="{ 'has-error': errors['room_mate'] }">
          {!! Form::textarea('room_mate', null, [ 'rows' => 4, 'cols' => 100 ,'class' => '','v-model'=>'room_mate', 'placeholder' => 'Name, class, rollno, place']) !!}
          <span id="basic-msg" class="help-block">*Subject to availability.</span>  
          <span id="basic-msg" v-if="errors['room_mate']" class="help-block">@{{ errors['room_mate'][0] }}</span>  
        </div>
        @if($adm_form->course->course_year == '1')
          <div class="form-group">
            {!! Form::label('ac_room','Do you want to apply for AC Room ?',['class' => 'col-sm-3 control-label required']) !!}
            <div class="col-sm-8" v-bind:class="{ 'has-error': errors['ac_room'] }">
              <input type="checkbox" name="ac_room" style="margin: 13px 0 0 0;" v-model='ac_room' value='Y' class="minimal" v-bind:true-value="'Y'"
              v-bind:false-value="'N'">
              <span id="basic-msg" class="help-block">- Limited seats, First come first serve basis.<br>
                - Confirmation of AC room allotment will be intimated separately through the registered email of the student.</span> 
              <span id="basic-msg" v-if="errors['room_mate']" class="help-block">@{{ errors['room_mate'][0] }}</span>  
          </div>
        @endif
        </div>
    </div>
