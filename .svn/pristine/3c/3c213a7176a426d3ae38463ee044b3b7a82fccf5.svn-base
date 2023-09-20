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
    @if(isset($elective))
        <h3 class="box-title">Edit Electives to {{ $course->course_name }}</h3>
    @else
        <h3 class="box-title">Add Electives to {{ $course->course_name }}</h3>
    @endif
    </div>
    <div class="box-body">
        @if(isset($elective))
            {!! Form::model($elective, ['method' => 'PATCH', 'action' => ['ElectiveController@update',$elective->id, $course->id], 'class' => 'form-horizontal']) !!}
        @else
            {!! Form::model( new \App\Elective(),['method' => 'POST','url' => 'electives/' . $course->id  , 'class' => 'form-horizontal']) !!}
        @endif
        <div>
            <div class="form-group">
                {!! Form::label('name','Name',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-5">
                {!! Form::text('name',null,['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="box-footer">
    @if(isset($elective))
        {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
    @else
        {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    @endif
    {!! Form::close() !!}
    {{ getVueData() }}
  </div>
</div>
@stop
@section('script')

@stop