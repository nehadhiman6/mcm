@extends('app')
@section('toolbar')
  @include('toolbars._bill_receipt_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h4>Release Refund</h4> 
        <p><span>Request No : {{$refund_request->id}} ( {{ $refund_request->fund_type == "H" ? "Hostel": " College" }} ), Request Date: {{$refund_request->request_date}} </span></p>
        <p>Student name: {{$refund_request->student->name}} , Class: {{$refund_request->student->course->course_name}} ,  Amount:  {{$refund_request->amount}}</p>
    </div>
    <div class="box-body">

        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

        @include('studentrefund.student_refund.form', ['submitButtonText' => 'Save'])

        {!! Form::close() !!}
        <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Your Request Submitted successfully!</strong> @{{ response['success'] }}
        </div>
        
    </div>
</div>

@stop
@section('script')
<script>
    function getNewForm() {
        return {
            id:0,
            std_id:'',
            std_ref_req_id:'',
            release_date:'',
            release_remarks:'',
            release_amt:''
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success: false,
            form: getNewForm(),
            errors: {},
            std_refund_request: '{{ $std_refund_request }}',
            refund_request:  {!! isset($refund_request) ? $refund_request : 0 !!},
            base_url: "{{ url('/')}}",
        },
        ready: function() {
            var self = this;
                self.form.std_id = self.refund_request.std_id;
                self.form.std_ref_req_id = self.std_refund_request;
        },
        methods: { 
            submit:function(){
                var self = this;
                self.$http.post("{{ url('student-refunds') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        self.errors = {};
                        self.success = true;
                        setTimeout(function() {
                            self.success = false;
                        }, 3000);
                        window.location.href = "{{ url('refund-requests-details')}}";
                        
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            // editRelease: function(){
            //     var self = this;
            //     self.form.id = self.student_refund.id;
            //     self.form.std_id = self.student_refund.std_id;
            //     self.form.std_ref_req_id = self.student_refund.std_ref_req_id;
            //     self.form.release_date = self.student_refund.release_date;
            //     self.form.release_remarks = self.student_refund.release_remarks;
            //     self.form.release_amt = self.student_refund.release_amt;
                
            
            // },

            hasError: function() {
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },

            reset:function(){
                window.location.href = "{{ url('refund-requests-details')}}";
            },
        }
    });
</script>
@endsection
</body>
  </html>