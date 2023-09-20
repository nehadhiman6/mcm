@extends($dashboard)
@if($dashboard == 'app')
@section('toolbar')
@include('toolbars._admform_toolbar')
@stop
@endif
@section('content')
<div id="app" v-cloak>
  <ul class="alert alert-info alert-dismissible" role="alert">
    <li>For any query, please write to us as per contact details given here: <a href="https://mcmdavcwchd.edu.in/admission-enquiries/" target="_blank">mcmdavcwchd.edu.in/admission-enquiries</a></li>
  </ul>
    <div>
      <ul class="alert alert-error alert-dismissible" role="alert" v-show="fails">
        <li  v-for='error in errors'>@{{ error}} </li>
      </ul>
      
      @if(isset($adm_form))
        {!! Form::model($adm_form, ['method' => 'PATCH', 'action' => ['AdmissionFormController@update', $adm_form->id], 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
      @else
        {!! Form::model($adm_form = new \App\AdmissionForm(),['url' => 'admission-form', 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
      @endif

      <div class="box box-warning " >
        <div class="box-header with-border"  v-show="(instructions == 'Y' && proceed == true) || form_id > 0 " >
          <div class="pull-left">
            <h3 class="box-title"><strong style="font-size:16px">Admission Form</strong></h3>
          </div>
          <div class="pull-right">
            <li type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Instructions</li>                  
          </div>
        </div>

        {{-- <div class="box-body" v-show="form_id == 0 && proceed == false" >
          @include('admissionformnew.pre_instructions')
        </div> --}}

        <div class="box-body" v-show = "(instructions == 'Y' && proceed == true) || form_id > 0 || app_guard == 'web'">
            <div class="nav-tabs-custom" id="admTabs">
                <ul class="nav nav-tabs">
                  <li id="active1" class="active"><a href="#student-detail" data-toggle="tab" >Student's Details</a></li>
                  <li id="active2" class=""><a  href="#parent-detail" data-toggle="tab">Parents' Details</a></li>
                  <li id="active3" class=""><a href="#subject-options" data-toggle="tab">Subjects/Options</a></li>
                  <li id="active4" class=""><a href="#acedmic-detail" data-toggle="tab">Academic Details</a></li>
                  {{-- <li id="active1" v-if="adm_form.active_tab >= 4" @click.prevent="showHideFields('showHostel')" class=""><a href="#hostel" data-toggle="tab">Hostel</a></li> --}}
                  <li id="active5" class=""><a href="#foreign-migration-alumni" data-toggle="tab">Foreign/Migration</a></li>
                  <li id="active6" class=""><a href="#declaration" data-toggle="tab">Declaration</a></li>
                  <li id="active7" class=""><a href="#adm-attachment" data-toggle="tab">Attachments</a></li>
                
              
                </ul>
            </div>
            <div class="tab-content" >
              <div class="tab-pane active" id="student-detail">
                <fieldset
                  :courses = "courses"
                  :form_id.sync = "form_id"
                  :adm-form.sync = "adm_form"
                  :active_tab.sync = "active_tab"
                  :course_id.sync = "course_id"
                  :comp-sub.sync = "compSub"
                  :course_type.sync = "course_type"
                  :comp-grp.sync = "compGrp"
                  :optional-sub.sync = "optionalSub"
                  :optional-grp.sync = "optionalGrp"
                  :electives.sync = "electives"
                  is="student-detail"
                >
                </fieldset>
              </div>
                    
                <div class="tab-pane" id="parent-detail">
                  <fieldset
                    v-if="adm_form.active_tab >= 1 || active_tab >= 1" 
                    :form_id.sync = "form_id"
                    :adm-form.sync = "adm_form"
                    :active_tab = "active_tab"
                    :courses = "courses"
                    is="parent-detail"
                  >
                  </fieldset>
                </div>

                <div class="tab-pane" id="subject-options">
                  <fieldset
                    v-if="adm_form.active_tab >= 2 || active_tab >= 2"
                    :courses = "courses"
                    :form_id.sync = "form_id"
                    :adm-form.sync = "adm_form"
                    :active_tab = "active_tab"
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
                  >
                  </fieldset>
                

                  
                </div>

                <div class="tab-pane" id="acedmic-detail">
                  <fieldset
                    v-if="adm_form.active_tab >= 3 || active_tab >= 3"
                    :form_id = "form_id"
                    :adm-form.sync = "adm_form"
                    :active_tab = "active_tab"
                    :courses = "courses"
                    :course_id = "course_id"
                    :postgrt = "postgrt"
                    is="acedmic-detail"
                  >
                  </fieldset>
                </div>


                <div class="tab-pane" id="foreign-migration-alumni">
                  <div
                    v-if="adm_form.active_tab >= 4 || active_tab >= 4"
                    :form_id = "form_id"
                    :adm-form.sync = "adm_form"
                    :active_tab = "active_tab"
                    :course_id = "course_id"
                    is="foreign-migration-alumni"
                  >
                  </div>
                </div>

                <div class="tab-pane" id="declaration">
                  <fieldset
                    v-if="adm_form.active_tab >= 5 || active_tab >= 5"
                    :form_id.sync = "form_id"
                    :adm-form.sync = "adm_form"
                    :active_tab = "active_tab"
                    is="declaration-component"
                  >
                  </fieldset>
                </div>

                <div class="tab-pane" id="adm-attachment">
                  <fieldset
                    v-if="adm_form.active_tab >= 6 || active_tab >= 6"
                    :form_id = "form_id"
                    :adm-form.sync = "adm_form"
                    :active_tab = "active_tab"
                    :course_id = "course_id"
                    is="adm-attachment"
                  >
                  </fieldset>
                </div>

              </div>

                    </div>
          {{-- 
          <div class="box-footer"  v-show="(instructions == 'Y' && proceed == true) || form_id > 0 || app_guard == 'web'">
              @if($adm_form->exists)
                <input class="btn btn-primary" id="btnsubmit"  type="submit" value="UPDATE" @click.prevent="admit">
                @if(isset($guard)&& $guard == 'web')
                  <button class="btn btn-primary" id="add_attachment">Attachments</button>
                @endif

              @else
                <input class="btn btn-primary" id="btnsubmit" type="submit" value="ADD" @click.prevent="admit">
              @endif

              <div class="alert alert-success alert-dismissible" role="alert" v-show="success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Success!</strong> @{{ response['success'] }}
              </div>
              <div>
                  <ul class="alert alert-error alert-dismissible" role="alert" v-show="fails">
                    <li  v-for='error in errors'>@{{ error}} </li>
                  </ul>
              </div>

          </div> --}}
      </div>

      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Instructions (<span>Scroll down to Continue</span>)</h4>
            </div>
            <div class="modal-body">
              @include('admissionformnew.pre_instructions',['mainTitle' => ""])
            </div>
            <div class="modal-footer">
              <span class="highlighted-instruction"><b>*Online Centralized Admissions : College admission form to be filled only after allotment of seat at DHE portal</b></span>
              {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
            </div>
          </div>
      {!! Form::close() !!}  
    </div>
  {{-- @if($adm_form->exists)
  <div class="box box-info" id="attach" style="display: none; margin-top:20px;">
    @include('admissionform._form_attachment',['student' => $adm_form])
  </div>
  @endif --}}
  @include('admissionformnew._student_detail')
    @include('admissionformnew._parent_detail')
    @include('admissionformnew._subject_options')
    @include('admissionformnew._acadmic')
    @include('admissionformnew._hostel')
    @include('admissionformnew._forei_mig_alumni')
    @include('admissionformnew._attachments')
    @include('admissionformnew._declaration')

</div>
@stop

@section('script')
  <script>
 
    var vm = new Vue({
      el: '#app',
      data: function(){
        return {
          active_tab: '',
          course_type: '',
          // form_id: {!! $adm_form ? $adm_form->id : 0 !!},
          adm_form : {!! $adm_form !!},
          app_guard: "{{ isset($guard) ? $guard : '' }}",
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
      //   this.active_tab = {{ $active_tab }};
      // },
      ready: function(){
        if(this.form_id == 0){
          $('#myModal').modal('show');
        }
        this.active_tab = {{ $active_tab }};
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

