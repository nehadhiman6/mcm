@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
@stop
@section('content')
    <div class="box-body">
        <div id="app1" class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Issue Date </h3>

                <h3 class="box-title"><strong> Name ( @{{student.stu_name }}  )    </strong>  <strong> Class  ( @{{student.class }} )  </strong>   <strong> College Roll No  ( @{{student.roll_no }}  )</strong></h3>
            </div>
            <div class="box-body">
                {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {!! Form::label('issue_date','Issue Date:',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::text('issue_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.issue_date']) !!}
                        <span v-if="hasError('issue_date')" class="text-danger" v-html="errors['issue_date'][0]"></span>
                    </div>

                    {!! Form::label('remarks','Issue Remarks:',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::text('remarks',null, ['class' => 'form-control','v-model'=>'form.remarks']) !!}
                        <span v-if="hasError('remarks')" class="text-danger" v-html="errors['remarks'][0]"></span>
                    </div>
                </div>
                <div class="box-footer">
                   <span v-if="form.issue_date == ''">
                        <button class="btn btn-primary" @click.prevent="submit()">Save</button>

                   </span>
                   <span v-else>
                        <button class="btn btn-primary"  @click.prevent="submit()">Update</button>

                   </span>
                    
                    <button class="btn btn-primary"  @click.prevent="cancel()">Cancel</button>
                </div>
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
            issue_date:'',
            remarks:'',
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            success: false,
            form: getNewForm(),
            errors: {},
            student:  {!! isset($student) ? $student : 0 !!},
            base_url: "{{ url('/')}}",
        },
        ready: function() {
            var self = this;
            self.editStudent();
        },
        methods: {   
            submit:function(){
                var self = this;
                self.$http.post("{{ url('issue-date') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        self.errors = {};
                        self.success = true;
                        setTimeout(function() {
                            self.success = false;
                            window.location.href = "{{ url('/stu-crt-passes')}}";
                        }, 500);
                    }
                }, 
                function(response) {
                    self.errors = response.body;
                });
            },

            editStudent: function(){
                var self = this;
                self.form.id = self.student.id;
                self.form.issue_date = self.student.issue_date;
                self.form.remarks = self.student.remarks;
            
            },

            hasError: function() {
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },

            cancel:function(){
                var self = this;
                window.location.href = "{{ url('stu-crt-passes')}}";
                       
            },
        }
    });
</script>
@endsection
</body>
  </html>