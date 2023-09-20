@extends('online.dashboard')
@section('content')
<div>
  <div class="box box-info" id='app'>
    <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Success!</strong> @{{ response['success'] }}
    </div>
    <ul class="alert alert-error alert-dismissible" role="alert" v-if="fails">
      <li  v-for='error in errors'>@{{ error}} <li>
    </ul>
    <div class="box-header with-border">
      <h3 class="box-title">Admission Form</h3>
    </div>
    <div class="box-body">
      @if(isset($adm_form))
      {!! Form::model($adm_form, ['method' => 'PATCH', 'action' => ['Online\StdAdmFormController@update', $adm_form->id], 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
      @else
      {!! Form::model($adm_form = new \App\AdmissionForm(),['url' => 'admforms', 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
      @endif
      @include('admissionform._form_student')
      @include('admissionform._form_parent')
      @include('admissionform._form_academic')
    </div>
    <div class="box-footer">
      @if($adm_form->exists)
      <input class="btn btn-primary" id="btnsubmit"  type="submit" value="UPDATE" @click.prevent="admit">
      {!! Form::close() !!}
      <button class="btn btn-primary" id="add_attachment">Attachments</button>
      @else
      <input class="btn btn-primary" id="btnsubmit" type="submit" value="ADD" @click.prevent="admit">
      @endif
      {!! Form::close() !!}
    </div>
    
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

  $('#others').on('ifChecked', function (event) {
  $('#checked').show();
  //alert(event.type + ' callback');
  });

</script>
@stop
