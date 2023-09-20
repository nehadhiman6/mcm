<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Edit: {{ $location->location }}</h3>
  </div>
  <div class="box-body">

    {!! Form::model($location, ['method' => 'PATCH', 'action' => ['LocationController@update', $location->id], 'class' => 'form-horizontal']) !!}

    @include('locations._form')
  </div>
  <div class='box-footer'>
    {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
  </div>
  {!! Form::close() !!}
</div>
