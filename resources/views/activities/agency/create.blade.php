@extends('app')
@section('toolbar')
@include('toolbars._activities_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ isset($agency_type) ? 'Update' : 'New' }} Organization/Sponsor/Activity</h3>
    </div>
    <div class="box-body">

        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

        @include('activities.agency.form', ['submitButtonText' => 'Save'])

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
            master_type:'',
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            form: getNewForm(),
            agency_type: {!! isset($agency_type) ? $agency_type : 0 !!},
            errors: {},
            base_url: "{{ url('agency-types')}}",
        },
        ready: function() {
            var self = this;
            if(self.agency_type.id > 0){
                self.editAgency();
            }
        },
        methods: {  
            submit:function(){
                this.$http.post("{{ url('agency-types') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        if(response.data.success){
                            this.errors = {};
                            window.location.href = "{{ url('agency-types')}}";
                        }else{
                            // self.resetForm();
                        }
                    }
                }, 
                function(response) {
                    this.errors = response.body;
                });
            },

            editAgency: function(id){
                this.errors = {};
                this.form.id = this.agency_type.id;
                this.form.name = this.agency_type.name;
                this.form.master_type = this.agency_type.master_type;
            },

            hasErrors: function() {
                console.log(this.errors && _.keys(this.errors).length > 0);
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },

        }
    });
</script>
@endsection
