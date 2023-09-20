@extends($dashboard)
@section('content')
@if(isset($guard) && $guard == 'students')
@if(!$adm_form->student || $adm_form->student->adm_cancelled == 'Y')
@include('online.admissions.form_instructions')
@endif
@endif

<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Detail</strong>
  </div>
  <div class='panel-body'>
    <fieldset>
      <legend>Student's Details</legend>
    <div class="col-sm-4">
      <p><strong class='p-head'>Name:</strong> {{ $adm_form->name }}</p>
      <p><strong class='p-head'>Mobile:</strong> {{ $adm_form->mobile }}</p>
      <p><strong class='p-head'>Gender:</strong> {{$adm_form->gender}}</p>
      <p><strong class='p-head'>Religion:</strong>{{ $adm_form->religion }}</p>
      
    </div>
    <div class="col-sm-4">
      <p><strong class='p-head'>Date Of Birth:</strong> {{ $adm_form->dob }}</p>
      <p><strong class='p-head'>Address:</strong> {{ $adm_form->per_address }}</p>
      <p><strong class='p-head'>Pincode:</strong> {{ $adm_form->pincode }}</p>
      <p><strong class='p-head'>Aadhar Number:</strong>{{ $adm_form->aadhar_no }}</p>
      
    </div>
    <div class="col-sm-4">
      <p><strong class='p-head'>Category:</strong>{{ $adm_form->category->name or '' }}</p>
      <p><strong class='p-head'>Reserved Category:</strong>{{ $adm_form->res_category->name or '' }}</p>
      <p><strong class='p-head'>Nationality:</strong>{{ $adm_form->nationality }}</p>
      <p><strong class='p-head'>EPIC No:</strong>{{ $adm_form->epic_no }}</p>
      
    </div>
    </fieldset>
    <fieldset>
  <legend>Parent Details</legend>
  <div class="row">
    <div class="col-lg-4 col-sm-12">
     <legend><h4> Father's Details</h4></legend>
     <p><strong class='p-head'>Name:</strong>{{ $adm_form->father_name or '' }}</p>
     <p><strong class='p-head'>Occupation:</strong>{{ $adm_form->father_occup or '' }}</p>
     <p><strong class='p-head'>Designation:</strong>{{ $adm_form->father_desig or '' }}</p>
     <p><strong class='p-head'>Phone No.:</strong>{{ $adm_form->father_phone or '' }}</p>
     <p><strong class='p-head'>Mobile No.:</strong>{{ $adm_form->father_mobile or '' }}</p>
     <p><strong class='p-head'>Email:</strong>{{ $adm_form->father_email or '' }}</p>
     <p><strong class='p-head'>Address:</strong>{{ $adm_form->father_address or '' }}</p>
     <p><strong class='p-head'>Office Address:</strong>{{ $adm_form->f_office_addr or '' }}</p>
    </div>
    
    <div class="col-lg-4 col-sm-12">
       <legend><h4>Mother's Details</h4></legend>
       <p><strong class='p-head'>Name:</strong>{{ $adm_form->mother_name or '' }}</p>
       <p><strong class='p-head'>Occupation:</strong>{{ $adm_form->mother_occup or '' }}</p>
        <p><strong class='p-head'>Designation:</strong>{{ $adm_form->mother_desig or '' }}</p>
        <p><strong class='p-head'>Phone No.:</strong>{{ $adm_form->mother_phone or '' }}</p>
        <p><strong class='p-head'>Mobile No.:</strong>{{ $adm_form->mother_mobile or '' }}</p>
        <p><strong class='p-head'>Email:</strong>{{ $adm_form->mother_email or '' }}</p>
        <p><strong class='p-head'>Address:</strong>{{ $adm_form->mother_address or '' }}</p>
        <p><strong class='p-head'>Office Address:</strong>{{ $adm_form->m_office_addr or '' }}</p>
    </div>
    <div class="col-lg-4 col-sm-12">
    <legend><h4>Guardian's Details</h4></legend>
        <p><strong class='p-head'>Name:</strong>{{ $adm_form->guardian_name or '' }}</p>
        <p><strong class='p-head'>Occupation:</strong>{{ $adm_form->guardian_occup or '' }}</p>
        <p><strong class='p-head'>Designation:</strong>{{ $adm_form->guardian_desig or '' }}</p>
        <p><strong class='p-head'>Phone No.:</strong>{{ $adm_form->guardian_phone or '' }}</p>
        <p><strong class='p-head'>Mobile No.:</strong>{{ $adm_form->guardian_mobile or '' }}</p>
        <p><strong class='p-head'>Email:</strong>{{ $adm_form->guardian_email or '' }}</p>
        <p><strong class='p-head'>Address:</strong>{{ $adm_form->guardian_address or '' }}</p>
        <p><strong class='p-head'>Office Address:</strong>{{ $adm_form->g_office_addr or '' }}</p>
    </div>
  </div>
</div>
</fieldset>
<fieldset>
  <legend>Academics Details</legend>
    <div class="col-sm-4">
      <p><strong class='p-head'>Panjab Univ. RegNo/PUPIN NO.:</strong> {{ $adm_form->pupin_no  or 'NA'}}</p>
      </div>
    <div class="col-sm-4">
      <p><strong class='p-head'>Panjab Univ. Roll No.:</strong> {{ $adm_form->pu_regno or 'NA'}}</p>
    </div>
    </fieldset>
    <!--<button class="btn btn-primary" id="add_attachment">Add Attachment</button>-->
    @if(isset($guard) && $guard == 'web')
    <a href="{{ url('admission-form/' . $adm_form->id . '/edit') }}" 
       class="btn btn-primary" id="add_attachment">
      Edit Detail
    </a>
    <a href="{{ url('admission-form/' . $adm_form->id ) }}" 
       class="btn btn-primary" id="add_attachment">
      Preview
    </a>
    @endif
    <div class="box box-info" id="attach" style="display: none; margin-top:20px;">
      @include('admissionform._form_attachment')
    </div>
  </div>
</div>
@stop
@section('script')
<script>
  $(document).ready(function () {
    $("#add_attachment").click(function () {
      $("#attach").show();
    });
  });
</script>
@stop
