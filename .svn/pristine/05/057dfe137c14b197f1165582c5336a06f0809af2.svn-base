@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="box box-info" id="app">
  <div class="box-header with-border">
    <h3 class="box-title">Edit Subject in {{ $coursesubject->course->course_name }}</h3>
  </div>
  <div class="box-body">

    {!! Form::model($coursesubject, ['method' => 'PATCH', 'action' => ['CourseController@updatesubject', $coursesubject->course->id, $coursesubject->id], 'class' => 'form-horizontal']) !!}

      @include('courses.subjects._form', ['submitButtonText' => 'Update Subject'])

   </div>
    <div class="box-footer">
        {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
        {{ getVueData() }}
    </div>
</div>

@stop
@section('script')
<script>
// $('#subject_id').on('change',function(){
//    vm['subject_id'] = $(this).val();
// });
  var vm = new Vue({
    el: '#app',
    data: {
      subject_id: {{ $coursesubject->subject_id ?: 0 }},
      subjects: {},
     // uni_code: '',
    },
    ready: function(){
      this.getSubjectList();
//      $('#subject_id').select2({
//        placeholder: 'Select an option'
//      });
//      if(this.subject_id > 0) {
//        console.log(this.subject_id);
//        $('#subject_id').val(this.subject_id).trigger('change');
//      }
//      $('#subject_id').on('change',function(){
//         vm['subject_id'] = $(this).val();
//      });
    },
    computed: {
      uni_code: function() {
        self = this;
        code = '';
        $(this.subjects).filter(function(i, n) {
          if(n.id == self.subject_id) {
            if(n.uni_code)
            code = n.uni_code;
            return true;
          }
        });
        return code;
      }
    },
    methods: {
      getSubjectList: function() {
        this.$http.get("{{ url('/subjects/list') }}"
        ).then(function (response) {
          this.subjects = $.parseJSON(response.data);
          this.$nextTick(function () {
           $('#subject_id').val(this.subject_id);
          });
        },function (response) {
          console.log(response.data);
        });
      },
 
    }
  });
</script>
@stop
