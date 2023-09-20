<div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Edit: {{ $feedback_section->name or '' }}</h3>
    </div>
    <div class="box-body">
  
      {!! Form::model($feedback_section, ['method' => 'PATCH', 'action' => ['Maintenance\FeedbackSectionController@update', $feedback_section->id], 'class' => 'form-horizontal']) !!}
  
      @include('maintenance.feedback_section._form')
    </div>
    <div class='box-footer'>
      {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>
  