@extends('online.dashboard')
@section('content')
  <div class="box-header with-border">
    <h3 class="box-title">New User</h3>
  </div>
  <div class="box-body">
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Application Regional Centre Examination</h3>
    </div>
    <div class="box-body">
        {!! Form::open(['url' => 'regional-centres', 'class' => 'form-horizontal']) !!}
             @include('regional_centre.form', ['submitButtonText' => 'Save'])
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
            stu_id:'',
            name:'',
            father_name:'',
            pupin_no:'',
            roll_no:'',
            app_no:'',
            course_id:'',
            semester:0,
            mobile_no:'',
            add:'',
            email:'',
            centre1:'',
            centre2:''
            // regional_centre:'',
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success: false,
            form: getNewForm(),
            errors: {},
            regional:  {!! isset($regional) ? $regional : 0 !!},
            base_url: "{{ url('/')}}",
            disable_uni_rollno: true
        },
        ready: function() {
            var self = this;
            console.log(self.regional);
            $('.select2').select2({
                placeholder: 'Select centre'
            });
            $('.select2').on('change',function(e){
                self.form.centre1 = $(this).val();
            }); 
            
            $('.selectcentre2').select2({
                placeholder: 'Select centre'
            });
            $('.selectcentre2').on('change',function(e){
                self.form.centre2 = $(this).val();
            }); 
            if(self.regional.id > 0){
                self.editRegional();
            }
        },
        methods: { 
            getStudentData:function(){
                var self = this;
                this.disable_uni_rollno = true;
                self.$http.get("{{ url('regional-centres') }}/"+self.form.roll_no)
                .then(function(response){
                   var student = response.data.student;
                   self.errors = {};
                   self.form.stu_id = student.id;
                   self.form.name = student.name;
                   self.form.father_name = student.father_name;
                   self.form.pupin_no = student.pupin_no;
                   self.form.course_id = student.course_id;
                   if(! student.pupin_no || student.pupin_no.trim().length == 0) {
                       this.disable_uni_rollno = false;
                   }
                })
                .catch(function(response){
                    this.errors = response.data;
                });
            },
             
            submit:function(){
                var self = this;
                self.$http.post("{{ url('regional-centres') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        self.errors = {};
                        self.success = true;
                        setTimeout(function() {
                            self.success = false;
                        }, 3000);
                        // self.getNewForm();
                        if(self.form.id > 0){
                            window.location.href = "{{ url('/regional-centres')}}";
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

            editRegional: function(){
                var self = this;
                self.form.id = self.regional.id;
                self.form.stu_id = self.regional.stu_id;
                self.form.name = self.regional.name;
                self.form.father_name = self.regional.father_name;
                self.form.pupin_no = self.regional.pupin_no;
                self.form.roll_no = self.regional.roll_no;
                self.form.course_id = self.regional.course_id;
                self.form.mobile_no = self.regional.mobile_no;
                self.form.add = self.regional.add;
                self.form.email = self.regional.email;
                self.form.centre1 = self.regional.centre1;
                $('.select2').val(self.form.centre1).trigger('change');
                self.form.centre2 = self.regional.centre2;
                $('.selectcentre2').val(self.form.centre2).trigger('change');
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