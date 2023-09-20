@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="row">
  <a href="@if(isset($coursesubject))
     {{ url('courses/'.$coursesubject->course->id.'/subjects') }}
     @else
     {{ url('courses/'.$course->id.'/subjects') }}
     @endif"
     class="btn  btn-primary margin">
    <span>Go Back</span>
    </button>
  </a>
</div>
<div class="box box-info" id="app">
  <div class="box-header with-border">
    @if(isset($coursesubject))
    <h3 class="box-title">Edit Subject in {{ $coursesubject->course->course_name }}</h3>
    @else
    <h3 class="box-title">Add Subject to {{ $course->course_name }}</h3>
    @endif
  </div>
  <div class="box-body">
    @if(isset($coursesubject))
      {!! Form::model($coursesubject, ['method' => 'PATCH', 'action' => ['CourseController@updatesubject', $coursesubject->course->id, $coursesubject->id], 'class' => 'form-horizontal']) !!}
    @else
      {!! Form::model($coursesubject = new \App\CourseSubject(),['url' => 'courses/' . $course->id . '/storesubject', 'class' => 'form-horizontal']) !!}
    @endif
    @include('courses.subjects._form', ['submitButtonText' => 'Add Subject'])
  </div>
  <div class="box-footer">
    @if($coursesubject->exists)
      {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
    @else
      {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    @endif
    {!! Form::close() !!}
    {{ getVueData() }}
  </div>
</div>
@stop
@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      subject_id: {{ $coursesubject->subject_id ?: 0 }},
      semester_id: {{ $coursesubject->semester ?: 0 }},
      subjects: {},
      honours:"{{ $coursesubject->honours == 'Y' ? 'Y' : 'N' }}",
      uni_code: "{{ $coursesubject->uni_code  }}",
      semesters: [],
      courseYear: {{ intVal($course_year)}}
    },
    ready: function(){
      var self = this;

      self.semesters = [{'id' : self.courseYear+(self.courseYear - 1), 'sem': self.getSemesterName(self.courseYear+(self.courseYear - 1))},
                        {'id' : self.courseYear+(self.courseYear-1) +1, 'sem': self.getSemesterName(self.courseYear+(self.courseYear-1) +1)}]
      self.getSubjectList();
    
      $('#subject_id').select2({
        placeholder: 'Select an option'
      });
      $('#subject_id').on('change',function(){
         vm['subject_id'] = $(this).val();
      });

      $('#semester').select2({
        placeholder: 'Select an option'
      });
      $('#semester').on('change',function(){
         vm['semester'] = $(this).val();
      });
      setTimeout(() => {
        $('#semester').val(this.semester_id).trigger('change');
      }, 500);

    },
    computed: {
      uni_code11: function() {
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
           $('#subject_id').val(this.subject_id).trigger('change');
          });
        },function (response) {
          console.log(response.data);
        });
      },
      getSemesterName:function(sem){
        switch (sem)
        {
            case 1: 
                return "First";
            case 2: 
                return "Second";
            case 3: 
                return "Third";
            case 4: 
                return "Fourth";
            case 5: 
                return "Fifth";
            case 6: 
                return "Sixth";
            default: 
                return "Select Course First";
        }
      }
    }
  });
</script>
@stop