<div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">New Feedback Section</h3>
    </div>
    <div class="box-body">
      {!! Form::open(['url' => 'feedback-sections', 'class' => 'form-horizontal']) !!}
      @include('maintenance.feedback_section._form')
  
    </div>
    <div class="box-footer">
      {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
    </div>
  </div>