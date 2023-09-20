@extends('app')
@section('toolbar')
@include('toolbars._placement_toolbar')
@stop
@section('content')
    <div class="box-body">
        <div id="app1" class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Placement Form</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['url' => 'placements', 'class' => 'form-horizontal']) !!}
                    @include('placement.placement.form', ['submitButtonText' => 'Save'])
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
            drive_date:'',
            type:'',
            nature:'',
            comp_id:'',
            hr_personnel:'',
            contact_no:'',
            email:'',
            staff_id:'',
            job_profile:'',
            stu_reg:'',
            stu_appear:'0',
            // stu_shorted:'',
            // stu_selected:'',
            min_salary:'',
            max_salary:'',
            round_no:'',
            

        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success: false,
            form: getNewForm(),
            errors: {},
            staff: {!! getNewStaff(true) !!} ,
            placement:  {!! isset($placement) ? $placement : 0 !!},
            // staff: {!! json_encode(getStaff(false)) !!},
            base_url: "{{ url('/')}}",
            disable_uni_rollno: true,
            // departments:{!! getDepartments(true) !!},
            departments:[],
            deprt:''
        },
        ready: function() {
            var self = this;
            self.staffSelect();
            $('.comp_id').select2({
                placeholder: 'Select'
            });
            $('.comp_id').on('change',function(e){
                self.form.comp_id = $(this).val();
            });

            $('#dept').select2({
                placeholder: 'Select'
            });
            $('#dept').on('change',function(e){
                self.dept_ids=  $(this).val();
            });
            if(self.placement.id > 0){
                self.editPlacement();
            }
        },
        
        methods: {   
            
            submit:function(){
                var self = this;
                self.$http.post("{{ url('placements') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        self.errors = {};
                        self.success = true;
                        setTimeout(function() {
                            self.success = false;
                            window.location.href = "{{ url('/placements')}}";
                        }, 500);
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            editPlacement: function(){
                var self = this;
                self.form.id = self.placement.id;
                self.form.drive_date = self.placement.drive_date;
                self.form.type = self.placement.type;
                self.form.nature = self.placement.nature;
                self.form.comp_id = self.placement.comp_id;
                self.form.hr_personnel = self.placement.hr_personnel;
                self.form.contact_no = self.placement.contact_no;
                self.form.email = self.placement.email;
                self.form.staff_id = self.placement.staff_id;
                self.form.job_profile = self.placement.job_profile;
                self.form.stu_appear = self.placement.stu_appear;
                self.form.stu_reg = self.placement.stu_reg;
                self.form.min_salary = self.placement.min_salary;
                self.form.max_salary = self.placement.max_salary;
                self.form.round_no = self.placement.round_no;
                $('.comp_id').val(self.form.comp_id).trigger('change');
                setTimeout(function(){
                    self.staffSelect();
                    var tt = self.placement.staff_id;
                    self.form.staff_id =tt.split(',');
                    $('#staff_id').val(self.form.staff_id).trigger('change');
                },400)
                // $('.selectcentre2').val(self.form.centre2).trigger('change');
                // self.form.regional_centre = self.regional.regional_centre;
            
            },

            staffSelect:function(){
                var self = this;
                var select1 = $("#staff_id")
                .select2({
                    placeholder: "Multi Select",
                    width:"100%",
                })
                .on("change", function(e) {
                    var stt = $("#staff_id").val();
                    self.form.staff_id = stt.join();
                    stt.forEach(function(e) {
                        self.getDepartment(e);
                    });
                    
                });
                 
            },


            getDepartment:function(staff_id){
                var self = this;
                self.departments = [];
                self.$http.get("{{ url('get-depatment') }}/"+ staff_id)
                .then(function(response){
                    var dept = response.data.staff.dept.name;
                    self.departments.push(dept);
                    self.deprt = self.departments.join();
                   
                })
                .catch(function(error){
                    console.log('gate form:', error)
                });
            }
,
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