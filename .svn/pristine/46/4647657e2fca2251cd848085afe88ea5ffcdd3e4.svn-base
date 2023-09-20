<div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Edit: {{ $feedback_question->question or '' }}</h3>
    </div>
    <div class="box-body">
  
      {!! Form::model($feedback_question, ['method' => 'PATCH', 'action' => ['Maintenance\FeedbackQuestionController@update', $feedback_question->id], 'class' => 'form-horizontal']) !!}
  
      @include('maintenance.feedback_question._form')
    </div>
    <div class='box-footer'>
      {!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>
  