@extends('app')
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Student Fee Control</h3>
    </div>
    <div class="box-body">

        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
        @include('appsetting.form', ['submitButtonText' => 'Add'])
        <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> @{{ response['success'] }}
          </div>
          <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
            <li v-for='error in errors'>@{{ error[0] }}<li>
          </ul>
        {!! Form::close() !!}
        
    </div>
</div>
@stop

@section('script')

<script>
    function getNewForm() {
        return {
            std_key:{
                college:{
                    id:0,
                    key_name:'pay_college_dues',
                    key_value:'',
                    description:'',
                },
                hostel:{
                    id:0,
                    key_name:'pay_hostel_dues',
                    key_value:'',
                    description:'',
                },

                addmission:{
                    id:0,
                    key_name:'pay_add_fees',
                    key_value:'',
                    description:'',
                },

                college_process:{
                    id:0,
                    key_name:'college_processing_fees',
                    key_value:'',
                    description:'',
                },

                hostel_process:{
                    id:0,
                    key_name:'hostel_processing_fees',
                    key_value:'',
                    description:'',
                },

                stu_satisfaction:{
                    id:0,
                    key_name:'stu_satisfaction_survey',
                    key_value:'',
                    description:'',
                },
            }
            
        
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            form: getNewForm(),
            errors: {},
            base_url: "{{ url('/')}}",
            app_setting: {!! isset($app_setting) ? $app_setting : 0 !!},
            success: false,
            fails: false,
            errors: {},
        },
        ready: function() {
            var self = this;
            if(self.app_setting){
                self.editSetting();
            }
        },
        methods: { 
            submit:function(){
                var self = this;
                self.$http.post("{{ url('app-setting') }}", this.form)
                .then(function(response) {
                    this.response = response.data;
                    self = this;
                    if (response.data.success) {
                        self = this;
                        this.success = true;
                        setTimeout(function() {
                            self.success = false;
                            window.location = "{{ url('app-setting/create') }}";
                        }, 1000);
                    }
                     
                   
                    }, function (response) {
                    this.fails = true;
                    self = this;
                    this.saving = false;
                    //  this.response.errors = response.data;
                    if(response.status == 422) {
                        this.errors = response.data;
                    }
        //              console.log(response.data);              
                    });
            },

            editSetting: function(){
                var self = this;
                self.app_setting.forEach(function(ele){
                    if(ele.key_name == 'pay_college_dues'){
                        self.form.std_key.college.id = ele.id;
                        self.form.std_key.college.key_name = ele.key_name;
                        self.form.std_key.college.key_value = ele.key_value;
                        self.form.std_key.college.description = ele.description;
                    }

                    if(ele.key_name == 'pay_hostel_dues'){
                        self.form.std_key.hostel.id = ele.id;
                        self.form.std_key.hostel.key_name = ele.key_name;
                        self.form.std_key.hostel.key_value = ele.key_value;
                        self.form.std_key.hostel.description = ele.description;
                    }

                    if(ele.key_name == 'pay_add_fees'){
                        self.form.std_key.addmission.id = ele.id;
                        self.form.std_key.addmission.key_name = ele.key_name;
                        self.form.std_key.addmission.key_value = ele.key_value;
                        self.form.std_key.addmission.description = ele.description;
                    }

                    if(ele.key_name == 'college_processing_fees'){
                        self.form.std_key.college_process.id = ele.id;
                        self.form.std_key.college_process.key_name = ele.key_name;
                        self.form.std_key.college_process.key_value = ele.key_value;
                        self.form.std_key.college_process.description = ele.description;
                    }

                    if(ele.key_name == 'hostel_processing_fees'){
                        self.form.std_key.hostel_process.id = ele.id;
                        self.form.std_key.hostel_process.key_name = ele.key_name;
                        self.form.std_key.hostel_process.key_value = ele.key_value;
                        self.form.std_key.hostel_process.description = ele.description;
                    }

                    if(ele.key_name == 'stu_satisfaction_survey'){
                        self.form.std_key.stu_satisfaction.id = ele.id;
                        self.form.std_key.stu_satisfaction.key_name = ele.key_name;
                        self.form.std_key.stu_satisfaction.key_value = ele.key_value;
                        self.form.std_key.stu_satisfaction.description = ele.description;
                    }
                })
                
              
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