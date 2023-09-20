@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="row">
  <a href="@if(isset($subjectgroup))
     {{ url('courses/'.$subjectgroup->course->id.'/subjects') }}
     @else
     {{ url('courses/'.$course->id.'/subjects') }}
     @endif"
     class="btn  btn-primary margin">
    <span>Go Back</span>
    </button>
  </a>
</div>
<div class="box box-info">
    <div class="box-header with-border">
        @if(isset($subjectgroup))
        <h3 class="box-title">Edit Group  {{ $subjectgroup->group_name }}</h3>
        @else
        <h3 class="box-title">Add Group to {{ $course->course_name }}</h3>
        @endif
    </div>
    @if(isset($subjectgroup))
    {!! Form::model($subjectgroup, ['method' => 'PATCH', 'action' => ['CourseController@updateGroup', $subjectgroup->course->id, $subjectgroup->id], 'class' => 'form-horizontal']) !!}
    @else
    {!! Form::model($subgroup = new \App\SubjectGroup(),['url' => 'courses/' . $course->id . '/addgroup', 'class' => 'form-horizontal']) !!}
    @endif
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('s_no','S.No',['class' => 'col-sm-1 control-label']) !!}
            <div class="col-sm-1">
                {!! Form::text('s_no',null,['class' => 'form-control']) !!}
            </div>
            {!! Form::label('subjects','Subject',['class' => 'col-sm-1 control-label required']) !!}
            <div class="col-sm-8">
                {!! Form::select('subjects[]',getCourseSubjects($course->id), (isset($subjectgroup) ? $subjectgroup->subjects->pluck('course_sub_id')->toArray() : null) ,['class' => 'form-control select2','multiple']) !!}
            </div>
            <!-- {!! Form::label('type','Subject Type',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-4">
                <label class="radio-inline">
                    <input type="radio" name="type" class="minimal" value="O" {{ checked('type','O') }}/>
                    Optional
                </label>
                <label class="checkbox-inline">
                    <input type="radio" name="type" class="minimal" value="C" {{ checked('type','C') }}/>
                    Compulsary
                </label>
            </div>  -->
        </div>
        <!-- <div class="form-group">
            {!! Form::label('subjects','Subject',['class' => 'col-sm-3 control-label required']) !!}
            <div class="col-sm-5">
                {!! Form::select('subjects[]',getCourseSubjects($course->id),(isset($subjectgroup) ? $subjectgroup->subjects->pluck('subject_id')->toArray() : null) ,['class' => 'form-control select2','multiple']) !!}
            </div>
        </div> -->
    </div>
    <div class="box-footer">
        @if(isset($subjectgroup))
        {!! Form::submit('UPDATE GROUP',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
        @else
        {!! Form::submit('ADD GROUP',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
        @endif
    </div>
</div>
@stop
