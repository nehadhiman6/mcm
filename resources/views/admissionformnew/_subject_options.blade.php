<template id="subject-options-template">

    <fieldset>
        <legend>Subjects/Options</legend>
        
        <div class="form-group">
            {!! Form::label('medium','Medium of Instruction',['class' => 'col-sm-3 control-label required']) !!}
            <div class="col-sm-8"  v-bind:class="{ 'has-error': errors['medium'] }">
                <label class="radio-inline" >
                {!! Form::radio('medium', 'English',null, ['class' => 'minimal','v-model'=>'medium']) !!}
                English
                </label>
                <label class="radio-inline">
                {!! Form::radio('medium', 'Hindi',null, ['class' => 'minimal','v-model'=>'medium']) !!}
                Hindi
                </label>
                <label class="radio-inline">
                {!! Form::radio('medium', 'Punjabi',null, ['class' => 'minimal','v-model'=>'medium']) !!}
                Punjabi
                </label>
                <span id="basic-msg" v-if="errors['medium']" class="help-block">@{{ errors['medium'][0] }}</span>
            </div>
        </div>


        <div class="col-sm-12" v-show = "course_type != 'PGRAD'">
            <p>
                <h4>
                    <strong>Compulsory Subjects:</strong>
                </h4>
            </p>
        </div>

        {{-- <div class='form-group'  v-show = "course_type != 'PGRAD'">
            <h4>
                {!! Form::label('comp_subject','Compulsory Subjects:',['class' => 'col-sm-2 control-label']) !!}
            </h4>
        </div> --}}

        <div  v-bind:class="{ 'has-error': errors['punjabi_in_tenth'] }" v-show = "course_type != 'PGRAD'">
            {!! Form::label('punjabi_in_tenth','Have you studied Punjabi in Class X?',['class' => 'col-sm-4 control-label required']) !!}
            <label class="radio-inline" >
                {!! Form::radio('punjabi_in_tenth', 'Y',null, ['class' => 'minimal punjabiInTenth','v-model'=>'punjabi_in_tenth', ':disabled'=>'disable_pbi_in_tenth && getCourseType == "GRAD"  && getSelectedCourse.course_year > 1']) !!}
                Yes
                </label>
                <label class="radio-inline" :disabled = "last_exam_mcm == 'Y'">
                {!! Form::radio('punjabi_in_tenth', 'N',null, ['class' => 'minimal punjabiInTenth','v-model'=>'punjabi_in_tenth', ':disabled'=>'disable_pbi_in_tenth && getCourseType == "GRAD"  && getSelectedCourse.course_year > 1']) !!}
                No
                </label>
                <span id="basic-msg" v-if="errors['punjabi_in_tenth']" class="help-block">@{{ errors['punjabi_in_tenth'][0] }}</span>
            <div class="col-sm-offset-2 col-sm-10" id="course-det"></div>
        </div>

        <ul class = "">
            <comp-grps 
                v-for="cgrp in compGrp" 
                :old-subjects='old_subjects' 
                :cgrp='cgrp' 
                type='C' 
                :disable-subjects="form_id > 0 && canChangeSubjects == false && getSelectedCourse.course_year > 1"
            >
            </comp-grps>
        </ul>
    
        <div class = "col-lg-offset-2" v-show = "course_type != 'PGRAD'"> 
            NOTE: HISTORY AND CULTURE OF PUNJAB is only for those who have not studied Punjabi in class X.
        </div>

        <div class='form-group'  v-show = "course_type != 'PGRAD'">
            {{-- {!! Form::label('comp_subject','Compulsory Subjects:',['class' => 'col-sm-2 control-label']) !!} --}}
            <div class="col-sm-10 col-sm-offset-2">
                <span class="control-label" v-for='ss in compSub' >
                    <span><strong>&#8226;</strong></span> @{{ ss.subject }} &nbsp;&nbsp;
                </span>
            </div>
        </div>

        

    
        <!-- Elective Options -->
        <div class="col-sm-12" v-if='electives.length > 0'>
            <p>
                <h4>
                    <strong>Elective Subjects:</strong>
                    <span id="basic-msg" v-if="errors['comp_group']" class="help-block">@{{ errors['comp_group'][0] }}</span>
                </h4>

                <span v-if="min_optional > 0 && admForm.course.course_name == 'BAI'"><strong>Instructions Regarding Selecting Elective Subjects</strong></span>

                <ul v-if="min_optional > 0 && admForm.course.course_name == 'BAI'" style="list-style: disc">
                    <li>Applicant is required to select 3 Elective subjects in all.</li>
                    <li>Applicant must give 3 preferences for Elective subject combinations.</li>
                    
                    {{-- <li>Applicant is required to select 3 Elective subjects in all.</li>
                    <li>Applicant must give 6 preferences for Elective subject combinations.</li>
                    <li>In each Preference, a set of 4 options is given. (Option 1- Option 4).</li>
                    <li>Select a set of 3 Electives from either of the 4 options. You cannot select individual subjects from different options.</li>
                    <li>A subject can be selected / repeated maximum 3 times as a preference.</li> --}}
                </ul>
                
                {{-- <span v-if="min_optional > 0 && admForm.course.course_name == 'BAI'"><strong>Steps for selecting 6 preferences:</strong></span>
                <ul v-if="min_optional > 0 && admForm.course.course_name == 'BAI'">
                    <li>Step 1: Preference 1: Select 3 Electives from any of the given options.</li>
                    <li>Step 2: Click Add Preference</li>
                    <li>Step 3: Preference 2: Select 3 Electives from any of the given options.</li>
                    <li>Step 4: Click Add Preference</li>
                    Repeat the above steps to for giving 6 preferences.</li>
                </ul> --}}
                <strong class="help-block">NOTE: Selecting Electives here does NOT guarantee their allotment.</strong>

                {{-- <span v-if="min_optional > 0 ">
                    A student is required to select 
                    <strong>@{{ min_optional }} </strong> 
                    electives.
                </span>

                <ul v-if="min_optional > 0 && admForm.course.course_name == 'BAI'">
                    <li>i.Applicant can give upto 5 preferences for elective subject combinations (Preference 1-Preference 5).Click 'Add Preference' button to add next subject combination preference.</li>
                    <li>
                        ii.For each Preference, the applicant must
                        - Choose any one Option (from Option 1-Option 4)
                        - Under chosen Option, select exactly <strong>@{{ min_optional }} </strong> electives 
                    </li>
                    <strong class="help-block">Note: Selecting electives here does NOT guarantee its allotment</strong>
                </ul> --}}
            </p>
        </div>

        <span id="basic-msg" v-if="errors['opt_subs_count']" class="help-block">@{{ errors['opt_subs_count'][0] }}</span>
        <div v-for="dets in sub_combination" v-if="admForm.course.course_name == 'BAI'"> 
            <div class="form-group">
                {!! Form::label('sub_combination_id','Subject Preference @{{dets.preference_no}}',['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-5">
                {{-- {!! Form::select('sub_combination_id',subjectCombinations(),null,['class' => 'form-control','v-model'=>'dets.sub_combination_id']) !!} --}}
                    <select v-model="dets.sub_combination_id" class="form-control" id="abc">
                        <option v-for="sub in subjectCombinations" :value="sub.id">@{{ sub.code }}:- @{{ sub.subject}} </option>
                    </select>
                </div>
            </div>
        </div>
       
        <legend v-show="course_id != 14 && course_type != 'PGRAD' && admForm.lastyr_rollno == null && electives.length > 0">Preference 1</legend>
        
        <div v-show="course_id != 14" v-for="elective in electives"> 
            <div v-show='elective.elective_subjects.length > 0 || elective.groups.length > 0'>
                <div class="form-group" >
                    <div class='col-sm-12'>
                        <button class='tooltip-btn' @click.prevent='selectElective(elective.id)'>
                            <span class="tooltiptext">Click this to select subjects from given list</span>
                            <span v-if="elective.id != selected_ele_id" >
                                <i class="glyphicon glyphicon-unchecked"  style="font-size:20px;margin-left:20px;color:black"> 
                                </i>
                            </span>
                            &nbsp;&nbsp;
                            <span v-if="elective.id == selected_ele_id" class="glyphicon glyphicon-ok" style="font-size:20px;margin-left:10px;;margin-right:10px;color:green" aria-hidden="true">
                            </span>
                            @{{ elective.name }}
                        </button>
                    </div>
                </div>

                <div v-if='selected_ele_id == 0 || elective.id == selected_ele_id'>
                    <div class="form-group"  >
                        <div class="col-sm-8 col-sm-offset-2" >
                            <div v-for="sub in elective.elective_subjects">
                                <div class="col-sm-12">
                                    <label class="checkbox" >
                                        <input type="checkbox" 
                                        name= "optional_sub[]" 
                                        value= "@{{ sub.subject_id }}" 
                                        :disabled="(sub.sub_type == 'C' || ((old_subjects.length > 0 || admForm.active_tab >= 3) && canChangeSubjects == false && getSelectedCourse.course_year > 1))" 
                                        number 
                                        v-model="selected_opts" 
                                        class="">
                                        @{{ sub.subject.subject }}      
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class = "">
                        <comp-grps v-for="cgrp in elective.groups" :cgrp='cgrp' :old-subjects='old_subjects' :type='cgrp.type'
                        :disable-subjects="form_id > 0 && canChangeSubjects == false && getSelectedCourse.course_year > 1">
                        </comp-grps>
                    </ul>
                </div>
            </div>
        </div>

        {{-- <div v-show="course_id == 14"
            :courses = "courses"
            :adm-form.sync = "admForm"
            :min_optional = "min_optional"
            :subject_preferences.sync = "subject_preferences"
            :comp-sub = "compSub"
            :comp-grp = "compGrp"
            :optional-sub = "optionalSub"
            :optional-grp = "optionalGrp"
            :electives = "electives"
            :course_id = "course_id"
            :form_id = "form_id"
            :subject_wise_counts="subject_wise_counts"
            is="subject-prefs"
        >
        </div> --}}

    
        <div v-if="getSelectedCourse && getSelectedCourse.course_year != 3 && getSelectedCourse.course_year !=1">
            <h4><strong>Honours Subjects</strong></h4>
            <p class="col-sm-offset-1 form-control-static">(To be filled only by those who are interested in applying for Honors)</p>
            <p class="col-sm-offset-1 form-control-static">Honours subject will be allotted in BA / BSc / BCom in third semester on merit basis at the time of admission in the College.</p>
        
            <div class="form-group">
                <label class="col-sm-2 control-label">Subjects Available:</label>
                <div class="col-sm-10">
                    <h4>
                        <p class="form-control-static">
                            @{{ honoursLabel }}
                        </p>
                    </h4>
                </div>
            </div>
            
            <honour-sub 
                v-for="index in getHonourSubjects.length"
                v-ref:honour
                :preference = "index+1"
                :list.sync = "getHonourSubjects"
            >
            </honour-sub>

        </div>
    
        <h4 v-if="course_type =='GRAD'">
            <strong>Add-on Course (Optional Courses)</strong>
        </h4>

        <div class="form-group" v-if="course_type =='GRAD'">
            {!! Form::label('addon_course_id','Add-On Course',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-5">
            {!! Form::select('addon_course_id',getAddOnCourses(),null,['class' => 'form-control','v-model'=>'addon_course_id']) !!}
            </div>
        </div>

        <div v-if="old_honour.length > 0">
            <h4><strong>Honours Subjects:</strong></h4>
            <p class="form-control-static  col-md-offset-1"><b>@{{old_honour[0].subject}}</b></p>
        </div>
        <div class="row col-md-12">

            {{-- <span id="basic-msg" class="help-block">Please 'Update' data, in case of any changes, before leaving the current tab !</span> --}}
            <span id="basic-msg" class="help-block">Click the "Update" button before leaving the current tab, in case there have been any changes.</span>

            <input v-on:click="rediretPreviousTab" v-show="isNoTabs !=true && active_tab >= 2" class="btn btn-primary"  type="button" value="Previous" >
            <input class="btn btn-primary"  type="button" :value="admForm.active_tab >= 3 ? 'Update' : 'Submit'" @click.prevent="submit">
            <input v-on:click="rediretNextTab" v-show="isNoTabs !=true && active_tab >= 3" class="btn btn-primary"  type="button" value="Next" >
        </div>
    </fieldset>
    <div>
        <ul class="alert alert-error alert-dismissible" role="alert" v-show="hasErrors">
            <li  v-for='error in errors'>@{{ error }} </li>
        </ul>
    </div>

</template>

<template id="comp-grp-template" >
    <div class="col-sm-10 col-sm-offset-2">
        <li>
        <div class='form-group'>
            <label class="input-group">
            <label class="checkbox-inline" >
                <input type="checkbox"  :disabled="oldSubjects.length > 0 || disableSubjects" name='grps[@{{ type }}][@{{ cgrp.id }}]' value="" @change='unselected' v-model='checked'>
                <label class="radio-inline radio-margin" v-for="sub in cgrp.details" >
                <input :disabled="oldSubjects.length > 0 || disableSubjects" type="radio" name="cmp_grp[@{{ cgrp.id }}]'" class="sub_@{{ cgrp.id }}" value="@{{ sub.ele_group_id ? sub.subject.id : sub.id }}" v-model="cgrp.selectedid" @click='selected'>
                <!--{!! Form::radio('cmp_grp[@{{ cgrp.id }}]',"@{{ sub.id }}" ,null, ['@click'=>'selected', 'class' => 'sub_@{{ cgrp.id }}']) !!}-->
                @{{ sub.ele_group_id ? sub.subject.subject : sub.subject }}
                </label>
            </label>
            </label>
            </div>
        </li>
    </div>
</template>

<template id = "honour-sub-template">
    <div class="form-group">
        <label class="col-sm-3 control-label">Preference @{{preference}}:</label>
        <div class="col-sm-3">
        <select class="form-control" number v-model="sub_id" @change="updatePreference">
            <option value="0">Select</option>
            <option v-for="(local_index, honour_sub) in getList" value="@{{honour_sub.subject_id}}">@{{ honour_sub.subject.subject }}</option>
        </select>
        </div>
    </div>
</template>
@include('admissionformnew._preferances')

@push('vue-components')
    <script>
        var no = 1000;
        var subjectOptions = Vue.extend({
            template: '#subject-options-template',
            props:['isNoTabs','courses','active_tab','course_id','form_id','admForm','compSub','compGrp','optionalSub','optionalGrp','electives','honoursSubjects','selected_opts','old_honour'],
            data: function(){
                return {
                    counter: 1,
                    selected_ele_id: 0,
                    min_optional: 0,
                    punjabi_tenth : "{{ $adm_form->punjabi_in_tenth }}",
                    punjabi_in_tenth:"",
                    disable_pbi_in_tenth: false,
                    course_type: "{{$adm_form->course_type}}",
                    old_subjects: [],
                    subject_preferences: {!! $adm_form->AdmissionSubPreference ? json_encode($adm_form->AdmissionSubPreference) : "[]" !!},
                    addon_course_id:'',
                    medium:"",
                    addon_course_id:'',

                    //basic
                        response: {},
                        success: false,
                        fails: false,
                        msg: '',
                        errors: [],

                    sub_combination:[],
                    subjectCombinations: {!! json_encode(getSubjectCombination($adm_form->course_id)) !!},

                
                }
            },

            ready: function() {
                var self = this;
                this.min_optional = self.admForm.course ? self.admForm.course.min_optional : 0;
                //new
                if(self.admForm.lastyr_rollno != null){
                    self.getStudentDetails();
                }

                if(self.admForm.active_tab >= 3 ){
                    self.setDataForForm(self.admForm);
                }
                
                var c = this.getSelectedCourse;
                self.course_type = c ? c.status : '';
                if(self.admForm.sub_combinations.length == 0){
                    var arr = ['1','2','3','4'];
                    var row = {};
                    for (let index = 1; index < arr.length; index++) {
                        row={
                            id:0,
                            admission_id:this.admForm.id,
                            preference_no:index,
                            sub_combination_id:'0',
                        }
                        self.sub_combination.push(row);
                    }
                }
               

                // this.showCompSubs;
                // this.elective_grps;
                // this.getSelectedCourse;
                // this.canChangeSubjects;
                // this.getHonourLink;
                // this.getSelectedSubjects;
                // this.getHonourSubjects;
                // this.honoursLabel;
                //new
              
                // this.punjabi_in_tenth = this.punjabi_tenth;
                // if(this.form_id > 0) {
                //     if(this.canChangeSubjects == false) {
                //     this.disable_pbi_in_tenth = true;
                //     }
                //     if (this.lastyr_rollno.trim().length > 0) {
                //     this.oldstudentDetails.name = self.name.trim().length > 0;
                //     this.oldstudentDetails.mother_name = self.mother_name.trim().length > 0;
                //     this.oldstudentDetails.father_name = self.father_name.trim().length > 0;
                //     this.oldstudentDetails.course_id = self.course_id && self.course_id > 0;
                //     this.oldstudentDetails.dob = self.dob.trim().length > 0;
                //     }
                // }

               

                
            },
            
            watch:{
                "course_id": function() {
                    this.selected_opts = [];
                    this.subject_preferences = [];
                    console.log('courses h:',this.course_id,this.admForm.course.id);
                },
                epic_card: function (val) {
                    var self = this;
                    if(val == "N"){
                    self.epic_no = " ";
                    }
                },
                adhar_card: function (val) {
                    var self = this;
                    if(val == "N"){
                    self.aadhar_no = "";
                    }
                },
                selected_opts: function() {
                    this.checkHonours();
                },
                electives: {
                    deep: true,
                    handler: function() {
                    this.checkHonours();
                    }
                },
                punjabi_in_tenth:{
                    handler:function(val){
                        var self = this;
                        console.log();
                        var hcp = '';
                        if(this.compGrp != '' && self.compGrp && self.compGrp.length > 0){
                            self.compGrp.forEach(function(element) {
                                element.details.forEach(function(ele) {
                                    if(ele.subject.toUpperCase() == "HISTORY AND CULTURE OF PUNJAB"){
                                        if(val == 'N'){
                                            $.each($('.sub_' + element.id), function( index, elem ) {
                                                if(elem.value == ele.id){
                                                    $('.sub_' + element.id)[index].disabled = false;
                                                    $('.sub_' + element.id)[index].checked = true;
                                                    element.selectedid = ele.id;
                                                    //$('.sub_' + element.id).trigger('click');
                                                }
                                                else{
                                                    $('.sub_' + element.id)[index].disabled = true;
                                                }
                                            });
                                        }
                                    }
                                    if(ele.subject.toUpperCase() == "PUNJABI COMPULSORY"){
                                        if(val == 'Y'){
                                            $.each($('.sub_' + element.id), function( index, elem ) {
                                                if(elem.value == ele.id){
                                                    $('.sub_' + element.id)[index].disabled = false;
                                                    $('.sub_' + element.id)[index].checked=true;
                                                    $('.sub_' + element.id).trigger('click');
                                                    element.selectedid = ele.id;
                                                }
                                                else{
                                                    $('.sub_' + element.id)[index].disabled = true;
                                                }
                                            });
                                        }
                                    }
                                });
                                $('.sub_1').trigger('click');
                            });
                        
                        }
                    }
                }
            },

            methods: {
                rediretNextTab: function(){
                    $('a[href="#acedmic-detail"]').click();
                },

                rediretPreviousTab: function(){
                    $('a[href="#parent-detail"]').click();
                },


                submit: function() {
                    var self = this;
                    self.errors = {};
                    var data = self.setFormData();
                    var submit = true;
                    console.log(data.subject_preferences.length > 0);
                    if(this.admForm && this.admForm.course && this.admForm.course.course_name != 'BAI' && data.subject_preferences.length > 0){
                        console.log("here");
                        data.subject_preferences.forEach(function(e,key){
                            console.log(e.selectedOpts.length);
                            if(e.selectedOpts.length != self.min_optional){
                                alert('Check ! Minimum subject should not be more than and less than 3 for Preference No '+ (parseInt(key) + 2));
                                submit = false;
                                return;
                            }
                        });

                        Object.keys(self.subject_combinations).forEach(function(e, i) {
                            console.log(e);
                            if(self.subject_combinations[e].count > 1) {
                                alert('Check ! Duplicate subject preferences found for '+self.subject_combinations[e].msg);
                                submit = false;
                                return;
                            }
                        })


                    }

                    if(this.admForm && this.admForm.course && this.admForm.course.course_name == 'BAI'){
                        var this_sub_combination_ids = [];
                        console.log(data.sub_combination);
                        data.sub_combination.forEach(function(e, i) {
                            if(e.sub_combination_id == 0) {
                                alert('Minimum 3 Subject Prefrence are Required');
                                submit = false;
                                return;
                            }
                            if(this_sub_combination_ids.includes(e.sub_combination_id)) {
                                alert('Subject Prefrence must be unique!');
                                submit = false;
                                return;
                            }
                            this_sub_combination_ids.push(e.sub_combination_id);
                            // var index_c = data.sub_combination.findIndex(arr=> arr.sub_combination_id == e.sub_combination_id)
                            // if(index_c > 0){
                            //     alert('Minimum 3 Subject Prefrence are Required');
                            //     submit = false;
                            //     return;
                            // }
                        })
                    }
                    
                    if(submit){
                        var data = $.extend({'elective_grps': this.elective_grps}, data);
                        self.$http[self.getMethod()](self.getUrl(), data)
                        .then(function (response) {
                            if (response.data.success) {
                                self.form_id = response.data.form_id;
                                self.active_tab = response.data.active_tab;
                                self.admForm.active_tab = response.data.active_tab;
                                self.sub_combination = response.data.adm_form.sub_combinations;
                                // console.log('subject_combinations:', response.data.adm_form.sub_combination);
                                // self.admForm = response.data.adm_form;
                                $.blockUI({ message: '<h3> Record successfully saved !!</h3>' });
                                setTimeout(function(){
                                    $.unblockUI();
                                },1000);
                                
                                // if(!response.data.active_tab){
                                //     window.location.reload();
                                // }
                                // setTimeout(function() {
                                //   self.success = false;
                                //   window.location = self.admitUrl+'/' +self.form_id +'/details';
                                // }, 3000);
                            }
                        }, function (response) {
                            self.fails = true;
                            if(response.status == 422) {
                                $('body').scrollTop(0);
                                self.errors = response.data;
                            }              
                        });
                    }
                },

                setFormData: function(){
                    return {
                        form_id : this.admForm.id,
                        active_tab: 3,
                        course_id : this.course_id,
                        subject_preferences: this.subject_preferences,
                        medium: this.medium,
                        addon_course_id:this.addon_course_id,
                        compSub: this.compSub,
                        compGrp:  this.compGrp,
                        optionalSub:  this.optionalSub,
                        optionalGrp:  this.optionalGrp,
                        electives:  this.electives,
                        honoursSubjects: this.honoursSubjects,
                        selected_ele_id:  this.selected_ele_id,
                        selected_opts:  this.selected_opts,
                        min_optional:  this.min_optional,
                        punjabi_tenth :  this.punjabi_tenth,
                        punjabi_in_tenth: this.punjabi_in_tenth,
                        old_honour: this.old_honour,
                        sub_combination:this.sub_combination,
                    }
                },

                setDataForForm: function(sub_op){
                    var self = this;
                    console.log('i am here shubham');
                    this.active_tab = sub_op.active_tab ? sub_op.active_tab : self.active_tab;
                    this.form_id  = sub_op.form_id;
                    // this.subject_preferences = sub_op.subject_preferences;
                    this.medium = sub_op.medium;
                    this.punjabi_in_tenth = sub_op.punjabi_in_tenth;
                    this.selected_opts = this.selected_opts;
                    this.addon_course_id = sub_op.addon_course_id;

                    // this.checkHonours();
                    // if(this.course_id > 0)
                    // self.showSubs();

                    if(this.canChangeSubjects == false) {
                        this.disable_pbi_in_tenth = true;
                    }

                    // // this.electives = this.electives;
                    // this.honoursSubjects = sub_op.honoursSubjects;
                    this.selected_ele_id = sub_op.selected_ele_id;
                    this.min_optional = sub_op.course.min_optional;
                    console.log(sub_op.sub_combinations,'Shubham');
                    var row = {};
                    sub_op.sub_combinations.forEach(element => {
                        row={
                            id:element.id,
                            admission_id:element.admission_id,
                            preference_no:element.preference_no,
                            sub_combination_id:element.sub_combination_id,
                        }
                        self.sub_combination.push(row);
                    });

                    // this.old_honour = sub_op.old_honour;
                },

                getMethod: function() {
                    if(this.isNoTabs == true){
                        return 'post';
                    }
                    if(this.admForm.active_tab >= 3)
                    return 'patch';
                    else
                    return 'post';
                },

                getUrl: function() {
                    if(this.isNoTabs == true){
                        return "{{url('/adm-subject-options')}}";
                    }
                    if(this.admForm.active_tab >= 3)
                        return 'subject-option/'+this.form_id;
                    else
                        return 'subject-option';
                },
            
                
                checkHonours: function() {
                    var self = this;
                    console.log('checkHonours');
                    return;

                    var max_preference = this.getHonourSubjects.length;
                    $.each(self.honoursSubjects, function( index, honour ) {
                        honour.opted = (self.getSelectedSubjects.indexOf(honour.honours_sub_id) > -1);
                        if(honour.opted == false) {
                        honour.selected = false;
                        honour.preference = 0;
                        }
                    });
                },

                isSubjectSelected: function(subject, compulsory) {
                    var self = this;
                    var found = false;
                    console.log('isSubjectSelected');

                    compulsory = compulsory || true;
                    if(self.compGrp.length > 0){
                        self.compGrp.forEach(function(element) {
                        element.details.forEach(function(ele) {
                            if(ele.subject.toUpperCase() == subject.toUpperCase() && ele.id == element.selectedid) {
                            found = true;
                            }
                        });
                        });
                    }
                    return found;
                },

                selectElective: function(ele_id) {
                    console.log('selectElective', ele_id);

                    if(this.selected_ele_id > 0 && this.old_subjects.length > 0){
                        return;
                    }
                    this.selected_ele_id = this.selected_ele_id != ele_id ? ele_id : 0;
                    this.selected_opts = [];
                    var self = this;
                    $.each(this.electives, function(key, elective) {
                        if(elective.id == self.selected_ele_id) {
                            $.each(elective.elective_subjects, function(key1, sub) {
                                if(sub.sub_type == 'C') {
                                    self.selected_opts.push(sub.subject_id);
                                }
                            });
                        }
                    });
                },

                showSubs: function(e) {
                    var self = this;
                    console.log('showSubs');
                    
                    self.selected_ele_id = 0;
                    this.$http.post("{{ url('courses/subs') }}",{'course_id': this.course_id})
                        .then(function (response) {
                        //$('#').blockUI();
                        self.compSub = response.data['compSub'];
                        self.compGrp = response.data['compGrp'];
                        self.optionalSub = response.data['optionalSub'];
                        self.optionalGrp = response.data['optionalGrp'];
                        self.min_optional = response.data['course'].min_optional;
                        if(self.admForm.active_tab < 3){
                            var honoursSubjects = response.data['honours'];
                            $.each(honoursSubjects, function(index, hSub) {
                                hSub.opted = false;
                                hSub.selected = false;
                                hSub.preference = 0;
                            });
                            self.honoursSubjects = honoursSubjects;
                        }
                        var electives = response.data.electives;
                        $.each(electives, function(key, elective) {
                            $.each(elective.groups, function(key, grp) {
                            if(typeof grp.selectedid == 'undefined') {
                                grp.selectedid = 0;
                            }
                            });
                        });
                        this.electives = electives;
                        self.showOldStudentSubjects();
                        }, function (response) {
                        $.each(response.data, function(key, val) {
                            self.msg += key+': '+val+' ';
                        });
                    });
                },

                showOldStudentSubjects: function() {
                    var self = this;
                    console.log('showOldStudentSubjects');

                    self.selected_opts = [];
                    console.log('here');
                    if(self.course_id) {
                        if(!self.canChangeSubjects){
                            self.old_subjects.forEach(function(arr){
                                self.selected_opts.push(arr.subject_id);
                            });
                            self.getElectiveGrp();
                            self.getCompGrp();
                        }
                    }
                },

                resetOldData: function() {
                    var self = this;
                    console.log('resetOldData');

                    this.old_subjects = [];
                    this.course_id = 0;
                    this.disable_pbi_in_tenth = false;
                },

                getCompGrp:function(){
                    var self = this;
                    console.log('getCompGrp');

                    var comp_sub = '';
                    $.each(this.compGrp, function(key, compul) {
                        // console.log(compul);
                        $.each(compul.details, function(key, details) {
                            $.each(self.old_subjects, function(key, sub) {
                            if(sub.subject_id == details.id){
                                compul.selectedid = details.id;
                            }
                            });
                        });
                    });
                    self.punjabi_in_tenth = this.isSubjectSelected('PUNJABI COMPULSORY') ? 'Y' : (this.isSubjectSelected('HISTORY AND CULTURE OF PUNJAB') ? 'N' : '');
                    self.disable_pbi_in_tenth = self.punjabi_in_tenth != "";
                },

                getElectiveGrp: function() {
                    var selected_opts = [];
                    console.log('getElectiveGrp');
                    
                    var opts = [];
                    var self = this;
                    var count = 0;
                    var ele_sub;
                    var ele_id = 0;
                    $.each(this.electives, function(key, elective) {
                        count = 0;
                        opts = [];
                        $.each(self.old_subjects, function(key, sub) {
                        ele_sub = _.findWhere(elective.elective_subjects, {subject_id: sub.subject_id});
                        if(typeof ele_sub != 'undefined') {
                            count++;
                            opts.push(sub.subject_id);
                        } else {
                            $.each(elective.groups, function(key, grp) {
                            ele_sub = _.findWhere(grp.details, {subject_id: sub.subject_id});
                            if(typeof ele_sub != 'undefined') {
                                count++;
                                grp.selectedid = ''+sub.subject_id;
                            }
                            });
                        }
                        });
                        if(count >= self.getSelectedCourse.min_optional) {
                            console.log('Elective: ', elective.id)
                            ele_id = elective.id;
                            selected_opts = opts;
                        }
                    });
                    if (ele_id > 0) {
                        self.selected_ele_id = 0;
                        self.selectElective(ele_id);
                        self.selected_opts = selected_opts;
                    }
                    // return ele_grps;
                },
                getStudentDetails: function() {
                    // console.log("details");
                    console.log('getStudentDetails');
                    try {
                        // if(this.admForm.lastyr_rollno.trim().length > 0 && this.admForm.form_id > 0) {
                        if((this.admForm.lastyr_rollno.trim().length > 0 && this.admForm.form_id > 0) || (this.admForm.adm_entry && this.admForm.adm_entry.dhe_form_no.trim().length > 0)) {
                            return ;
                        }
                        if(this.admForm.lastyr_rollno.trim().length == 0) {
                            return;
                        }
                        this.resetOldData();
                        var self = this;
                        this.$http['get']('admforms/'+ this.admForm.lastyr_rollno + '/studentinfo')
                            .then(function (response) {
                                var student = response.data.data;
                                // console.log(response.data.success);
                                if(response.data.success == true){
                                    for (let field in student) {
                                        if(self.$data.hasOwnProperty(field) && typeof(self.$data[field]) != 'function') {
                                        self.$data[field] = student[field];
                                        }
                                    }
                                    // disable field
                                
                                    self.course_id = response.data.next_course_id;
                                    self.course_type = self.getCourseType;
                                    self.old_subjects = response.data.old_subjects;
                                    if(response.data.old_hon_sub && response.data.old_hon_sub.length > 0) {
                                    self.old_honour = response.data.old_hon_sub;
                                    }
                                    self.showSubs();
                                } 
                            })
                            .catch(function(){
                
                            });
                    } catch (error) {
                        console.loh(error);
                    }
                   
                }
            },

            computed: {
                hasErrors: function() {
                    return Object.keys(this.errors).length > 0;
                },
        
                showCompSubs: function() {
                    console.log('showCompSubs');
                    var compSubs = '';
                    $.each(this.compSub, function(key, val) {
                        compSubs += val.subject+' , ';
                    });
                    return compSubs;
                },

                elective_grps: function() {
                    var ele_grps = [];
                    console.log('elective_grps');

                    var self = this;
                    $.each(this.electives, function(key, elective) {
                        if(elective.id == self.selected_ele_id) {
                        $.each(elective.groups, function(key1, grp) {
                            ele_grps.push(grp);
                        });
                        }
                    });
                    return ele_grps;
                },

                getCourses: function() {
                    var self = this;
                    return this.courses.filter(function(course) {
                        return course.status == self.course_type;
                    });
                },

                getCourseType: function() {
                    var self = this;
                    console.log('course type');
                    var c = this.getSelectedCourse;
                    // console.log(c);
                    return c ? c.status : '';
                },
                
                getSelectedCourse() {
                    var self = this;
                    if(this.course_id == 0)
                        return null;
                    var c = this.courses.filter(function(course){
                        return course.id == self.course_id;
                    });
                    return c ? c[0] : null;
                },

                canChangeSubjects: function() {
                    @if(isset($guard) && $guard == 'web')
                        return true;
                    @endif
                    var c = this.getSelectedCourse;
                    if(this.admForm.lastyr_rollno && c && (c.course_id == 'BA' || c.course_id == 'BA-OM')) {
                        return false;
                    }
                    return true;
                },

                getHonourLink:function(){
                    var self = this;
                    console.log('getHonourLink');
                    
                    var course = this.getSelectedCourse;
                    if(course && course.honours_link == 'Y'){
                        return true;
                    }
                    return false;
                },

                getSelectedSubjects:function(){
                    var self = this;
                    console.log('getSelectedSubjects');
                    // var selected = $.extend({}, self.selected_opts);
                    var selected = [];
                    console.log(self.selected_opts);
                    $.each(self.selected_opts,function(index,val){
                        $.each(self.electives,function(index,ele){
                            if(ele.id == self.selected_ele_id){
                            $.each(ele.elective_subjects,function(index,ele_sub){
                                if(ele_sub.subject_id == val){
                                selected.push(ele_sub.course_sub_id);
                                }
                            });
                            }
                        });
                    });
        
                    // selected.push(self.selected_opts);
                    $.each(this.elective_grps, function(key, grp) {
                        if((grp.selectedid * 1) > 0) {
                            $.each(grp.details, function(key, detail) {
                                if(parseInt(detail.subject_id) ==  parseInt(grp.selectedid)){
                                    selected.push(detail.course_sub_id);
                                }
                            });
                        }
                    });
        
                    return selected;
                },
                getHonourSubjects:function(){
                    var self = this;

                    if(this.getSelectedCourse && (this.getSelectedCourse.course_id == "BCOM" || this.getSelectedCourse.course_id == "BCOM-SF") && this.getSelectedCourse.course_year == 2) {
                        return this.honoursSubjects;
                    }

                    return this.honoursSubjects.filter(function(hon) {
                        return self.getSelectedSubjects.includes(hon.honours_sub_id);
                    });

                    $.each(self.honoursSubjects, function( index, honour ) {
                    if(honour.honours_sub_id == value){
                        var h_subj = new Object();
                        h_subj={ subject_id :honour.subject_id , subject :honour.subject , preference : 0 ,selected:false}
                        honourSelect.push(h_subj);
                    }
                    });
                    return honourSelect;
                },

                honoursLabel: function() {
                    return _.pluck(_.pluck(this.getHonourSubjects, "subject"), 'subject').join(' , ');
                },
        
                
                firstYear:function(){
                    if(this.getSelectedCourse && this.getSelectedCourse.course_year && this.getSelectedCourse.course_year == 1 && this.getCourseType == 'GRAD'){
                    return true;
                    }
                    return false;
                },

                subject_wise_counts: function() {
                    var self = this;
                    var subjects = {};
                    $.each(self.selected_opts, function(i, e) {
                        subjects[e] = subjects[e] ? subjects[e] + 1 : 1;
                    });

                    $.each(this.elective_grps, function(key, grp) {
                        if((grp.selectedid * 1) > 0) {
                            $.each(grp.details, function(key, detail) {
                                if(parseInt(detail.subject_id) ==  parseInt(grp.selectedid)){
                                    subjects[detail.subject_id] = subjects[detail.subject_id] ? subjects[detail.subject_id] + 1 : 1;
                                }
                            });
                        }
                    });

                    $.each(self.subject_preferences, function(i, e) {
                        $.each(e.selectedOpts, function(ii, ee) {
                            subjects[ee.subject_id] = subjects[ee.subject_id] ? subjects[ee.subject_id] + 1 : 1;
                        })
                    });

                    return subjects;
                },

                subject_combinations: function() {
                    var self = this;
                    var combinations = {};

                    var comb = [];
                    if(self.selected_opts && self.selected_opts.length > 0) {
                        comb = [].concat(self.selected_opts);
                    }
                    $.each(this.elective_grps, function(key, grp) {
                        if((grp.selectedid * 1) > 0) {
                            comb.push(grp.selectedid);
                        }
                    });

                    var label = comb.sort().toString();
                    if(! combinations[label]) {
                        combinations[label] = {};
                    }
                    combinations[label]['count'] = 1; 
                    combinations[label]['msg'] = 'Preference: 1'; 

                    $.each(self.subject_preferences, function(i, e) {
                        comb = [];
                        $.each(e.selectedOpts, function(ii, ee) {
                            comb.push(ee.subject_id);
                        })
                        label = comb.sort().toString();
                        if(! combinations[label]) {
                            combinations[label] = {};
                        }
                        combinations[label]['count'] = combinations[label] && combinations[label]['count'] ? combinations[label]['count'] + 1 : 1; 
                        combinations[label]['msg'] = combinations[label] && combinations[label]['msg'] ? combinations[label]['msg'] + ", Preference: " + (i+2) : 'Preference: '+(i+2); 
                    });
                    
                    return combinations;

                }
        
            },

            events: {
                'show-ttt': function (msg) {
                console.log('Shown');
                }
            },

            components: {
                'comp-grps': {
                    template: "#comp-grp-template",
                    props: ['cgrp', 'type','oldSubjects', 'disableSubjects'],
                    data: function() {
                        return {
                        checked: false,
                        };
                    },
                    ready: function() {
                        this.updateChkState();
                    },
                    watch: {
                        "cgrp.selectedid": function() {
                        this.updateChkState();
                        }
                    },
                    methods: {
                        updateChkState: function() {
                            var self = this;
                            if(this.cgrp.selectedid > 0) {
                                this.checked = true;
                                var chks = $('.sub_'+this.cgrp.id);
                                $(chks).each(function(index,value){
                                    if($(this).val() == self.cgrp.selectedid){
                                        $(this).attr('checked',true);
                                    }
                                });
                            }
                        },
                        selected: function(e) {
                            this.checked = true;
                        },
                        unselected: function(e) {
                            if(! this.checked) {
                                $('.sub_'+this.cgrp.id).attr('checked', false);
                            }
                            this.checked = false;
                            this.cgrp.selectedid = 0;
                        },
                    },
                },

                'honour-sub':{
                    template:"#honour-sub-template",
                    props:['preference','list'],
                    data: function() {
                        return {
                        sub_id: 0
                        };
                    },
                    ready: function() {
                        var self = this;
                        console.log(111111111111111111111)
                        var sub = _.findWhere(self.list, { preference: self.preference});
                        if(typeof sub != 'undefined') {
                            self.sub_id = sub.subject_id;
                        }
                    },
                    watch: {
                        list: function(newValue, oldValue) {
                            var self = this;
                            var sub = _.findWhere(self.list, { subject_id: self.sub_id*1});
                            if(typeof sub == 'undefined') {
                                self.sub_id = 0
                            } else {
                                sub.preference = self.preference;
                            }
                            $.each(newValue, function(index, val) {
                                if(val.preference > newValue.length) {
                                val.preference = 0;
                                }
                            });
                        }
                    },

                    methods: {
                        updatePreference: function() {
                        var self = this;
                        $.each(self.list, function(index, sub) {
                            if(sub.preference == self.preference) {
                                sub.preference = 0;
                            }
                            if(sub.subject_id == self.sub_id) {
                                sub.preference = self.preference;
                            }
                        });
                        }
                    },

                    computed:{
                        getList:function(){
                        var self = this;
                            return self.list.filter(function(s){
                                return s.preference == self.preference || s.preference == 0;
                            });
                        }
                    }
                }
            },
        });

    Vue.component('subject-options', subjectOptions);
    </script>
@endpush
