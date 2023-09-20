@extends('app')
@section('toolbar')
@include('toolbars._activities_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ isset($activity) ? 'Update' : 'New' }}  Activity</h3>
    </div>
    <div class="box-body">

        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

        @include('activities.activities.form', ['submitButtonText' => 'Add Activity'])

        {!! Form::close() !!}
        
    </div>
</div>
@stop

@section('script')

<script>
    function getNewForm() {
        return {
            id:0,
            start_date:'',
            end_date:'',
            org_agency_id:'',
            act_type_id:'',
            sponsor_by_id:'',
            sponsor_address:'',
            topic:'',
            colloboration_with_id: 0,
            college_teachers:0,
            college_students:0,
            college_nonteaching:0,
            outsider_teachers:0,
            outsider_students:0,
            outsider_nonteaching:0,
            agency_id:'',
            other_remarks:'',
            remarks:'',
            details:'',
            convener:'',
            internal:'',
            agency_name:'',
            sponsor_amt:'',
            aegis:'',
            act_grp_id:'',
            guest:[{
                id:0,
                guest_name:'',
                guest_designation:'',
                guest_affiliation:'',
                address:''
            }]

        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            form: getNewForm(),
            errors: {},
            base_url: "{{ url('/')}}",
            activity: {!! isset($activity) ? $activity : 0 !!},
            org_by:'',
            orgnisations:[],
            collo_by:'',
            // colloboration_with_id:'',
            colloboration:[]
            
        },
        ready: function() {
            var self = this;
            if(self.activity.id > 0){
                self.editActivity();
            }
        },
        methods: { 
            setCollo:function(){
                var self = this;
                if(self.form.id == 0){
                    self.colloboration_with_id = 0;
                    if(self.form.internal == "External"){
                        self.collo_by = '';
                        self.form.agency_id= '';
                    }
                    else if(self.form.internal == "Internal"){
                        self.form.agency_name= '';
                    }
                    else if(self.form.internal == "Not Any"){
                        self.collo_by = '';
                        self.form.agency_id= '';
                        self.form.agency_name= '';
                    }
                } 
            },
            getOrgnization:function(){
                var self = this;
                self.$http.get("{{ url('activities') }}/"+self.org_by + '/orgnization')
                .then(function(response){
                    // console.log(response)
                    self.orgnisations = response.data.orgnization;
                })
                .catch(function(response){
                    this.errors = response.data;
                });
            },

            getColloboration:function(){
                var self = this;
                if(self.form.internal == 'Internal'){
                    self.$http.get("{{ url('activities') }}/"+self.form.colloboration_with_id + '/orgnization')
                    .then(function(response){
                        // console.log(response)
                        self.colloboration = response.data.orgnization;
                    })
                    .catch(function(response){
                        this.errors = response.data;
                    });
                }
                
            },
             
            submit:function(){
                var self = this;
                self.$http.post("{{ url('activities') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        if(response.data.success){
                            self.errors = {};
                            window.location.href = "{{ url('activities')}}";
                        }
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            editActivity: function(){
                var self = this;
                var row = [];
                console.log(self.activity);
                self.form.id = self.activity.id;
                self.form.start_date = self.activity.start_date;
                self.form.end_date = self.activity.end_date;
                self.form.act_type_id = self.activity.act_type_id;
                self.form.topic = self.activity.topic;
                self.form.sponsor_amt = self.activity.sponsor_amt;
                self.form.aegis = self.activity.aegis;
                self.form.act_grp_id = self.activity.act_grp_id;
                self.form.sponsor_by_id = self.activity.sponsor_by_id;
                self.form.sponsor_address = self.activity.sponsor_address;
                self.form.college_teachers = self.activity.college_teachers;
                self.form.college_students = self.activity.college_students;
                self.form.college_nonteaching = self.activity.college_nonteaching;
                self.form.outsider_teachers = self.activity.outsider_teachers;
                self.form.outsider_students = self.activity.outsider_students;
                self.form.outsider_nonteaching = self.activity.outsider_nonteaching;
                self.form.remarks = self.activity.remarks;
                self.form.details = self.activity.details;
                self.form.other_remarks = self.activity.other_remarks;
                self.form.convener=self.activity.convener;
                self.form.org_agency_id = self.activity.org_agency_id;
                self.org_by = self.activity.orgnization.agency_type_id;
                self.form.colloboration_with_id = self.activity.colloboration ? self.activity.colloboration.colloboration_with_id :'';
                console.log(self.activity.colloboration);
                if(self.activity.colloboration != null){
                    if(self.activity.colloboration.agency_id != null){
                        self.form.internal = "Internal";
                        self.form.agency_id = self.activity.colloboration.agency_id;
                        self.collo_by = self.activity.colloboration.orgnization.agency_type_id;
                    }
                    else if(self.activity.colloboration.agency_name != null){
                        self.form.internal = "External";
                        self.form.agency_name = self.activity.colloboration.agency_name;
                        // self.colloboration_with_id = self.activity.colloboration.agency_name;
                    }
                    else{
                        self.form.internal = "Not Any"
                    }

                }
                else{
                    console.log('not')
                    self.form.internal = "Not Any"
                }
                // console.log(collo_by);
                self.getOrgnization();
                self.getColloboration();
                self.form.guest = [];
                // console.log(self.activity);
                self.activity.guest.forEach(function(ele){
                    row = {
                         id: ele.id,
                        guest_name: ele.guest_name,
                        guest_designation: ele.guest_designation,
                        guest_affiliation: ele.guest_affiliation,
                        address: ele.address
                    }
                    self.form.guest.push(row);
                })
                // employee.dependent.forEach(function(ele,index){
                //     console.log(ele);
                //     row = {
                //         id: ele.id,
                       
                //     }
                //     self.form.dependent.push(row);
                // });


                // setTimeout(function(){
                //     self.org_by = self.activity.orgnization;
                //     self.colloboration = self.activity.colloboration.orgnization;
                // }, 500);
            
                // console.log(self.activity.orgnization);
                
            },

            hasError: function() {
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },

            removeElement:function(key) {
                if(this.form.guest.length > 1){
                    this.form.guest.splice(key, 1);
                }
            },

            addRow:function(){
                var self = this;
                self.form.guest.push({
                    id:0,
                    guest_name:'',
                    guest_designation:'',
                    guest_affiliation:'',
                    address:''
                });
            },
            
        }
    });
</script>
@endsection