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
        <!-- <div class="box-header with-border"  v-show="(instructions == 'Y' && proceed == true) || form_id > 0 " >
          <div class="pull-left">
            <h3 class="box-title"><strong style="font-size:16px">Admission Form</strong></h3>
          </div>
          <div class="pull-right">
            <li type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Instructions</li>                  
          </div>
        </div> -->
        <div class="box-body" >
            <div class="nav-tabs-custom" id="admTabs">
                <ul class="nav nav-tabs">
                  <li id="active7" class="active"><a href="#adm-attachment" data-toggle="tab">Attachments</a></li>
            
                </ul>
            </div>
            <div class="tab-content" >
                <div class="tab-pane active" id="adm-attachment">
                  <fieldset
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
         
      </div>

      
      {!! Form::close() !!}  
    </div>
    @include('admissionformnew._attachments')
    

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
         
        }
      },

      // created: function() {
      //   this.active_tab = {{ $active_tab }};
      // },
      ready: function(){
        
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

