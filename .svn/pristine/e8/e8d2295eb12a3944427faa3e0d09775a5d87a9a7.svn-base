@extends('app')
@section('toolbar')
@include('toolbars._placement_toolbar')
@stop
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> Student Details  </h3>
        <h3 class="box-title"> <strong>@{{placement.drive_date}} </strong>  <strong>@{{placement.company.name}} </strong></h3>
    </div>
    <div class="box-body">
            {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
            <div class="table-overflow">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="" style="">SrNo</th>
                            <th class="td-width-and-size">Session</th>
                            <th class="td-width-and-size">Roll No</th>
                            <th class="td-width-and-size" v-if="btn_name == 'AP'">Action</th>
                            <th class="td-width-and-size">Name</th>
                            <th class="td-width-and-size">Father Name</th>
                            <th class="td-width-and-size">Mother Name</th>
                            <th class="td-width-and-size">Class</th>
                            <th class="td-width-and-size">Ph. No.</th>
                            <th class="td-width-and-size">Email ID</th>
                            <th class="td-width-and-size">Category</th>
                            <th class="td-width-and-size">Job Profile</th>
                            <th class="td-width-and-size" v-if="btn_name == 'Selected' || btn_name == 'SL'">Status</th>
                            <th class="td-width-and-size" v-if="btn_name == 'Selected'">Letter Type</th>
                            <th class="td-width-and-size">Remarks</th>
                            <th class="td-width-and-size" v-if="btn_name == 'Selected'">Pay Package</th>
                            <th class="td-width-size" v-if="btn_name == 'Selected'">Upload proof (pdf)</th>
                            <th v-if="btn_name == 'selected'"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="dets in form.students ">
                                <td v-if="dets.row_show != 'N' ">
                                    @{{$index+1}}
                                </td>
                                <td v-if="dets.row_show != 'N' ">
                                    {!! Form::select('session',['20182019'=>'2018-2019','20192020'=>'2019-2020','20202021'=>'2020-2021','20212022'=>'2021-2022','20222023'=>'2022-2023'],null,['class' => 'form-control','v-model'=>'dets.session',':disabled'=>"btn_name == 'SL' || btn_name=='Selected' || dets.show_field == 'dis' ?  true : false"]) !!}
                                    <span v-if="hasError('students.'+$index+'.session')" class="text-danger" v-html="errors['students.'+$index+'.session'][0]"></span>
                                </td>
                                <td v-if="dets.row_show != 'N' ">
                                    <input type="text" class="form-control" v-model="dets.roll_no" :disabled="btn_name == 'SL' || btn_name=='Selected' || dets.show_field == 'dis' ?  true : false">
                                    <span v-if="hasError('students.'+$index+'.roll_no')" class="text-danger" v-html="errors['students.'+$index+'.roll_no'][0]"></span>
                                </td>
                                <td v-if="btn_name == 'AP' && dets.row_show != 'N'">
                                    <span v-if="dets.show_field != 'dis'">
                                        {!! Form::button('Get',['class' => 'btn btn-success', '@click.prevent' => 'getStudent($index)']) !!}
                                    </span>

                                    
                                </td>

                                <td v-if="dets.row_show != 'N' ">
                                    @{{dets.name }}
                                </td>

                                <td v-if="dets.row_show != 'N' ">
                                    @{{dets.father_name }}

                                </td>
                                
                                <td v-if="dets.row_show != 'N' ">
                                    @{{dets.mother_name }}

                                </td>

                                <td v-if="dets.row_show != 'N' ">
                                    @{{dets.class_name }}

                                </td>

                                <td v-if="dets.row_show != 'N' ">
                                    @{{dets.phone_no }}

                                </td>

                                <td v-if="dets.row_show != 'N' ">
                                    {!! Form::text('email',null, ['class' => 'form-control','v-model'=>'dets.email']) !!}
                                    <span v-if="hasError('students.'+$index+'.email')" class="text-danger" v-html="errors['students.'+$index+'.email'][0]"></span>

                                </td>

                                <td v-if="dets.row_show != 'N' ">
                                    @{{dets.category_name }}
                                </td>

                                <td v-if="dets.row_show != 'N' ">
                                    {!! Form::text('job_profile',null, ['class' => 'form-control','v-model'=>'dets.job_profile']) !!}
                                    <span v-if="hasError('students.'+$index+'.job_profile')" class="text-danger" v-html="errors['students.'+$index+'.job_profile'][0]"></span>
                                
                                </td>

                                <td v-if="(btn_name == 'Selected' || btn_name == 'SL') && dets.row_show != 'N'">
                                    <select class="form-control select-form" v-model="dets.status" :disabled="btn_name == 'SL' && dets.status=='Selected' ?  true : false">
                                        {{-- <option value="" Selected>Select</option> --}}
                                        <option value="AP" v-if="btn_name == 'SL' ">Appeared</option>
                                        <option value="SL" v-if="btn_name == 'SL' || btn_name == 'Selected'">Shortlisted</option>
                                        <option value="Selected" v-if="btn_name == 'Selected' || dets.status=='Selected'">Selected</option>
                                    </select>
                                </td>

                                {{-- <td v-show="btn_name != 'Selected' || btn_name != 'SL'">
                                </td> --}}

                                <td v-if="btn_name == 'Selected' && dets.row_show != 'N'">
                                    <select class="form-control select-form" v-model="dets.letter_type" v-if="dets.status=='Selected'">
                                        {{-- <option value="" Selected>Select</option> --}}
                                        <option value="O">Offer Letters</option>
                                        <option value="E">Selection E-Mail</option>
                                    </select>
                                </td>
                                <td v-if="dets.row_show != 'N'">
                                    {!! Form::text('remarks',null, ['class' => 'form-control','v-model'=>'dets.remarks']) !!}
                                </td>

                                <td v-if="dets.status == 'Selected' && btn_name == 'Selected' && dets.row_show != 'N'">
                                    {!! Form::text('pay_package',null, ['class' => 'form-control','v-model'=>'dets.pay_package']) !!}

                                </td>
                            
                                <td v-if="dets.status == 'Selected' && btn_name == 'Selected' && dets.row_show != 'N'" class="choose-file">
                                    <input class="form-control" type="file" name="file" 
                                        @change.prevent="upload($event,$index)" 
                                        data-url="@{{ attachUrl+'/'+dets.id  }}" 
                                    >
                                    <span id="help-block" class="help-block" v-html="errors[$index]['file'][0]"></span>
                                </td>
                                
                                <td v-if="dets.status == 'Selected' && btn_name == 'Selected' && dets.row_show != 'N'">
                                    <a v-if="dets.resource.length > 0"  class="btn btn-default" @click.prevent="showImage(dets.id)" style="width:70px">
                                        <span >
                                            <img src="{{ url('img/pdf.png')}}" width="70px;" />
                                        </span>
                                    </a>
                                </td>
                                
                            
                                <td v-if="btn_name == 'AP' && dets.row_show != 'N'">
                                    <span v-if="dets.status == 'AP'">
                                        {!! Form::button('Remove',['class' => 'btn btn-success', '@click.prevent' => 'removeElement($index)']) !!}

                                    </span>
                                    <span v-if="dets.status == 'SL'">
                                        <strong>
                                            Shortlisted !!
                                        </strong>
                                    </span>
                                    <span v-if="dets.status == 'Selected'">
                                        <strong>
                                            Selected !!
                                        </strong>
                                    </span>
                                </td>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group" v-if="btn_name == 'AP'">
                    
                    {!! Form::button('Add Row',['class' => 'btn btn-success pull-left', '@click.prevent' => 'addRow']) !!}
                </div>
            </div>
            <div class="box-footer">
                <span v-if='edit == "edit"'>
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
            place_id:'',
            students:[{
                id:'',
                placement_id:'',
                stu_id:'',
                roll_no:'',
                name:'',
                father_name:'',
                mother_name:'',
                class_name:'',
                phone_no:'',
                email:'',
                category_name:'',
                job_profile:'',
                pay_package:0,
                remarks:'',
                status:'AP',
                file:'',
                attachment_id:0,
                letter_type:'',
                show_field:'',
                row_show:'Y'

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
            placement_students: {!! isset($placement_student) ? $placement_student : 0 !!},
            place_id: {!! isset($id) ? $id : 0 !!},
            roll_no:'',
            stu_detail:{},
            edit:'',
            btn_name: "{!! isset($btn_name) ? $btn_name : '' !!}",
            files: [],
            attachUrl: "{{  url('uploads') }}",
            url:"{{  url('upload-thumbnail') }}",
            successAttach:false,
            failsAttach: false,
            fileUpload: {},
            placement: {!! isset($placement) ? $placement : 0 !!}
        },
        ready: function() {
            var self = this;
            self.form.place_id = self.place_id;
            if(self.placement_students){
                self.editPlacementStudents();
            }

            
        },
        methods: { 
            
            getStudent:function(key){
                console.log('i am here');
                var self = this;
                self.$http.get("{{ url('get-student') }}/"+self.form.students[key].roll_no+'/'+self.form.students[key].session)
                .then(function(response){
                    var stu_detail  = response.data.student;
                    self.form.students[key].stu_id = stu_detail.id;
                    self.form.students[key].placement_id = self.place_id;
                    self.form.students[key].roll_no =stu_detail.roll_no;
                    self.form.students[key].name =stu_detail.name;
                    self.form.students[key].email =stu_detail.email;
                    self.form.students[key].father_name =stu_detail.father_name;
                    self.form.students[key].mother_name =stu_detail.mother_name;
                    self.form.students[key].class_name =stu_detail.course_name;
                    self.form.students[key].phone_no =stu_detail.mobile;
                    self.form.students[key].category_name =stu_detail.cat_name;
                    self.form.students[key].cat_id =stu_detail.cat_id;
                    self.form.students[key].course_id =stu_detail.course_id;
                    Vue.set(self.form.students[key],'show_field','dis');
                    
                })
                .catch(function(response){
                    this.errors = response.data;
                    $.blockUI({'message':this.errors.college_roll_no[0]});
                    setTimeout(function() {
                        $.unblockUI()
                    },3000);
                });
                
            },
             
            submit:function(){
                var self = this;
                self.$http.post("{{ url('student-details') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        if(response.data.success){
                            self.errors = {};
                            $.blockUI({'message':'<h4>Successfully updated</h4>'});
                            setTimeout(function() {
                                $.unblockUI()
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
                window.location.href = "{{ url('placements')}}";
                       
            },

           

            hasError: function() {
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },

            editPlacementStudents: function(){
                var self = this;
                self.edit = 'edit';
                self.form.students = [];
                self.form.place_id = self.place_id;
                // var dets = self.placement_students.find(ele=>ele.status == 'SL');
                // console.log(dets);
                
                    self.placement_students.forEach(function(ele,index){
                        // var row = {};
                        if(self.btn_name == 'Selected'){
                            if(ele.status == 'SL' || ele.status == 'Selected' ||  ele.status == 'AP' ){
                                if(ele.status == 'AP'){
                                    var row_show = 'N'
                                }
                               var row = {
                                    id:ele.id,
                                    stu_id:ele.std_id,
                                    placement_id:ele.placement_id,
                                    roll_no:ele.roll_no,
                                    session:ele.session,
                                    name:ele.name,
                                    father_name:ele.father_name,
                                    mother_name:ele.mother_name,
                                    class_name:ele.course.course_name,
                                    course_id:ele.course_id,
                                    phone_no:ele.phone,
                                    email:ele.email,
                                    category_name:ele.category.name,
                                    cat_id:ele.cat_id,
                                    job_profile:ele.job_profile,
                                    pay_package:ele.pay_package,
                                    status:ele.status,
                                    remarks:ele.remarks,
                                    attachment_id:ele.resource[0] ? ele.resource[0].attachment_id : 0,
                                    resource:ele.resource,
                                    letter_type:ele.letter_type,
                                    row_show:row_show
                                
                                };
                                self.form.students.push(row);
                            }
                            
                        }else{
                            var row = {
                                id:ele.id,
                                stu_id:ele.std_id,
                                placement_id:ele.placement_id,
                                roll_no:ele.roll_no,
                                session:ele.session,
                                name:ele.name,
                                father_name:ele.father_name,
                                mother_name:ele.mother_name,
                                class_name:ele.course.course_name,
                                course_id:ele.course_id,
                                phone_no:ele.phone,
                                email:ele.email,
                                category_name:ele.category.name,
                                cat_id:ele.cat_id,
                                job_profile:ele.job_profile,
                                pay_package:ele.pay_package,
                                status:ele.status,
                                remarks:ele.remarks,
                                attachment_id:ele.resource[0] ? ele.resource[0].attachment_id : 0,
                                resource:ele.resource,
                                letter_type:ele.letter_type,
                                show_field:'dis',
                                row_show:'Y'
                            
                            };
                            self.form.students.push(row);
                        }
                        
                        
                        
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
                    stu_id:'',
                    placement_id:'',
                    roll_no:'',
                    name:'',
                    father_name:'',
                    mother_name:'',
                    class_name:'',
                    phone_no:'',
                    email:'',
                    category_name:'',
                    job_profile:'',
                    pay_package:0,
                    remarks:'',
                    status:'AP',
                    attachment_id:'0',
                    letter_type:'',
                    cat_id:'',
                    course_id:'',
                    show_field:'',
                    row_show:'Y'
                });
            },

            upload: function (e,index) {
                console.log(index);
                this.errors = {};
                this.successAttach = false;
                this.failsAttach = false;
                var ele = e.target;
                this.filesList = $(ele).prop('files');
                this.uploadPer = 0;
                var self = this;
                // if(this.filesList && this.filesList[0] && (this.filesList[0].size / 1024) > 300) {
                //     this.errors[index] = ["File size is greater than maximum allowed filesize!"];
                //     return;
                // }

                // var loadingImage = loadImage(
                //     ele.files[0],
                //     function (img) {

                //         try {
                //             $('#'+self.optName).empty();
                //             $('#'+self.optName).append($(img));
                //         } catch (error) {
                //             console.log(error);
                //         }
                //     },
                //     { maxWidth: 250 }
                // );
                // if (!loadingImage) {
                //     // Alternative code ...
                // }
                if(! _.isEmpty(this.fileUpload)) {
                    console.log('i am here');
                    console.log($(ele).fileupload());
                    $(ele).fileupload('destroy');
                    this.fileUpload = {};
                }
                
                if(_.isEmpty(this.fileUpload)) {
                    self = this;
                    this.fileUpload = $(ele).fileupload({
                        progress: function (e, data) {
                            self.uploadPer = parseInt(data.loaded / data.total * 100, 10);
                        },
                        done: function (e, data) {
                            self.successAttach = true;
                            self.failsAttach = false;
                            var file = JSON.parse(data.jqXHR.responseText);
                            console.log(file.resource);
                            // if(data.result.files) {
                            //     self.url = data.result.files.url;
                            //     self.urlUpdated = true;
                            // }

                            if(file){
                                self.form.students.forEach(function(ele,key){
                                    if(index == key){
                                        console.log(ele);
                                        ele.attachment_id = file.resource.id;
                                    }
                                })
                            }
                                
                        },
                        fail: function (e, data) {
                            self.successAttach = false;
                            self.failsAttach = true;
                            var err = JSON.parse(data.jqXHR.responseText);
                            var req = [];
                            if(err){
                                self.form.students.forEach(function(ele,key){
                                    if(index == key){
                                        req[index] = err;
                                        self.errors = req;
                                    }
                                })
                            }
                            
                            self.uploadPer = 0;
                            $('#'+self.optName).html('');

                        },
                        always: function(e, data) {

                        }
                    });
                }
                var jqXHR = $(ele).fileupload('send', {files: this.filesList, type: 'POST'});
                // var attach = this.jqXHR.responseJSON;
                // console.log(file);
                
            },

            showImage: function(id) {
                self = this;
                if(self.url) {
                        if(self.optName == 'photograph'){
                        $.fancybox.open({
                            src  : self.url,
                            type : 'iframe',
                            opts : {
                                beforeLoad: function() {
                                    if(self.urlUpdated) {
                                        $($('.fancybox-iframe')[0]).attr('src', $($('.fancybox-iframe')[0]).attr('src')+'?time='+new Date().getTime());
                                        self.urlUpdated = false;
                                    }
                                },
                                iframe: {
                                    css: {
                                        width: '70% !important'
                                    }
                                }
                            }
                        });
                    }else{
                        window.open(self.base_url+'/upload-thumbnail/'+id,'_blank');
                    }
                }
            }
            
        }
    });
</script>
@endsection