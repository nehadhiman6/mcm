@extends('online.dashboard')
@section('content')
<div class='panel panel-default'>
    <div class='panel-heading'>
        <strong>Detail</strong>
    </div>
    <div class='panel-body'>
        <div class="col-sm-4">
              <p><strong class='p-head'>Name:</strong> {{ $student->name }}</p>
              <p><strong class='p-head'>Mobile:</strong> {{ $student->mobile }}</p>
              <p><strong class='p-head'>Gender:</strong> {{$student->gender}}</p>
              <p><strong class='p-head'>Father Name:</strong> {{$student->father_name}}</p>
              <p><strong class='p-head'>Mother Name:</strong> {{$student->mother_name}}</p>
          </div>
        <div class="col-sm-4">
              <p><strong class='p-head'>Date Of Birth:</strong> {{ $student->dob }}</p>
              <p><strong class='p-head'>Address:</strong> {{ $student->per_address }}</p>
              <p><strong class='p-head'>Pincode:</strong> {{ $student->pincode }}</p>
          </div>
        <div class="col-sm-4">
            <p><strong class='p-head'>Category:</strong>{{ $student->category->name or '' }}</p>
            <p><strong class='p-head'>Reserved Category:</strong>{{ $student->res_category->name or '' }}</p>
            <p><strong class='p-head'>Nationality:</strong>{{ $student->nationality }}</p>
            <p><strong class='p-head'>Religion:</strong>{{ $student->religion }}</p>
         </div>
         <button class="btn btn-primary" id="add_attachment">Add Attachment</button>
         <a href='{{ url('admforms/' . $student->id . '/edit') }}' class="btn btn-primary" id="add_attachment">Edit Detail</a>
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
