@extends('app')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Edit: {{ $student->name }}</h3>
    </div>
    <div class="box-body">
       {!! Form::model($student, ['method' => 'PATCH', 'action' => ['AdmissionFormController@update', $student->id], 'class' => 'form-horizontal']) !!}
   
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#student-record" data-toggle="tab">Student Record</a></li>
                <li class=""><a href="#parent-record" data-toggle="tab">Parent Record</a></li>
                <li class=""><a href="#academic" data-toggle="tab">Academic Record</a></li>
                <li class=""><a href="#attachment" data-toggle="tab">Attachment</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="student-record">
                    @include('admissions._form_student')
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="parent-record">
                    @include('admissions._form_parent')
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="academic">
                    @include('admissions._form_academic')
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="attachment">
                    @include('admissions._form_attachment')
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('script')
<script>
    var no = 1000;
    $('#add_row').click(function () {
    $('#table-academic').append(
            '<tr>\n\
              <td><input type="text" name="exam" value=""  class ="form-control"/></td>\n\
              <td><input type="text" name="institute" value=""  class ="form-control"/></td>\n\
              <td> {!! Form::select('board_id',getBoardlist(),null,['class' => 'form-control select2']) !!}</td>\n\
              <td><input type="text" name="rollno" value="" class ="form-control"/></td>\n\
              <td><input type="text" name="year" value="" class ="form-control"/></td>\n\
              <td><input type="text" name="result" value="" class ="form-control"/></td>\n\
              <td><input type="text" name="marks" value="" class ="form-control" /></td>\n\
              <td><input type="text" name="marks_per" value="" class ="form-control"/></td>\n\
              <td><input type="text" name="subjects" value="" class ="form-control"/></td>\n\
              </tr>');
    no++;
    });
</script>
@stop