@extends('alumni.dashboard')

@section('content')
<div class="row" id="app">
<div class="col-sm-9 col-sm-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
          <strong>Membership of AMDA</strong>
        </div>
        <div class="panel-body" style="padding-left: 30px;">
            <ul style="padding-left: 30px;">
                <li style="list-style:circle">AMDA is a registered Trust.</li>
                <li style="list-style:circle">Its aim is To Care,To Share, To Sustain.</li>
                <li style="list-style:circle">Every year AMDA conducts activities to achieve its aim.</li>
                <li style="list-style:circle">The Membership fee is utilized for the above.</li>
                <li style="list-style:circle">Transaction status might take 15 to 20 minutes to update.</li>
            </ul>

            <strong>A lifetime member is entitled to the following benefits* </strong>
            <ol style="padding-left: 30px;">
                    <li>Limited access to the library.</li>
                    <li>Limited aceess to the college guest house.</li>
                    <li>Concession at the time of Alumni meet or other events.</li>
            </ol>
            <strong style="color: red;">* Terms and Conditions Applied</strong>
            @if($alumni->life_member == 'N')
                <div class="form-horizontal">
                    <div class="form-group">
                        {!! Form::label('member_yes_no','Would you like to be a life time member of the Association of MCM DAV Alumni (AMDA) ?',['class' => 'col-sm-10 control-label']) !!}            
                        <div class="col-sm-1">
                            <label class="col-sm-2 checkbox">
                            <input type="checkbox" name="member_yes_no"  v-model='member_yes_no' v-bind:true-value="'Y'"
                                    v-bind:false-value="'N'" class="minimal"/>
                            </label>
                        </div>
                        <input v-show="member_yes_no == 'Y'" class="btn btn-primary" id="pay"  type="button" value="Pay" :disabled="paying_fees" @click.prevent="makeLifeMemberPayment">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="col-sm-9 col-sm-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Donation</strong>
        </div>
        <div class="panel-body" style="padding-left: 30px;">
            <ul style="padding-left: 30px;">
                <li>AMDA provides a platform for you to donate to the college on any occassion that touches your heart.Due recognition will be 
                    given to your generosity by way of display on the college website, social media accounts and various college reports.</li>
            </ul>

            <strong>A lifetime member is entitled to the following benefits* </strong>
            <ol style="padding-left: 30px;">
                    <li>Limited access to the library.</li>
                    <li>Limited aceess to the college guest house.</li>
                    <li>Concession at the time of Alumni meet or other events.</li>
            </ol>

            <div class="form-horizontal">
                <div class="form-group">
                    {!! Form::label('reason_yes_no','Wolud you like to Donate to the College?',['class' => 'col-sm-5 control-label']) !!}
                    <div class="col-sm-1">
                        <label class="col-sm-2 checkbox">
                        <input type="checkbox" name="reason_yes_no"  v-model='reason_yes_no' v-bind:true-value="'Y'"
                                v-bind:false-value="'N'" class="minimal" />
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div v-show="reason_yes_no == 'Y'">
                        {!! Form::label('occasion','Occasion',['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('occasion',null,['class' => 'form-control col-sm-2','v-model'=>'occasion']) !!}
                        </div> 
                    </div>
                </div>
                <div class="form-group" v-show="reason_yes_no == 'Y'">
                    {!! Form::label('donation_reason','Purpose',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-5">
                        {!! Form::select('donation_reason',getDonationReasons(),null,['class' => 'form-control','v-model'=>'donation_reason']) !!}
                    </div>
                    <div class="col-sm-2" v-show="donation_reason == 'Others'">
                        {!! Form::text('donation_other',null,['class' => 'form-control col-sm-2','v-model'=>'donation_other']) !!}
                    </div>
                </div>
                <div class="form-group" v-show="reason_yes_no == 'Y'">
                    {!! Form::label('amount','Amount(INR)',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                    {!! Form::text('amount',null,['class' => 'form-control col-sm-2','v-model'=>'amount']) !!}
                    </div>
                    <input class="btn btn-primary" id="pay"  type="button" value="Pay" @click.prevent="donate">
                </div>
            </div>   
        </div>
    </div>
</div>

<div class="col-sm-9 col-sm-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                Thank you for sparing your time. In case you wish to become a member,donate or update any information, kindly login any time.
                {{-- <br> --}}
                For any query mail us at <a href="mailto:alumni@mcmdavcwchd.edu.in"><u>alumni@mcmdavcwchd.edu.in</u></a> and visit us on our <a href = "https://www.facebook.com/pages/category/Organization/AMDA-Association-of-MCM-DAV-Alumni-118343124846458/"><u>facebook</u></a> page.
                
            </strong>
        </div>
    </div>
</div>
<div id="fee-box"></div>
</div>

@endsection
@section('script')
<script>
  var vm = new Vue({
	el: '#app',
	data: {
        member_yes_no: 'N',
		donation_other: '',
		donation_reason: '',
		payment_amount: '',
        paying_fees: false
	},

	ready: function(){
        
	},
	
	methods: {
        makeLifeMemberPayment() {
            if(this.paying_fees) {
                return;
            }
            paying_fees = true;
            $('#fee-box').html('');
            $('#fee-box').append('<form id="fee-form" action=\'{{ url("payments/alumni-member-fee") }}\' method="POST">');
            $('#fee-form').append('<input type="hidden" name="alumni_stu_id" value="' + {{ $alumni->id }} + '">')
                .append('{!! csrf_field() !!}')
                .submit();
        },
        donate() {
            console.log('paying donation');
        }
	}
  });
</script>
@stop