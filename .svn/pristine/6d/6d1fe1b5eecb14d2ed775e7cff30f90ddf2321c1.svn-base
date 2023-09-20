@extends('online.dashboard')

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
    @endif
    <div id="app1">
    <div class="panel panel-default" style="margin-top:0px;" v-show="proceed == true">
        <div class="panel-heading instructions">Instructions for Students to get the No-Dues Slip</div>
        <div class="panel-body" style="padding:0px 15px;box-shadow: none;">
            <ul>
                <li>1. Students must update the Mobile Number and Email ID.</li>
                <li>2. The OTP and Activation Link will be sent on your mobile number and Email ID.</li>
                <li>3. After entering Mobile Number click on “Generate OTP”. You will receive the OTP on your mobile. Enter the OTP in the text box provided for entering it.</li>
                <li>4. After entering Email ID press “Update” button.  You will receive the activation link in your email inbox. Open your inbox and open the received email from MCM DAV. Click the “Activate” Button in the mail. You will automatically be taken back to your college dashboard to proceed.</li>
                <li>5. Only when the OTP received on your Mobile has been entered and activation link received in your email has been activated, the No-Dues slip will be available for download.</li>
                <li>6. Click on “Print No-Dues” Button to print the slip.</li>
            </ul>
        </div>
        <div class="panel-footer">
            <input class="btn btn-primary"  type="submit" value="Proceed" @click.prevent="onProceedClick()">
        </div>
    </div>

    <div class="panel panel-default" style="margin-top:0px;" v-show="proceed == false">
        <div class="panel-heading">
            <strong>No Dues Form</strong>
        </div>
        @if($student)
            <div class='panel panel-default' style="padding:0 20px 0 20px;box-shadow:none;margin-top:0px;">
                <div>
                    <fieldset>
                        <legend style="border-bottom:none;">Student's Details</legend>
                        <div class="col-sm-4">
                            <p><strong class='p-head'>Name :</strong> {{ $student->name }}</p>
                            <p><strong class='p-head'>Course :</strong> {{ $student->course->course_name }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p><strong class='p-head'>Father Name :</strong> {{ $student->father_name }}</p>
                            <p><strong class='p-head'>Mother Name :</strong> {{ $student->mother_name }}</p>
                        </div>
                    </fieldset>            
                </div>         
            </div>

            <div class="panel-body">
                {!! Form::model($student, ['method' => 'PATCH', 'action' => ['Online\NoDuesController@update', $student->id], 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {!! Form::label('father_mobile','Father Mobile (+91)',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('father_mobile',$student->father_mobile,['class' => 'form-control']) !!}
                        <span v-if="hasError('father_mobile')" class="text-danger" v-html="errors['father_mobile'][0]" ></span>
                    </div>
                    {!! Form::label('mother_mobile','Mother Mobile (+91)',['class' => 'col-sm-3 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('mother_mobile',$student->mother_mobile,['class' => 'form-control']) !!}
                        <span v-if="hasError('mother_mobile')" class="text-danger" v-html="errors['mother_mobile'][0]" ></span>
                    </div>
                </div>
        @endif
                @if($studentuser)
                    <div class="form-group">
                        {!! Form::label('stu_mobile','Student Mobile (+91)',['class' => 'col-sm-2 control-label required']) !!}
                        <div class="col-sm-2">
                            @if($studentuser->mobile_verified == "Y")
                                {!! Form::text('stu_mobile',$studentuser->mobile,['class' => 'form-control', 'v-model' => 'stu_mobile','disabled']) !!}
                            @else
                                {!! Form::text('stu_mobile',$studentuser->mobile,['class' => 'form-control', 'v-model' => 'stu_mobile']) !!}
                            @endif
                        </div>
                        <div class="col-sm-1">
                            {{-- {!! Form::submit('Generate OTP',['class' => 'btn btn-primary buttonprimary']) !!} --}}
                            @if($studentuser->mobile_verified == "Y")
                                <img src="{{ asset('dist/img/admitted.png')}}">
                            @else
                                <button class="btn btn-primary buttonprimary" :disabled = "stu_mobile == ''  || stu_mobile.length != 10 || isNaN(stu_mobile) == true" @click.prevent="genOTP">@{{ otp_text }}</button>
                            @endif
                        </div>
                        {!! Form::label('otp','Enter OTP',['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-2">
                            @if($studentuser->mobile_verified == "Y")
                                {!! Form::text('otp',null,['class' => 'form-control','disabled']) !!}
                            @else 
                                {!! Form::text('otp',null,['class' => 'form-control']) !!}
                            @endif
                        </div>
                        {{-- <div class="col-sm-2">
                            {!! Form::submit('Verify Mobile',['class' => 'btn btn-primary buttonprimary']) !!}
                        </div> --}}
                    </div>
                {{-- @endif
                @if($studentuser) --}}
                    <div class="form-group">
                        {!! Form::label('email2','Verify Email (Std)',['class' => 'col-sm-2 control-label required']) !!}
                        <div class="col-sm-4">
                            @if($studentuser->email2_confirmed == "Y")
                                {!! Form::text('email2',$studentuser->email2,['class' => 'form-control','disabled']) !!}
                            @else 
                                {!! Form::text('email2',$studentuser->email2,['class' => 'form-control']) !!}
                            @endif
                        </div>
                        <div class="col-sm-4">
                            @if($studentuser->email2_confirmed == "Y" )
                                <img src="{{ asset('dist/img/admitted.png')}}">
                            {{-- @endif --}}
                            @elseif($studentuser->email2_code != 0 && $studentuser->email2_confirmed == "N" )
                            <p class="form-control-static"><span style="color: #ce0d0d;">Email Verification is pending</span></p>{{-- {!! Form::submit('Verify Email',['class' => 'btn btn-primary buttonprimary','disabled'=>'$studentuser->email2_confirmed == "Y"','v-model' => 'email2']) !!} --}}
                           @else 

                            @endif
                        </div>
                    @endif
                </div>
        
            <div class="panel-footer">
                @if($studentuser->mobile_verified == "Y" && $studentuser->email2_confirmed == "Y")
                    {!! Form::submit('Update', ['class' => 'btn btn-primary','disabled']) !!}
                @else
                    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                @endif
                <div class="col-sm-2" style="float:right">
                    @if($studentuser->mobile_verified == "Y" && $studentuser->email2_confirmed == "Y")
                        <a href="{{url('/admforms/no-dues-slip/'.auth('students')->user()->adm_form->id) }}" target="_blank">
                            {!! Form::button('Print No Dues', ['class' => 'btn btn-primary']) !!}
                        </a>
                    @else
                        <a href="#"">
                            {!! Form::button('Print No Dues', ['class' => 'btn btn-primary','disabled'=>'$studentuser->mobile_verified == "N" || $studentuser->email2_confirmed == "N"']) !!}
                        </a>
                    @endif

                    
                </div>
                {!! Form::close() !!}
            </div>
            <div class="no-dues-footer-msg">Please Update and verify your data to Print No Dues Form !!</div>
    </div>
</div>
@stop

@section('script')
    <script>
        // $('.alert').delay(3000).fadeOut(300);
    </script>
<script>
  var vm = new Vue({
    el: '#app1',
    data: {
        otp_text:'Generate OTP',
        stu_mobile: '',
        errors: [],
        email2: '',
        proceed: true
    },
    
    methods: {
        onProceedClick:function(){
            console.log('aaaaaaaaa');
            this.proceed = false;
            console.log('bbbbbbbbbbbbb');
        },

        genOTP: function(){
            var self= this;
            if(this.stu_mobile !=""){
                this.otp_text = "Resend OTP";
                this.$http.post('otp',{'mobile':self.stu_mobile})
                .then(function(response) {
                    self.senMsg = "OTP Sent to " + self.stu_mobile;
                }, function(errors) {
                    console.log(errors);
                });
            }
        },
        verify: function(){
            var self= this;
            if(this.stu_mobile !=""){
                this.otp_text = "Resend OTP";
                this.$http.post('otp',{'mobile':self.stu_mobile})
                .then(function(response) {
                    self.senMsg = "OTP Sent to " + self.stu_mobile;
                }, function(errors) {
                    console.log(errors);
                });
            }
        },
        hasError: function(fld) {
            var error = false;
            $.each(Object.keys(this.errors), function(i, v) {
                if (fld == v) {
                    error = true;
                }
            });
            return error;
        },
    }
  });
</script>
@endsection