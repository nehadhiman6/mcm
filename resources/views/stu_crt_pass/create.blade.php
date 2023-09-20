@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> Student Details </h3>
    </div>
    <div class="box-body">
            {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
            <div class="table-overflow">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th  style="font-size: 14px">SrNo</th>
                            <th class="td-width-and-size">Date</th>
                            <th class="td-width-and-size">College Roll No</th>
                            <th class="td-width-and-size">Student Name</th>
                            <th class="td-width-and-size">Contact No</th>
                            <th class="td-width-and-size">Email</th>
                            <th class="td-width-and-size">Address</th>
                            <th class="td-width-and-size">Class</th>
                            <th class="td-width-and-size">Session</th>
                            <th class="td-width-and-size">Particular</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="det in form.students">
                            <td>
                                @{{$index+1}}
                            </td>
                            <td>
                                {!! Form::text('req_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'det.req_date']) !!}
                                <span v-if="hasError('students.'+$index+'.req_date')" class="text-danger" v-html="errors['students.'+$index+'.req_date'][0]"></span>
                            </td>
                            <td>
                                {!! Form::text('roll_no',null, ['class' => 'form-control','v-model'=>'det.roll_no']) !!}
                                <span v-if="hasError('students.'+$index+'.roll_no')" class="text-danger" v-html="errors['students.'+$index+'.roll_no'][0]"></span>
                            
                            </td>

                            <td>
                                {!! Form::text('stu_name',null, ['class' => 'form-control','v-model'=>'det.stu_name']) !!}
                                <span v-if="hasError('students.'+$index+'.stu_name')" class="text-danger" v-html="errors['students.'+$index+'.stu_name'][0]"></span>

                            </td>
                            <td>
                                {!! Form::text('contact_no',null, ['class' => 'form-control','v-model'=>'det.contact_no']) !!}
                                <span v-if="hasError('students.'+$index+'.contact_no')" class="text-danger" v-html="errors['students.'+$index+'.contact_no'][0]"></span>

                            </td>
                            <td>
                                {!! Form::text('email',null, ['class' => 'form-control','v-model'=>'det.email']) !!}
                                <span v-if="hasError('students.'+$index+'.email')" class="text-danger" v-html="errors['students.'+$index+'.email'][0]"></span>

                            </td>

                            <td>
                                {!! Form::text('add',null, ['class' => 'form-control','v-model'=>'det.add']) !!}
                                <span v-if="hasError('students.'+$index+'.add')" class="text-danger" v-html="errors['students.'+$index+'.add'][0]"></span>

                            </td>

                            <td>
                                {!! Form::text('class',null, ['class' => 'form-control','v-model'=>'det.class']) !!}
                                <span v-if="hasError('students.'+$index+'.class')" class="text-danger" v-html="errors['students.'+$index+'.class'][0]"></span>

                            </td>

                           
                            <td>
                                {!! Form::text('session',null, ['class' => 'form-control','v-model'=>'det.session']) !!}
                                <span v-if="hasError('students.'+$index+'.session')" class="text-danger" v-html="errors['students.'+$index+'.session'][0]"></span>
                            
                            </td>

                            <td >
                                <select class="form-control select-form" v-model="det.type">
                                    <option value="" Selected>Select</option>
                                    <option value="Character">Character</option>
                                    <option value="Bonafide">Bonafide</option>
                                    <option value="Bus Pass">Bus Pass</option>
                                    <option value="Alumni Renewal Fund">Alumni Renewal Fund</option>
                                </select>
                            </td>

                            <td v-if='!student'>
                                {!! Form::button('Remove',['class' => 'btn btn-success', '@click.prevent' => 'removeElement($index)']) !!}
                                
                            </td>
                            {{-- <td>
                            </td> --}}
                        </tr>
                    </tbody>
                </table>
                <div class="form-group" v-if='!student'>
                    
                    {!! Form::button('Add Row',['class' => 'btn btn-success pull-left', '@click.prevent' => 'addRow']) !!}
                </div>
            </div>
            <div class="box-footer">
                <span v-if='student.id > 0'>
                    <button class="btn btn-primary"  @click.prevent="submit()">Update</button>
                    <button class="btn btn-primary"  @click.prevent="cancel()">Cancel</button>
                </span>
                <span v-else>
                    <button class="btn btn-primary"  @click.prevent="submit()">Add </button>
                    <button class="btn btn-primary"  @click.prevent="cancel()">Cancel</button>
                </span>
                
                
            </div>
            {!! Form::close() !!}
        
    </div>
</div>
@stop
<style>
    .table-overflow{
        overflow-x: auto
    }
    .td-width-and-size{
        font-size: 14px;
        min-width:150px;
    }
    .td-width-size{
        font-size: 14px;
        min-width:300px;
    }
</style>
@section('script')

<script>
    function getNewForm() {
        return {
            students:[{
                id:'',
                req_date:'',
                stu_name:'',
                class:'',
                roll_no:'',
                session:'',
                type:'',
                contact_no:'',
                email:'',
                add:'',
            }]

        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success:false,
            form: getNewForm(),
            errors: {},
            base_url: "{{ url('/')}}",
            student: {!! isset($student) ? $student : 0 !!}
        },
        ready: function() {
            var self = this;
            if(self.student){
                self.editStudent();
            }

            
        },
        methods: { 
            submit:function(){
                var self = this;
                self.$http.post("{{ url('stu-crt-passes') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        if(response.data.success){
                            self.errors = {};
                            $.blockUI({'message':'<h4>Successfully updated</h4>'});
                            setTimeout(function() {
                                $.unblockUI();
                                self.cancel();
                            },1000);
                        }
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            cancel:function(){
                var self = this;
                window.location.href = "{{ url('stu-crt-passes')}}";
                       
            },

            hasError: function() {
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },

            editStudent: function(){
                var self = this;
                self.form.students.forEach(function(e){
                    e.id = self.student.id;
                    e.req_date = self.student.req_date;
                    e.stu_name = self.student.stu_name;
                    e.class = self.student.class;
                    e.roll_no = self.student.roll_no;
                    e.session = self.student.session;
                    e.type = self.student.type;
                    e.contact_no =self.student.contact_no;
                    e.email =self.student.email;
                    e.add =self.student.add;
                });
            
            },

            removeElement:function(key) {
                if(this.form.students.length > 1){
                    this.form.students.splice(key, 1);
                }
            },

            addRow:function(){
                var self = this;
                self.form.students.push({
                    id:'',
                    req_date:'',
                    stu_name:'',
                    class:'',
                    roll_no:'',
                    session:'',
                    type:'',
                    contact_no:'',
                    email:'',
                    add:''
                });
            },

            

           
        }
    });
</script>
@endsection