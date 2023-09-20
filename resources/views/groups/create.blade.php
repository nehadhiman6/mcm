<div class='box box-info'>
    <div class="box-header with-border">
        <h3 class="box-title">Add Group</h3>
    </div>
    {!! Form::open(['url' => 'groups', 'class' => 'form-horizontal']) !!}
    <div class='box-body'>
      <div class="form-group">
        {!! Form::label('group_name','Group Name',['class' => 'col-sm-2 control-label required']) !!}
        <div class="col-sm-3">
            {!! Form::text('group_name',null,['class' => 'form-control']) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('description','Description',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::textarea('description',null,['size' => '30x2' ,'class' => 'form-control']) !!}
        </div>
      </div>
    </div>
    <div class='box-footer'>
        {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
