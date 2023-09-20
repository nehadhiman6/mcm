@extends($dashboard)
@if($dashboard == 'app')
@section('toolbar')
@include('toolbars._admform_toolbar')
@stop
@endif
@section('content')
<div>
  <ul class="alert alert-info alert-dismissible" role="alert">
    <li>For any query please mail us at mcmadmissions@gmail.com</li>
  </ul>
    <div id='app' v-cloak>
      <ul class="alert alert-error alert-dismissible" role="alert" v-show="fails">
        <li  v-for='error in errors'>@{{ error}} </li>
      </ul>
      @if(isset($adm_form))
      {!! Form::model($adm_form, ['method' => 'PATCH', 'action' => ['AdmissionFormController@update', $adm_form->id], 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
      @else
      {!! Form::model($adm_form = new \App\AdmissionForm(),['url' => 'admission-form', 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
      @endif
      <div class="box box-info" >
        <div class="box-header with-border"  v-show="(instructions == 'Y' && proceed == true) || form_id > 0 " >
              <h3 class="box-title">Admission Form</h3>
        </div>
        <div class="box-body" v-show = "(instructions == 'Y' && proceed == true) || form_id > 0 || app_guard == 'web'">
      
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#student-detail" data-toggle="tab">Student Detail</a></li>
              <li class=""><a href="#parent-detail" data-toggle="tab">Parent's Details</a></li>
              <li class=""><a href="#subject_options" data-toggle="tab">Subjects/Options</a></li>
              <li class=""><a href="#acedmic_detail" data-toggle="tab">Academic</a></li>
              <li class=""><a href="#hostel" data-toggle="tab">Hostel</a></li>
              <li class=""><a href="#foreign_migration_alumni" data-toggle="tab">Foreign/Migrations/Alumni</a></li>
              <li class=""><a href="#declaration" data-toggle="tab">Declaration</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="student-detail">
                @include('admissionform._form_student')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="parent-detail">
                @include('admissionform._form_parent')
              </div>
              <!-- /.tab-content -->
              @include('admissionform._form_academic')
             
{{-- 0
              <div class="tab-pane" id="attach">
                <div class="box box-default" v-show="form.id > 0">
                  <div class="box-header with-border">
                    <h3 class=box-title>Documents</h3>
                  </div>
                  <div class="box-body">
                    <table class='table table-bordered'>
                      <tr>
                  <th>Document Type</th>
                  <th>Select File</th>
                  <th>Upload</th>
                  <th>Upload Progress</th>
                  <th></th>
                  <th></th>
                        </tr>
                        <tr 
                            is="file-upload" 
                            v-for="file in files" 
                            :files="files" 
                            :employee_id="form.id" 
                            :attach_types="attach_types" 
                            :file="file" 
                            :index="$index"
                        ></tr>
                      </table>
                    </div>
                    <div class="box-footer">
                      <input class="btn btn-warning" type="submit" value="Add File" @click.prevent="addFile">
                    </div>
                  </div>
                <div v-else>
                  First save the employee then you can add documents for him.
                </div>
              </div> --}}
            </div>
          </div>

          {{-- @include('admissionform._form_student')
          @include('admissionform._form_parent')
          @include('admissionform._form_academic') --}}
        </div>
        <div class="box-body" v-show="form_id == 0 && proceed == false" >
            @include('admissionform.pre_instructions')
        </div>
        <div class="box-footer"  v-show="(instructions == 'Y' && proceed == true) || form_id > 0 || app_guard == 'web'">
            @if($adm_form->exists)
            <input class="btn btn-primary" id="btnsubmit"  type="submit" value="UPDATE" @click.prevent="admit">
              {{-- {!! Form::close() !!} --}}
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
                  {{-- {{ getVueData() }} <br><br> --}}
            <div>
                <ul class="alert alert-error alert-dismissible" role="alert" v-show="fails">
                  <li  v-for='error in errors'>@{{ error}} </li>
                </ul>
            </div>
        </div>
      </div>
      {!! Form::close() !!}
      
    </div>
  @if($adm_form->exists)
  <div class="box box-info" id="attach" style="display: none; margin-top:20px;">
    @include('admissionform._form_attachment',['student' => $adm_form])
  </div>
  @endif
</div>
@stop
@section('script')
<script>
  $('#add_row').click(function () {
      $('#table-academic').append(
              '<tr>\n\
              <td><input type="text" name="acades[' + no + '][exam]" value=""  class ="form-control"/></td>\n\
              <td><input type="text" name="acades[' + no + '][institute]" value=""  class ="form-control"/></td>\n\
              <td> {!! Form::select('board_id',getBoardlist(),null,['class' => 'form - control select2']) !!}</td>\n\
              <td><input type="text" name="acades[' + no + '][rollno]" value="" class ="form-control"/></td>\n\
              <td><input type="text" name="acades[' + no + '][year]" value="" class ="form-control"/></td>\n\
              <td><input type="text" name="acades[' + no + '][result]" value="" class ="form-control"/></td>\n\
              <td><input type="text" name="acades[' + no + '][marks]" value="" class ="form-control" /></td>\n\
              <td><input type="text" name="acades[' + no + '][marks_per]" value="" class ="form-control"/></td>\n\
              <td><input type="text" name="acades[' + no + '][subjects]" value="" class ="form-control"/></td>\n\
              </tr>');
      no++;
  });
  $('#others').on('ifChecked', function (event) {
      $('#checked').show();
      //alert(event.type + ' callback');
  });

</script>
@stop
