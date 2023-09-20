
<div class="tab-pane" id="subject_options">
  <fieldset>
    <legend>Subjects/Options</legend>   
      <div class="form-group">
        {!! Form::label('medium','Medium  for Instruction',['class' => 'col-sm-2 control-label required']) !!}
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
    
      <div class='form-group'  v-show = "course_type != 'PGRAD'">
        {!! Form::label('comp_subject','Compulsory Subjects:',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
          
          <span class="control-label" v-for='ss in compSub' >
            @{{ $index+1 }}) @{{ ss.subject }} &nbsp;&nbsp;
          </span>
           
        </div>
      </div>
    
      <div class = "col-lg-offset-2" v-show = "course_type != 'PGRAD'"> Note :HISTORY AND CULTURE OF PUNJAB is only for those who have not studied Punjabi in class X.</div>
          
      <ul class = "">
        <comp-grps v-for="cgrp in compGrp" :old-subjects='old_subjects' :cgrp='cgrp' type='C' :disable-subjects="form_id > 0 && canChangeSubjects == false && getSelectedCourse.course_year > 1">
        </comp-grps>
      </ul>
      {{-- ************************************************************************ --}}
       <div v-bind:class="{ 'has-error': errors['opt_subs_count'] }">
    
      <!-- Elective Options -->
      <div class="col-sm-12" v-if='electives.length > 0'>
        <p>
          <h4><strong>Elective Subjects:</strong></h4><span v-if="min_optional >0 ">A student is required to select <strong>@{{ min_optional}} </strong> electives.</span><br>Choose any one option from the following and select from the given electives</h><br>*Selecting electives here does <b>NOT</b> guarantee its allotment
        </p>
      </div>
      
      <div  v-if="last_exam_mcm =='Y'">
        <div v-for="elective in electives"> 
          <div v-show='elective.elective_subjects.length > 0 || elective.groups.length > 0'>
            <div class="form-group" >
              <div class='col-sm-12'>
                <button class='tooltip-btn' @click.prevent='selectElective(elective.id)'>
                  <span class="tooltiptext">Click this to select subjects from given list</span>
                  <span v-if="elective.id != selected_ele_id" ><i class="glyphicon glyphicon-unchecked"  style="font-size:20px;margin-left:20px;color:black"> </i></span>&nbsp;&nbsp;
                  <span v-if="elective.id == selected_ele_id" class="glyphicon glyphicon-ok" style="font-size:20px;margin-left:10px;;margin-right:10px;color:green" aria-hidden="true"></span>
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
                          <input type="checkbox" name= "optional_sub[]" value= "@{{ sub.subject_id }}" :disabled="(sub.sub_type == 'C' || ((old_subjects.length > 0 || form_id > 0) && canChangeSubjects == false && getSelectedCourse.course_year > 1))" number v-model="selectedOpts" class="">
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
      </div>
      
    
      <div v-else>
        <div v-for="(index,pref) in subject_preferences">
          <fieldset>
          <legend>Preferences @{{index+1}}</legend>
              <div v-for="elective in electives" > 
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
                                :disabled ="(sub.sub_type == 'C' || ((old_subjects.length > 0 || form_id > 0) && canChangeSubjects == false && getSelectedCourse.course_year > 1))" 
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
                    <subject-grps 
                        v-for="cgrp in elective.groups" 
                        :cgrp='cgrp' 
                        :subject-preferences = 'subject_preferences'
                        {{-- :value = "setSubjectGroupId('subject',sub.subject_id,index)"  --}}
                        :old-subjects='old_subjects' 
                        :index = 'index'
                        component-type='preferance_subject'
                        :disable-subjects="form_id > 0 && canChangeSubjects == false && getSelectedCourse.course_year > 1">
                    </subject-grps>
                    {{-- <comp-grps 
                      v-for="(index3,cgrp) in elective.groups" 
                      @click.prevent='selectSubjects("elective",cgrp,index,index3)'
                      :cgrp='cgrp' 
                      :old-subjects='old_subjects' 
                      :type='cgrp.type'
                      :disable-subjects="form_id > 0 && canChangeSubjects == false && getSelectedCourse.course_year > 1">
                    </comp-grps> --}}
                  </ul>
                </div>
    
              </div>
            </div>
          </fieldset>
          {{-- <template id="comp-sub-grp-template" > --}}
            <div class="col-sm-10 col-sm-offset-2">
              <li>
                <div class='form-group'>
                  <label class="input-group">
                    <label class="checkbox-inline" >
                      <input 
                        type="checkbox"  
                        :disabled="oldSubjects.length > 0 || disableSubjects" 
                        name='grps[@{{ cgrp.id }}]' 
                        :class="'subject_group_'+index+'_' + cgrp.id"                    
                        @change='unselected' 
                        v-model='checked'
                      >
                      <label class="radio-inline radio-margin" v-for="sub in cgrp.details" >
                        
                        <input 
                          :disabled="oldSubjects.length > 0 || disableSubjects" 
                          type="radio" 
                          name="cmp_grp[@{{ cgrp.id }}]'" 
                          :class="'grp_subject_'+index+'_' + cgrp.id+'_'+sub.subject_id+' sub_'+cgrp.id"
                          {{-- class="sub_@{{ cgrp.id }}"  --}}
                        {{-- :value = "setSubjectGroupId('sub_group_subject',sub.subject_id,index)"                              --}}
          
                          value="@{{ sub.ele_group_id ? sub.subject.id : sub.id }}" 
                          {{-- v-model="cgrp.selectedid"  --}}
                          @click='selected'
                        >
                        <!--{!! Form::radio('cmp_grp[@{{ cgrp.id }}]',"@{{ sub.id }}" ,null, ['@click'=>'selected', 'class' => 'sub_@{{ cgrp.id }}']) !!}-->
                        @{{ sub.ele_group_id ? sub.subject.subject : sub.subject }}
                      </label>
                    </label>
                  </label>
                  </div>
              </li>
            </div>
          {{-- </template> --}}
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            {!! Form::button('Add Preference',['class' => 'btn btn-success pull-right', '@click' => 'addPreferenceRow']) !!}
          </div>
        </div>
      </div>
    
    
      {{-- **************************************************************************** --}}
      <!-- <div class="form-group">
        <div v-for="sub in old_subjects" class="col-sm-10 col-sm-offset-2">
          <div class="col-sm-12">
            <label class="checkbox">
                    <input type="checkbox" value= "@{{ sub.subject_id }}" disabled checked>
                    @{{ sub.subject }}      
            </label>
          </div>
        </div>
      </div> -->
      <div v-if="getSelectedCourse && getSelectedCourse.course_year != 3 && getSelectedCourse.course_year !=1">
        <h4>Honours Subjects</h4>
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
        
    
        <honour-sub v-for="index in getHonourSubjects.length"
          v-ref:honour
          :preference = "index+1"
          :list.sync = "getHonourSubjects"
        >
        </honour-sub>
      </div>
    
      <h4 v-if="course_type =='GRAD'">Add-on Course (Optional Courses)</h4>
      <div class="form-group" v-if="course_type =='GRAD'">
        {!! Form::label('addon_course_id','Add-On Course',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('addon_course_id',getAddOnCourses(),null,['class' => 'form-control','v-model'=>'addon_course_id']) !!}
        </div>
      </div>
      <div v-if="old_honour.length > 0">
          <h4>Honours Subjects:</h4>
          <p class="form-control-static  col-md-offset-1"><b>@{{old_honour[0].subject}}</b></p>
      </div>
    </fieldset>  
</div>

<div class="tab-pane" id="acedmic_detail">
  <fieldset>
    <legend>Academic Details</legend>
     
      <div class='form-group'>
        {!! Form::label('pu_regno','Panjab Univ. Roll No.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['pu_regno'] }">
          {!! Form::text('pu_regno',null,['class' => 'form-control','v-model'=>'pu_regno',':disabled'=>'firstYear','placeholder'=>'Panjab Univ. Roll No.']) !!}
          <span id="basic-msg" v-if="errors['pu_regno']" class="help-block">@{{ errors['pu_regno'][0] }}</span>
        </div>
        {!! Form::label('pupin_no','Panjab Univ. RegNo/PUPIN NO.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['pupin_no'] }">
          {!! Form::text('pupin_no',null,['class' => 'form-control','v-model'=>'pupin_no',':disabled'=>'firstYear','placeholder'=>'11 digit identification no.(if any)']) !!}
          <span id="basic-msg" v-if="errors['pupin_no']" class="help-block">@{{ errors['pupin_no'][0] }}</span>
        </div>
      </div>
     
      <div class='form-group' v-if="showOcet">
          {!! Form::label('ocet_rollno','O-CET Roll No.',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['ocet_rollno'] }" >
            {!! Form::text('ocet_rollno',null,['class' => 'form-control','v-model'=>'ocet_rollno',':disabled'=>'firstYear','placeholder'=>'O-CET Roll no']) !!}
            
            <span id="basic-msg" v-if="errors['ocet_rollno']" class="help-block">@{{ errors['ocet_rollno'][0] }}</span>
          </div>
      </div>
     
      <span  v-if="showOcet" id="basic-msg" >(O-CET Roll No. is mandatory without which your admission will be cancelled)</span>
      <h4 style="color: #3f576c;"> <strong>Last Exam Appeared for: (Fill Details Here..)</strong></h4>
      <h5>Previous examination results (All Semesters)</h5>
      
      <div class="academics" v-for='acade in acades'>
        <div class='form-group'>
          {!! Form::label('exam','Exams',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['acades.'+$index+'.exam'] }" >
            <select v-model="acade.exam" class="form-control">
              <option v-for="exam in exams" :value="exam">@{{ exam }}</option>
            </select>
          </div>
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['acades.'+$index+'.other_exam'] }">
            <input type="text" v-model='acade.other_exam'  class="form-control" placeholder="Other Equivalent Exam Name" :disabled="acade.exam !== 'Others'"/>
          </div>
          {!! Form::label('institute','Institution',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['acades.'+$index+'.institute'] }">
            <input type="text" v-model='acade.institute'  class="form-control"/>
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('board_id','Board/University',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['acades.'+$index+'.board_id'] }">
            <select v-model="acade.board_id" class="form-control">
              <option v-for="board in boards" :value="board.id">@{{ board.name }}</option>
            </select>
          </div>
          <div class="col-sm-3">
            <input type="text"  v-model='acade.other_board' :disabled="acade.board_id !== 0"  class="form-control" placeholder="Enter Board/University (If Others)"/>
          </div>
          {!! Form::label('inst_state_id','Institution State.',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['acades.'+$index+'.inst_state_id'] }">
            {{-- {!! Form::select('inst_state_id',getStates(),null,['class' => 'form-control','v-model'=>'acade.inst_state_id']) !!} --}}
            <select v-model="acade.inst_state_id" class="form-control">
                <option v-for="(state,key) in states" :value="state">@{{ key }}</option>
              </select>
          </div>
         
        </div>
        <div class='form-group'>
          {!! Form::label('years','Year',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['acades.'+$index+'.year'] }">
            <input type="text"  v-model='acade.year'  class="form-control"/>
          </div>
          {!! Form::label('result','Result',['class' => 'col-sm-1 control-label required']) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['acades.'+$index+'.result'] }">
            <select v-model="acade.result" class="form-control">
              <option v-for="result in results" :value="result">@{{ result }}</option>
            </select>
          </div>
          
          {!! Form::label('reappear_subjects','Reappear Subjects',['class' => 'col-sm-3 control-label required','v-if'=>"acade.result == 'COMPARTMENT'"]) !!}
          <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['acades.'+$index+'.reappear_subjects'] }" v-if="acade.result == 'COMPARTMENT'">
            <input type="text"  :disabled="acade.result != 'COMPARTMENT'"  v-model='acade.reappear_subjects' class="form-control"/>
          </div>
          
        </div>
       
        <div class="form-group">
          
          {!! Form::label('total_marks','Maximum Marks',['class' => 'col-sm-2 control-label','v-bind:class'=>"{ 'required': acade.result == 'PASS' }"]) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['acades.'+$index+'.total_marks'] }">
            <input type="text"  v-model='acade.total_marks'  class="form-control"/>
          </div>
          {!! Form::label('marks_obtained','Marks Scored',['class' => 'col-sm-2 control-label','v-bind:class'=>"{ 'required': acade.result == 'PASS' }"]) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['acades.'+$index+'.marks_obtained'] }">
            <input type="text"  v-model='acade.marks_obtained'  class="form-control"/>
          </div>
          {!! Form::label('marks_per','%age',['class' => 'col-sm-2 control-label','v-bind:class'=>"{ 'required': acade.result == 'PASS' }"]) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['acades.'+$index+'.marks_per'] }">
            <input type="text"  v-model='acade.marks_per'  class="form-control"/>
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('rollno','Roll No.',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-2" v-bind:class="{ 'has-error': errors['acades.'+$index+'.rollno'] }">
              <input type="text"  v-model='acade.rollno'  class="form-control" />
            </div>
        {!! Form::label('division','Division',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['acades.'+$index+'.division'] }">
            <input type="text" v-model='acade.division' class="form-control"/>
          </div>
        </div>
        <div class='form-group'>
        {!! Form::label('subjects','Subjects Studied',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-6" v-bind:class="{ 'has-error': errors['acades.'+$index+'.subjects'] }">
            <input type="text"  v-model='acade.subjects'  class="form-control"/>
          </div>
        </div>
        {!! Form::button('Remove',['class' => 'btn btn-success', '@click.prevent' => 'removeRow($index)','v-if'=>"acade.last_exam == 'N'"]) !!}
      </div>
     
      <div class="form-group">
        <div class="col-sm-12">
          {!! Form::button('Add Another Exam',['class' => 'btn btn-success pull-right', '@click' => 'addRow']) !!}
        </div>
      </div>
     
      <h4 style="color: #3f576c;" v-if="course_type == 'PGRAD'"> <strong>For Postgraduate Students Only:</strong></h4>
      <h5 v-if="course_type == 'PGRAD'">(Details of the Subject in which applying for Masters)</h5>
      
      <div class="academics" v-if="course_type == 'PGRAD'">
        <div class='form-group '>
          {!! Form::label('bechelor_degree','Bachelor Degree',['class' => 'col-sm-2 control-label required']) !!}
          <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.bechelor_degree'] }" >
            <input type="text" v-model='postgraduate.bechelor_degree'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.bechelor_degree']" class="help-block">@{{ errors['postgraduate.bechelor_degree'][0] }}</span>
          </div>
          {!! Form::label('subjects','Subjects',['class' => 'col-sm-1 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['postgraduate.subjects'] }" >
            <input type="text" v-model='postgraduate.subjects'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.subjects']" class="help-block">@{{ errors['postgraduate.subjects'][0] }}</span>
          </div>
          {!! Form::label('percentage','%age',['class' => 'col-sm-1 control-label required']) !!}
          <div class="col-sm-2" v-bind:class="{ 'has-error': errors['postgraduate.percentage'] }" >
            <input type="text" v-model='postgraduate.percentage'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.percentage']" class="help-block">@{{ errors['postgraduate.percentage'][0] }}</span>
          </div>
        </div>
        <div class='form-group'>
            {!! Form::label('marks_obtained','Marks Scored',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.marks_obtained'] }" >
              <input type="text" v-model='postgraduate.marks_obtained'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.marks_obtained']" class="help-block">@{{ errors['postgraduate.marks_obtained'][0] }}</span>
              
            </div>
            {!! Form::label('total_marks','Maximum Marks',['class' => 'col-sm-1 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.total_marks'] }">
              <input type="text" v-model='postgraduate.total_marks'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.total_marks']" class="help-block">@{{ errors['postgraduate.total_marks'][0] }}</span>
            </div>
           
        </div>
        <legend><h5>Honour Subject Details (if any):</h5></legend>
        
        <div class='form-group'>
            {!! Form::label('honour_subject','Honour Subject',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3" >
              <input type="text" v-model='postgraduate.honour_subject'  class="form-control"/>
            </div>
            {!! Form::label('honour_marks','Obtained Marsks',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3" >
              <input type="text" v-model='postgraduate.honour_marks'  class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('honour_total_marks','Maximum Marks',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3" >
              <input type="text" v-model='postgraduate.honour_total_marks'  class="form-control"/>
            </div>
            {!! Form::label('honour_percentage','%age',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2" v-bind:class="{ 'has-error': errors['postgraduate.honour_percentage'] }">
              <input type="text" v-model='postgraduate.honour_percentage'  class="form-control"/>
              <span id="basic-msg" v-if="errors['postgraduate.honour_percentage']" class="help-block">@{{ errors['postgraduate.honour_percentage'][0] }}</span>
            </div>
        </div>
        <legend><h5>Elective Subject(Aggregate of 6 semesters in Subject Applied for):</h5></legend>
        <div class='form-group'>
            {!! Form::label('elective_subject','Elective Subject',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.elective_subject'] }" >
              <input type="text" v-model='postgraduate.elective_subject'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.elective_subject']" class="help-block">@{{ errors['postgraduate.elective_subject'][0] }}</span>
              
            </div>
            {!! Form::label('ele_obtained_marks','Obtained Marks',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.ele_obtained_marks'] }" >
              <input type="text" v-model='postgraduate.ele_obtained_marks'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.ele_obtained_marks']" class="help-block">@{{ errors['postgraduate.ele_obtained_marks'][0] }}</span>
              
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('ele_total_marks','Maximum Marks',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.ele_total_marks'] }" >
              <input type="text" v-model='postgraduate.ele_total_marks'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.ele_total_marks']" class="help-block">@{{ errors['postgraduate.ele_total_marks'][0] }}</span>
              
            </div>
            {!! Form::label('ele_percentage','%age',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['postgraduate.ele_percentage'] }">
              <input type="text" v-model='postgraduate.ele_percentage'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.ele_percentage']" class="help-block">@{{ errors['postgraduate.ele_percentage'][0] }}</span>
              
            </div>
        </div>
        <span v-if="lastyr_rollno != ''" ><h5>Old Student Seeking Admission in Semester III:</h5></span>
        <legend v-if="lastyr_rollno != ''"><h5><strong>&nbsp;&nbsp;&nbsp;&nbsp;PG Semester I :</strong></h5></legend>
        <div class='form-group' v-if="lastyr_rollno != ''">
            {!! Form::label('pg_sem1_subject','Subject',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem1_subject'] }">
              <input type="text" v-model='postgraduate.pg_sem1_subject'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem1_subject']" class="help-block">@{{ errors['postgraduate.pg_sem1_subject'][0] }}</span>
              
            </div>
            {!! Form::label('pg_sem1_obtained_marks','Obtained Marks',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem1_obtained_marks'] }" >
              <input type="text" v-model='postgraduate.pg_sem1_obtained_marks'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem1_obtained_marks']" class="help-block">@{{ errors['postgraduate.pg_sem1_obtained_marks'][0] }}</span>
              
            </div>
        </div>
        <div class="form-group" v-if="lastyr_rollno != ''">
            {!! Form::label('pg_sem1_total_marks','Maximum Marks',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem1_total_marks'] }">
              <input type="text" v-model='postgraduate.pg_sem1_total_marks'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem1_total_marks']" class="help-block">@{{ errors['postgraduate.pg_sem1_total_marks'][0] }}</span>
              
            </div>
            {!! Form::label('pg_sem1_percentage','%age',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['postgraduate.pg_sem1_percentage'] }" >
              <input type="text" v-model='postgraduate.pg_sem1_percentage'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem1_percentage']" class="help-block">@{{ errors['postgraduate.pg_sem1_percentage'][0] }}</span>
              
            </div>
        </div>
        <legend v-if="lastyr_rollno != ''" ><h5><strong>&nbsp;&nbsp;&nbsp;&nbsp;PG Semester II :</strong></h5></legend>
        <div class='form-group' v-if="lastyr_rollno != ''">
            {!! Form::label('pg_sem2_result','Result',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem2_result'] }" >
            <select v-model="postgraduate.pg_sem2_result" class="form-control">
              <option v-for="result in results" :value="result">@{{ result }}</option>
            </select>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem2_result']" class="help-block">@{{ errors['postgraduate.pg_sem2_result'][0] }}</span>
            </div>
        </div>
        <div class='form-group' v-if="lastyr_rollno != ''">
            {!! Form::label('pg_sem2_subject','Subject',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem2_subject'] }" >
              <input type="text" v-model='postgraduate.pg_sem2_subject'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem2_subject']" class="help-block">@{{ errors['postgraduate.pg_sem2_subject'][0] }}</span>
            </div>
            {!! Form::label('pg_sem2_obtained_marks','Obtained Marks',['class' => 'col-sm-2 control-label ','v-bind:class'=>"{ 'required': postgraduate.pg_sem2_result == 'PASS' }"]) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem2_obtained_marks'] }">
              <input type="text" v-model='postgraduate.pg_sem2_obtained_marks'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem2_obtained_marks']" class="help-block">@{{ errors['postgraduate.pg_sem2_obtained_marks'][0] }}</span>
              
            </div>
        </div>
        <div class="form-group"  v-if="lastyr_rollno != ''">
            {!! Form::label('pg_sem2_total_marks','Maximum Marks',['class' => 'col-sm-2 control-label ','v-bind:class'=>"{ 'required': postgraduate.pg_sem2_result == 'PASS' }"]) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem2_total_marks'] }">
              <input type="text" v-model='postgraduate.pg_sem2_total_marks'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem2_total_marks']" class="help-block">@{{ errors['postgraduate.pg_sem2_total_marks'][0] }}</span>
              
            </div>
            {!! Form::label('pg_sem2_percentage','%age',['class' => 'col-sm-2 control-label ','v-bind:class'=>"{ 'required': postgraduate.pg_sem2_result == 'PASS' }"]) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem2_percentage'] }">
              <input type="text" v-model='postgraduate.pg_sem2_percentage'  class="form-control"/>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem2_percentage']" class="help-block">@{{ errors['postgraduate.pg_sem2_percentage'][0] }}</span>
              
            </div>
        </div>
     </div>
    
      
      <div class='form-group'>
        {!! Form::label('gap_year','Mention Gap Year (if any, submit two copies in original)',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::text('gap_year',null,['class' => 'form-control','v-model'=>'gap_year']) !!}
        </div>
      </div>
      <!-- <div class='form-group'>
        {!! Form::label('org_migrate','Original Migration Certificate Attached?',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-1 checkbox-inline">
          <input type="checkbox" name="org_migrate" v-model='org_migrate' v-bind:true-value="'Y'"
                 v-bind:false-value="'N'" class="minimal">
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('migrated','Are You Migrating From Other College Or University?If Yes Give Details..',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-1 checkbox-inline">
          <input type="checkbox" name="migrated"  v-model='migrated' v-bind:true-value="'Y'"
                 v-bind:false-value="'N'" class="minimal" />
        </div>
      </div> -->
      <div class="form-group" v-if="migrated == 'Y'">
        <div class="col-sm-7 col-sm-offset-4" v-bind:class="{ 'has-error': errors['migrate_detail'] }">
          {!! Form::textarea('migrate_detail', null, ['size' => '30x3' ,'class' => 'form-control','v-model' => 'migrate_detail','placeholder'=>'Write Details Here...']) !!}
          <span id="basic-msg" v-if="errors['migrate_detail']" class="help-block">@{{ errors['migrate_detail'][0] }}</span>
        </div>
      </div>
    
      <div class='form-group'>
        {!! Form::label('disqualified','Have you ever been disqualified by any Board/Body/Council/University. If yes, give detail',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-1">
          <label class="col-sm-1 checkbox">
          <input type="checkbox" name="disqualified"  v-model='disqualified' v-bind:true-value="'Y'"
                 v-bind:false-value="'N'" class="minimal" />
         </label>
        </div>
      </div>
    
      <div class="form-group" v-if="disqualified == 'Y'">
        <div class="col-sm-7 col-sm-offset-4" v-bind:class="{ 'has-error': errors['disqualify_detail'] }">
          {!! Form::textarea('disqualify_detail', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'disqualify_detail','placeholder'=>'Write Details Here...']) !!}
          <span id="basic-msg" v-if="errors['disqualify_detail']" class="help-block">@{{ errors['disqualify_detail'][0] }}</span>
        </div>
      </div>
    
      <div class='form-group'>
        {!! Form::label('spl_achieve','Special Achievements(National/International Level):',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-2">
          <label class="col-sm-2 checkbox">
            <input type="checkbox" name="sports"  v-model='sports' v-bind:true-value="'Y'"
                   v-bind:false-value="'N'" class="minimal" />
            Sports
          </label>
        </div>
        <div class="col-sm-2">
          <label class="col-sm-2 checkbox">
            <input type="checkbox" name="cultural" v-model='cultural' class="minimal" v-bind:true-value="'Y'"
                   v-bind:false-value="'N'"/>
            Cultural
          </label>
        </div>
        <div class="col-sm-2">
          <label class="col-sm-2 checkbox">
            <input type="checkbox" name="academic" v-model='academic' class="minimal" v-bind:true-value="'Y'"
                   v-bind:false-value="'N'"/>
            Academic
          </label>
        </div>
        <div v-if="academic == 'Y' || cultural == 'Y' || sports == 'Y'" class="col-sm-12" v-bind:class="{ 'has-error': errors['spl_achieve'] }">
          {!! Form::label('spl_achieve','Please Specify Achievements:',['class' => 'col-sm-4 control-label required']) !!}
          <div class="col-sm-6">
            {!! Form::textarea('spl_achieve',null,['size' => '50x2','class' => 'form-control','v-model'=>'spl_achieve']) !!}
          </div>
          <span id="basic-msg" v-if="errors['spl_achieve']" class="help-block">@{{ errors['spl_achieve'][0] }}</span>
        </div>
      </div>
    
    </fieldset>
</div>

<div class="tab-pane" id="hostel">
  <fieldset >
    <legend>Hostel</legend>
      <div class="form-group"  v-if="hostel == 'Y'">
        <div class="col-sm-7">
          <p class= "control-label"><b>Note :Hostel seat allotment is subject to the filling of hostel form and availability of seats.</b></p>
        </div>
      </div>
      <div class='form-group'>
        {!! Form::label('hostel','Seeking Hostel Seat',['class' => 'col-sm-2 control-label','v-if'=>"getSelectedCourse && getSelectedCourse.course_year == '1'"]) !!}
        {!! Form::label('hostel','Applied for Hostel',['class' => 'col-sm-2 control-label','v-else']) !!}
        <div class="col-sm-1">
          <label class="col-sm-1 checkbox">
            <input type="checkbox" name="hostel" v-model = 'hostel' value='Y' class="minimal" v-bind:true-value="'Y'"
                  v-bind:false-value="'N'">
          </label>
        </div>
      </div>
      <div class='form-group' v-if="hostel == 'Y'">
          {!! Form::label('schedule_backward_tribe','Do you belong to Scheduled Caste/Schedule Tribe/Backward Class?',['class' => 'col-sm-6 control-label required']) !!}
          <div class="col-sm-3" v-bind:class="{ 'has-error': errors['schedule_backward_tribe'] }">
            <label class="radio-inline">
              {!! Form::radio('schedule_backward_tribe', 'Y',null, ['class' => 'minimal','v-model'=>'hostel_data.schedule_backward_tribe']) !!}
              Yes
            </label>
            <label class="radio-inline">
              {!! Form::radio('schedule_backward_tribe', 'N',null, ['class' => 'minimal','v-model'=>'hostel_data.schedule_backward_tribe']) !!}
              No
            </label>
            <span id="basic-msg" v-if="errors['schedule_backward_tribe']" class="help-block">@{{ errors['schedule_backward_tribe'][0] }}</span>
          </div>
      </div>
      <div class="form-group" v-if="hostel == 'Y'">
        {!! Form::label('serious_ailment','If you have any serious ailment, give details',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-4">
          {!! Form::textarea('serious_ailment',null,['size' => '30x2','class' => 'form-control','v-model'=>'hostel_data.serious_ailment']) !!}
        </div>
      </div>
      <div class="form-group" v-if="hostel == 'Y'">
        {!! Form::label('hostel_data','If you were in hostel of this college earlier, give particulars:',['class' => 'col-sm-5 control-label']) !!}
      </div>
      <div class="form-group" v-if="hostel == 'Y'">
        {!! Form::label('prv_hostel_block','Hostel Block',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('prv_hostel_block',null,['class' => 'form-control','v-model'=>'hostel_data.prv_hostel_block']) !!}
        </div>
        {!! Form::label('prv_room_no','Room No.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('prv_room_no',null,['class' => 'form-control','v-model'=>'hostel_data.prv_room_no']) !!}
        </div>
      </div>
      <div class="form-group" v-if="hostel == 'Y'">
        {!! Form::label('prv_class','Class',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('prv_class',null,['class' => 'form-control','v-model'=>'hostel_data.prv_class']) !!}
        </div>
        {!! Form::label('prv_roll_no','Roll No.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('prv_roll_no',null,['class' => 'form-control','v-model'=>'hostel_data.prv_roll_no']) !!}
        </div>
      </div>
  </fieldset>
  
</div>

<div class="tab-pane" id="foreign_migration_alumni">
  <fieldset v-if="foreign_national == 'Y'">
    <legend>For Foreign Students Only</legend>
    <div class='form-group'>
      {!! Form::label('foreign_national','Foreign National',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-1 checkbox-inline">
        <input type="checkbox" disabled readonly name="foreign_national"  v-model='foreign_national' 
               v-bind:true-value="'Y'"
               v-bind:false-value="'N'"
               class="minimal" />
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('icssr_sponser','ICSSR Sponser',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-4 " v-bind:class="{ 'has-error': errors['icssr_sponser'] }">
          <label class="radio-inline">
            {!! Form::radio('icssr_sponser', 'Y',null, ['class' => 'minimal','v-model'=>'icssr_sponser']) !!}
            Yes
          </label>
          <label class="radio-inline">
            {!! Form::radio('icssr_sponser', 'N',null, ['class' => 'minimal','v-model'=>'icssr_sponser']) !!}
            No
          </label>
          <span id="basic-msg" v-if="errors['icssr_sponser']" class="help-block">@{{ errors['icssr_sponser'][0] }}</span>
        </div>
    </div>
    <div class="form-group">
      {!! Form::label('equivalence_certificate', 'Equivalence Certificate',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-4 " v-bind:class="{ 'has-error': errors['equivalence_certificate'] }">
          <label class="radio-inline">
            {!! Form::radio('equivalence_certificate', 'Y',null, ['class' => 'minimal','v-model'=>'equivalence_certificate']) !!}
            Yes
          </label>
          <label class="radio-inline">
            {!! Form::radio('equivalence_certificate', 'N',null, ['class' => 'minimal','v-model'=>'equivalence_certificate']) !!}
            No
          </label>
          <span id="basic-msg" v-if="errors['equivalence_certificate']" class="help-block">@{{ errors['equivalence_certificate'][0] }}</span>
        </div>
    </div>
    <div class='form-group'>
      <!--    {!! Form::label('f_nationality','Nationality',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::text('f_nationality',null,['class' => 'form-control','v-model'=>'f_nationality']) !!}
      </div>-->
      {!! Form::label('passportno','Passport No.',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['passportno'] }">
        {!! Form::text('passportno',null,['class' => 'form-control','v-model'=>'passportno']) !!}
        <span id="basic-msg" v-if="errors['passportno']" class="help-block">@{{ errors['passportno'][0] }}</span>
      </div>
      {!! Form::label('passport_validity','Passport Valid upto',['class' => '  col-sm-2 control-label']) !!}
      <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['passport_validity'] }">
        {!! Form::text('passport_validity',null,['class' => 'app-datepicker form-control','v-model'=>'passport_validity']) !!}
        <span id="basic-msg" v-if="errors['passport_validity']" class="help-block">@{{ errors['passport_validity'][0] }}</span>
      </div>
    </div>
    <div class='form-group'>
      {!! Form::label('visa','Visa No.',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['visa'] }">
        {!! Form::text('visa',null,['class' => 'form-control','v-model'=>'visa']) !!}
        <span id="basic-msg" v-if="errors['visa']" class="help-block">@{{ errors['visa'][0] }}</span>
      </div>
      {!! Form::label('visa_validity','Visa Valid upto',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['visa_validity'] }">
        {!! Form::text('visa_validity',null,['class' => 'app-datepicker form-control','v-model'=>'visa_validity']) !!}
        <span id="basic-msg" v-if="errors['visa_validity']" class="help-block">@{{ errors['visa_validity'][0] }}</span>
      </div>
    </div>
    <div class='form-group'>
      {!! Form::label('res_permit','Resident Permit',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::text('res_permit',null,['class' => 'form-control','v-model'=>'res_permit']) !!}
      </div>
      {!! Form::label('res_validity','Resident Permit Valid upto',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::text('res_validity',null,['class' => ' app-datepicker form-control','v-model'=>'res_validity']) !!}
      </div>
    </div>
    
    <div class="row">
      <div class="col-lg-7 "><strong>Please Attach Copy Of Passport And Eligibility Certificate From Punjab University.</strong>
      </div>
    </div>
  </fieldset>
  <fieldset>
    <legend>For Migration Cases Only</legend>
      {!! Form::label('migration','Migration',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-1">
          <label class="checkbox">
            <input type="checkbox" name="migration" v-model = 'migration' value='Y' class="minimal" v-bind:true-value="'Y'"
                  v-bind:false-value="'N'">
          </label>
        </div>
      <div v-if="migration == 'Y'">
        <div class="col-sm-12">
        {!! Form::label('migration_certificate','Migrartion certificate',['class' => 'col-sm-2 control-label']) !!}
        <label class="radio-inline">
            {!! Form::radio('migration_certificate', 'A',null, ['class' => 'minimal','v-model'=>'migration_certificate']) !!}
            Attached
          </label>
          <label class="radio-inline">
            {!! Form::radio('migration_certificate', 'W',null, ['class' => 'minimal','v-model'=>'migration_certificate']) !!}
          Awaited
          </label>
        </div>
          {!! Form::label('migrate_from','Former Board/University',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('migrate_from',null,['class' => 'form-control','v-model'=>'migrate_from']) !!}
        </div>
        {!! Form::label('migrate_deficient_sub','Deficient Subject(s)(if Any)',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
          {!! Form::text('migrate_deficient_sub',null,['class' => 'form-control','v-model'=>'migrate_deficient_sub']) !!}
        </div>
        <div class="col-sm-12">
          <p><br>
            <b>Note:-Original copy of migration to be submitted to the college by October 15,2019.</b><br>
                In case of deficient subjects you have to clear the subjects within the permissible chances.
          </p>
        </div>
      </div>
  </fieldset>

  <fieldset >
    <legend>Alumni</legend>
    (Ex-Student of MCM DAV)
    <div class='form-group'>
      {!! Form::label('alumani','Do you know any Ex-student of this College?',['class' => 'col-sm-4 control-label']) !!}
      <label class="radio-inline">
          {!! Form::radio('know_alumani', 'Y',null, ['class' => 'minimal','v-model'=>'know_alumani']) !!}
          yes
        </label>
        <label class="radio-inline">
          {!! Form::radio('know_alumani', 'N',null, ['class' => 'minimal','v-model'=>'know_alumani']) !!}
          No
        </label>
      </div>
  
      <div  v-if="know_alumani == 'Y'">
        <div class='form-group' >
          {!! Form::label('','Name',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('',null,['class' => 'form-control','v-model'=>'alumani.name']) !!}
            </div>
            {!! Form::label('passing_year','Year of passing',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! Form::text('',null,['class' => 'form-control','v-model'=>'alumani.passing_year']) !!}
            </div>
        </div>
        <div class='form-group'>
          {!! Form::label('occupation','Occupation',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
            {!! Form::text('occupation',null,['class' => 'form-control','v-model'=>'alumani.occupation']) !!}
          </div>
          {!! Form::label('designation','Designation',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
            {!! Form::text('designation',null,['class' => 'form-control','v-model'=>'alumani.designation']) !!}
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('contact','Contact',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
            {!! Form::text('contact',null,['class' => 'form-control','v-model'=>'alumani.contact']) !!}
          </div>
          {!! Form::label('email','Email',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
            {!! Form::text('email',null,['class' => 'form-control','v-model'=>'alumani.email']) !!}
          </div>
        </div>
        <div class='form-group'>
          {!! Form::label('others','Any Other Information',['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-7">
          {!! Form::textarea('others', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'alumani.other']) !!}
          </div>
        </div>
      </div>
  </fieldset>
</div>

<div class="tab-pane" id="declaration">
  @include('admissionform.terms_conditions')
</div>

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
      <select class="form-control" v-model="sub_id" @change="updatePreference">
        <option value="0">Select</option>
        <option v-for="(local_index, honour_sub) in getList" value="@{{honour_sub.subject_id}}">@{{ honour_sub.subject.subject }}</option>
      </select>
    </div>
  </div>
</template>

@section('script')
<script>
  $(document).ready(function () {
      $("#add_attachment").click(function () {
          $("#attach").show();
      });
  });
 var no = 1000;
 var vm = new Vue({
    el: '#app',
    data: {
      counter: 1,
      instructions:'N', // should be N later
      last_exam_mcm:'{{ strlen(trim($adm_form->lastyr_rollno)) > 0 ? 'Y' : 'N' }}',
      lastyr_rollno:'{{ $adm_form->lastyr_rollno }}',
      same_address: "{{ $adm_form->same_address == 'Y' ? 'Y' : 'N' }}",
      form_id: {{ $adm_form->id or 0 }},
      app_guard: "{{ isset($guard) ? $guard : '' }}",
      manual_formno: '',
      form_not_editable: {{ $adm_form->std_id > 0 ? 'false' : 'true' }},  //for dob only 
      cat_id: 0,
      foreigner: false,
      resvcat_id: 0,
      other_religion:'',
      dob: '',
      loc_cat: '',
      geo_cat: '',
      nationality: '',
      religion: 'NA',
      name: '',
      mobile: '',
      aadhar_no: '',
      epic_no:'',
      father_name: "{{ $adm_form->father_name }}", 
      father_email:'',
      mother_name: '',
      guardian_name: '',
      mother_email:'',
      boarder:'',
      conveyance:'',
      veh_no:'',
      sports_seat:"{{ $adm_form->sports_seat == 'Y' ? 'Y' : 'N' }}",
      sport_name:'',
      medium:"",
      blood_grp: '',
      per_address: '',
      city: '',
      state_id: 0,
      pincode: '',
      corr_address: '',
      corr_city: '',
      corr_state_id: 0,
      corr_pincode: '',
      migration: "{{ $adm_form->migration == 'Y' ? 'Y' : 'N' }}" ,
      gender: '',
      hostel: "{{ $adm_form->hostel == 'Y' ? 'Y' : 'N' }}",
      father_occup: '',
      mother_occup: '',
      father_desig: '',
      mother_desig: '',
      father_phone: '',
      mother_phone: '',
      father_mobile: '',
      mother_mobile: '',
      f_office_addr: '',
      m_office_addr: '',
      guardian_occup: '',
      guardian_desig: '',
      guardian_phone: '',
      g_office_addr: '',
      guardian_mobile: '',
      annual_income: '',
      pu_regno: '', // PU reg no and PUPIn  both are same. we are not changing migration but use this field as roll_no
      pupin_no: '',
      ocet_rollno:'',
      gap_year: '',
      org_migrate: "{{ $adm_form->org_migrate == 'Y' ? 'Y' : 'N' }}" ,
      migrated: "{{ $adm_form->migrated == 'Y' ? 'Y' : 'N' }}",
      disqualified: "{{ $adm_form->disqualified == 'Y' ? 'Y' : 'N' }}",
      foreign_national: "{{ $adm_form->foreign_national == 'Y' ? 'Y' : 'N' }}",
      migrate_detail: '',
      disqualify_detail: '',
      gap_year: '',
      sports: "{{ $adm_form->sports == 'Y' ? 'Y' : 'N' }}",
      cultural: "{{ $adm_form->cultural == 'Y' ? 'Y' : 'N' }}",
      academic: "{{ $adm_form->academic == 'Y' ? 'Y' : 'N' }}",
      f_nationality: '',
      passportno: '',
      passport_validity:'',
      visa: '',
      visa_validity:'',
      res_validity:'',
      res_permit: '',
      terms_conditions: "@if(isset($guard) && $guard == 'web') {{'Y'}} @elseif($adm_form->terms_conditions == 'Y') {{'Y'}} @else {{'N'}} @endif".trim(),
      response: {},
      success: false,
      fails: false,
      msg: '',
      errors: [],
      compSub: {!! isset($compSubs) ? json_encode($compSubs) : '{}' !!},
      compGrp: {!! isset($compGrps) ? json_encode($compGrps) : '{}' !!},
      optionalSub: {!! isset($optionalSubs) ? json_encode($optionalSubs) : '{}' !!},
      optionalGrp: {!! isset($optionalGrps) ? json_encode($optionalGrps) : '{}' !!},
      electives: {!! isset($electives) ? json_encode($electives) : '{}' !!},
      honoursSubjects: {!! isset($honoursSubjects) ? json_encode($honoursSubjects) : '[]' !!},
      selected_ele_id: {{ $adm_form->selected_ele_id or 0}},
      selectedOpts: {!! isset($selectedOpts) ? json_encode($selectedOpts) : '[]' !!},
      course_id: {{ intval($adm_form->course_id) }},
      course_code: "{!! isset($course) ? $course->class_code : '' !!}",
      courses: {!! getCoursesForAdmForm(false) !!},
      min_optional: "{!! isset($course) ? $course->min_optional : '' !!}",
      amy:{!! json_encode($adm_form->academics) !!},
      acades: {!! $adm_form->academics->count() > 0 ? json_encode($adm_form->academics) : "[{exam: '',other_exam:'', last_exam: 'Y', institute: '', board_id: 0, rollno: '', year: '', result: '',total_marks: '',marks_obtained: '' , marks_per: '', subjects: '', other_board: '',reappear_subjects:'',division:'',inst_state_id:0}]" !!},
      boards: {!! getBoardlist(true) !!},
      exams: {!! getAcademicExam(true) !!},
      results: {!! resultType(true) !!},
      admitUrl: "{{ isset($guard) && $guard == 'web' ? url('admission-form') : url('admforms') }}",
      course_type: "",
      migration_certificate:"{{ $adm_form->migration_certificate == 'W' ? 'W' : 'A' }}",
      migrate_from:'',
      migrate_deficient_sub:'',
      know_alumani:"{!! isset($adm_form->alumani) ? 'Y': 'N' !!}",
      alumani: {!! isset($alumani) ? json_encode($alumani) : " {name:'',passing_year:'',occupation:'', designation:'', contact:'', email:'', other:'' }" !!},
      minority:"{{ $adm_form->minority == 'Y' ? 'Y' : 'N' }}",
      differently_abled:"{{ $adm_form->differently_abled == 'Y' ? 'Y' : 'N' }}",
      remarks_diff_abled:'',
      epic_card:"{{ isset($adm_form->epic_card)? ($adm_form->epic_card == 'Y' ? 'Y' : 'N') : 'Y' }}",
      adhar_card:"{{ isset($adm_form->adhar_card) ? ($adm_form->adhar_card == 'Y' ? 'Y' : 'N') :'Y'  }}",
      spl_remarks:'',
      spl_achieve:'',
      punjabi_tenth : "{{ $adm_form->punjabi_in_tenth }}",
      punjabi_in_tenth:"",
      disable_pbi_in_tenth: false,
      reservedcatList:[],
      belongs_bpl:"{{ $adm_form->belongs_bpl == 'Y' ? 'Y' : 'N' }}",
      schedule_backward_tribe:"{{ $adm_form->schedule_backward_tribe == 'Y' ? 'Y' : 'N' }}",
      icssr_sponser:"{{ $adm_form->icssr_sponser == 'Y' ? 'Y' : 'N' }}",
      equivalence_certificate:"{{ $adm_form->equivalence_certificate == 'Y' ? 'Y' : 'N' }}",
      father_address:'',
      mother_address:'',
      guardian_address:'',
      guardian_relationship:'',
      serious_ailment:'',
      guardian_email:'',
      hostel_data: {!! isset($hostel_data) ? json_encode($hostel_data) : " {serious_ailment:'',prv_hostel_block:'',prv_room_no:'', prv_class:'', prv_roll_no:'',schedule_backward_tribe:'N'}" !!},
      old_subjects: [],
      addon_course_id:'',
      oldstudentDetails:{
         name: false,
         mother_name: false,
         father_name: false,
         course_id: false,
         dob: false
      },
      states:{!! json_encode(getStates())!!},
      postgraduate:{!! isset($becholor_degree_details) ? json_encode($becholor_degree_details) : "{ bechelor_degree:'',subjects:'', marks_obtained:'', total_marks:'',percentage:'',honour_subject:'',honour_marks:'',honour_total_marks:'',honour_percentage:'',elective_subject:'',ele_obtained_marks:'', ele_total_marks:'',ele_percentage:'',pg_sem1_subject:'',pg_sem1_obtained_marks:'',pg_sem1_total_marks:'',pg_sem1_percentage:'',pg_sem2_result: '' , pg_sem2_subject:'', pg_sem2_obtained_marks:'',pg_sem2_total_marks:'',pg_sem2_percentage:''}" !!},
      // matchedHonours :[],
      old_honour:{!! isset($old_hon_sub) ? json_encode($old_hon_sub) : '{}' !!},
      proceed:false ,
      subject_preferences: {!! $adm_form->AdmissionSubPreference ? json_encode($adm_form->AdmissionSubPreference) : "[]" !!},
     // same_addr: ''
    },
    ready: function() {
        var self = this;
        this.boards.unshift({ id: '', name: 'Select' });
        this.boards.push({ id: 0, name: 'Others' });
        this.isForeignNational();
        // if(this.punjabi_tenth == 'Y'){
        //   this.punjabi_in_tenth = 'Y';
        // }
        // else if(this.punjabi_tenth == 'Y'){
        //   this.punjabi_in_tenth = 'N';
        // }
        // else{
        //   this.punjabi_in_tenth = '';
        // }
        this.punjabi_in_tenth = this.punjabi_tenth;
        this.checkHonours();
        if(this.form_id > 0) {
          if(this.canChangeSubjects == false) {
            this.disable_pbi_in_tenth = true;
          }
          if (this.lastyr_rollno.trim().length > 0) {
            this.oldstudentDetails.name = self.name.trim().length > 0;
            this.oldstudentDetails.mother_name = self.mother_name.trim().length > 0;
            this.oldstudentDetails.father_name = self.father_name.trim().length > 0;
            this.oldstudentDetails.course_id = self.course_id && self.course_id > 0;
            this.oldstudentDetails.dob = self.dob.trim().length > 0;
          }
        }

        if(self.last_exam_mcm == 'N' &&  self.subject_preferences.length > 0){

        var tmp_pref = self.subject_preferences;
        self.subject_preferences = [];
        var id = 0;
        // console.log(tmp_pref.length)
        if(tmp_pref.length > 0){
          tmp_pref.forEach(function(e){
            if(e.selected_ele_id != id){
              self.subject_preferences.push({
                admission_id: self.form_id,
                selected_ele_id: e.selected_ele_id,
                selectedOpts: []
              });
            }
            id = e.selected_ele_id;
          });
        }

        tmp_pref.forEach(function(e){
          self.subject_preferences.forEach(function(ele,index){
            // console.log(e.selected_ele_id, ele.selected_ele_id)
            if(ele.selected_ele_id == e.selected_ele_id){
              ele.selectedOpts.push({
                  subject_id: e.subject_id,
                  admission_id: e.admission_id,
                  selected_ele_id: e.selected_ele_id,
                  ele_group_id: e.ele_group_id,
                  sub_group_id: e.sub_group_id,
              });
            }
          });
        });

          self.subject_preferences.forEach(function(ele,index){
            ele.selectedOpts.forEach(function(e){
                if(e.sub_group_id > 0){
                  setTimeout(function(){
                      console.log('grouped subjects')
                      $('.subject_group_'+e.sub_group_id).prop('checked',true);
                      $('.grp_subject_'+e.sub_group_id+'_'+e.subject_id).prop('checked',true);
                  },500);
                }else{
                  setTimeout(function(){
                    $('.subject_'+self.subject_preferences[index].selected_ele_id+'_' + e.subject_id).prop('checked',true);
                },500);
                }
            });
          });

        }
    },
    watch:{
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
        selectedOpts: function() {
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
            var hcp = ''
            if(this.compGrp != ''){
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
      //subject preferances methods
      addPreferenceRow: function(){
            var self = this;
            if(self.subject_preferences.length > 4){
              alert('Preferences can not be more then 5');
              return;
            }
            if((self.course_type == 'GRAD' || self.course_type == 'PGRAD')&& self.course_id > 0 ){

              try {
              this.counter++;
              this.subject_preferences.splice(this.acades.length + 1, 0, {
                admission_id: self.form_id,
                selected_ele_id: 0,
                selectedOpts: []

              });
            } catch (e) {
              console.log(e);
            }
          }else{
            alert('Kindly select course type and course!!');
          }
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
        console.log(ele_id);
        var self = this;
        if((ele_id > 0 || self.subject_preferences[index].selected_ele_id > 0) && this.old_subjects.length > 0)
          return;

        self.subject_preferences[index].selected_ele_id = ele_id;
        self.subject_preferences[index].selectedOpts = [];
        self.subject_preferences[index].showSubjects = true;
      },

      //subject prefernace methods
     
      annualIncomeChanged:function(){
          if(this.annual_income == 'below 2 lac'){
            this.belongs_bpl  = 'Y'
            return;
          }
          this.belongs_bpl = 'N';

      },
      checkHonours: function() {
        var self = this;
        var max_preference = this.getHonourSubjects.length;
        $.each(self.honoursSubjects, function( index, honour ) {
          honour.opted = (self.getSelectedSubjects.indexOf(honour.honours_sub_id) > -1);
          if(honour.opted == false) {
            honour.selected = false;
            honour.preference = 0;
          }
        });
        // $.each(this.getHonourSubjects, function(index, honour) {
        //   if(honour.preference > max_preference) {
        //     honour.preference = 0;
        //   }
        // });
      },
      isSubjectSelected: function(subject, compulsory) {
        var self = this;
        var found = false;
        compulsory = compulsory || true;
        if(this.compGrp != ''){
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
      lastExamStatus: function() {
        if(this.last_exam_mcm == 'N') {
          this.lastyr_rollno = '';
          this.resetOldData();
        }
      },
      copy_address: function(e){
        if(this.same_address == "Y") {
          this.corr_address = this.per_address;
          this.corr_city = this.city;
          this.corr_state_id = this.state_id;
          this.corr_pincode = this.pincode;
        } else {
          this.corr_address = '';
          this.corr_city = '';
          this.corr_state_id = 0;
          this.corr_pincode = '';
        }
      },
      isForeignNational: function(e){
        var self = this;
        var selected = $('#cat_id option:selected').text();
        this.foreigner = selected.toUpperCase().search('FOREIGN') > -1;
        if(this.foreigner) {
          this.foreign_national = 'Y';
          if(this.nationality == 'INDIAN') {
            this.nationality = '';
          }
          var str = [];    
          if(this.reservedcatList == ''){
            $("#resvcat_id option").each(function () {
                if($(this)[0].value != ''){
                  str.push({text:$(this).text(),value:$(this)[0].value});   
                }
            }); 
            this.reservedcatList= str;
          }
          this.reservedcatList.forEach(function(element) {
            if(element.text == "others" || element.text == "Others" ||element.text == "OTHERS"){
               self.resvcat_id = element.value;
              $("#resvcat_id").attr('disabled',true);
            }
          });
          
        } else {
          this.foreign_national = 'N';
          this.nationality = 'INDIAN';
          $("#resvcat_id").attr('disabled',false);
        }
      },
      selectElective: function(ele_id) {
        if(this.selected_ele_id > 0 && this.old_subjects.length > 0){
          return;
        }
        this.selected_ele_id = this.selected_ele_id != ele_id ? ele_id : 0;
        this.selectedOpts = [];
        var self = this;
        $.each(this.electives, function(key, elective) {
          if(elective.id == self.selected_ele_id) {
            $.each(elective.elective_subjects, function(key1, sub) {
              if(sub.sub_type == 'C') {
                self.selectedOpts.push(sub.subject_id);
              }
            });
          }
        });
      },
      showSubs: function(e) {
        var self = this;
        self.selected_ele_id = 0;
        this.$http.post("{{ url('courses/subs') }}",{'course_id': this.course_id})
          .then(function (response) {
            //$('#').blockUI();
            self.compSub = response.data['compSub'];
            self.compGrp = response.data['compGrp'];
            self.optionalSub = response.data['optionalSub'];
            self.optionalGrp = response.data['optionalGrp'];
            self.course_code = response.data['course'].class_code;
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
        self.selectedOpts = [];
        console.log('here');
        if(self.course_id) {
          if(!self.canChangeSubjects){
            self.old_subjects.forEach(function(arr){
              self.selectedOpts.push(arr.subject_id);
            });
            self.getElectiveGrp();
            self.getCompGrp();
          }
        }
      },
      getAdmitUrl: function() {
        if(this.form_id > 0)
          return this.admitUrl+'/'+this.form_id;
        else
          return this.admitUrl;
      },
      admit: function() {
        var self = this;
        this.errors = {};
        var data = $.extend({'elective_grps': this.elective_grps}, this.$data);
        this.$http[this.getMethod()](this.getAdmitUrl(), data)
          .then(function (response) {
            this.form_id = response.data.form_id;
            if (response.data.success) {
              this.success = true;
              setTimeout(function() {
                self.success = false;
              //  console.log(self.admitUrl+'/' +self.form_id +'/details');
                window.location = self.admitUrl+'/' +self.form_id +'/details';
              }, 3000);
            }
          }, function (response) {
            this.fails = true;
            if(response.status == 422) {
              $('body').scrollTop(0);
              this.errors = response.data;
            }              
          });
      },
      getMethod: function() {
        if(this.form_id > 0)
          return 'patch';
        else
          return 'post';
      },
      addRow: function(){
          try {
          this.counter++;
          this.acades.splice(this.acades.length + 1, 0, {
            "no": this.counter,
            "step_no": this.acades.length + 1,
            "last_exam": "N",
            "other_board": '',
            "other_exam": '',
            "exam": '',
            "institute": '',
            "board_id": 0,
            "rollno": '',
            "year": '',
            "result": '',
            "total_marks": '',
            "marks_obtained": '',
            "marks_per": '',
            "subjects": '',
          });
        } catch (e) {
          console.log(e);
        }
      },
      removeRow: function(index){
        if(this.acades.length > 1 && index > 0)
          this.acades.splice(index, 1);
      },
      resetOldData: function() {
        var self = this;
        this.old_subjects = [];
        this.course_id = 0;
        this.disable_pbi_in_tenth = false;
        for (let field in self.oldstudentDetails) {
          self.oldstudentDetails[field] = false;
        }
      },
      getCompGrp:function(){
        var self = this;
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
        var selectedOpts = [];
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
            selectedOpts = opts;
          }
        });
        if (ele_id > 0) {
          self.selected_ele_id = 0;
          self.selectElective(ele_id);
          self.selectedOpts = selectedOpts;
        }
        // return ele_grps;
      },
      proceedClick:function(){
        if(this.instructions == 'Y'){
          this.proceed = true;
        }
      },
      getStudentDetails: function() {
        // console.log("details");
        if(this.lastyr_rollno.trim().length > 0 && this.form_id > 0) {
          return ;
        }
        if(this.lastyr_rollno.trim().length == 0) {
          return;
        }
        this.resetOldData();
        var self = this;
        this.$http['get']('admforms/'+ this.lastyr_rollno + '/studentinfo')
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
              for (let field in student) {
                  if(self.$data.oldstudentDetails.hasOwnProperty(field)) {
                     if(student[field] != ""){
                       console.log(student[field]);
                       self.oldstudentDetails[field] = true;
                     }
                  }
              }
              if(student.aadhar_no){
                self.adhar_card = 'Y';
              }
              if(student.epic_no){
                self.epic_card = 'Y';
              }
              self.course_id = response.data.next_course_id;
              self.course_type = self.getCourseType;
              self.old_subjects = response.data.old_subjects;
              if(response.data.old_hon_sub && response.data.old_hon_sub.length > 0) {
                self.old_honour = response.data.old_hon_sub;
              }
              self.showSubs();
            } else{
               alert("Not a valid Roll no.");
               self.lastyr_rollno = '';
            }
          })
          .catch(function(){

          });
      }
    },
    computed: {
      
      showCompSubs: function() {
        var compSubs = '';
        $.each(this.compSub, function(key, val) {
          compSubs += val.subject+' , ';
        });
        return compSubs;
      },
      elective_grps: function() {
        var ele_grps = [];
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


      inOffice: function() {
        @if(isset($guard) && $guard == 'web')
          return true;
        @else
          return false;
        @endif
      },
      getCourseType: function() {
        var self = this;
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
        if(this.lastyr_rollno && c && (c.course_id == 'BA' || c.course_id == 'BA-OM')) {
          return false;
        }
        return true;
      },
      getHonourLink:function(){
        var self = this;
        var course = this.getSelectedCourse;
        if(course && course.honours_link == 'Y'){
           return true;
        }
        return false;
      },
      getSelectedSubjects:function(){
        var self = this;
        // var selected = $.extend({}, self.selectedOpts);
          var selected = [];
          $.each(self.selectedOpts,function(index,val){
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

        // selected.push(self.selectedOpts);
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
      getHonourSubjects:function(){
        return this.honoursSubjects.filter(function(hon) {
          return hon.opted;
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

      showPool:function(){
          if(this.getSelectedCourse){
            var showPoolCourses = ['BCA','BBA','BCOM','BSC','BCOM-SF','MCOM','MSC','BSC-COMP','BSC-NMED','BSC-MED','MSC-COMP','MSC-MATH','MSC-CHEM'];
            if(showPoolCourses.includes(this.getSelectedCourse.course_id)){
              this.loc_cat = '';
            }
            else{
              this.loc_cat = ' ';
            }
            return showPoolCourses.includes(this.getSelectedCourse.course_id);
          }
          this.loc_cat = ' ';
          return false;
      },

      showOcet:function(){
        if( this.getSelectedCourse && this.getSelectedCourse.course_name == "MSC-I CHEMISTRY"){
            return true;
        }
        return false;
      },

      firstYear:function(){
          if(this.getSelectedCourse && this.getSelectedCourse.course_year && this.getSelectedCourse.course_year == 1 && this.getCourseType == 'GRAD'){
            return true;
          }
          return false;
      },

      showBoarder:function(){
        if(this.getSelectedCourse && this.getSelectedCourse.course_year && (this.getSelectedCourse.course_year == 2 || this.getSelectedCourse.course_year == 3)){
          return true;
        }
        return false;
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

      'subject-grps': {
        template: "#comp-sub-grp-template",
        props: ['cgrp', 'componentType','oldSubjects', 'disableSubjects','index','subjectPreferences'],
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
            // if(this.cgrp.selectedid > 0 && self.componentType == "C") {
            //   this.checked = true;
            //   console.log('.sub_'+self.cgrp.id+'_'+self.index);
            //   var chks = $('.sub_'+self.cgrp.id+'_'+self.index);
            //   $(chks).each(function(index,value){
            //     if($(this).val() == self.cgrp.selectedid){
            //       $(this).attr('checked',true);
            //     }
            //   });
            // }
          },

          selected: function(ele) {
            var self = this;
            this.checked = true;
            // console.log('.sub_'+self.cgrp.subject_id+'_'+self.index);

            if(self.componentType == "preferance_subject"){
              if(self.subjectPreferences[self.index].selectedOpts.length > 0){
              self.subjectPreferences[self.index].selectedOpts.forEach(function(e,key){
                    if(e.sub_group_id == self.cgrp.id){
                      e.subject_id = ele.target.value;
                    }else{
                      self.subjectPreferences[self.index].selectedOpts.push({
                        subject_id: ele.target.value,
                        admission_id: self.form_id,
                        selected_ele_id: self.subjectPreferences[self.index].selected_ele_id,
                        ele_group_id: 0,
                        sub_group_id: self.cgrp.id,
                      });
                    }
                });
              }else{
                self.subjectPreferences[self.index].selectedOpts.push({
                        subject_id: ele.target.value,
                        admission_id: self.form_id,
                        selected_ele_id: self.subjectPreferences[self.index].selected_ele_id,
                        ele_group_id: 0,
                        sub_group_id: self.cgrp.id,
                });
              }

             
            }
          },
          unselected: function(e) {
            var self = this;
            if(self.componentType == "preferance_subject"){
                self.subjectPreferences[self.index].selectedOpts.forEach(function(e,key){
                  self.cgrp.details.forEach(function(ele){
                    if(e.subject_id == ele.subject_id)
                      self.subjectPreferences[self.index].selectedOpts.splice(key,1);
                  });
                });
            }
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
        created: function() {
          var sub = _.findWhere(this.list, { preference: this.preference});
          if(typeof sub != 'undefined') {
            this.sub_id = sub.subject_id;
          }
        },
        watch: {
          list: function(newValue, oldValue) {
            var sub = _.findWhere(this.list, { subject_id: this.sub_id*1});
            if(typeof sub == 'undefined') {
              this.sub_id = 0
            } else {
              sub.preference = this.preference;
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
            $.each(this.list, function(index, sub) {
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
    }
  });
</script>
@stop
