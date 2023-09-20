<template id="acedmic-template">
    <fieldset>
        <legend><strong>Academic Details</strong></legend>
        <div class='form-group'>
            {!! Form::label('pu_regno','Panjab Univ. Roll No. (if any)',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['pu_regno'] }">
                {!! Form::text('pu_regno',null,['class' => 'form-control','v-model'=>'pu_regno',':disabled'=>'firstYear','placeholder'=>'Panjab Univ. Roll No.']) !!}
                <span id="basic-msg" v-if="errors['pu_regno']" class="help-block">@{{ errors['pu_regno'][0] }}</span>
                <span id="basic-msg" v-else class="help-block">*Not applicable to Undergraduate First Year Applicants</span>
            </div>
            {!! Form::label('pupin_no','Panjab Univ. RegNo/PUPIN NO. (if any)',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['pupin_no'] }">
                {!! Form::text('pupin_no',null,['class' => 'form-control','v-model'=>'pupin_no',':disabled'=>'firstYear','placeholder'=>'11 digit identification no.(if any)']) !!}
                <span id="basic-msg" v-if="errors['pupin_no']" class="help-block">@{{ errors['pupin_no'][0] }}</span>
            </div>
        </div>
        <div class='form-group' v-if="ocet_dis">
            {!! Form::label('ocet_rollno','PU-CET (PG) / OCET Roll No.',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['ocet_rollno'] }" >
            {!! Form::text('ocet_rollno',null,['class' => 'form-control','v-model'=>'ocet_rollno',':disabled'=>'firstYear','placeholder'=>'O-CET Roll no']) !!}
            
            <span id="basic-msg" v-if="errors['ocet_rollno']" class="help-block">@{{ errors['ocet_rollno'][0] }}</span>
            </div>
        </div>
        {{-- <span  v-if="ocet_dis" id="basic-msg" >(PU-CET (PG) / OCET. Roll No. is mandatory without which your admission will be cancelled)</span> --}}
        <span  v-if="ocet_dis" id="basic-msg" ></span>
        <h4 style="color: #3f576c;"> <strong>Previous examination results (All Classes/Semesters)</strong></h4>
        <h5  style="color: #2169a9;">Fill the details in REVERSE chronological order i.e. First, enter the details of last examination passed.</h5>
        <h5>Click "Add Another Exam" button to enter other exam details as per requirement.</h5>
        <h5>Please attach document for conversion factor of CGPA to % (if applicable)</h5>
        <div class="academics" v-for='acade in acades'>
        <div class='form-group'>
            {!! Form::label('exam','Examination',['class' => 'col-sm-2 control-label required']) !!}
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
            {!! Form::label('inst_state_id','Institution State',['class' => 'col-sm-2 control-label required']) !!}
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
            
            {!! Form::label('reappear_subjects','Compartment/Reappear Subjects',['class' => 'col-sm-3 control-label required','v-if'=>"acade.result == 'COMPARTMENT'"]) !!}
            <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['acades.'+$index+'.reappear_subjects'] }" v-if="acade.result == 'COMPARTMENT'">
            <input type="text"  :disabled="acade.result != 'COMPARTMENT'"  v-model='acade.reappear_subjects' class="form-control"/>
            </div>
            
        </div>
        <div class='form-group'>
            {!! Form::label('cgpa','CGPA',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-2" v-bind:class="{ 'has-error': errors['acades.'+$index+'.cgpa'] }">
            <select class="form-control select-form" v-model="acade.cgpa">
                <option value="Y">Yes</option>
                <option value="N">No</option>

            </select>
            <!-- <span id="basic-msg" v-if="errors['cgpa']" class="help-block">@{{ errors['cgpa'][0] }}</span> -->
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
            {!! Form::label('division','Division',['class' => 'col-sm-2 control-label', 'v-bind:class'=>"{ 'required': acade.result == 'PASS' }"]) !!}
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
        <span v-if="admForm.lastyr_rollno != null" ><h5>Old Student Seeking Admission in Semester III:</h5></span>
        <legend v-if="admForm.lastyr_rollno != null"><h5><strong>&nbsp;&nbsp;&nbsp;&nbsp;PG Semester I :</strong></h5></legend>
        <div class='form-group' v-if="admForm.lastyr_rollno != null">
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
        <div class="form-group" v-if="admForm.lastyr_rollno != null">
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
        <legend v-if="admForm.lastyr_rollno != null" ><h5><strong>&nbsp;&nbsp;&nbsp;&nbsp;PG Semester II :</strong></h5></legend>
        <div class='form-group' v-if="admForm.lastyr_rollno != null">
            {!! Form::label('pg_sem2_result','Result',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduate.pg_sem2_result'] }" >
            <select v-model="postgraduate.pg_sem2_result" class="form-control">
                <option v-for="result in results" :value="result">@{{ result }}</option>
            </select>
            <span id="basic-msg" v-if="errors['postgraduate.pg_sem2_result']" class="help-block">@{{ errors['postgraduate.pg_sem2_result'][0] }}</span>
            </div>
        </div>
        <div class='form-group' v-if="admForm.lastyr_rollno != null">
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
        <div class="form-group"  v-if="admForm.lastyr_rollno != null">
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
        <p class= "control-label" style="text-align:left; padding: 0 0 0 31px; font-size: 14px; font-weight: bold;">Mention Gap Year (if any) Attach certificate under 'Attachments' tab, specimen can be viewed here - <a style="color:blue" href="https://mcmdavcwchd.edu.in/wp-content/uploads/2021/08/Gap-Year-Proforma.pdf" target="_blank">https://mcmdavcwchd.edu.in/wp-content/uploads/2021/08/Gap-Year-Proforma.pdf </a> (Also submit two copies in original, as and when notified by college)</p>
        {!! Form::label('gap_year','Mention Gap Year (if any)',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-2">
            {!! Form::text('gap_year',null,['class' => 'form-control','v-model'=>'gap_year']) !!}
        </div>
        </div>
        <!-- <div class='form-group'>
        {{-- {!! Form::label('org_migrate','Original Migration Certificate Attached?',['class' => 'col-sm-4 control-label']) !!} --}}
        <div class="col-sm-1 checkbox-inline">
            <input type="checkbox" name="org_migrate" v-model='org_migrate' v-bind:true-value="'Y'"
                v-bind:false-value="'N'" class="minimal">
        </div>
        </div>
        <div class='form-group'>
        {{-- {!! Form::label('migrated','Are You Migrating From Other College Or University?If Yes Give Details..',['class' => 'col-sm-4 control-label']) !!} --}}
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
        {!! Form::label('disqualified','Have you ever been disqualified by any Board/Body/Council/University ? If yes, give details.',['class' => 'col-sm-4 control-label']) !!}
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
        {{-- <span id="basic-msg" class="help-block">Please 'Update' data, in case of any changes, before leaving the current tab !</span> --}}
        <span id="basic-msg" class="help-block">Click the "Update" button before leaving the current tab, in case there have been any changes.</span>

        <input v-on:click="rediretPreviousTab" v-show="active_tab >= 3" class="btn btn-primary"  type="button" value="Previous" >
        <input class="btn btn-primary"  type="button" :value="admForm.active_tab >= 4 ? 'Update' : 'Submit'" @click.prevent="submit">
        <input v-on:click="rediretNextTab" v-show="active_tab >= 4" class="btn btn-primary"  type="button" value="Next" >
    
    </fieldset>
    <div>
        <ul class="alert alert-error alert-dismissible" role="alert" v-show="hasErrors">
            <li  v-for='error in errors'>@{{ error }} </li>
        </ul>
    </div>
</template>
  
@push('vue-components')
    <script>
        var no = 1000;
        var acedmicComponent = Vue.extend({
            template: '#acedmic-template',
            props:['courses', 'course_id','active_tab', 'form_id', 'admForm', 'postgrt'],
            data: function(){
                return {

                    counter: 0,
                    pu_regno: '', // PU reg no and PUPIn  both are same. we are not changing migration but use this field as roll_no
                    pupin_no: '',
                    ocet_rollno:'',
                    gap_year: '',
                    disqualified: "{{ $adm_form->disqualified == 'Y' ? 'Y' : 'N' }}",
                    migrate_detail: '',
                    disqualify_detail: '',
                    spl_achieve:'',
                    course_type: '',

                    //php functions
                    sports: "{{ $adm_form->sports == 'Y' ? 'Y' : 'N' }}",
                    cultural: "{{ $adm_form->cultural == 'Y' ? 'Y' : 'N' }}",
                    academic: "{{ $adm_form->academic == 'Y' ? 'Y' : 'N' }}",
                    postgraduate:{ 
                        bechelor_degree:'',
                        subjects:'', 
                        marks_obtained:'', 
                        total_marks:'',
                        percentage:'',
                        honour_subject:'',
                        honour_marks:'',
                        honour_total_marks:'',
                        honour_percentage:'',
                        elective_subject:'',
                        ele_obtained_marks:'', 
                        ele_total_marks:'',
                        ele_percentage:'',
                        pg_sem1_subject:'',
                        pg_sem1_obtained_marks:'',
                        pg_sem1_total_marks:'',
                        pg_sem1_percentage:'',
                        pg_sem2_result: '' , pg_sem2_subject:'',
                        pg_sem2_obtained_marks:'',
                        pg_sem2_total_marks:'',
                        pg_sem2_percentage:''
                    },
                    acades: {!! $adm_form->academics->count() > 0 ? json_encode($adm_form->academics) : "[{exam: 'Select',other_exam:'', last_exam: 'Y', institute: '', board_id: 0, rollno: '', year: '', result: '',total_marks: '',marks_obtained: '' , marks_per: '', subjects: '', other_board: '',reappear_subjects:'',division:'',inst_state_id:0,cgpa:'N'}]" !!},
                    exams: {!! getAcademicExam(true) !!},
                    boards: {!! getBoardlist(true) !!},
                    states:{!! json_encode(getStates())!!},
                    results: {!! resultType(true) !!},

                    //basic
                    response: {},
                    success: false,
                    fails: false,
                    msg: '',
                    errors: [],
                    ocet_dis:false,
                }
            },
            ready: function(){
                var self = this;
                this.boards.unshift({ id: '', name: 'Select' });
                this.boards.push({ id: 0, name: 'Others' });
                if(self.admForm && self.admForm.active_tab >= 4){
                    self.setDataForForm(self.admForm);
                }
              
                var c = this.getSelectedCourse;
                self.course_type = c ? c.status : '';

                self.showOcet();
            },

            computed: {
                hasErrors: function() {
                    return Object.keys(this.errors).length > 0;
                },

                // showOcet:function(){
                //     return false;
                //     console.log('i am here fggs');
                //     if( this.getSelectedCourse && this.getSelectedCourse.course_name == "MSC-I CHEMISTRY"){
                //        console.log('i am here');
                //         return true;
                //     }
                //     return false;
                // },

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
            },

            methods:{
                showOcet:function(){
                    var self = this;
                    // return false;
                    console.log('i am here fggs');
                    if( this.getSelectedCourse && this.getSelectedCourse.course_name == "MSC-I CHEMISTRY"){
                       console.log('i am here');
                       self.ocet_dis =  true;
                    }
                    else{
                        self.ocet_dis =  false;
                    }
                },
                rediretNextTab: function(){
                    $('a[href="#foreign-migration-alumni"]').click();
                },

                rediretPreviousTab: function(){
                    $('a[href="#subject-options"]').click();
                },

                removeRow: function(index){
                    if(this.acades.length > 1 && index > 0)
                    this.acades.splice(index, 1);
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
                            'cgpa':'N',
                            "total_marks": '',
                            "marks_obtained": '',
                            "marks_per": '',
                            "subjects": '',
                        });
                    } 
                    catch (e) {
                    console.log(e);
                    }
                },
                
                submit: function() {
                    var self = this;
                    self.errors = {};
                    var data = self.setFormData();
                    self.$http[self.getMethod()](self.getUrl(), data)
                    .then(function (response) {
                        if (response.data.success) {
                        self.form_id = response.data.form_id;
                        self.active_tab = response.data.active_tab;
                        self.admForm.active_tab = response.data.active_tab;
                        // self.admForm = response.data.adm_form;
                        $.blockUI({ message: '<h3> Record successfully saved !!</h3>' });
                        setTimeout(function(){
                            $.unblockUI();
                        },1000);
                        
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
                },

                setFormData: function(){
                    return {
                        active_tab: 4,
                        form_id : this.form_id,
                        course_id : this.course_id,
                        course_type : this.course_type,
                        pu_regno:  this.pu_regno,
                        pupin_no:  this.pupin_no,
                        ocet_rollno: this.ocet_rollno,
                        gap_year:  this.gap_year,
                        disqualified: this.disqualified,
                        migrate_detail:  this.migrate_detail,
                        disqualify_detail:  this.disqualify_detail,
                        sports: this.sports,
                        cultural:  this.cultural,
                        academic:  this.academic,
                        spl_achieve: this.spl_achieve,
                        acades: this.acades,
                        results: this.results,
                        postgraduate: this.postgraduate,
                    }
                },

                setDataForForm: function(ac_det){
                    this.active_tab = ac_det.active_tab;
                    this.form_id  = ac_det.form_id;
                    this.pu_regno = ac_det.pu_regno;
                    this.pupin_no = ac_det.pupin_no;
                    this.ocet_rollno = ac_det.ocet_rollno;
                    this.gap_year = ac_det.gap_year;
                    this.disqualified = ac_det.disqualified;
                    this.migrate_detail = ac_det.migrate_detail;
                    this.disqualify_detail = ac_det.disqualify_detail;
                    this.sports = ac_det.sports;
                    this.cultural = ac_det.cultural;
                    this.academic = ac_det.academic;
                    this.spl_achieve = ac_det.spl_achieve;
                    this.postgraduate = this.postgrt;

                },

                getMethod: function() {
                    if(this.admForm.active_tab >= 4)
                    return 'patch';
                    else
                    return 'post';
                },

                getUrl: function() {
                    if(this.admForm.active_tab >= 4)
                    return 'acedmic-details/'+this.form_id;
                    else
                    return 'acedmic-details';
                },
            
            }
        });

        Vue.component('acedmic-detail', acedmicComponent)
    </script>
@endpush
