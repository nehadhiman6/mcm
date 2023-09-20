@extends('alumni.dashboard')

@section('content')
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <!-- <span style="color:red"><b>There is a technical problem. Please try again later.<b></span> -->
      <div class="panel panel-default">
        <div class="panel-heading">
          @if($fees_for == 'hostel')
            Hostel
          @endif
          Processing Fee
        </div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST"
            action="{{ url('payments/alumni-meet-fee') }}"
          >
            {{ csrf_field() }}
            
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-sm-3 control-label required">E-Mail Address</label>

              <div class="col-sm-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ $loggedUser->email }}" required autofocus>
                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>
            
            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
                <label for="mobile" class="col-sm-3 control-label required">Mobile</label>
                
                <div class="col-sm-6">
                  <input id="mobile" class="form-control" name="mobile" value="{{ $loggedUser->mobile }}" required>
                  @if ($errors->has('mobile'))
                  <span class="help-block">
                    <strong>{{ $errors->first('mobile') }}</strong>
                  </span>
                  @endif
                </div>
            </div>

            <div class="form-group">
              <div class="col-sm-6 col-sm-offset-4">
                <button type="submit" class="btn btn-primary" >
                  Pay Fees
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3>Instructions for Making Online Transaction</h3>
        </div>
        <div class="panel-body">
        <ol>
          <li>
            Processing Fees is Rs.{{ config('college.alumni_meet_fee') }}/-
          </li>
          <li>Proceed only if you want to make the transaction.</li>
          <li>As it is an online transaction there are chances that the transaction might not a success. If this is the case and you are 
              not redirected to 'Success' or 'Failure' screen at the end, then <strong>YOU</strong> must ensure that the transaction has failed and no 
              money has been transferred from your account <strong>before trying again.</strong></li>
          <li>You can check the status of the transaction in the 'Online Payments' section from the side bar menu.</li>
          <li>Transaction status might take 15 to 20 minutes to update.</li>
        </ol>
        </div>
      </div>
    </div>
  </div>

@endsection
