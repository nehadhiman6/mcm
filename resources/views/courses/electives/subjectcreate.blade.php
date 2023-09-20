@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="row">
  <a href="{{ url('courses/'.$course->id.'/subjects') }}"
     class="btn  btn-primary margin">
    <span>Go Back</span>
    </button>
  </a>
</div>
<div class="box box-info" id="app">
  <div class="box-header with-border">
    @if(isset($elective_subject))
    <h3 class="box-title"> Edit Subject to {{ $elective->name }} in ({{ $course->course_name }})</h3>
    @else
    <h3 class="box-title">Add Subject to {{ $elective->name }} in ({{ $course->course_name }})</h3>
    @endif
  </div>
  <div class="box-body">
    @if(isset($elective_subject))
    {!! Form::model($elective_subject, ['method' => 'PATCH', 'action' => ['ElectiveController@updatesubject',$elective_subject->id], 'class' => 'form-horizontal']) !!}
    @else
    {!! Form::model($elective_subject = new \App\ElectiveSubject(),['url' => 'electives/' . $elective->id . '/storesubject', 'class' => 'form-horizontal']) !!}
    @endif
    @include('courses.electives.subject_form', ['submitButtonText' => 'Add Subject'])
  </div>
  <div class="box-footer">
    @if($elective_subject->exists)
    {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
    @else
    {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    @endif
    {!! Form::close() !!}
   
  </div>
</div>
<div class= "box box-body">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Subject Name</th>
            <th>Optional/Compulsory</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($elective->electiveSubjects as $ele_sub)
          <tr>
            <td>{{$ele_sub->coursesubject->subject->subject}}</td>
            <td>{{$ele_sub->sub_type}}</td>
            <td> 
              <a href="{{ url('electives/'. $ele_sub->id . '/' . 'editsubject') }}" class="btn btn-primary btn-xs">Edit Subject</a>
              <a href="{{ url('electives/'. $ele_sub->id . '/' . 'removesubject') }}" class="btn btn-primary btn-xs">Remove</a>
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
</div>
 
@stop
@section('script')
<script>

</script>
@stop