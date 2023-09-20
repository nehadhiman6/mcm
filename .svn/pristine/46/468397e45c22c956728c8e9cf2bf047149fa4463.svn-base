<template id="bs-modal-subjects">
  <div class="modal fade" id="subjectModal" tabindex="-1" role="dialog" aria-labelledby="subjectModalLabel" data-backdrop="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header with-border">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="subjectModalLabel">Update Subjects</h4>
        </div>
        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
        <div class="modal-body" >
          <div class="form-group">
            {!! Form::label('course','Course',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              <p class="form-control-static">@{{ (student && student.course) ? student.course.course_name : '' }}</p>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('subject_id','Subjects : ',['class' => 'col-sm-2 control-label']) !!}
            {!! Form::label('comp_subject','Compulsory Groups : ',['class' => 'col-sm-2 control-label']) !!}
            <ul class = "">
              <comp-grps v-for="cgrp in compGrp" :cgrp='cgrp' type='C'></comp-grps>
            </ul>
          </div>
          <div class="form-group">
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
              <ul class = "">
                <comp-grps v-for="cgrp in optionalGrp" :cgrp='cgrp' type='O'></comp-grps>
              </ul>
            </div>
          </div>
          
          <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> @{{ response['success'] }}
          </div>
          <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
            <li v-for='error in errors'>@{{ error[0] }}<li>
          </ul>
        </div>
        <div class="modal-footer">
          {!! Form::submit('Update Subject',['class' => 'btn btn-primary pull-left','@click.prevent'=>'updateSubjects']) !!}
          {!! Form::close() !!}
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
        {{ getVueData() }}
      </div>
    </div>
  </div>
</template>

<template id="comp-grp-template" >
  <div class="col-sm-10 col-sm-offset-2">
    <li>
      <div class='form-group'>
        <div class="input-group">
          <label class="checkbox-inline" >
            <input type="checkbox" name='grps[@{{ type }}][@{{ cgrp.id }}]' value="" @change='unselected' v-model='checked'>

            <label class="radio-inline radio-margin" v-for="sub in cgrp.details" >
              <input type="radio" name="cmp_grp[@{{ cgrp.id }}]'" class="sub_@{{ cgrp.id }}" value="@{{ sub.id }}" v-model="cgrp.selectedid" @click='selected'>
              <!--{!! Form::radio('cmp_grp[@{{ cgrp.id }}]',"@{{ sub.id }}" ,null, ['@click'=>'selected', 'class' => 'sub_@{{ cgrp.id }}']) !!}-->
              @{{ sub.subject }}
            </label>
          </label>
        </div>
      </div>
    </li>

  </div>
</template>

@push('vue-components')
<script>
  Vue.component('sub-modal', {
    template: '#bs-modal-subjects',
    props: [],
    data: function () {
        return {
          student_id: 0,
          min_optional: "{!! isset($course) ? $course->min_optional : '' !!}",
          compGrp: {!! isset($compGrps) ? json_encode($compGrps) : '{}' !!},
          optionalSub: {!! isset($optionalSubs) ? json_encode($optionalSubs) : '{}' !!},
          optionalGrp: {!! isset($optionalGrps) ? json_encode($optionalGrps) : '{}' !!},
          selectedOpts: {!! isset($selectedOpts) ? json_encode($selectedOpts) : '[]' !!},
          student: {},
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
      getStdSubs: function() {
        this.errors = {};
        this.$http['get']("{{ url('students') }}/" + this.student_id + '/subjects')
          .then(function (response) {
            self = this;
            if(response.data.success) {
              this.student = response.data.student;
              this.compSub = response.data.compSubs;
              this.compGrp = response.data['compGrps'];
              this.optionalSub = response.data['optionalSubs'];
              this.optionalGrp = response.data['optionalGrps'];
              this.selectedOpts = response.data['selectedOpts'] ? response.data['selectedOpts'] : [];
              $('#subjectModal').modal('show');
            }
          }, function (response) {
            this.fails = true;
            self = this;
            if(response.status == 422) {
              this.errors = response.data;
            }              
          });
      },
      
      updateSubjects: function() {
        this.errors = {};
        this.$http['post']("{{ url('students') }}/" + this.student_id + '/subjects', this.$data)
          .then(function (response) {
            self = this;
            if(response.data.success) {
              this.response = response.data;
              this.success = true;
              setTimeout(function() {
                self.success = false;
                $('#subjectModal').modal('hide');
                self.student_id = 0;
                self.student = {};
                self.compSub = {};
                self.compGrp = {};
                self.optionalSub = {};
                self.optionalGrp = {};
                self.selectedOpts = [];
                self.response = {};
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
    },
    events: {
      'show-subjects': function(student_id, row, col) {
        // `this` in event callbacks are automatically bound
        // to the instance that registered it
        this.student_id = student_id;
        this.row = row;
        this.col = col;
        this.getStdSubs();
      }
    },
    components: {
      'comp-grps': {
        template: "#comp-grp-template",
        props: ['cgrp', 'type'],
        data: function() {
          return {
            checked: false,
          };
        },
        ready: function() {
          if(this.cgrp.selectedid > 0) {
            this.checked = true;
            self = this;
            var chks = $('.sub_'+this.cgrp.id);
            $(chks).each(function(index,value){
              if($(this).val() == self.cgrp.selected){
                $(this).attr('checked',true);
              }
            });
          }
        },
        methods: {
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
      }
    }
  });
  
  
</script>
@endpush