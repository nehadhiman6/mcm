@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="row">
  <a href="  {{ url('courses/'.$course->id.'/subjects') }}"  class="btn  btn-primary margin">
    <span>Go Back</span>
    </button>
  </a>
</div>
<div class="box box-info">
    <div class="box-header with-border">
        @if(isset($elective))
            <h3 class="box-title">Edit Group  {{ $elective->name}}</h3>
        @else
            <h3 class="box-title">Add Group to {{ $elective->name}}</h3>
        @endif
    </div>
    @if(isset($elective_group))
        {!! Form::model($elective_group, ['method' => 'PATCH', 'action' => ['ElectiveController@updateGroup', $elective_group->id], 'class' => 'form-horizontal']) !!}
    @else
        {!! Form::model($elective_group = new \App\ElectiveGroup(), ['url' => 'electives/' . $elective->id . '/addgroup', 'class' => 'form-horizontal']) !!}
    @endif
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('s_no','S.No',['class' => 'col-sm-1 control-label']) !!}
            <div class="col-sm-1">
                {!! Form::text('s_no',null,['class' => 'form-control']) !!}
            </div>
            {!! Form::label('type','Subject Type',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-4">
                <label class="radio-inline">
                    <input type="radio" name="type" class="minimal" value="O" {{ checked('type','O') }}/>
                    Optional
                </label>
                <label class="checkbox-inline">
                    <input type="radio" name="type" class="minimal" value="C" {{ checked('type','C') }}/>
                    Compulsary
                </label>
            </div> 
        </div>
        <div class="form-group">
            {!! Form::label('subjects','Subject',['class' => 'col-sm-1 control-label required']) !!}
            <div class="col-sm-8">
                {!! Form::select('subjects[]', getCourseSubjects($course->id), (isset($elective_group) ? $elective_group->details->pluck('course_sub_id')->toArray() : null) , ['class' => 'form-control select2','multiple']) !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        @if($elective_group->exists)
            {!! Form::submit('UPDATE GROUP',['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        @else
            {!! Form::submit('ADD GROUP',['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        @endif
    </div>
</div>
    <div class= "box box-body">
      <table class="table table-bordered">
        <thead>
          <tr>
          <th>Serial No.</th>
            <th>Group Name</th>
            <th>Optional/Compulsory</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($elective->groups as $ele_group)
          <tr>
          <td>{{$ele_group->s_no}}</td>
            <td>{{$ele_group->group_name}}</td>
            <td>{{$ele_group->type}}</td>
            <td> <a href="{{ url('electives/'. $ele_group->id . '/' . 'editgroup') }}" class="btn btn-primary btn-xs">Edit Group</a></td></td>
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
</div
@stop
