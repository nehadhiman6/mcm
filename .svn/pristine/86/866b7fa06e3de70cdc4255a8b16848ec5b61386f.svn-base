<fieldset>
	<legend>Qualification Details</legend>
	<legend><h5>Graduation </h5></legend>
	<div class="form-group">
		{!! Form::label('graduatecourse','UG Course:',['class' => 'col-sm-2 control-label required']) !!}
		<div class="col-sm-5" v-bind:class="{ 'has-error': errors['graduatecourse.0.course_id'] }">
			<select class="form-control" v-model="graduatecourse[0].course_id">
				<option value="0">Select</option>
				<option v-for="course in graduateCourses" :value="course.id">@{{ course.name }}</option>
				<option value="-1">Other</option>
			</select>
			<span id="basic-msg" v-if="errors['graduatecourse.0.course_id']" class="help-block">@{{ errors['graduatecourse.0.course_id'] }}</span>
		</div>
		{!! Form::label('other_course','Mention Course',['class' => 'col-sm-2 control-label required','v-if'=>"graduatecourse[0].course_id =='-1'"]) !!}
		<div class="col-sm-3" v-bind:class="{ 'has-error': errors['graduatecourse.0.other_course'] }" v-if="graduatecourse[0].course_id =='-1'">
			{!! Form::text('other_course',null,['class' => 'form-control','v-model'=>'graduatecourse[0].other_course']) !!}
			<span id="basic-msg" v-if="errors['graduatecourse.0.other_course']"  class="help-block">@{{ errors['graduatecourse.0.other_course'] }}</span>
		</div>
	</div>
	<div class="form-group">	
		{!! Form::label('subject','Subject:',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-5">
			{!! Form::text('subject',null,['class' => 'form-control','v-model'=>'graduatecourse[0].subject']) !!}
		</div>
		{!! Form::label('passing_year','Year',['class' => 'col-sm-2 control-label required']) !!}
		<div class="col-sm-3" v-bind:class="{ 'has-error': errors['graduatecourse.0.passing_year'] }" >
			{!! Form::text('passing_year',null,['class' => 'form-control','max-length'=>'10','v-model'=>'graduatecourse[0].passing_year']) !!}
			<span id="basic-msg" v-if="errors['graduatecourse.0.passing_year']" class="help-block">@{{ errors['graduatecourse.0.passing_year']}}</span>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('mcm_college','Institution:',['class' => 'col-sm-2 control-label required']) !!}
		<div class="col-sm-5" v-bind:class="{ 'has-error': errors['graduatecourse.0.mcm_college'] }">
			<label class="radio-inline">
				{!! Form::radio('mcm_college_ug', 'Y',null, ['class' => 'minimal','v-model'=>'graduatecourse[0].mcm_college']) !!}
				MCM COLLEGE
				</label>
				<label class="radio-inline">
				{!! Form::radio('mcm_college_ug', 'N',null, ['class' => 'minimal','v-model'=>'graduatecourse[0].mcm_college']) !!}
				Other Institution
				</label>
			<span id="basic-msg" v-if="errors['graduatecourse.0.mcm_college']" class="help-block">@{{ errors['graduatecourse.0.mcm_college']}}</span>
		</div>
		{!! Form::label('other_institute','Institution/University',['class' => 'col-sm-2 control-label required' ,'v-if'=>"graduatecourse[0].mcm_college == 'N'"]) !!}
		<div class="col-sm-3" v-bind:class="{ 'has-error': errors['graduatecourse.0.other_institute'] }" v-if="graduatecourse[0].mcm_college == 'N'">
			{!! Form::text('other_institute',null,['class' => 'form-control','max-length'=>'10','v-model'=>'graduatecourse[0].other_institute']) !!}
			<span id="basic-msg" v-if="errors['graduatecourse.0.other_institute']"  class="help-block">@{{ errors['graduatecourse.0.other_institute'] }}</span>
		</div>
	</div>

	<legend><h5>Post Graduation</h5></legend>
	<div class="form-group">
		{!! Form::label('is_graduacted','Have you done Post Graduation?',['class' => 'col-sm-4 control-label required']) !!}
		<div class="col-sm-4">
			<label class="radio-inline">
				<input type="radio" name="is_graduacted" value="Y" v-model="is_graduacted" @change="showHidePgRecPro('pg')">Yes<br>
			</label>
			<label class="radio-inline">
					<input type="radio" name="is_graduacted" value="N" v-model="is_graduacted" @change="showHidePgRecPro('pg')">No<br>
			</label>
				{{-- <input type="checkbox" name="is_graduacted"  v-model='is_graduacted' v-bind:true-value="'Y'"
				v-bind:false-value="'N'" class="minimal" @change="showHidePgRecPro('pg')" />Yes --}}
		</div>
	</div>
	<div v-for="pgcourse in postgraduatecourses" class="academics">
		<div class="form-group" v-show="showPgSection">
			{!! Form::label('graduatecourse','PG Course:',['class' => 'col-sm-2 control-label ']) !!}
			<div class="col-sm-5"  v-bind:class="{ 'has-error': errors['postgraduatecourses.'+$index+'.course_id'] }">
				<select class="form-control" v-model="pgcourse.course_id">
					<option value="0">Select</option>
					<option v-for="course in postGraduateCourses" :value="course.id">@{{ course.name }}</option>
					<option value="-1">Other</option>
				</select>
				<span id="basic-msg" v-if="errors['postgraduatecourses.'+$index+'.course_id'] " class="help-block">@{{ errors['postgraduatecourses.'+$index+'.course_id']}}</span>
			</div>
			{!! Form::label('other_course','Mention Course',['class' => 'col-sm-2 control-label ','v-if'=>"pgcourse.course_id =='-1'"]) !!}
			<div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduatecourses.'+$index+'.other_course'] }" v-if="pgcourse.course_id =='-1'">
				{!! Form::text('other_course',null,['class' => 'form-control','v-model'=>'pgcourse.other_course']) !!}
				<span id="basic-msg" v-if="errors['postgraduatecourses.'+$index+'.other_course'] " class="help-block">@{{ errors['postgraduatecourses.'+$index+'.other_course']}}</span>
			</div>
		</div>
		<div class="form-group" v-show="showPgSection">
			{!! Form::label('subject','Subject/Specialization:',['class' => 'col-sm-2 control-label ']) !!}
			<div class="col-sm-5"  v-bind:class="{ 'has-error': errors['postgraduatecourses.'+$index+'.subject'] }">
				{!! Form::text('subject',null,['class' => 'form-control','v-model'=>'pgcourse.subject']) !!}
				<span id="basic-msg" v-if="errors['postgraduatecourses.'+$index+'.subject'] " class="help-block">@{{ errors['postgraduatecourses.'+$index+'.subject']}}</span>
			</div>
			{!! Form::label('passing_year','Year',['class' => 'col-sm-2 control-label ']) !!}
			<div class="col-sm-3"  v-bind:class="{ 'has-error': errors['postgraduatecourses.'+$index+'.passing_year'] }">
				{!! Form::text('passing_year',null,['class' => 'form-control','max-length'=>'10','v-model'=>'pgcourse.passing_year']) !!}
				<span id="basic-msg" v-if="errors['postgraduatecourses.'+$index+'.passing_year'] " class="help-block">@{{ errors['postgraduatecourses.'+$index+'.passing_year']}}</span>
			</div>
		</div>
		<div class="form-group" v-show="showPgSection">
			{!! Form::label('mcm_college','Institution:',['class' => 'col-sm-2 control-label ']) !!}
			<div class="col-sm-5" v-bind:class="{ 'has-error': errors['postgraduatecourses.'+$index+'.mcm_college'] }">
				<label class="radio-inline">
						<input type="radio" :name="'mcm_college_pg'+$index" value="Y" v-model="pgcourse.mcm_college"> MCM College<br>
					</label>
					<label class="radio-inline">
							<input type="radio" :name="'mcm_college_pg'+$index" value="N" v-model="pgcourse.mcm_college">Other Institution <br>
					</label>
				<span id="basic-msg" v-if="errors['postgraduatecourses.'+$index+'.passing_year'] " class="help-block">@{{ errors['postgraduatecourses.'+$index+'.mcm_college']}}</span>
			</div>
			{!! Form::label('other_institute','Institution/University',['class' => 'col-sm-2 control-label' ,'v-if'=>"pgcourse.mcm_college == 'N'"]) !!}
			<div class="col-sm-3" v-bind:class="{ 'has-error': errors['postgraduatecourses.'+$index+'.other_institute'] }" v-if="pgcourse.mcm_college == 'N'">
				{!! Form::text('other_institute',null,['class' => 'form-control','max-length'=>'10','v-model'=>'pgcourse.other_institute']) !!}
				<span id="basic-msg" v-if="errors['postgraduatecourses.'+$index+'.other_institute'] " class="help-block">@{{ errors['postgraduatecourses.'+$index+'.other_institute']}}</span>
			</div>
			<div class="col-sm-12" v-if="$index > 0">
			{!! Form::button('Remove',['class' => 'btn btn-success pull-right' , '@click.prevent' => 'removeRow($index,"pg")']) !!}
			</div>
		</div>
	</div>

	<div class="form-group" v-show="showPgSection">
		<div class="col-sm-12">
		  {!! Form::button('Add Another PG',['class' => 'btn btn-success pull-right', '@click' => 'addRow("pg")']) !!}
		</div>
	</div>

	<legend><h5>Professional Courses</h5></legend>
	<div class="form-group">
		{!! Form::label('is_profession','Have you done Professional Course?',['class' => 'col-sm-4 control-label required']) !!}
		<div class="col-sm-4">
			<label class="radio-inline">
				<input type="radio" name="is_profession" value="Y" v-model="is_profession" @change="showHidePgRecPro('professional')">Yes<br>
			</label>
			<label class="radio-inline">
					<input type="radio" name="is_profession" value="N" v-model="is_profession" @change="showHidePgRecPro('professional')">No<br>
			</label>
			{{-- <label class="col-sm-2 checkbox">
			<input type="checkbox" name="is_profession"  v-model='is_profession' v-bind:true-value="'Y'"
					v-bind:false-value="'N'" class="minimal" @change="showHidePgRecPro('professional')" />Yes
			</label> --}}
		</div>
	</div>
	<div v-for="pfcourse in professionaldegrees" class="academics">
		<div class="form-group" v-show="showProSection">
			{!! Form::label('graduatecourse','Course Name:',['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-5"  v-bind:class="{ 'has-error': errors['professionaldegrees.'+$index+'.course_id'] }">
				<select class="form-control" v-model="pfcourse.course_id">
					<option value="0">Select</option>
					<option v-for="course in professionalCourses" :value="course.id">@{{ course.name }}</option>
					<option value="-1">Other</option>
				</select>
				<span id="basic-msg" v-if="errors['professionaldegrees.'+$index+'.course_id'] " class="help-block">@{{ errors['professionaldegrees.'+$index+'.course_id']}}</span>
			</div>
			{!! Form::label('other_course','Mention Course',['class' => 'col-sm-2 control-label','v-if'=>"pfcourse.course_id =='-1'"]) !!}
			<div class="col-sm-3"  v-bind:class="{ 'has-error': errors['professionaldegrees.'+$index+'.other_course'] }" v-if="pfcourse.course_id =='-1'">
				{!! Form::text('other_course',null,['class' => 'form-control','v-model'=>'pfcourse.other_course']) !!}
				<span id="basic-msg" v-if="errors['professionaldegrees.'+$index+'.other_course'] " class="help-block">@{{ errors['professionaldegrees.'+$index+'.other_course']}}</span>
			</div>
		</div>
		<div class="form-group" v-show="showProSection">
			{!! Form::label('subject','Subject/Specialization:',['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-5" v-bind:class="{ 'has-error': errors['professionaldegrees.'+$index+'.subject'] }">
				{!! Form::text('subject',null,['class' => 'form-control','v-model'=>'pfcourse.subject']) !!}
			<span id="basic-msg" v-if="errors['professionaldegrees.'+$index+'.subject'] " class="help-block">@{{ errors['professionaldegrees.'+$index+'.subject']}}</span>
			</div>
			{!! Form::label('passing_year','Year',['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-3" v-bind:class="{ 'has-error': errors['professionaldegrees.'+$index+'.passing_year'] }">
				{!! Form::text('passing_year',null,['class' => 'form-control','max-length'=>'10','v-model'=>'pfcourse.passing_year']) !!}
				<span id="basic-msg" v-if="errors['professionaldegrees.'+$index+'.passing_year'] " class="help-block">@{{ errors['professionaldegrees.'+$index+'.passing_year']}}</span>
			</div>
		</div>
		<div class="form-group" v-show="showProSection">
			{!! Form::label('mcm_college','Institution:',['class' => 'col-sm-2 control-label ']) !!}
			<div class="col-sm-5"  v-bind:class="{ 'has-error': errors['professionaldegrees.'+$index+'.mcm_college'] }">
					<label class="radio-inline">
							<input type="radio" :name="'mcm_college_pf'+$index" value="Y" v-model="pfcourse.mcm_college"> MCM College<br>
						</label>
						<label class="radio-inline">
								<input type="radio" :name="'mcm_college_pf'+$index" value="N" v-model="pfcourse.mcm_college">Other Institution <br>
						</label>
				<span id="basic-msg" v-if="errors['professionaldegrees.'+$index+'.mcm_college'] " class="help-block">@{{ errors['professionaldegrees.'+$index+'.mcm_college']}}</span>
			</div>
			{!! Form::label('other_institute','Institution/University',['class' => 'col-sm-2 control-label' ,'v-if'=>"pfcourse.mcm_college == 'N'"]) !!}
			<div class="col-sm-3" v-bind:class="{ 'has-error': errors['professionaldegrees.'+$index+'.other_institute'] }" v-if="pfcourse.mcm_college == 'N'">
				{!! Form::text('other_institute',null,['class' => 'form-control','max-length'=>'10','v-model'=>'pfcourse.other_institute']) !!}
				<span id="basic-msg" v-if="errors['professionaldegrees.'+$index+'.other_institute'] " class="help-block">@{{ errors['professionaldegrees.'+$index+'.other_institute']}}</span>
			</div>
			<div class="col-sm-12" v-if="$index > 0">
			{!! Form::button('Remove',['class' => 'btn btn-success pull-right' , '@click.prevent' => 'removeRow($index,"professional")']) !!}
			</div>
		</div>
	</div>
	<div class="form-group" v-show="showProSection">
		<div class="col-sm-12">
		  {!! Form::button('Add Another',['class' => 'btn btn-success pull-right', '@click' => 'addRow("professional")']) !!}
		</div>
	</div>

	<legend><h5>Research Degrees</h5></legend>
	<div class="form-group">
		{!! Form::label('is_research','Have you done Research Degree?',['class' => 'col-sm-4 control-label required']) !!}
		<div class="col-sm-4">
				<label class="radio-inline">
					<input type="radio" name="is_research" value="Y" v-model="is_research" @change="showHidePgRecPro('research')">Yes<br>
				</label>
				<label class="radio-inline">
						<input type="radio" name="is_research" value="N" v-model="is_research" @change="showHidePgRecPro('research')">No<br>
				</label>
			{{-- <label class="col-sm-2 checkbox">
			<input type="checkbox" name="is_research"  v-model='is_research' v-bind:true-value="'Y'"
					v-bind:false-value="'N'" class="minimal" @change="showHidePgRecPro('research')" />Yes
			</label> --}}
		</div>
	</div>
	<div v-for="researchCourse in researchdegrees" class="academics">
		<div class="form-group" v-show="showRecSection">
			{!! Form::label('graduatecourse','Degree Name:',['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-5" v-bind:class="{ 'has-error': errors['professionaldegrees.'+$index+'.course_id'] }">
				<select class="form-control" v-model="researchCourse.course_id">
					<option value="0">Select</option>
					<option v-for="course in researchCourses" :value="course.id">@{{ course.name }}</option>
					<option value="-1">Other</option>
				</select>
				<span id="basic-msg" v-if="errors['researchdegrees.'+$index+'.course_id'] " class="help-block">@{{ errors['researchdegrees.'+$index+'.course_id']}}</span>
			</div>
			{!! Form::label('other_course','Mention Course',['class' => 'col-sm-2 control-label','v-if'=>"researchCourse.course_id =='-1'"]) !!}
			<div class="col-sm-3" v-bind:class="{ 'has-error': errors['researchdegrees.'+$index+'.other_course'] }"  v-if="researchCourse.course_id =='-1'">
				{!! Form::text('other_course',null,['class' => 'form-control','v-model'=>'researchCourse.other_course']) !!}
				<span id="basic-msg" v-if="errors['researchdegrees.'+$index+'.other_course'] " class="help-block">@{{ errors['researchdegrees.'+$index+'.course_id']}}</span>
			</div>
		</div>
		<div class="form-group" v-show="showRecSection">
				{!! Form::label('research_area','Area of Research:',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-5"  v-bind:class="{ 'has-error': errors['researchdegrees.'+$index+'.research_area'] }" >
					{!! Form::text('research_area',null,['class' => 'form-control','v-model'=>'researchCourse.research_area']) !!}
					<span id="basic-msg" v-if="errors['researchdegrees.'+$index+'.research_area'] " class="help-block">@{{ errors['researchdegrees.'+$index+'.research_area']}}</span>
				</div>
				{!! Form::label('passing_year','Year',['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-3" v-bind:class="{ 'has-error': errors['researchdegrees.'+$index+'.passing_year']}">
				{!! Form::text('passing_year',null,['class' => 'form-control','max-length'=>'10','v-model'=>'researchCourse.passing_year']) !!}
				<span id="basic-msg" v-if="errors['researchdegrees.'+$index+'.passing_year'] " class="help-block">@{{ errors['researchdegrees.'+$index+'.passing_year']}}</span>
			</div>
		</div>
		<div class="form-group" v-show="showRecSection">
			{!! Form::label('mcm_college','Institution:',['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-5"   v-bind:class="{ 'has-error': errors['researchdegrees.'+$index+'.mcm_college'] }">
					<label class="radio-inline">
							<input type="radio" :name="'mcm_college_re'+$index" value="Y" v-model="researchCourse.mcm_college"> MCM College<br>
						</label>
						<label class="radio-inline">
								<input type="radio" :name="'mcm_college_re'+$index" value="N" v-model="researchCourse.mcm_college">Other Institution <br>
					</label>
				<span id="basic-msg" v-if="errors['researchdegrees.'+$index+'.mcm_college'] " class="help-block">@{{ errors['researchdegrees.'+$index+'.mcm_college']}}</span>
			</div>
			{!! Form::label('other_institute','Institution/University',['class' => 'col-sm-2 control-label' ,'v-if'=>"researchCourse.mcm_college == 'N'"]) !!}
			<div class="col-sm-3"  v-bind:class="{ 'has-error': errors['researchdegrees.'+$index+'.other_institute'] }" v-if="researchCourse.mcm_college == 'N'">
				{!! Form::text('other_institute',null,['class' => 'form-control','max-length'=>'10','v-model'=>'researchCourse.other_institute']) !!}
				<span id="basic-msg" v-if="errors['researchdegrees.'+$index+'.other_institute'] " class="help-block">@{{ errors['researchdegrees.'+$index+'.other_institute']}}</span>
			</div>
			<div class="col-sm-12" v-if="$index > 0">
			{!! Form::button('Remove',['class' => 'btn btn-success pull-right' , '@click.prevent' => 'removeRow($index,"research")']) !!}
			</div>
		</div>
	</div>
	<div class="form-group" v-show="showRecSection">
		<div class="col-sm-12">
		  {!! Form::button('Add Another',['class' => 'btn btn-success pull-right', '@click' => 'addRow("research")']) !!}
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Competitive Exams </legend>
	<div class="form-group">
		{!! Form::label('ugc_qualified','Did you clear UGC NET?',['class' => 'col-sm-4 control-label required']) !!}
		<div class="col-sm-2">
			<label class="radio-inline">
				<input type="radio" name="ugc_qualified" value="Y" v-model="ugc_qualified" @change="changedUGCExam">Yes<br>
			</label>
			<label class="radio-inline">
					<input type="radio" name="ugc_qualified" value="N" v-model="ugc_qualified" @change="changedUGCExam">No<br>
			</label>
			{{-- <label class="col-sm-2 checkbox">
			<input type="checkbox" name="ugc_qualified"  v-model='ugc_qualified' v-bind:true-value="'Y'"
					v-bind:false-value="'N'" class="minimal" @change="changedUGCExam" />Yes
			</label> --}}
		</div>
		{!! Form::label('ugc_subject_name','Subject',['class' => 'col-sm-1 control-label required' ,'v-if'=>"ugc_qualified == 'Y'"]) !!}
		<div class="col-sm-3" v-bind:class="{ 'has-error': errors['ugc_subject_name'] }" v-if="ugc_qualified == 'Y'">
			{!! Form::text('ugc_subject_name',null,['class' => 'form-control','max-length'=>'10','v-model'=>'ugc_subject_name']) !!}
			<span id="basic-msg" v-if="errors['ugc_subject_name']" class="help-block">@{{ errors['ugc_subject_name']}}</span>
		</div>
		{!! Form::label('ugc_year','Year',['class' => 'col-sm-1 control-label required' ,'v-if'=>"ugc_qualified == 'Y'"]) !!}
		<div class="col-sm-1" v-bind:class="{ 'has-error': errors['ugc_year'] }" v-if="ugc_qualified == 'Y'">
			{!! Form::text('ugc_year',null,['class' => 'form-control','max-length'=>'10','v-model'=>'ugc_year']) !!}
			<span id="basic-msg" v-if="errors['ugc_year']" class="help-block">@{{ errors['ugc_year']}}</span>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('competitive_exam_qualified','Did you clear any other competitive exam?',['class' => 'col-sm-4 control-label required']) !!}
		<div class="col-sm-2">
				<label class="radio-inline">
					<input type="radio" name="competitive_exam_qualified" value="Y" v-model="competitive_exam_qualified" @change="changedCompetitiveExam">Yes<br>
				</label>
				<label class="radio-inline">
						<input type="radio" name="competitive_exam_qualified" value="N" v-model="competitive_exam_qualified" @change="changedCompetitiveExam">No<br>
				</label>
			{{-- <label class="col-sm-2 checkbox">
			<input type="checkbox" name="competitive_exam_qualified"  v-model='competitive_exam_qualified' v-bind:true-value="'Y'"
					v-bind:false-value="'N'" class="minimal" @change="changedCompetitiveExam"/>Yes
			</label> --}}
		</div>
		{!! Form::label('competitive_exam_id','Exam',['class' => 'col-sm-1 control-label required' ,'v-if'=>"competitive_exam_qualified == 'Y'"]) !!}
		<div class="col-sm-3" v-bind:class="{ 'has-error': errors['competitive_exam_id'] }" v-if="competitive_exam_qualified == 'Y'">
				<select class="form-control" v-model="competitive_exam_id">
					<option value="0">Select</option>
					<option v-for="exam in competitive" :value="exam.id">@{{ exam.name }}</option>
					<option value="-1">Other</option>
				</select>
			<span id="basic-msg" v-if="errors['competitive_exam_id']" class="help-block">@{{ errors['competitive_exam_id'][0] }}</span>
		</div>
		{!! Form::label('competitive_exam_year','Year',['class' => 'col-sm-1 control-label required' ,'v-if'=>"competitive_exam_qualified == 'Y'"]) !!}
		<div class="col-sm-1" v-bind:class="{ 'has-error': errors['competitive_exam_year'] }" v-if="competitive_exam_qualified == 'Y'">
			{!! Form::text('competitive_exam_year',null,['class' => 'form-control','max-length'=>'10','v-model'=>'competitive_exam_year']) !!}
			<span id="basic-msg" v-if="errors['competitive_exam_year']" class="help-block">@{{ errors['competitive_exam_year']}}</span>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('other_competitive_exam','Mention Other Exam',['class' => 'col-sm-2 control-label' ,'v-if'=>"competitive_exam_id == '-1'"]) !!}
		<div class="col-sm-3" v-bind:class="{ 'has-error': errors['other_competitive_exam'] }" v-if="competitive_exam_id == '-1'">
			{!! Form::text('other_competitive_exam',null,['class' => 'form-control','max-length'=>'10','v-model'=>'other_competitive_exam']) !!}
			<span id="basic-msg" v-if="errors['other_competitive_exam']" class="help-block">@{{ errors['other_competitive_exam']}}</span>
		</div>
		{!! Form::label('upsc_psu_exam_name','Name of Service',['class' => 'col-sm-2 control-label' ,'v-if'=>"competitive_exam_id == '1' || competitive_exam_id == '2'"]) !!}
		<div class="col-sm-3" v-bind:class="{ 'has-error': errors['upsc_psu_exam_name'] }" v-if="competitive_exam_id == '1' || competitive_exam_id == '2'">
			{!! Form::text('upsc_psu_exam_name',null,['class' => 'form-control','max-length'=>'10','v-model'=>'upsc_psu_exam_name']) !!}
			<span id="basic-msg" v-if="errors['upsc_psu_exam_name']" class="help-block">@{{ errors['upsc_psu_exam_name']}}</span>
		</div>
	</div>
</fieldset>
 
      