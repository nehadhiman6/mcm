<template id="subject-prefs-template">
<div >
    <div v-if="admForm && admForm.lastyr_rollno == null && admForm.course && admForm.course.class_code =='BAI'" >
        <div v-for="(index,pref) in subject_preferences" style="border-top: 2px solid #2488b7;margin-top: 30px;">
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
                       <div class="row">
                            <div class="col-sm-8 col-sm-offset-2" >
                            <div v-for="(index2,sub) in elective.elective_subjects">
                                <div class="col-sm-12">
                                <label class="checkbox" >
                                    <input 
                                        @change.prevent='selectSubjects($event,sub,index,index2)'
                                        type ="checkbox" 
                                        name = "optional_sub[]" 

                                        {{-- :value = "setSubjectId(sub.subject_id,index)"  --}}
                                        {{-- :disabled = "sub.sub_type == 'C'" --}}
                                        number 
                                        {{-- v-model="pref.selectedOpts.subject_id"  --}}
                                        :class="'subject_'+index+'_'+subject_preferences[index].selected_ele_id+'_'+sub.subject_id"
                                    >
                                    @{{ sub.subject.subject }}      
                                </label>
                                </div>
                            </div>
                            </div>
                      </div>
            
                        <ul class = "" v-if='pref.selected_ele_id == 0 || elective.id == pref.selected_ele_id'>
                         <div class="row">
                            <div class="col-sm-10 col-sm-offset-2" v-for="cgrp in elective.groups">
                                <li>
                                    <div class='form-group'>
                                        <label class="input-group">
                                            <label class="checkbox-inline">
                                                <input 
                                                    type="checkbox"
                                                    {{-- name='grps[@{{ cgrp.id }}]'  --}}
                                                    :class="'subject_group_'+index+'_' + cgrp.id"
                                                    @change='unSelected(index,cgrp)' 
                                                    {{-- v-model='checked' --}}
                                                >
                                                <label class="radio-inline radio-margin" v-for="sub in cgrp.details" >
                                               
                                                    <input 
                                                        type="radio"
                                                        {{-- name="cmp_grp[@{{ cgrp.id }}]'"  --}}
                                                        :class="'grp_subject_'+index+'_' + cgrp.id+'_'+sub.subject_id+' grp_subject_'+index+'_' + cgrp.id"
                                                        {{-- value="@{{ sub.ele_group_id ? sub.subject.id : sub.id }}"  --}}
                                                        {{-- @click.='selected(index,cgrp,sub)' --}}
                                                        @click='selected($event,index,cgrp,sub)'
                                                        {{-- :disabled="subject_wise_counts && subject_wise_counts[sub.subject_id] && subject_wise_counts[sub.subject_id] > 2" --}}
                                                        >
                                                    @{{ sub.ele_group_id ? sub.subject.subject : sub.subject }}
                                                </label>
                                            </label>
                                        </label>
                                    </div>
                                </li>
                            </div>
                        </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group iw-prefrence-btn" v-show="admForm && admForm.lastyr_rollno == null && admForm.course_id == 14">
        <div class="row">
            <div class="col-sm-7 col-sm-offset-5">
                <button class="btn btn-danger mr-2" v-if="subject_preferences.length > 0" @click="removePreferenceRow" type="button">Remove Preference @{{ subject_preferences.length + 1}}</button>
                {!! Form::button('Add Preference',['class' => 'btn btn-success', '@click' => 'addPreferenceRow']) !!}
        </div>
    </div>
    </div>
</div>

</template>

@push('vue-components')
    <script>
        var no = 1000;
        var subjectPrefs = Vue.extend({
            template: '#subject-prefs-template',
            props:['courses','course_id','min_optional','subject_preferences','subject_wise_counts','form_id','admForm','compSub','compGrp','optionalSub','optionalGrp','electives','honoursSubjects','selected_opts','old_honour'],
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
                    var pref_no = 0;
                    if( self.tmp_pref.length > 0){
                        self.tmp_pref.forEach(function(e,i){
                            if(e.preference_no != 1){
                                if(e.selected_ele_id != id || e.preference_no != pref_no) {
                                    self.subject_preferences.push({
                                        admission_id: self.form_id,
                                        selected_ele_id: e.selected_ele_id,
                                        preference_no: e.preference_no,
                                        selectedOpts: []
                                    });
                                }
                                id = e.selected_ele_id;
                                pref_no = e.preference_no;
                            }
                        });

                        self.tmp_pref.forEach(function(e){
                            self.subject_preferences.forEach(function(ele,index){
                                if(ele.selected_ele_id == e.selected_ele_id && ele.preference_no == e.preference_no){
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
                    }

                    

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
                                    var selSubCls = '.subject_'+index+'_'+self.subject_preferences[index].selected_ele_id+'_' + e.subject_id;
                                    $(selSubCls).prop('checked',true);
                                    self.disableComSub(self.subject_preferences[index].selected_ele_id,e.subject_id,index);
                                },500);
                            }
                        });
                    });

                }
            },           

            methods: { 
                disableComSub:function(ele_id,subject_id,index){
                    var self = this;
                    $.each(self.electives, function(key, elective) {
                        if(elective.id == ele_id) {
                            $.each(elective.elective_subjects, function(key1, sub) {
                                if(sub.sub_type == 'C' && sub.subject_id == subject_id) {
                                    var subClas = '.subject_' + index + '_' + ele_id + '_' + subject_id;
                                    setTimeout(function(){
                                        $(subClas).prop('disabled',true);
                                    },500);
                                }
                            });
                        }
                    });
                },

                unSelected: function(index,cgrp) {
                    var self = this;
                    console.log('unSelected',index);

                    // var chks = $('.sub_'+cgrp.id);
                    var chks = $('.grp_subject_'+index+'_'+cgrp.id);
                    console.log('chks:', chks);
                    $(chks).each(function(i,v){
                        $(this).prop('checked',false);
                    });

                    self.subject_preferences[index].selectedOpts.forEach(function(e,key){
                        // cgrp.details.forEach(function(ele){
                            if(e.ele_group_id == cgrp.id){
                                $('.grp_subject_'+index+'_'+cgrp.id+'_'+e.subject_id).prop('checked',false);
                                self.subject_preferences[index].selectedOpts.splice(key,1);
                            }
                        // });
                    });
                    
                    $('.subject_group_'+index+'_'+cgrp.id).prop('checked',false);
                       
                               // }
                    // this.checked = false;
                    // this.cgrp.selectedid = 0;
                },

                selected: function(event,index,cgrp,sub) {
                    // return;
                    var self = this;
                    // console.log('selected',index);
                    // console.log('selected',sub);
                    // console.log('count:', self.subject_wise_counts[sub.subject_id]);

                    if(self.subject_wise_counts && self.subject_wise_counts[sub.subject_id] && self.subject_wise_counts[sub.subject_id] > 2) {
                        this.$nextTick(function() {
                            $(event.target).prop('checked', false);
                        });
                        alert(sub.subject.subject + ": You can not select same subject more than 3 times!");
                        return;
                    }

                    this.checked = true;

                    this.$nextTick(function() {
                        var chks = $('.grp_subject_'+index+'_'+cgrp.id);
                        $(chks).each(function(i,v){
                            // $(this).attr('checked',false);
                            $(this).prop('checked', false)
                        });
                        $('.subject_group_'+index+'_'+cgrp.id).prop('checked',true);
                        $('.grp_subject_'+index+'_'+cgrp.id+'_'+sub.subject_id).prop('checked',true);
                    });
                    // console.log('.sub_'+self.cgrp.subject_id+'_'+self.index);
                    var found = false;

                    self.subject_preferences[index].selectedOpts.every(function(e,key){
                        if(e.ele_group_id == cgrp.id){
                            e.subject_id = sub.subject.id;
                            found = true;
                            return false;
                        }
                        return true;
                    });

                    if(self.subject_preferences[index].selectedOpts.length == 0 || found == false) {
                        self.subject_preferences[index].selectedOpts.push({
                                subject_id: sub.subject.id,
                                admission_id: self.form_id,
                                selected_ele_id: self.subject_preferences[index].selected_ele_id,
                                ele_group_id: cgrp.id,
                                sub_group_id: 0,
                        });
                    }
                },
               
                addPreferenceRow: function(){
                    var self = this;
                                    
                    if(self.subject_preferences.length > 4){
                        alert('Preferences can not be more then 6');
                        return;
                    }

                    var msg = '';
                    self.subject_preferences.forEach(function(e, i) {
                        if(e.selectedOpts.length != self.min_optional){
                            msg += 'Check! Select exactly 3 elective subjects for Preference no. '+ (i + 2) + "\n";
                            // alert('Check ! Minimum subject should not be more or less than 3 for Preference No '+ (i + 2) );
                            // return;
                        }
                    });
                    if(msg.length > 0) {
                            alert(msg);
                            return;
                    }


                    // if(self.subject_preferences.length != 0 && self.subject_preferences[self.subject_preferences.length -1].selectedOpts.length != self.min_optional){
                    //     alert('Check ! Minimum subject should not be more or less than 3 for Preference No '+ (parseInt(self.subject_preferences.length) + 1) );
                    //     return;
                    // }


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

                removePreferenceRow: function() {
                    if(this.subject_preferences.length == 0) {
                        return;
                    }
                    var pref = this.subject_preferences.length - 1;
                    this.subject_preferences.splice(pref, 1);
                },

                selectSubjects(event,sub,index,index2){
                    var self = this;
                    var count = 0;

                    if($(event.target).prop('checked') && self.subject_wise_counts && self.subject_wise_counts[sub.subject_id] && self.subject_wise_counts[sub.subject_id] > 2) {
                        this.$nextTick(function() {
                            $(event.target).prop('checked', false);
                        });
                        alert(sub.subject.subject + ": You can not select same subject more than 3 times!");
                        return;
                    }
                  
                    var elem = '.subject_' + index + '_' + self.subject_preferences[index].selected_ele_id + '_' + sub.subject_id;
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
                                    var subClas = '.subject_' + index + '_' + ele_id + '_' + sub.subject_id;
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