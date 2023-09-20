@extends('app')
@section('toolbar')
@include('toolbars._academics_toolbar')
@stop
@section('content')
    <div id="app" v-cloak>
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Student's TimeTable</h3>
            </div>
            <div class="box-body create_user">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row form-group">
                            <label class=" col-sm-2 control-label required"> Roll No.</label>
                            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['roll_no'] }">
                                <input type ="text" class="form-control" v-model="roll_no">
                                <span id="basic-msg" v-if="errors['roll_no']" class="help-block">@{{ errors['roll_no'][0] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="submit" value="Show" class="btn btn-primary" @click="showStudentTimeTable">
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Edit Student's TimeTable</h3>
            </div>
            <div class="box-body">
                <div class="row form-group">
                    <label class=" col-md-1 control-label">Subjects</label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.subjects'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.subjects">
                        <span id="basic-msg" v-if="errors['student_timetable.subjects']" class="help-block">@{{ errors['student_timetable.subjects'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Honours</label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.honours'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.honours">
                        <span id="basic-msg" v-if="errors['student_timetable.honours']" class="help-block">@{{ errors['student_timetable.honours'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Add-on </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.add_on'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.add_on">
                        <span id="basic-msg" v-if="errors['student_timetable.add_on']" class="help-block">@{{ errors['student_timetable.add_on'][0] }}</span>
                    </div>
                </div> 
                <div class="row form-group">
                    <label class=" col-md-1 control-label">Location</label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.location'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.location">
                        <span id="basic-msg" v-if="errors['student_timetable.location']" class="help-block">@{{ errors['student_timetable.location'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Period 0  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_0'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_0">
                        <span id="basic-msg" v-if="errors['student_timetable.period_0']" class="help-block">@{{ errors['student_timetable.period_0'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Period 1 </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_1'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_1">
                        <span id="basic-msg" v-if="errors['student_timetable.period_1']" class="help-block">@{{ errors['student_timetable.period_1'][0] }}</span>
                    </div>
                </div>
                <div class="row form-group">
                    <label class=" col-md-1 control-label">Period 2  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_2'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_2">
                        <span id="basic-msg" v-if="errors['student_timetable.period_2']" class="help-block">@{{ errors['student_timetable.period_2'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Period 3 </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_3'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_3">
                        <span id="basic-msg" v-if="errors['student_timetable.period_3']" class="help-block">@{{ errors['student_timetable.period_3'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Period 4  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_4'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_4">
                        <span id="basic-msg" v-if="errors['student_timetable.period_4']" class="help-block">@{{ errors['student_timetable.period_4'][0] }}</span>
                    </div>
                </div>
                
                <div class="row form-group">
                    <label class=" col-md-1 control-label">Period 5  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_5'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_5">
                        <span id="basic-msg" v-if="errors['student_timetable.period_5']" class="help-block">@{{ errors['student_timetable.period_5'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Period 6  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_6'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_6">
                        <span id="basic-msg" v-if="errors['student_timetable.period_6']" class="help-block">@{{ errors['student_timetable.period_6'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Period 7  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_7'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_7">
                        <span id="basic-msg" v-if="errors['student_timetable.period_7']" class="help-block">@{{ errors['student_timetable.period_7'][0] }}</span>
                    </div>
                </div>

                <div class="row form-group">
                    <label class=" col-md-1 control-label">Period 8  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_8'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_8">
                        <span id="basic-msg" v-if="errors['student_timetable.period_8']" class="help-block">@{{ errors['student_timetable.period_8'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Period 9  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_9'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_9">
                        <span id="basic-msg" v-if="errors['student_timetable.period_9']" class="help-block">@{{ errors['student_timetable.period_9'][0] }}</span>
                    </div>
                    <label class=" col-md-1 control-label">Period 10  </label>
                    <div class="col-md-3"  v-bind:class="{ 'has-error': errors['student_timetable.period_10'] }"> 
                        <input type="text" class="form-control" v-model="student_timetable.period_10">
                        <span id="basic-msg" v-if="errors['student_timetable.period_10']" class="help-block">@{{ errors['student_timetable.period_10'][0] }}</span>
                    </div>
                </div>
            </div>
            <div class="box-footer text-right">
                <input type="submit" :disabled = "student_timetable.roll_no == ''" value="UPDATE" class="btn btn-primary" @click="saveTimeTable">
            </div>
        </div>
    </div>
@stop
@section('script')
<script>
    function getDetails(){
        return{
            std_id:'',
            roll_no:'',
            subjects:'',
            honours:'',
            add_on:'',
            period_0:'',
            period_1:'',
            period_2:'',
            period_3:'',
            period_4:'',
            period_5:'',
            period_6:'',
            period_7:'',
            period_8:'',
            period_9:'',
            period_10:'',
            location:'',
        }
    }
    var vm = new Vue({
        el:'#app',
        data:function(){
            return {
                roll_no:'',
                base_url:"{{ url('/')}}",
                student_timetable:getDetails(),
                errors:{}
            }
        },
        methods:{
            showStudentTimeTable:function(){
                var self = this;
                self.student_timetable = getDetails();
                self.errors ={};
                self.$http.post(this.base_url+'/students-timetable/timetable',this.$data)
                .then(function(response){
                    if(response.data.success == true){
                        if(response.data.student_timetable){
                            self.student_timetable = response.data.student_timetable;
                        }
                    }
                })
                .catch(function(error){
                    if(error.status == 422) {
                        self.errors = error.data;
                    }
                });
            },
            saveTimeTable:function(){
                var self = this;
                self.errors ={};
                self.$http.post(this.base_url+'/students-timetable/update-timetable',this.$data)
                .then(function(response){
                    if(response.data.success == true){
                        $.blockUI({'message':'Successfully Saved'});
                        setTimeout(function(){
                            $.unblockUI();
                            self.student_timetable = getDetails();
                            self.roll_no = '';
                        },2000);
                    }
                })
                .catch(function(error){
                    if(error.status == 422) {
                        self.errors = error.data;
                    }
                });
            }
        }
    });
</script>
@stop