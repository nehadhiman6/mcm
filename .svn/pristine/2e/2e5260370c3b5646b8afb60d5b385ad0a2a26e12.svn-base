@extends('online.dashboard')
@section('content')
<div class="panel panel-default" id ='app'>
  <div class="panel-heading">
    <strong>Online Payments</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Fee Type</th>
          <th>Amount</th>
          <th>Transaction Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($std_payments as $pay)
        <tr>
          <td>
            @if($pay->trn_type == 'prospectus_fee')<span>Processing Fee</span>
            @elseif($pay->trn_type == 'prospectus_fee_hostel')<span>Hostel Processing Fee</span>
            @elseif($pay->trn_type == 'admission_fee')<span>Admission Fee</span>
            @elseif($pay->trn_type == 'direct_college_receipt')<span>Fee Payment</span>
            @elseif($pay->trn_type == 'hostel_receipt')<span>Hostel Receipt</span>
            @endif
          </td>
          <td>{{ $pay->amt }}</td>
          <td>{{ $pay->trntime }}</td>
          <td>
            @if($pay->ourstatus == 'OK')
              @if($pay->trn_type == 'prospectus_fee' || $pay->trn_type == 'prospectus_fee_hostel' || $pay->trn_type == 'admission_fee')
                Successful 
                @if($pay->trn_type == 'admission_fee')
                  <a href="{{ url('admfees/' . $pay->id . '/printreceipt') }}" target="_blank" class="btn btn-sm btn-primary">Print</a>
                @endif
              @else
                Successful <a href="{{ url('stdreceipts/' . $pay->fee_rcpt_id . '/printreceipt') }}" target="_blank" class="btn btn-sm btn-primary">Print</a>
              @endif
            @else 
              Failed
            @endif

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop
@section('script')
<script>
 var vm = new Vue({
    el: '#app',
    data: {
      response: {},
          
    },
    methods: {
      checkStatus: function(id) {
          console.log(id);
      },
    },
  });
</script>
@stop