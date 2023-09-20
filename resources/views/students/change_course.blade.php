<template id="bs-modal-course">
  <div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel" data-backdrop="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header with-border">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="courseModalLabel">Update Course</h4>
        </div>
        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
        <div class="modal-body" >
          <div class="form-group">
            {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['student.course_id'] }">
              {!! Form::select('course_id',\App\Course::pluck('course_name','id'),null,['class' => 'form-control','v-model'=>'course_id','@change'=>'showSubs']) !!}
            </div>
            {!! Form::label('course_code','Course Code',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
              <p class="form-control-static">@{{ course_code}}</p>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('subject_id','Subjects : ',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::label('comp_subject','Compulsory Groups : ',['class' => 'col-sm-2 control-label']) !!}
            <ul class = ""><comp-grps v-for="cgrp in compGrp" :cgrp='cgrp' type='C'></comp-grps></ul>
          </div>
          <!-- <div class="form-group">
            <div v-bind:class="{ 'has-error': errors['opt_subs_count'] }">
              <div class="col-sm-8">
                <p><strong>Elective Subjects:</strong><span v-if = "min_optional >0 "> Select Any <strong>@{{ min_optional}} </strong>Of The Following</span></p>
              </div>
              <div class="form-group" >
                <div class="col-sm-8 col-sm-offset-2" >
                  <div v-for="sub in optionalSub">
                    <div class="col-sm-12">
                      <label class="checkbox">
                        <input type="checkbox" name= "optional_sub[]" value= "@{{ sub.id }}" number v-model="selectedOpts" class="">
                        @{{ sub.subject }}      
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <ul class = ""> <comp-grps v-for="cgrp in optionalGrp" :cgrp='cgrp' type='O'></comp-grps></ul>
            </div>
          </div> -->
          <div class="col-sm-12" v-if='electives.length > 0'>
          <p>
            <h4><strong>Elective Subjects:</strong></h4><span v-if="min_optional >0 ">A student is required to select <strong>@{{ min_optional}} </strong> electives.</span><br>Choose any one option from the following & select two or more electives from the given choices</h>
          </p>
        </div>
        
        <div v-for="elective in electives">
          <div v-show='elective.elective_subjects.length > 0 || elective.groups.length > 0'>
            <div class="form-group" >
              <div class='col-sm-12'>
                <button class='tooltip-btn' @click.prevent='selectElective(elective.id)'>
                  <span class="tooltiptext">Click this to select subjects from given list</span>
                  <span v-if="elective.id != student.selected_ele_id" ><i class="glyphicon glyphicon-unchecked"  style="font-size:20px;margin-left:20px;color:black"> </i></span>&nbsp;&nbsp;
                  <span v-if="elective.id == student.selected_ele_id" class="glyphicon glyphicon-ok" style="font-size:20px;margin-left:10px;;margin-right:10px;color:green" aria-hidden="true"></span>
                  @{{ elective.name }}
                </button>
              </div>
            </div>
            <div v-if='student.selected_ele_id == 0 || elective.id == student.selected_ele_id'>
              <div class="form-group"  >
                <div class="col-sm-8 col-sm-offset-2" >
                  <div v-for="sub in elective.elective_subjects">
                    <div class="col-sm-12">
                      <label class="checkbox" >
                              <input type="checkbox" name= "optional_sub[]" value= "@{{ sub.subject_id }}" number v-model="selectedOpts" class="">
                              @{{ sub.subject.subject }}      
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <ul class = ""><comp-grps v-for="cgrp in elective.groups" :cgrp='cgrp' :type='cgrp.type'></comp-grps></ul>
            </div>
          </div>
        </div>
        <!-- Elective Options -->
          <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> @{{ response['success'] }}
          </div>
          <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
            <li v-for='error in errors'>@{{ error[0] }}<li>
          </ul>
        </div>
        <div class="form-group" >
          {!! Form::label('addon_course_id','Add-On Course',['class' => 'col-sm-3 control-label']) !!}
          <div class="col-sm-5">
            {!! Form::select('addon_course_id',getAddOnCourses(),null,['class' => 'form-control','v-model'=>'addon_course_id']) !!}
          </div>
        </div>
        <div class="modal-footer">
          {!! Form::submit('Update',['class' => 'btn btn-primary','@click.prevent'=>'updateCourse']) !!}
          {!! Form::close() !!}
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>

        {{ getVueData() }}
      </div>
    </div>
  </div>
</template>
<template id="course-comp-grp-template" >
  <div class="col-sm-10 col-sm-offset-2">
    <li>
      <div class='form-group'>
        <div class="input-group">
          <label class="checkbox-inline" >
            <input type="checkbox"  name='grps[@{{ type }}][@{{ cgrp.id }}]' value="" @change='unselected' v-model='checked'>

            <label class="radio-inline radio-margin" v-for="sub in cgrp.details" >
              <input type="radio" name="cmp_grp[@{{ cgrp.id }}]'" class="sub_@{{ cgrp.id }}" value="@{{ sub.ele_group_id ? sub.subject.id : sub.id }}" v-model="cgrp.selectedid" @click='selected'>
              <!--{!! Form::radio('cmp_grp[@{{ cgrp.id }}]',"@{{ sub.id }}" ,null, ['@click'=>'selected', 'class' => 'sub_@{{ cgrp.id }}']) !!}-->
              @{{ sub.ele_group_id ? sub.subject.subject : sub.subject }}
            </div>
          </label>
        </div>
      </div>
    </li>
  </div>
</template>
@push('vue-components')
<script>
  Vue.component('course-modal', {
    template: '#bs-modal-course',
    props: [],
    data: function () {
        return {
          student_id: 0,
          student: {},
          course_id : {{ $student->course_id or 0}},
         // min_optional: "{!! isset($course) ? $course->min_optional : '' !!}",
          compSub: {!! isset($compSubs) ? json_encode($compSubs) : '{}' !!},
          compGrp: {!! isset($compGrps) ? json_encode($compGrps) : '{}' !!},
          optionalSub: {!! isset($optionalSubs) ? json_encode($optionalSubs) : '{}' !!},
          optionalGrp: {!! isset($optionalGrps) ? json_encode($optionalGrps) : '{}' !!},
          electives: {!! isset($electives) ? json_encode($electives) : '[]' !!},
          selectedOpts: {!! isset($selectedOpts) ? json_encode($selectedOpts) : '[]' !!},
          course_code: "{!! isset($course) ? $course->class_code : '' !!}",
          addon_course_id: 0,
          response: {},
          success: false,
          fails: false,
          msg: '',
          errors: [],
          row: 0,
          col: 0,
        }
    },
    methods: {
      selectElective: function(ele_id) {
        if(ele_id > -1) {
          this.student.selected_ele_id = this.student.selected_ele_id != ele_id ? ele_id : 0;
          this.selectedOpts = [];
        }
        var self = this;
        $.each(this.electives, function(key, elective) {
          if(elective.id == self.student.selected_ele_id) {
            $.each(elective.elective_subjects, function(key1, sub) {
              if(sub.sub_type == 'C') {
                self.selectedOpts.push(sub.subject_id);
              }
            });
          }
        });
      },
      getStdCourse: function() {
        this.errors = {};
        this.$http['get']("{{ url('students') }}/" + this.student_id + '/course')
          .then(function (response) {
            self = this;
            if(response.data.success) {
              this.student = response.data.student;
              this.course_id = this.student.course_id;
              this.compSub = response.data.compSubs;
              this.compGrp = response.data['compGrps'];
              this.optionalSub = response.data['optionalSubs'];
              this.optionalGrp = response.data['optionalGrps'];
              this.electives = response.data['electives'];
              this.selectedOpts = response.data['selectedOpts'] ? response.data['selectedOpts'] : [];
              this.course_code = response.data['course'] ? response.data['course'].class_code : '';
              this.addon_course_id = response.data['student']['adm_entry']['addon_course_id'];
              $('#courseModal').modal('show');
              setTimeout(function() {
                self.success = false;
              }, 3000);
            }
          }, function (response) {
            this.fails = true;
            self = this;
            if(response.status == 422) {
              this.errors = response.data;
            }              
          });
      },
      showSubs: function(e) {
          console.log(this.course_id);
          this.selectedOpts = [];
          this.$http.post("{{ url('courses/subs') }}",{'course_id': this.course_id})
          .then(function (response) {
            //$('#').blockUI();
            this.compSub = response.data.compSub;
            this.compGrp = response.data['compGrp'];
            this.optionalSub = response.data['optionalSub'];
            this.optionalGrp = response.data['optionalGrp'];
            this.course_code = response.data['course'].class_code;
//              console.log(this.course_code = response.data['course']);
            var electives = response.data.electives;
            $.each(electives, function(key, elective) {
              $.each(elective.groups, function(key, grp) {
                if(typeof grp.selectedid == 'undefined') {
                  grp.selectedid = 0;
                }
              });
            });
            this.electives = electives;
          }, function (response) {
            self = this;
            $.each(response.data, function(key, val) {
              self.msg += key+': '+val+' ';
            });
          });
      },
      
      updateCourse: function() {
        console.log('here');
        this.errors = {};
        var data = $.extend({'elective_grps': this.elective_grps}, this.$data);
        this.$http['post']("{{ url('students') }}/" + this.student_id + '/course', data)
        .then(function (response) {
          self = this;
          if(response.data.success) {
            this.response = response.data;
            this.success = true;
            if(response.data.course) {
              console.log(dashboard.table.cell(this.row, this.col).data());
              dashboard.table.cell(this.row, this.col).data(response.data.course).draw();
            }
            setTimeout(function() {
              self.success = false;
              $('#courseModal').modal('hide');
              self.student = {};
              self.course_id = 0;
              self.compSub = [];
              self.compGrp = [];
              self.optionalSub = [];
              self.optionalGrp = [];
              self.electives = [];
              self.selectedOpts = [];
              self.course_code = '';
              self.response = {};
            }, 1000);
          }
        }, function (response) {
          this.fails = true;
          self = this;
          if(response.status == 422) {
            this.errors = response.data;
          }              
        });
      },
      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
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
          if(elective.id == self.student.selected_ele_id) {
            $.each(elective.groups, function(key1, grp) {
              ele_grps.push(grp);
            });
          }
        });
        return ele_grps;
      },
    },
    events: {
      'show-course': function(student_id, row, col) {
        // `this` in event callbacks are automatically bound
        // to the instance that registered it
        this.student_id = student_id;
        this.row = row;
        this.col = col;
        this.getStdCourse();
      }
    },
    components: {
      'comp-grps': {
        template: "#course-comp-grp-template",
        props: ['cgrp', 'type', 'disableSubjects'],
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
//            this.cgrp.selectedid = this.id;
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
    }
  });
  
</script>
@endpush