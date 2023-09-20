@extends('app')
@section('toolbar')
@include('toolbars.alumni_toolbar')
@stop
@section('content')
<div class="box box-default box-solid" id='app'>
    <div class="box-header with-border">
        Filter
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                <i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        {!! Form::open(['url' => 'alumnies/event', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            {!! Form::label('event_id','Event Date',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('event_id',getEvents(),null,['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('SHOW',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
<div class='panel panel-default'>
    <div class='panel-heading'>
        <strong>Alumni List</strong>
    </div>
    <div class='panel-body'>
        <table class="table table-bordered" id="example1">
            <thead>
                <tr>
                    <th>Sr. no</th>
                    <th>Name</th>
                    <th>Passing Year</th>
                    <th>Father's Name</th>
                    <th>Mother's Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Stream</th>
                    <th>Attending</th>
                </tr>
            </thead>
            <tbody>
                @php $start = 1 @endphp
                @foreach($alumnies as $alm)
                <tr>
                    <td>{{$start}}</td>
                    <td>{{$alm->almstudent->name}}</td>
                    <td>{{$alm->almstudent->passout_year}}</td>
                    <td>{{$alm->almstudent->father_name}}</td>
                    <td>{{$alm->almstudent->mother_name}}</td>
                    <td>{{$alm->almstudent->mobile}}</td>
                    <td>{{$alm->almstudent->email}}</td>
                    @if(count($alm->almstudent->alumnistream) > 0)
                    @php $a =  getAlumniCourse($alm->almstudent->alumnistream[0]) @endphp
                     <td>{{ $a }}</td>
                    @else
                    <td></td>
                    @endif
                    <td>{{$alm->attending_meet}}</td>
                </tr>
                @php $start++; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                 </tr>
            </tfoot>
        </table>
    </div>
</div>
@stop

@section('script')
<script>
    $('#example1').DataTable();
    </script>
@stop