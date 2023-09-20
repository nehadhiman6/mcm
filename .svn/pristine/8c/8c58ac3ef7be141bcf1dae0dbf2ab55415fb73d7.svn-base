@extends('app')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            @if(isset($alumni_e))
                <h3 class="box-title">Edit Alumni Meet Event</h3>
                @else
                <h3 class="box-title">Add Alumni Meet Event</h3>
           @endif
        </div>
        <div class="box-body">
            @if(isset($alumni_e))
            {!! Form::model($alumni_e, ['method' => 'PATCH', 'action' => ['Alumni\AlumniMeetController@update', $alumni_e->id], 'class' => 'form-horizontal']) !!}
            @else

            {!! Form::open(['url' => 'alumnies', 'class' => 'form-horizontal']) !!}
            @endif
            <div class="form-group">
                {!! Form::label('meet_venue','Venue',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-4">
                    {!! Form::text('meet_venue',null,['class' => 'form-control']) !!}
                </div>
                {!! Form::label('meet_date','Meet Date',['class' => ' col-sm-2 control-label required']) !!}
                <div class="col-sm-4">
                    {!! Form::text('meet_date',null,['class' => 'form-control app-datepicker']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('meet_time','Meet Time',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-4">
                    {!! Form::text('meet_time',null,['class' => 'form-control']) !!}
                </div>
                {!! Form::label('remarks','Remarks',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-4">
                        {!! Form::textarea('remarks', null, ['size' => '30x3' ,'class' => 'form-control','v-model' => 'remarks','placeholder'=>'Write Details Here...']) !!}
                </div>
            </div>
        </div>
        <div class="box-footer">
            @if(isset($alumni_e))
                {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
            @else
                {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
            @endif
          {!! Form::close() !!}
        </div>
      </div>
      <div class='panel panel-default'>
            <div class='panel-heading'>
                <strong>Alumni Meets</strong>
            </div>
            <div class='panel-body'>
                <table class="table table-bordered" id="example1">
                    <thead>
                        <tr>
                            <th>Sr. no</th>
                            <th>Venue</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Remarks</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $start = 1 @endphp
                        @foreach($alumni_meets as $alm)
                        <tr>
                            <td>{{$start}}</td>
                            <td>{{$alm->meet_venue}}</td>
                            <td>{{$alm->meet_date}}</td>
                            <td>{{$alm->meet_time}}</td>
                            <td>{{$alm->remarks}}</td>
                            @can('ACTIVE-ALUMNI-EVENT')
                                <td>
                                    @if($alm->active == 'N')
                                    
                                    <a href="{{ url('alumnies/status/active/'.$alm->id)}}" >Make Active</a>
                                    @else
                                    <b>ACTIVE</b><br>
                                    <a href="{{ url('alumnies/status/in-active/'.$alm->id)}}">Make In-active</a>
                                    @endif
                                </td>
                            @endcan
                            @can('EDIT-ALUMNI-EVENT')
                                <td>
                                    <a href="{{ url('alumnies/'.$alm->id.'/edit')}}" class="btn btn-primary">Edit</a>
                                </td>
                            @endcan
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
