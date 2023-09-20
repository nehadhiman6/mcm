@extends('app')
@section('toolbar')
@include('toolbars.alumni_toolbar')
@stop
@section('content')
<div class="box box-default box-solid" id='app' v-cloak>
    <div class="box-header with-border">
        Filter
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group row">
        {!! Form::label('course_type','Course Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">                                                                                     
        {!! Form::select('course_type',[''=>'Select','GRAD'=>'UG','PGRAD'=>'PG'],null,['class' => 'form-control','v-model'=>'course_type','@change'=>'changeCourseType']) !!}
        </div>
        {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3">                                                      
          <select class="form-control" v-model="course_id" >                      
            <option value="0">Select</option>
            <option v-for="course in courses" :value="course.id">@{{ course.course_name }}</option>
          </select>
        </div>
          {!! Form::label('passout_year',' Passout Year',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
              <select class="form-control"  v-model="passout_year">                      
                  <option value="0">Select</option>
                  <option v-for="pass in pass_years" :value="pass">@{{ pass }}</option>
                </select>
          </div>
        </div>
      <!-- <div class="form-group row">
        
       
      </div> -->
      <div class="form-group row text-center">
        <b>OR</b>
      </div>
      <div class="form-group row">
          {!! Form::label('type','Type',['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-2">
            {!! Form::select('type',getCoursesType(),null,['class' => 'form-control ','v-model' => 'type','@change'=>'changeType']) !!}
            <span id="basic-msg" v-if="errors['type']" class="help-block">@{{ errors['type'][0] }}</span>
          </div>
          {!! Form::label('course_id','Course filled by Student',['class' => 'col-sm-2 control-label', 'v-show' => 'type != "" ']) !!}
          <div class="col-sm-3" v-if="type != '' && type == 'UG' ">
              <select class="form-control" v-model="student_course_id" @change.prevent = 'changeType'>
                  <option value="0">Select</option>
                  <option v-for="course in graduateCourses" :value="course.id">@{{ course.name }}</option>
              </select>    
          </div>
          <div class="col-sm-3" v-if="type != '' && type == 'PG' ">
            <select class="form-control" v-model="student_course_id" @change.prevent = 'changeType'>
                <option value="0">Select</option>
                <option v-for="course in postGraduateCourses" :value="course.id">@{{ course.name }}</option>
            </select>    
          </div>
          <div class="col-sm-3" v-if="type != '' && type == 'Professional' ">
            <select class="form-control" v-model="student_course_id" @change.prevent = 'changeType'>
                <option value="0">Select</option>
                <option v-for="course in professionalCourses" :value="course.id">@{{ course.name }}</option>
            </select>    
          </div>
          <div class="col-sm-3" v-if="type != '' && type == 'Research' ">
            <select class="form-control" v-model="student_course_id">
                <option value="0">Select</option @change.prevent = 'changeType'>
                <option v-for="course in researchCourses" :value="course.id">@{{ course.name }}</option>
            </select>    
          </div>

          
      </div>
      <div class="form-group row" style="margin:0 0 0 37px;">
        <div >
              <label class="checkbox">
              <input type="checkbox" name="life" v-model= "life" 
              v-bind:true-value="'Y'" 
              v-bind:false-value="'N'" >
                <!-- <input type="checkbox" name="life" value='Y'  v-model="life" class="minimal"> -->
                Show Only Life Time Members.
              </label>    
          </div>
        </div>
      <div class="box-footer">
        {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
        {!! Form::close() !!}
      </div>

</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Alumni
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
    </table>
  </div>
</div>
<div id="subject-box"></div>
@stop
@section('script')
<script>
var dashboard = new Vue({
  el: '#app',
  data: {
    tData: [],
    course_type: '',       
    passout_year:'',
    course_id:'0',
    type:'',
    student_course_id:'0',
    life:'N',
    table: null,
    graduateCourses: {!! graduateCourses() !!},
    postGraduateCourses: {!! postGraduateCourses() !!},
    professionalCourses: {!! professionalCourses() !!},
    researchCourses: {!! researchCourses() !!},
    courses: {!! json_encode(getFinalYearCourses()) !!},
		pass_years:{!! json_encode(getPassingYears()) !!},
    errors: {},

    },
  created: function() {
      self = this;
      var targert_on = 0;
      this.table = $('#example1').DataTable({
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
           'pageLength',
            {
                extend: 'excelHtml5',
                exportOptions: { orthogonal: 'export' }
            },
          ],
        "processing": true,
        "scrollCollapse": true,
        "ordering": true,
        data: [],
        columnDefs: [
          { title: 'S.No.', targets: targert_on++, data: 'id',
          "render": function( data, type, row, meta) {
            return meta.row + 1;
          }},
          { title: 'Name', targets: targert_on++, data: 'name'},
          { title: 'Father Name', targets: targert_on++, data: 'father_name' },
          { title: 'Mother Name',targets: targert_on++, data: 'mother_name' },
          { title: 'Course',targets: targert_on++, data: 'id' ,
            "render":function(data,type,row,meta){
              var str = '';
              if(row.course){
                str+= row.course.course_name;
              }
              // if(row.previousyearstudent && row.previousyearstudent.course){
              //   str+= row.previousyearstudent.course.course_name;
              // }
              return str;
            }
          },
          { title: 'Pass Out Year',targets: targert_on++, data: 'passout_year' },
          { title: 'DOB', targets: targert_on++, data: 'dob' },
          { title: 'Mobile', targets: targert_on++, data: 'mobile' },
          { title: 'Email', targets: targert_on++, data: 'email' },
          { title: 'PU Pupin', targets: targert_on++, data: 'pu_pupin' },
          { title: 'PU Reg No',targets: targert_on++, data: 'pu_regno' },
          { title: 'Gender', targets: targert_on++, data: 'gender' },
          { title: 'Address', targets: targert_on++, data: 'per_address' },
          { title: 'UG Course/Year/Institution', targets: targert_on++,
              "render": function( data, type, row, meta) {
                var str = '';
                var passing_year = '';
                var insti = '';
                if(row.graduatecourse == null)
                return '';
                row.graduatecourse.forEach(function(e) {
                  passing_year = e.passing_year;
                  if(e.mcm_college == 'Y')
                      insti = 'MCM College';
                    else
                      insti = e.other_institute;
                  if(e.course_id == 1)
                    str += 'Bachelor of Arts (BA)/';
                  else if(e.course_id == 2)
                    str += 'Bachelor of Commerce (B.Com)';
                  else if(e.course_id == 3)
                    str += 'Bachelor of Computer Application (BCA)';
                  else if(e.course_id == 4)
                    str += 'Bachelor of Business Administration (BBA)';
                  else if(e.course_id == 5)
                    str += 'Microbial and Food Technology (MFT)';
                  else if(e.course_id == 6)
                    str += 'Bachelor of Science (B.Sc)-Medical';
                  else if(e.course_id == 7)
                    str += 'Bachelor of Science (B.Sc)-Non-Medical';
                  else if(e.course_id == 8)
                    str += 'Bachelor of Science (B.Sc)-Comp.Application';
                  else
                  return '';
                });
                if(row.graduatecourse.length > 0)
                return str +'/'+passing_year+'/'+insti ;
                else
                return '';
          }},
          { title: 'PG Course/Year/Institution', targets: targert_on++,
              "render": function( data, type, row, meta) {
                var str = '';
                var passing_year = '';
                var insti = '';
                row.postgradcourses.forEach(function(e) {
                  passing_year = e.passing_year;
                  if(e.mcm_college == 'Y')
                      insti = 'MCM College';
                    else
                      insti = e.other_institute;
                  if(e.course_id == 1)
                    str += 'Master of Arts (MA)';
                  else if(e.course_id == 2)
                    str += 'Master of Science (M.Sc)';
                  else if(e.course_id == 3)
                    str += 'Master of Commerce (M.Com)';
                  else if(e.course_id == 4)
                    str += 'PGDCM';
                  else if(e.course_id == 5)
                    str += 'PGDCA';
                  else
                  return '';
                });
                
                if(row.postgradcourses.length > 0)
                return str +'/'+passing_year+'/'+insti ;
                else
                return '';
          }},
          { title: 'Professional/Year/Institution', targets: targert_on++,
              "render": function( data, type, row, meta) {
                var str = '';
                var passing_year = '';
                var insti = '';
                row.professionalcourses.forEach(function(e) {
                  passing_year = e.passing_year;
                  if(e.mcm_college == 'Y')
                      insti = 'MCM College';
                    else
                      insti = e.other_institute;
                  if(e.course_id == 1)
                    str += 'Chartered Accountant';
                  else if(e.course_id == 2)
                    str += 'Bachelor of Education (B.Ed)';
                  else if(e.course_id == 3)
                    str += 'Company Secretary';
                  else if(e.course_id == 4)
                    str += 'Bachelor of Law (LLB)';
                  else if(e.course_id == 5)
                    str += 'Master of Business Administration (MBA)';
                  else if(e.course_id == 6)
                    str += 'Nursery Teacher Training (NTT)';
                  else if(e.course_id == 7)
                    str += 'Master of Law and Business (LLM)';
                  else if(e.course_id == 8)
                    str += 'Fashion Designing';
                    else
                  return '';
                });
                if(row.professionalcourses.length > 0)
                return str +'/'+passing_year+'/'+insti ;
                else
                return '';
          }},
          { title: 'Research/Year/Institution', targets: targert_on++,
              "render": function( data, type, row, meta) {
                var str = '';
                var passing_year = '';
                var insti = '';
                if(row.researches == null)
                return '';
                row.researches.forEach(function(e) {
                  passing_year = e.passing_year;
                  if(e.mcm_college == 'Y')
                      insti = 'MCM College';
                    else
                      insti = e.other_institute;
                  if(e.course_id == 1)
                    str += 'Chartered Accountant';
                  else if(e.course_id == 2)
                    str += 'Bachelor of Education (B.Ed)';
                  else if(e.course_id == 3)
                    str += 'Company Secretary';
                  else if(e.course_id == 4)
                    str += 'Bachelor of Law (LLB)';
                  else if(e.course_id == 5)
                    str += 'Master of Business Administration (MBA)';
                  else if(e.course_id == 6)
                    str += 'Nursery Teacher Training (NTT)';
                  else if(e.course_id == 7)
                    str += 'Master of Law and Business (LLM)';
                  else if(e.course_id == 8)
                    str += 'Fashion Designing';
                    else
                  return '';
                });
                if(row.researches.length > 0)
                return str +'/'+passing_year+'/'+insti ;
                else
                return '';
          }},
          { title: 'UGC NET/Subject/Year', targets: targert_on++,
              "render": function( data, type, row, meta) {
                var subject = row.ugc_subject_name ? row.ugc_subject_name + "/" : "" ;
                var year = row.ugc_year ? row.ugc_year : '';
                return subject + year;
          }},
          { title: 'Competitive Exam/Year', targets: targert_on++,
              "render": function( data, type, row, meta) {
                var name = '';
                if(row.competitive_exam_id == 1)
                    name = 'Civil Service (UPSC)/';
                else if(row.competitive_exam_id == 2)
                    name = 'Civil Service(SPSC)/';
                else if(row.competitive_exam_id == 3)
                    name = 'Bank PO/';
                else if(row.competitive_exam_id == 0)
                    name = ' ';
                else
                  name = row.other_competitive_exam+'/';

                return name + row.competitive_exam_year ? row.competitive_exam_year : '';
          }},
          { title: 'Work Type', targets: targert_on++,
              "render": function( data, type, row, meta) {
                var str = '';
                if(row.almexperience == null) {
                return '';
                }else{
                  row.almexperience.forEach(function(e) {
                    if(e.currently_working == 'Y'){
                      str += e.emp_type;
                    }
                });
                return str;
                }
          }},
          { title: 'Awards/Field/Year', targets: targert_on++,
              "render": function( data, type, row, meta) {
                var str = '';
                if(row.alm_award == null){
                return '';
                }else{
                row.alm_award.forEach(function(e) {
                  str += e.award_name + '/'+ e.award_field +'/'+e.award_year+'<br>';
                });
                return str;
              }
          }},
          { title: 'Shared Info View', targets: targert_on++, data: 'remarks' },
          { targets: '_all', visible: true }
        ],
        "sScrollX": true,
      });
      // self.getData();  
  },
  methods: {
    getData: function() {
      var self = this;
        data = {
          course_id: self.course_id,
          course_type:self.course_type,
          passout_year:self.passout_year,
          student_course_id:self.student_course_id,
          type:self.type,
          life:self.life,
        };
        this.$http.get("{{ url('alumnies') }}", {params: data})
          .then(function (response) {
            this.tData = response.data;
            self.errors = {};
            this.reloadTable();
          }, function (response) {
            self = this;
            if(response.status == 422) {
              self.errors = response.data;
            }              
          });
      },
      
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      },

      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
      changeCourseType:function(){
        var self = this;
        self.type = "";
        self.student_course_id = 0;
        data = $.extend({}, {
          course_type: self.course_type,
        })
        this.$http.get("{{url('send-sms-alumni/course-list')}}", {params: data})
          .then(function(response){
            if(response.status == 200){
              self.courses =  response.data.courses;
            }
        })
        .catch(function(){
  
        });
      },

      changeType:function(){
        this.course_type = "";
        this.course_id = 0;
        this.passout_year = "";
      }
  }
  
});
</script>
@stop