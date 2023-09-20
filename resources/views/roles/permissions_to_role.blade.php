@extends('app')
@section('toolbar')
@include('toolbars._users_toolbar')
@stop
@section('content')
{!! Form::open(['url' => 'roles/'.$role->id.'/permissions', 'class' => 'form-horizontal']) !!}
<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Permissions</h3>
  </div>
  <div class='box-body'>
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>SNo.</th>
          <th>Permission</th>
          <th>Allow</th>
        </tr>
      </thead>
      <tbody>
      @foreach($group as $g)
        <tr>
          <th colspan="3">{{ $g->group_name }}: Permissions</th>
        </tr>
        <?php $i = 1; ?>
        @foreach($g->permissions as $permission)
        <tr>
          <td>{{ $i }}</td>
          <td>{{ $permission->label }}</td>
          <td> 
            <input type="checkbox" name="permission_id[]" value="{{ $permission->id }}" @if($role->permissions->contains('name',$permission->name)) checked @endif >
          </td>
        </tr>
        <?php $i++; ?>
        @endforeach
      @endforeach
      <tr><th colspan="3">Permissions with No Group assigned yet</th></tr>
      <?php $i = 1; ?>
      @foreach($permissions as $permission)
      <tr>
        <td>{{ $i }}</td>
        <td>{{ $permission->label }}</td>
        <td>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="permission_id[]" value="{{ $permission->id }}" @if($role->permissions->contains('name',$permission->name)) checked @endif >
            </label>
          </div>
        </td>
      </tr>
      <?php $i++; ?>
      @endforeach
      </tbody>
      <tfoot>
        <tr></tr>
      </tfoot>
    </table>

  </div>

  <div class="box-footer">
    {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
  </div>
</div>
{!! Form::close() !!}
@stop