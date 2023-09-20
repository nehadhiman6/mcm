<div class="form-group">
    {!! Form::label('site_id','Site',['class' => 'col-sm-1 control-label required']) !!}
    <div class="col-sm-7">
        {!! Form::select('site_id',getSite(),null,[ 'v-model'=> 'form.site_id', 'class' => 'form-control select2', '@change' => 'getShifts()']) !!}
        <span v-if="errors['site_id']" class="text-danger">@{{ errors['site_id'][0] }}</span>
    </div>
</div>
    
    {{-- <table class="table table-bordered" v-show="showShifts">
        <thead>
            <tr>
                <th>Shift</th>
                <th>Time From</th>
                <th>Time To</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for = "(key, row) in form.shift">
                <td> Shift @{{row.shift}} </td>
                <td> <div class="col-md-6">{!! Form::time('time_from',null,['v-model'=> 'row.time_from','class' => 'form-control']) !!}</div></td>
                <td> <div class="col-md-6">{!! Form::time('time_to',null,['v-model'=> 'row.time_to', 'class' => 'form-control col-md-4']) !!}</div></td>
                <td> {!! Form::checkbox('shift',null, false,['v-model'=>'row.check']) !!}</td>
            </tr>
        </tbody>
    </table> --}}
    