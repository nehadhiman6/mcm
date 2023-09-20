<div class="box box-default box-solid" >
    <div class="box-header with-border">
       Details
    </div>
    {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
    <div class="box-body">
        <div class="form-group" >
           {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['subject_section.course_id'] }">
                {!! Form::select('course_id',getTeacherCourses(),0,['class' => 'form-control selectCourse',':disabled'=>'addSection == true || showLists == true ','v-model'=>'subject_section.course_id']) !!}
                <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['subject_section.course_id'][0] }}</span>
            </div>
            {!! Form::label('subject_id','Subject',['class' => 'col-sm-1 control-label']) !!}
            
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['subject_section.subject_id'] }">
                <select class='form-control subjectSelect' id='subject_id' v-model='subject_section.subject_id' :disabled ='addSection || showLists' >
                    <option v-for="sub in subjects | orderBy 'subject'" :value="sub.id">@{{ sub.subject }}</option>
                </select>
                <span id="basic-msg" v-if="errors['subject_id']" class="help-block">@{{ errors['subject_section.subject_id'][0] }}</span>
            </div>
            <div class="col-sm-3">
                {!! Form::submit('Reset',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()','v-if'=>'showLists']) !!}
                {!! Form::submit('Show',['class' => 'btn btn-primary mr','@click.prevent'=>'showSubjectSections()','v-if'=>'!showLists']) !!}
                {!! Form::submit('Add New Section',['class' => 'btn btn-primary ','v-show'=>'showAdd','@click.prevent'=>'addNewSection()']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<div class="box box-default box-solid" v-show="addSection">
    <div class="box-header with-border">
        @{{ subject_section.id > 0 ? 'Update Section' : 'Add New Section' }}
        {{-- <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div> --}}
    </div>
    {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
    <div class="box-body">
        <div class="form-group" >
            {!! Form::label('section_id', 'Section', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['subject_section.section_id'] }">
                <select class="form-control" v-model="subject_section.section_id">
                    <option v-for="s in sections" :value="s.id">@{{ s.section }}</option>
                </select>
                <span id="basic-msg" v-if="errors['section_id']" class="help-block">@{{ errors['subject_section.section_id'][0] }}</span>
            </div>
            {!! Form::label('has_sub_subjects','Has Sub Subjects',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['has_sub_subjects'] }">
                <label class="radio-inline">
                    {!! Form::radio('has_sub_subjects','Y',null, ['class' => 'minimal','v-model'=>'subject_section.has_sub_subjects','@change'=>'changeHasSubSubject']) !!}
                    Yes
                    </label>
                <label class="radio-inline">
                {!! Form::radio('has_sub_subjects', 'N',null, ['class' => 'minimal','v-model'=>'subject_section.has_sub_subjects','@change'=>'changeHasSubSubject']) !!}
                    No
                </label>
            </div>
            <div class="col-sm-5 text-right">
                {{-- {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()']) !!} --}}
                {{-- {!! Form::submit('Show',['class' => 'btn btn-primary','@click.prevent'=>'checkRecord()']) !!} --}}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('teacher_id', 'Teacher', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4" v-show="subject_section.has_sub_subjects == 'N'" v-bind:class="{ 'has-error': errors['subject_section.teacher_id'] }">
                <select class="form-control select-teacher" v-model="subject_section.teacher_id">
                    <option v-for="s in teachers" :value="s.id">@{{ s.name }} @{{ s.middle_name }} @{{ s.last_name }} ( @{{ s.dept.name }})</option>
                </select>
                {{-- {!! Form::select('teacher_id', getTeachers(false), null, ['class' => 'form-control select-teacher', 'v-model' => 'subject_section.teacher_id']) !!} --}}
                <span id="basic-msg" v-if="errors['teacher_id']" class="help-block">@{{ errors['subject_section.teacher_id'][0] }}</span>
            </div>
            <div class="col-sm-3" v-else v-bind:class="{ 'has-error': errors['subject_section.teacher_id'] }">
                <input type="text" class="form-control" disabled v-model="subject_section.teacher_id" value="0"/>
            </div>

            {{-- v-if="showDetails" --}}
            <div class="col-sm-2 text-right"  >
                <input class="btn btn-primary mr" type="submit" value="Save" v-if="subject_section.id == 0" @click.prevent="saveTeacher()">
                <input class="btn btn-primary mr" type="submit" value="Update" v-if="subject_section.id > 0" @click.prevent="saveTeacher()">
                <input class="btn btn-primary" type="submit" value="Cancel" @click.prevent="addSection=false">
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<div class="box box-default box-solid" v-show="showSubSubjectForm">
    <div class="box-header with-border">
      <span v-if="sub_subject_teachers.id==0">New</span>
      <span v-else>Edit</span>
      Sub Subject
      {{-- <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div> --}}
    </div>
    {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('section_id', 'Section', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                <p class="form-control-static">@{{ ss.section.section }}</p>
            </div>
            {!! Form::label('has_sub_subjects','Has Sub Subjects',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3">
                <p class="form-control-static">@{{ ss.has_sub_subjects }}</p>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('teacher_id', 'Teacher', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4" v-bind:class="{ 'has-error': errors['teacher_id'] }">
                <select class="form-control select-teacher1" v-model="sub_subject_teachers.teacher_id">
                    <option v-for="s in teachers" :value="s.id">@{{ s.name }} @{{ s.middle_name }} @{{ s.last_name }} (@{{ s.dept.name }})</option>
                </select>
                {{-- {!! Form::select('teacher_id', getTeachers(false), null, ['class' => 'form-control select-teacher1', 'v-model' => 'sub_subject_teachers.teacher_id']) !!} --}}
                <span id="basic-msg" v-if="errors['teacher_id']" class="help-block">@{{ errors['teacher_id'][0] }}</span>
            </div>
            {!! Form::label('sub_subject_name', 'Sub Subject Name', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['sub_subject_name'] }">
                {!! Form::text('sub_subject_name',null, ['class' => 'form-control', 'v-model' => 'sub_subject_teachers.sub_subject_name']) !!}
                <span id="basic-msg" v-if="errors['sub_subject_name']" class="help-block">@{{ errors['sub_subject_name'][0] }}</span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('is_practical','Is Practical?',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['is_practical'] }">
                <label class="radio-inline">
                    {!! Form::radio('is_practical','Y',null, ['class' => 'minimal','v-model'=>'sub_subject_teachers.is_practical']) !!}
                    Yes
                    </label>
                <label class="radio-inline">
                {!! Form::radio('is_practical', 'N',null, ['class' => 'minimal','v-model'=>'sub_subject_teachers.is_practical']) !!}
                    No
                </label>
            </div>
            <div class="col-sm-5 text-right">
                <input class="btn btn-primary mr" type="submit" value="Save" v-if="sub_subject_teachers.id == 0" @click.prevent="saveSubSubject()">
                <input class="btn btn-primary mr" type="submit" value="Update" v-if="sub_subject_teachers.id > 0" @click.prevent="saveSubSubject()">
                <input class="btn btn-primary " type="submit" value="Cancel" @click.prevent="resetSubSubject()">
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

<div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Successfully Saved!</strong> 
</div>

<div class="panel panel-default" v-if="subject_section.sub_sec_details.length > 0">
    <div class="panel-heading">
    Sub Subjects - Section @{{ ss.section.section }}
    </div>
    <div class="panel-body" >
        <table class="table table-bordered" id ="volunteerListDashboard">
            <thead>
                <th>Sub Subject Name</th>
                <th>Practical</th>
                <th>Teacher</th>
                <th>Edit</th>
            </thead>
            <tbody>
                <tr v-for="detail in subject_section.sub_sec_details">
                    <td>@{{detail.sub_subject_name}}</td>
                    <td>@{{detail.is_practical == 'N' ? 'No':'Yes'}}</td>
                    <td>@{{detail.teacher.name}} @{{detail.teacher.middle_name}} @{{detail.teacher.last_name}}</td>
                    @can('EDIT-SECTION-DETAIL')
                        <td><input type="button" class="btn btn-primary" @click="editSubSubject(detail.id)" value="Edit"></td>
                    @endcan
                </tr>
            </tbody>
        </table>
    </div>
</div>
    
<div class="panel panel-default" v-if="subjectSectionsList.length > 0">
    <div class="panel-heading">
    Subject Sections
    </div>
    <div class="panel-body" >
        <table class="table table-bordered" id ="volunteerListDashboard">
            <thead>
                <th>Subject Name</th>
                <th>Section</th>
                <th>Teacher</th>
                <th>Has Sub Subjects</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr v-for="sub_sec in subjectSectionsList">
                    <td>@{{sub_sec.subject.subject}}</td>
                    <td>@{{sub_sec.section.section}}</td>
                    <td>@{{sub_sec.teacher ? sub_sec.teacher.name:''}} @{{sub_sec.teacher ? sub_sec.teacher.middle_name:''}}  @{{sub_sec.teacher ? sub_sec.teacher.last_name:''}}</td>
                    <td>@{{sub_sec.has_sub_subjects =='Y' ?'Yes':'No' }}</td>
                    <td>
                        <input type="button" class="btn btn-primary"  value="Edit" @click.prevent="editSubjectTeacher(sub_sec)">
                        <input type="button" class="btn btn-primary"  value="Add Sub Subject" v-if="sub_sec.has_sub_subjects == 'Y'" @click.prevent="addSubSubject(sub_sec)">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

    
