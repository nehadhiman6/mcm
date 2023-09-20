<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">Edit: {{ $city->city }}</h3>
  </div>
  <div class="box-body">

    {!! Form::model($city, ['method' => 'PATCH', 'action' => ['CityController@update', $city->id], 'class' => 'form-horizontal']) !!}

    @include('cities._form')
  </div>
  <div class='box-footer'>
    {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
  </div>
  {!! Form::close() !!}
</div>
