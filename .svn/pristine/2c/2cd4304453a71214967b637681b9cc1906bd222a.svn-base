@extends('app')
@section('toolbar')
@include('toolbars._fees_maintenance_toolbar')
@stop
@section('content')
<div class="box box-info" id='app'>
  <div class="box-header with-border">
    <h3 class="box-title">Subject Charges</h3>
  </div>
  <div class="box-body">
    @if(isset($subcharge))
    {!! Form::model($subcharge, ['method' => 'PATCH', 'action' => ['Fees\SubjectChargesController@update', $subcharge->id], 'class' => 'form-horizontal']) !!}
    @else
    {!! Form::open(['url' => 'subcharges', 'class' => 'form-horizontal']) !!}
    @endif
    @include('fees.subcharges._form')

  </div>
  <div class="box-footer">
    @if(isset($subcharge))
    {!! Form::submit('UPDATE',['class' => 'btn btn-primary']) !!}
    @else
    {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    @endif
    {!! Form::close() !!}
  </div>
@if (config('college.app_location') == 'local')
{{ getVueData() }}
@endif
</div>
@stop
@section('script')
<script>
var dashboard = new Vue({
  el: '#app',
  data: {
      //subcharge_id: {{ $subcharge->id or 0 }},
      course_id: {{ $course->id or request("course_id",0) }},
      subject_id: {{ $subcharge->subject_id or request("subject_id",0)  }},
     // subjects: {}
      subjects: {!! isset($subjects) ? json_encode($subjects) : '{}' !!},
    
   },
//   created: function() {
//    this.getSubjects();
//  },
   methods: {
      getSubjects: function(e) {
         self = this;
         this.subjects = [];
         this.$http.post("{{ url('courses/subsforcharges') }}", { course_id: this.course_id })
          .then(function (response) {
           // console.log('response.data.subjects');
            this.subjects = response.data;
          }, function (response) {
//            console.log(response.data);
        });
      },
  }
});
</script>
@stop