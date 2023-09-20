@extends('online.dashboard')

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
            @if($fees_for == 'college')
              action="{{ url('payments/prospectus') }}"
            @else
              action="{{ url('payments/pros-hostel') }}"
            @endif
          >
            {{ csrf_field() }}
            
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-sm-3 control-label">E-Mail Address</label>

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
                <label for="mobile" class="col-sm-3 control-label">Mobile</label>
                
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

      <div class="panel panel-default ">
        <div class="panel-heading">
          <h3>Instructions for Making Online Transaction</h3>
        </div>
        <div class="panel-body">
        <ol>
          <li>
            @if($fees_for == 'college')
              Processing Fees is Rs.{{ config('college.payment_pros_fee') }}/-
            @elseif($fees_for == 'hostel')
              Hostel Processing Fees is Rs.{{ config('college.hostel_pros_fee') }}/-
            @endif
          </li>
          <li>  Proceed only if you want to make the transaction.</li>
          {{-- <li>As it is an online transaction there are chances that the transaction might not a success. If this is the case and you are 
              not redirected to 'Success' or 'Failure' screen at the end, then <strong>YOU</strong> must ensure that the transaction has failed and no 
              money has been transferred from your account <strong>before trying again.</strong></li> --}}
          <li>  You can check the status of the transaction in the 'Online Payments' section from the side bar menu.</li>
          <li>  Transaction status might take 15 to 20 minutes to update.</li>
          {{-- <li>  
            Considering the prolonged impact of COVID-19 pandemic, the college is charging an advanced partial 
            amount (Rs. 50000/- for old students, Rs. 51000/ for new students) against the annual hostel fee of Rs. 1,06,000/-. 
            However, if the hostel does not become operational by December 31st, 2020, half of the paid amount will be adjusted in
             annual hostel fee. 
            </li> --}}
        </ol>
        {{-- <p>
         Note: The hostel fee for the entire session is Rs. 1,06,000 (New Students) and Rs. 1,05,000 (Old Students) including maintenance charges, food charges and laundry facility. However, considering the prolonged impact of COVID-19 pandemic, College is taking an advance amount of Rs. 25,000 (Old Students) and Rs. 26,000 (New Students). Whenever, the hostel becomes operational, hostel fee will be proportionately adjusted/reduced.
        </p> --}}
        </div>
      </div>
    </div>
  </div>

@endsection
