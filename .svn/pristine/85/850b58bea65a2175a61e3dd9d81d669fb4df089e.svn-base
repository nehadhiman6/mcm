<div class="form-group">
    {!! Form::label('roll_no','College Roll No:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('roll_no',null, ['class' => 'form-control','v-model'=>'form.roll_no','disabled' => 'true']) !!}

    </div>
    

    
</div>
    
<div class="form-group" >
    {!! Form::label('name','Student Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('name',null, ['class' => 'form-control','v-model'=>'form.name','disabled' => 'true']) !!}
        <span v-if="hasError('name')" class="text-danger" v-html="errors['name'][0]"></span>
    </div>
    {!! Form::label('father_name','Father Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('father_name',null, ['class' => 'form-control','v-model'=>'form.father_name','disabled' => 'true']) !!}
        <span v-if="hasError('father_name')" class="text-danger" v-html="errors['father_name'][0]"></span>
    </div>
    
   
</div>

<div class="form-group">
    {!! Form::label('course','Class :',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('course',null, ['class' => 'form-control','v-model'=>'form.course','disabled' => 'true']) !!}
        <span v-if="hasError('course')" class="text-danger" v-html="errors['course'][0]"></span>
    </div>
    {!! Form::label('fund_type','College Fee /Hostel Fee:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="form.fund_type">
            <option value="" Selected>select</option>
            <option value="C">College Fee</option>
            <option value="H">Hostel Fee</option>
        </select>
        <span v-if="hasError('fund_type')" class="text-danger" v-html="errors['fund_type'][0]" ></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('request_date','Request Date:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        {!! Form::text('request_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.request_date','disabled' => 'true']) !!}
        <span v-if="hasError('request_date')" class="text-danger" v-html="errors['request_date'][0]"></span>
    </div>

    {!! Form::label('fee_deposite_date','Fee Deposite Date:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        {!! Form::text('fee_deposite_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.fee_deposite_date']) !!}
        <span v-if="hasError('fee_deposite_date')" class="text-danger" v-html="errors['fee_deposite_date'][0]"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('bank_name','Bank & Branch Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('bank_name',null, ['class' => 'form-control','v-model'=>'form.bank_name']) !!}
        <span v-if="hasError('bank_name')" class="text-danger" v-html="errors['bank_name'][0]"></span>
    </div>
    {!! Form::label('ifsc_code','IFSC code:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('ifsc_code',null, ['class' => 'form-control','v-model'=>'form.ifsc_code']) !!}
        <span v-if="hasError('ifsc_code')" class="text-danger" v-html="errors['ifsc_code'][0]"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('bank_ac_no','Bank A/c No',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('bank_ac_no',null, ['class' => 'form-control','v-model'=>'form.bank_ac_no']) !!}
        <span v-if="hasError('bank_ac_no')" class="text-danger" v-html="errors['bank_ac_no'][0]"></span>
    </div>
    {!! Form::label('account_holder_name','Account Holder Name:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('account_holder_name',null, ['class' => 'form-control','v-model'=>'form.account_holder_name']) !!}
        <span v-if="hasError('account_holder_name')" class="text-danger" v-html="errors['account_holder_name'][0]"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('amount','Fee Deposited (Rs.)',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::text('amount',null, ['class' => 'form-control','v-model'=>'form.amount']) !!}
        <span v-if="hasError('amount')" class="text-danger" v-html="errors['amount'][0]"></span>
    </div>
    {!! Form::label('reason_of_refund','Reason of withdrawal/Refund:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-4">
    {!! Form::textarea('reason_of_refund',null, ['class' => 'form-control','v-model'=>'form.reason_of_refund']) !!}
        <span v-if="hasError('reason_of_refund')" class="text-danger" v-html="errors['reason_of_refund'][0]"></span>
    </div>
</div>
<div class="form-group">
    <span style="font-size:20px; margin:0 0 0 20px" v-if="hasError('old_refund')" class="text-danger" v-html="errors['old_refund'][0]"></span>
</div>
<hr>
<div >
<p><span style="colo:#000; font-size:18px; "><strong>Instructions</strong></span></p>
<p style="margin: 0;"><span style="margin: 0 6px 0 0px;">1)</span> <span> Account Holder (to be given for Bank Details) should be either the Student herself or her Father only. </span></p>
<p  style="padding:0 0 0 21px">Please note that, these details will be used by the college to refund the fee amount.</p>
<p><span style="margin: 0 6px 0 0px;">2)</span> <span> After approval, no change in above mentioned details will be entertained by the college.</span></p>
<p><span style="margin: 0 6px 0 0px;">3)</span> <span>	Payment will be refunded within month of submission of Refund Form, and as per the norms of the Institution.</span></p>
</div>
<div class="box-footer">
    <button class="btn btn-primary" v-if="form.id > 0" @click.prevent="submit()">Update</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Save</button>
    <button class="btn btn-primary" @click.prevent="reset()">Cancel</button>
</div>



