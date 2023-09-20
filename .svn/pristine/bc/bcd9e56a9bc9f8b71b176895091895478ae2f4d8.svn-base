<br>
<div class="form-group">
    {!! Form::label('member_yes_no','Would you like to be life time member of Association MCM DAV Alumni (AMDA) yes 1500 Pay?',['class' => 'col-sm-5 control-label required']) !!}
    <div class="col-sm-1">
        <label class="col-sm-2 checkbox">
        <input type="checkbox" name="member_yes_no"  v-model='member_yes_no' v-bind:true-value="'Y'"
                v-bind:false-value="'N'" class="minimal" @change="showPayment('member')" />
        </label>
    </div>
    <div class="col-sm-2" v-show="showMemberSection">
        {!! Form::text('payment_amount',null,['class' => 'form-control col-sm-2','v-model'=>'payment_amount']) !!}
    </div>
    <input v-show="showMemberSection" class="btn btn-primary" id="pay"  type="button" value="Pay" @click.prevent="showPayment">
</div>

<div class="form-group">
    {!! Form::label('reason_yes_no','Wolud you like to Donate to the College?',['class' => 'col-sm-5 control-label required']) !!}
    <div class="col-sm-1">
        <label class="col-sm-2 checkbox">
        <input type="checkbox" name="reason_yes_no"  v-model='reason_yes_no' v-bind:true-value="'Y'"
                v-bind:false-value="'N'" class="minimal" @change="showPayment('reason')" />
        </label>
    </div>

    <div class="col-sm-3" v-show="showReasonSection">
        {!! Form::select('donation_reason',getDonationReasons(),null,['class' => 'form-control','v-model'=>'donation_reason', '@change' =>"showOtherField"]) !!}
    </div>
    <div class="col-sm-2" v-show="showDonationOther">
        {!! Form::text('donation_other',null,['class' => 'form-control col-sm-2','v-model'=>'donation_other']) !!}
    </div>
</div>