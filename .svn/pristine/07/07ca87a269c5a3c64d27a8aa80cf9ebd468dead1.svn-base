@extends('online.dashboard')
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ isset($refund_request) ? 'Update' : 'New' }}  Refund Request (Only student can apply)</h3>
    </div>
    <div class="box-body">

        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

        @include('online.student_refund_request.form', ['submitButtonText' => 'Save'])

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
            name:'',
            father_name:'',
            course:'',
            roll_no:'',
            request_date:'',
            fund_type:'',
            bank_name:'',
            ifsc_code:'',
            bank_ac_no:'',
            account_holder_name:'',
            amount:'',
            reason_of_refund:'',
            fee_deposite_date:''
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success: false,
            form: getNewForm(),
            errors: {},
            refund_request:  {!! isset($refund_request) ? $refund_request : 0 !!},
            base_url: "{{ url('/')}}",
        },
        ready: function() {
            var self = this;
            self.getStudentData();
            if(self.refund_request.id > 0){
                self.editRefund();
            }
        },
        methods: { 
            getStudentData:function(){
                var self = this;
                self.$http.get("{{ url('get-std-details') }}")
                .then(function(response){
                   var student = response.data.student;
                   self.errors = {};
                   self.form.std_id = student.id;
                   self.form.name = student.name;
                   self.form.father_name = student.father_name;
                   self.form.roll_no = student.roll_no;
                   self.form.course = student.course.course_name;
                   
                })
                .catch(function(response){
                    this.errors = response.data;
                });
            },
             
            submit:function(){
                var self = this;
                self.$http.post("{{ url('student-refund-requests') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        self.errors = {};
                        self.success = true;
                        setTimeout(function() {
                            self.success = false;
                        }, 3000);
                        window.location.href = "{{ url('student-refund-requests')}}";
                        
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            editRefund: function(){
                var self = this;
                self.form.id = self.refund_request.id;
                self.form.std_id = self.refund_request.std_id;
                self.form.request_date = self.refund_request.request_date;
                self.form.fee_deposite_date = self.refund_request.fee_deposite_date;
                self.form.fund_type = self.refund_request.fund_type;
                self.form.bank_name = self.refund_request.bank_name;
                self.form.ifsc_code = self.refund_request.ifsc_code;
                self.form.bank_ac_no = self.refund_request.bank_ac_no;
                self.form.account_holder_name = self.refund_request.account_holder_name;
                self.form.amount = self.refund_request.amount;
                self.form.reason_of_refund = self.refund_request.reason_of_refund;
            
            },

            hasError: function() {
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },

            reset:function(){
                window.location.href = "{{ url('student-refund-requests')}}";
            },
        }
    });
</script>
@endsection
</body>
  </html>