@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
@stop
@section('content')
    <div class="box-body">
        <div id="app1" class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Reject Student</h3>

                <h3 class="box-title"><strong> Name ( @{{student.stu_name }}  )    </strong>  <strong> Class  ( @{{student.class }} )  </strong>   <strong> College Roll No  ( @{{student.roll_no }}  )</strong></h3>
            </div>
            <div class="box-body">
                {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
                <div class="form-group">
                    {!! Form::label('remarks','Reject Remarks:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-6">
                        {!! Form::text('remarks',null, ['class' => 'form-control','v-model'=>'form.remarks']) !!}
                        <span v-if="hasError('remarks')" class="text-danger" v-html="errors['remarks'][0]"></span>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" @click.prevent="submit()">Save</button>
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
                self.$http.post("{{ url('stu-crt-pass-reject') }}", this.form)
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