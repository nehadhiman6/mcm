@extends($dashboard)
@if($dashboard == 'app') 
{{-- @section('toolbar')
@include('toolbars._admform_toolbar')
@stop --}}
@endif
@section('content')
<div>
    <div id='app' v-cloak>
      <div class="box box-warning " >
        <div class="box-body" >
            <fieldset
                :is-no-Tabs = "true"
                :courses = "courses"
                :form_id.sync = "form_id"
                :adm-form.sync = "adm_form"
                :comp-sub = "compSub"
                :comp-grp = "compGrp"
                :course_type = "course_type"
                :optional-sub = "optionalSub"
                :optional-grp = "optionalGrp"
                :electives = "electives"
                :honours-subjects = "honoursSubjects"
                :selected_opts = "selected_opts"
                :old_honour = "old_honour"
                :course_id = "course_id"
                is="subject-options"
                :show-prev-next = "false"
                >
            </fieldset>
        </div>
      </div>
    @include('admissionformnew._subject_options')

    </div>
</div>

@stop
@section('script')
  <script>
 
    var vm = new Vue({
      el: '#app',
      data: function(){
        return {
          course_type: '',
          // form_id: {!! $adm_form ? $adm_form->id : 0 !!},
          adm_form : {!! $adm_form !!},
          form_id: 0,
          course_id: {{ intval($adm_form->course_id) }},
          instructions:'N', // by default N
          proceed : false, // by default false
          response: {},
          success: false,
          fails: false,
          msg: '',
          errors: [],
          showIfOldStd: false,
          //data from helper function
          courses: {!! getCoursesForAdmForm(false) !!},
          // compSub: {!! isset($compSubs) ? json_encode($compSubs) : '{}' !!},

          //compact data
          compSub: {!! isset($compSubs) ? json_encode($compSubs) : '{}' !!},
          compGrp: {!! isset($compGrps) ? json_encode($compGrps) : '{}' !!},
          optionalSub: {!! isset($optionalSubs) ? json_encode($optionalSubs) : '{}' !!},
          optionalGrp: {!! isset($optionalGrps) ? json_encode($optionalGrps) : '{}' !!},
          electives: {!! isset($electives) ? json_encode($electives) : '{}' !!},
          honoursSubjects: {!! isset($honoursSubjects) ? json_encode($honoursSubjects) : '[]' !!},
          selected_opts: {!! isset($selectedOpts) ? json_encode($selectedOpts) : '[]' !!},
          old_honour:{!! isset($old_hon_sub) ? json_encode($old_hon_sub) : '{}' !!},
          postgrt: {!! isset($becholor_degree_details) ? json_encode($becholor_degree_details) : "{ bechelor_degree:'',subjects:'', marks_obtained:'', total_marks:'',percentage:'',honour_subject:'',honour_marks:'',honour_total_marks:'',honour_percentage:'',elective_subject:'',ele_obtained_marks:'', ele_total_marks:'',ele_percentage:'',pg_sem1_subject:'',pg_sem1_obtained_marks:'',pg_sem1_total_marks:'',pg_sem1_percentage:'',pg_sem2_result: '' , pg_sem2_subject:'', pg_sem2_obtained_marks:'',pg_sem2_total_marks:'',pg_sem2_percentage:''}" !!},
        }
      },

      // created: function() {
      // },
      ready: function(){
        if(this.form_id == 0){
          $('#myModal').modal('show');
        }
        this.form_id = this.adm_form.id;
      },

      methods:{
        proceedClick:function(){
          var self = this;
          if(self.instructions == 'Y'){
            $('#myModal').modal('hide');
            self.proceed = true;
          }
        },

        updateCourseId(courseId){
          console.log(courseId);
          this.course_id = courseId;
        },

        showHideFields(tabName){
          var self = this;
          // if(tabName == '')
          $.each( self.tabsArr, function( key, value ) {
            if(key == tabName)
              self.tabsArr[key] = true;
            else
              self.tabsArr[key] = false;
          });
        },

        admit: function() {
          var self = this;
          self.errors = {};
          var data = $.extend({'elective_grps': self.elective_grps}, self.$data);
          self.$http[self.getMethod()](self.getAdmitUrl(), data)
            .then(function (response) {
              self.form_id = response.data.form_id;
              if (response.data.success) {
                self.success = true;
                setTimeout(function() {
                  self.success = false;
                //  console.log(self.admitUrl+'/' +self.form_id +'/details');
                  window.location = self.admitUrl+'/' +self.form_id +'/details';
                }, 3000);
              }
            }, function (response) {
              self.fails = true;
              if(response.status == 422) {
                $('body').scrollTop(0);
                self.errors = response.data;
              }              
            });
        },
      }

    });
  </script>
@endsection

