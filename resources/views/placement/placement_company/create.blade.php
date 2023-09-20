@extends('app')
@section('toolbar')
@include('toolbars._placement_toolbar')
@stop
@section('content')
    <div class="box-body">
        <div id="app1" class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Comapny Form</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['url' => 'pre-registration', 'class' => 'form-horizontal']) !!}
                    @include('placement.placement_company.form', ['submitButtonText' => 'Save'])
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
            add:'',
            city:'',
            state_id:'',
            comp_type:'',
            comp_nature:''
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success: false,
            form: getNewForm(),
            errors: {},
            company:  {!! isset($company) ? $company : 0 !!},
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
            
            if(self.company.id > 0){
                self.editCompany();
            }
        },
        methods: {   
            submit:function(){
                var self = this;
                self.$http.post("{{ url('placement-companies') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        self.errors = {};
                        self.success = true;
                        setTimeout(function() {
                            self.success = false;
                            window.location.href = "{{ url('/placement-companies')}}";
                        }, 500);
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            editCompany: function(){
                var self = this;
                self.form.id = self.company.id;
                self.form.name = self.company.name;
                self.form.add = self.company.add;
                self.form.city = self.company.city;
                self.form.state_id = self.company.state_id;
                self.form.comp_type = self.company.comp_type;
                self.form.comp_nature = self.company.comp_nature;
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