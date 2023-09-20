<div class="form-group">
    {!! Form::label('board','Is Board',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-1">
        <label class="checkbox">
            <input type="checkbox" name="board" @if(isset($board) && $board->board==1)
                      checked
                     @endif value='Y' class="minimal" />
        </label>
    </div>
    {!! Form::label('name','Name',['class' => 'col-sm-1 control-label required']) !!}
    <div class="col-sm-4">
        {!! Form::text('name',null,['class' => 'form-control']) !!}
    </div>
    {!! Form::label('migration','Migration',['class' => 'col-sm-1 control-label']) !!}
    <div class="col-sm-1">
        <label class="checkbox">
            <input type="checkbox" name="migration" @if(isset($board) && $board->migration==1)
                      checked
                     @endif value='Y' class="minimal" />
        </label>
    </div>
</div>