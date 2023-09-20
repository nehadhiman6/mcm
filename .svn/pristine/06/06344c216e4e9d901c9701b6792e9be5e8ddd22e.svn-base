<h1>Transaction Status</h1>
@if ($status === 'SUC') 
<p>Payment Received.</p>
@elseif ($status === 'FAL') 
<p>Transaction Failure.</p>
@endif
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Transaction Result</strong>
  </div>
  <div class="panel-body">
    <div class="trans_details">
      <div class="row">
        <div class="col-sm-1 col-sm-offset-3">
          <img src="{{ asset("/dist/img/mcm-logo.png") }}" 
               alt="logo" title="logo" 
               height="80"/>
        </div>
        <div class="col-sm-4">
          <h2><strong>MCM, Sector - 36, Chandigarh</strong></h2>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-sm-offset-3">
          <p>
            @if($trans->ourstatus == 'OK')
            e-Receipt
            @endif
          </p>
        </div>
        <div class="col-sm-6">
          <p>Status: {{ $trans->status == 'F' ? 'Failed' : $trans->status }}</p>
        </div>
      </div>
      <div class="row">

        <div class="col-sm-3 col-sm-offset-3">
          <p>Online Transaction Ref. No.</p>
        </div>
        <div class="col-sm-6">
          <p>{{ $trans->trcd }}</p>
        </div>
      </div>
      <div class="row">

        <div class="col-sm-3 col-sm-offset-3">
          <p>Transaction Date</p>
        </div>
        <div class="col-sm-6">
          <p>{{ $trans->trntime }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-sm-offset-3">
          <p>Name of Student</p>
        </div>
        <div class="col-sm-6">
          <p>{{ $trans->std_user->adm_form->name or '' }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-sm-offset-3">
          <p>Course</p>
        </div>
        <div class="col-sm-6">
          <p>{{ $trans->std_user->adm_form->course->course_name or '' }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-sm-offset-3">
          @if($trans->std_user && $trans->std_user->student)
          <p>Admission No.</p>
          <p>Roll No.</p>
          @endif
        </div>
        <div class="col-sm-6">
          @if($trans->std_user && $trans->std_user->student)
          <p>{{ $trans->std_user->student->adm_no or '' }}</p>
          <p>{{ $trans->std_user->student->roll_no or '' }}</p>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 col-sm-offset-3">
          <p>Amount</p>
        </div>
        <div class="col-sm-6">
          <p>{{ $trans->amt}}</p>
        </div>

      </div>
    </div>
  </div>
</div>

