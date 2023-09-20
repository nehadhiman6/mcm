@extends('online.dashboard')
@section('content')
    <div class="box-body">
        <div id="app1" class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Pre Registration Form</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['url' => 'pre-registration', 'class' => 'form-horizontal']) !!}
                    @include('pre_registration.form', ['submitButtonText' => 'Save'])
                {!! Form::close() !!}

                <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Your Request Submitted successfully!</strong> @{{ response['success'] }}
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
<style>
    body .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 7px;
        right: 2px;
    }
</style>
<script>
    function getNewForm() {
        return {
            id:0,
            name:'',
            father_name:'',
            course_id:'',
            mobile_no:'',
            add:'',
            email:'',
            city:'',
            state_id:'',
            hostel:'N'
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success: false,
            form: getNewForm(),
            errors: {},
            pre_regi:  {!! isset($pre_regi) ? $pre_regi : 0 !!},
            base_url: "{{ url('/')}}",
            disable_uni_rollno: true
        },
        ready: function() {
            var self = this;
            
            $('.select2').select2({
                placeholder: 'Select'
            });
            $('.select2').on('change',function(e){
                self.form.state_id = $(this).val();
            }); 
            
            if(self.pre_regi.id > 0){
                self.editRegistration();
            }
        },
        methods: {   
            submit:function(){
                var self = this;
                self.$http.post("{{ url('pre-registration') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        self.errors = {};
                        self.success = true;
                        setTimeout(function() {
                            self.success = false;
                        }, 3000);
                        if(self.form.id > 0){
                            window.location.href = "{{ url('/pre-registration')}}";
                        }
                        else{
                            window.location.href = "{{ url('/stulogin')}}";
                        }
                        
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            editRegistration: function(){
                var self = this;
                self.form.id = self.pre_regi.id;
                self.form.name = self.pre_regi.name;
                self.form.father_name = self.pre_regi.father_name;
                self.form.course_id = self.pre_regi.course_id;
                self.form.mobile_no = self.pre_regi.mobile_no;
                self.form.add = self.pre_regi.add;
                self.form.email = self.pre_regi.email;
                self.form.city = self.pre_regi.city;
                self.form.hostel = self.pre_regi.hostel;
                self.form.state_id = self.pre_regi.state_id;
                $('.select2').val(self.form.state_id).trigger('change');
               
                // $('.selectcentre2').val(self.form.centre2).trigger('change');
                // self.form.regional_centre = self.regional.regional_centre;
            
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