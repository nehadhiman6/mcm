@extends($dashboard)
@section('content')
<div class="col-sm-12 invoice-col">
  <div class="">
    <img src = "@if(isset($guard )&& $guard == 'students' ) 
         {{ url('stdattachment/' . $student->id.'/'.$file_type) }} 
         @else 
         {{ url('attachment/' . $student->id.'/'.$file_type) }} @endif"
          width= "300" class="student-image" alt="Student Image">
  </div>
</div>
@stop