@extends('app')
@section('toolbar')
@include('toolbars._activities_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ isset($orgnization) ? 'Update' : 'New' }}  Organization</h3>
    </div>
    <div class="box-body">
        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
        @include('activities.orgnization.form', ['submitButtonText' => 'Add Organization'])
        {!! Form::close() !!}
    </div>
</div>
@stop

@section('script')

<script>
    function getNewForm() {
        return {
            id:0,
            name:'',
            external_agency:'N',
            agency_type_id:'',
            dept_id:0,

        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            form: getNewForm(),
            errors: {},
            org:  {!! isset($orgnization) ? $orgnization : 0 !!},
            base_url: "{{ url('/')}}",
        },
        ready: function() {
            var self = this;
            if(self.org.id > 0){
                self.editOrgnization();
            }
        },
        methods: { 
             
            submit:function(){
                var self = this;
                self.$http.post("{{ url('orgnization') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        if(response.data.success){
                            self.errors = {};
                            window.location.href = "{{ url('orgnization')}}";
                        }else{
                            // self.resetForm();
                        }
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            editOrgnization: function(id){
                var self = this;
                self.errors = {};
                self.form.id = self.org.id;
                self.form.name = self.org.name;
                self.form.external_agency = self.org.external_agency;
                self.form.agency_type_id = self.org.agency_type_id;
                self.form.dept_id = self.org.dept_id;
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