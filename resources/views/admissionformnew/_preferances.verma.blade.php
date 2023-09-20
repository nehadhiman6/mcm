<template id="subject-prefs-template">
    <div v-if="admForm && admForm.lastyr_rollno == null && admForm.course && admForm.course.class_code =='BAI'" >
        <div v-for="(index,pref) in subject_preferences">
            <legend>Preference @{{index+2}}</legend>
            <div v-for="elective in electives"> 
                <div v-show='elective.elective_subjects.length > 0 || elective.groups.length > 0'>
                    <div class="form-group" >
                        <div class='col-sm-12'>
                            <button class='tooltip-btn' @click.prevent='selectSubPrefElective(elective.id,index)'>
                              <span class="tooltiptext">Click this to select subjects from given list</span>
                              <span v-if="elective.id != subject_preferences[index].selected_ele_id">
                                  <i class="glyphicon glyphicon-unchecked"  style="font-size:20px;margin-left:20px;color:black"></i>
                              </span>
                                &nbsp;&nbsp;
                              <span 
                                  v-if="elective.id == subject_preferences[index].selected_ele_id" 
                                  class="glyphicon glyphicon-ok" 
                                  style="font-size:20px;margin-left:10px;;margin-right:10px;color:green" 
                                  aria-hidden="true"
                              ></span>
                              @{{ elective.name }}
                            </button>
                          </div>
                    </div>
    
                    <div v-if="elective.id == subject_preferences[index].selected_ele_id">
                        <div class="col-sm-8 col-sm-offset-2" >
                          <div v-for="(index2,sub) in elective.elective_subjects">
                            <div class="col-sm-12">
                              <label class="checkbox" >
                                  <input 
                                    @change.prevent='selectSubjects(sub,index,index2)'
                                    type ="checkbox" 
                                    name = "optional_sub[]" 

                                    {{-- :value = "setSubjectId(sub.subject_id,index)"  --}}
                                    {{-- :disabled = "sub.sub_type == 'C'" --}}
                                    number 
                                    {{-- v-model="pref.selectedOpts.subject_id"  --}}
                                    :class="'subject_'+subject_preferences[index].selected_ele_id+'_'+sub.subject_id"
                                  >
                                  @{{ sub.subject.subject }}      
                              </label>
                            </div>
                          </div>
                    </div>
        
                    <ul class = "" v-if='pref.selected_ele_id == 0 || elective.id == pref.selected_ele_id'>
                        <div class="col-sm-10 col-sm-offset-2"   v-for="cgrp in elective.groups">
                            <li>
                                <div class='form-group'>
                                    <label class="input-group">
                                        <label class="checkbox-inline">
                                            <input 
                                                type="checkbox"
                                                {{-- name='grps[@{{ cgrp.id }}]'  --}}
                                                :class="'subject_group_'+index+'_' + cgrp.id"                    
                                                @change.prevent='unSelected(index,cgrp)' 
                                                {{-- v-model='checked' --}}
                                            >
                                            <label class="radio-inline radio-margin" v-for="sub in cgrp.details" >
                                            
                                            <input 
                                                type="radio"
                                                {{-- name="cmp_grp[@{{ cgrp.id }}]'"  --}}
                                                :class="'grp_subject_'+index+'_' + cgrp.id+'_'+sub.subject_id"                    
                                                {{-- value="@{{ sub.ele_group_id ? sub.subject.id : sub.id }}"  --}}
                                                {{-- @click.='selected(index,cgrp,sub)' --}}
                                                @click='selected(index,cgrp,sub)'
                                            >
                                            @{{ sub.ele_group_id ? sub.subject.subject : sub.subject }}
                                            </label>
                                        </label>
                                    </label>
                                </div>
                            </li>
                        </div>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group" v-show="admForm && admForm.lastyr_rollno == null && admForm.course && admForm.course.class_code =='BAI'">
      <div class="col-sm-12">
        {!! Form::button('Add Preference',['class' => 'btn btn-success pull-right', '@click' => 'addPreferenceRow']) !!}
      </div>
    </div>
  </div>
</fieldset>
</template>

@push('vue-components')
    <script>
        var no = 1000;
        var subjectPrefs = Vue.extend({
            template: '#subject-prefs-template',
            props:['courses','course_id','min_optional','subject_preferences','form_id','admForm','compSub','compGrp','optionalSub','optionalGrp','electives','honoursSubjects','selected_opts','old_honour'],
            data: function(){
                return {
                    counter: 1,
                    selected_ele_id: 0,
                    sub_count: 1,
                    tmp_pref: [],
                    course_type: "{{$adm_form->course_type}}",
                    //basic
                        response: {},
                        success: false,
                        fails: false,
                        msg: '',
                        errors: [],
                }
            },

            ready: function() {
                var self = this;
                if(self.subject_preferences.length > 0){
                    
                    self.tmp_pref = self.subject_preferences;
                    self.subject_preferences = [];

                    var id = 0;
                    // console.log(tmp_pref.length)
                    if( self.tmp_pref.length > 0){
                            self.tmp_pref.forEach(function(e){
                                if(e.preference_no != 1){
                                if(e.selected_ele_id != id){
                                    self.subject_preferences.push({
                                        admission_id: self.form_id,
                                        selected_ele_id: e.selected_ele_id,
                                        selectedOpts: []
                                    });
                                }
                                id = e.selected_ele_id;
                            }
                        });
                    }

                    self.tmp_pref.forEach(function(e){
                    self.subject_preferences.forEach(function(ele,index){
                        
                        // console.log(e.selected_ele_id, ele.selected_ele_id)
                        if(ele.selected_ele_id == e.selected_ele_id && e.preference_no > 1){
                        ele.selectedOpts.push({
                            subject_id: e.subject_id,
                            admission_id: e.admission_id,
                            selected_ele_id: e.selected_ele_id,
                            ele_group_id: e.ele_group_id,
                            sub_group_id: 0,
                        });
                        }
                    });
                    });

                    self.subject_preferences.forEach(function(ele,index){
                        ele.selectedOpts.forEach(function(e){
                            if(e.ele_group_id > 0){
                                var grpSubClass = '.grp_subject_'+index+'_'+e.ele_group_id+'_'+e.subject_id;
                                var subGrpClass = '.subject_group_'+index+'_'+e.ele_group_id;
                                setTimeout(function(){
                                    $(grpSubClass).prop('checked',true);
                                    $(subGrpClass).prop('checked',true);
                                },500);

                            }else{
                            setTimeout(function(){
                                var selSubCls = '.subject_'+self.subject_preferences[index].selected_ele_id+'_' + e.subject_id;
                                $(selSubCls).prop('checked',true);
                                self.disableComSub(self.subject_preferences[index].selected_ele_id,e.subject_id);
                            },500);
                            }
                        });
                    });

                    }
            },
            
           

            methods: { 
                disableComSub:function(ele_id,subject_id){
                    var self = this;
                    $.each(self.electives, function(key, elective) {
                        if(elective.id == ele_id) {
                            $.each(elective.elective_subjects, function(key1, sub) {
                                if(sub.sub_type == 'C' && sub.subject_id == subject_id) {
                                    var subClas = '.subject_' + ele_id + '_' + subject_id;
                                    setTimeout(function(){
                                        $(subClas).prop('disabled',true);
                                    },500);
                                }
                            });
                        }
                    });
                }  ,
                // checkHonours1: function() {
                //     var self = this;
                //     console.log('checkHonours1');

                //     var max_preference = this.getHonourSubjects.length;
                //     $.each(self.honoursSubjects, function( index, honour ) {
                //         honour.opted = (self.getSelectedSubjects.indexOf(honour.honours_sub_id) > -1);
                //         if(honour.opted == false) {
                //         honour.selected = false;
                //         honour.preference = 0;
                //         }
                //     });
                // },

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

                selectElective1: function(ele_id) {
                    console.log('selectElective1');

                    if(this.selected_ele_id > 0 ){
                        return;
                    }
                    this.selected_ele_id = this.selected_ele_id != ele_id ? ele_id : 0;
                    this.selected_opts = [];
                    var self = this;
                    $.each(this.electives, function(key, elective) {
                        if(elective.id == self.selected_ele_id) {
                        $.each(elective.elective_subjects, function(key1, sub) {
                            console.log(sub);
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
                    self.$http.post("{{ url('courses/subs') }}",{'course_id': self.course_id})
                        .then(function (response) {
                        //$('#').blockUI();
                        self.compSub = response.data['compSub'];
                        self.compGrp = response.data['compGrp'];
                        self.optionalSub = response.data['optionalSub'];
                        self.optionalGrp = response.data['optionalGrp'];
                        self.min_optional = response.data['course'].min_optional;
                        var honoursSubjects = response.data['honours'];
                        $.each(honoursSubjects, function(index, hSub) {
                            hSub.opted = false;
                            hSub.selected = false;
                            hSub.preference = 0;
                        });
                        self.honoursSubjects = honoursSubjects;
                        var electives = response.data.electives;
                        $.each(electives, function(key, elective) {
                            $.each(elective.groups, function(key, grp) {
                            if(typeof grp.selectedid == 'undefined') {
                                grp.selectedid = 0;
                            }
                            });
                        });
                        self.electives = electives;
                        self.showOldStudentSubjects();
                        }, function (response) {
                        $.each(response.data, function(key, val) {
                            self.msg += key+': '+val+' ';
                        });
                    });
                },

                unSelected: function(index,cgrp) {
                    var self = this;
                    console.log('unSelected',index);

                    self.subject_preferences[index].selectedOpts.forEach(function(e,key){
                        cgrp.details.forEach(function(ele){
                            if(e.ele_group_id == cgrp.id){
                                $('.grp_subject_'+index+'_'+cgrp.id+'_'+e.subject_id).prop('checked',false);
                                self.subject_preferences[index].selectedOpts.splice(key,1);
                            }
                        });
                    });
                    
                    $('.subject_group_'+index+'_'+cgrp.id).prop('checked',false);
                       
                               // }
                    // this.checked = false;
                    // this.cgrp.selectedid = 0;
                },

                selected: function(index,cgrp,sub) {
                    var self = this;
                  
                    console.log('selected',index);
                    this.checked = true;
                    $('.subject_group_'+index+'_'+cgrp.id).prop('checked',true);
                    setTimeout(function(){
                        $('.grp_subject_'+index+'_'+cgrp.id+'_'+sub.subject_id).prop('checked',true);
                    },100);

                    // console.log('.sub_'+self.cgrp.subject_id+'_'+self.index);
                    if(self.subject_preferences[index].selectedOpts.length > 0){
                        self.subject_preferences[index].selectedOpts.every(function(e,key){
                            console.log(e.ele_group_id,cgrp.id);
                                if(e.ele_group_id == cgrp.id){
                                    e.subject_id = sub.subject.id;
                                    return false;
                                }else{

                                    self.subject_preferences[index].selectedOpts.push({
                                        subject_id: sub.subject.id,
                                        admission_id: self.form_id,
                                        selected_ele_id: self.subject_preferences[index].selected_ele_id,
                                        ele_group_id: cgrp.id,
                                        sub_group_id: 0,
                                    });
                                    return false;
                                }
                            });
                        }
                    else{
                        self.subject_preferences[index].selectedOpts.push({
                                subject_id: sub.subject.id,
                                admission_id: self.form_id,
                                selected_ele_id: self.subject_preferences[index].selected_ele_id,
                                ele_group_id: cgrp.id,
                                sub_group_id: 0,
                        });
                    }
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
                        self.selectElective1(ele_id);
                        self.selected_opts = selected_opts;
                    }
                    // return ele_grps;
                },
               
                addPreferenceRow: function(){
                    var self = this;
                                    
                    if(self.subject_preferences.length > 3){
                        alert('Preferences can not be more then 5');
                        return;
                    }
                    if(self.subject_preferences.length != 0 && self.subject_preferences[self.subject_preferences.length -1].selectedOpts.length != self.min_optional){
                        alert('Check ! Minimum subject should not be more than and less than 3 for Preference No '+ (parseInt(self.subject_preferences.length) + 1) );
                        return;
                    }


                    try {
                        this.counter++;
                        this.subject_preferences.splice(this.subject_preferences.length + 1, 0, {
                            admission_id: self.form_id,
                            selected_ele_id: 0,
                            selectedOpts: []

                        });
                    } catch (e) {
                        console.log(e);
                    }
                    // }else{
                    //     alert('Kindly select course type and course!!');
                    // }
                },
                selectSubjects(sub,index,index2){
                    var self = this;
                    var count = 0;
                  
                    var elem = '.subject_' + self.subject_preferences[index].selected_ele_id + '_' + sub.subject_id;
                    $(document).on('change', elem, function(e) {
                        if(this.checked &&  count == 0) {
                        self.subject_preferences[index].selectedOpts.push({
                            subject_id: sub.subject_id,
                            admission_id: self.form_id,
                            selected_ele_id: self.subject_preferences[index].selected_ele_id,
                            ele_group_id: 0,
                            sub_group_id: sub.sub ? sub.sub.sub_group_id : 0,
                            });
                        }else if(this.checked == false &&  count == 0){
                            self.subject_preferences[index].selectedOpts.forEach(function(e,key){
                            if(e.subject_id == sub.subject_id)
                                self.subject_preferences[index].selectedOpts.splice(key,1);
                            });
                        };
                        count++;
                    });
                },
                selectSubPrefElective: function(ele_id,index) {
                    var self = this;
                    // if(ele_id == 0 || self.subject_preferences[index].selected_ele_id > 0)
                    //     return;

                    self.subject_preferences[index].selected_ele_id = ele_id;
                    self.subject_preferences[index].selectedOpts = [];
                    self.subject_preferences[index].showSubjects = true;
                    
                    $.each(self.electives, function(key, elective) {
                        if(elective.id == ele_id) {
                            $.each(elective.elective_subjects, function(key1, sub) {
                                if(sub.sub_type == 'C') {
                                    self.subject_preferences[index].selectedOpts.push({
                                        subject_id: sub.subject_id,
                                        admission_id: self.form_id,
                                        selected_ele_id: ele_id,
                                        ele_group_id: 0,
                                        sub_group_id: 0,
                                    });
                                    var subClas = '.subject_' + ele_id + '_' + sub.subject_id;
                                    setTimeout(function(){
                                        $(subClas).prop('checked',true);
                                        $(subClas).prop('disabled',true);
                                    },500);
                                }
                            });
                        }
                    });
                },
            },

            computed: {
        
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
                        if((grp.selectedid * 1) > 0)
                        $.each(grp.details, function(key, detail) {
                            if(parseInt(detail.subject_id) ==  parseInt(grp.selectedid)){
                                selected.push(detail.course_sub_id);
                            }
                        });
                        });
            
                        return selected;
                    },
                    
                    firstYear:function(){
                        if(this.getSelectedCourse && this.getSelectedCourse.course_year && this.getSelectedCourse.course_year == 1 && this.getCourseType == 'GRAD'){
                        return true;
                        }
                        return false;
                    },
        
            },

            events: {
                'show-ttt': function (msg) {
                console.log('Shown');
                }
            },
        });

    Vue.component('subject-prefs', subjectPrefs);
    </script>
@endpush