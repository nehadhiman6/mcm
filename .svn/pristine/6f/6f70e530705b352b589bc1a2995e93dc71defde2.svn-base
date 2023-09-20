@extends('app')
@section('toolbar')
  @include('toolbars._bill_receipt_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h4>@{{ title }} Refund </h4> 

        <p><span>Request No : {{$refund_request->id}} ( {{ $refund_request->fund_type == "H" ? "Hostel": " College" }} ), Request Date: {{$refund_request->request_date}} </span></p>
        <p>Student name: {{$refund_request->student->name}} , Class: {{$refund_request->student->course->course_name}} ,  Amount:  {{$refund_request->amount}}</span></p>
    </div> 
    <div class="box-body">

        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

        @include('studentrefund.approval_refund.approval_form', ['submitButtonText' => 'Save'])

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
            approval_remarks:'',
            approval_date:'',
            approval:'',
            approved_by:'',
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success: false,
            form: getNewForm(),
            errors: {},
            id : '{{ $id }}',
            approval: '{{ $approval }}',
            title:'',
            refund_request: {!! isset($refund_request) ? $refund_request : 0 !!},
            base_url: "{{ url('/')}}",
        },
        ready: function() {
            var self = this;
            self.form.approval = self.approval;
            self.form.id = self.id;
            self.title = self.approval == "approved" ? "Approve": "Cancel";
        //     if(self.refund_request.id > 0){
        //         self.getapproveData();
        //     }
        },
        methods: {          
            // getapproveData:function(){
            //     var self = this;
            //         if(self.refund_request){
            //             self.form.id = self.refund_request.id;
            //             self.form.approval_remarks = self.refund_request.approval_remarks;
            //         }
                   
            // },
            reset:function(){
                window.location.href = "{{ url('refund-requests-details')}}";
            },
             
            submit:function(){
                var self = this;
                self.$http.post("{{ url('approval-refund') }}", this.form)
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

            hasError: function() {
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },
        }
    });
</script>
@endsection
</body>
  </html>