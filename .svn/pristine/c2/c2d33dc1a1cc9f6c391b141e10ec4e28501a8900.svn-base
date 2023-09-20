

@extends('online.dashboard')
@section('content')
<div class="panel panel-default" id='app'>
  <div class="panel-heading">
    <strong>Time Table</strong>
    <p style="color:#ff6e41; margin:10px 0 0"><strong>Name :-</strong><span style="margin:0 30px 0 0">{{ $student->name}}</span>   <strong>Roll No :-</strong><span style="margin:0 30px 0 0">{{ $student->roll_no}}</span> 
        <strong>Course :-</strong>{{ $student->course->course_name}} </p>
    
  </div>
  <div class="panel-body">
        @if($student_timetable)
    <table class="table table-bordered">
            <thead>
                <tr>
                    <th> Serial no./Location </th>
                    <th> Period 0 </th>
                    <th> Period 1 </th>
                    <th> Period 2 </th>
                    <th> Period 3 </th>
                    <th> Period 4 </th>
                    <th> Period 5 </th>
                    <th> Period 6 </th>
                    <th> Period 7 </th>
                    <th> Period 8 </th>
                    <th> Period 9 </th>
                    <th> Period 10 </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $student_timetable->location}}</td>
                    <td>{{ $student_timetable->period_0}}</td>
                    <td>{{ $student_timetable->period_1}}</td>
                    <td>{{ $student_timetable->period_2}}</td>
                    <td>{{ $student_timetable->period_3}}</td>
                    <td>{{ $student_timetable->period_4}}</td>
                    <td>{{ $student_timetable->period_5}}</td>
                    <td>{{ $student_timetable->period_6}}</td>
                    <td>{{ $student_timetable->period_7}}</td>
                    <td>{{ $student_timetable->period_8}}</td>
                    <td>{{ $student_timetable->period_9}}</td>
                    <td>{{ $student_timetable->period_10}}</td>
                </tr>
            </tbody>
    </table>
    @else
        <h4>No Record!!</h4>
    @endif

    <div class= "col-sm-2">
      {{-- <img v-if="course_id > 0 && user_src == ''"  :src="getSource()" alt="your image" width="115" height="115"/> --}}
      <span style="margin-bottom:10px"><b>Timetable Summary</b></span>
      <a class="btn btn-default" @click.prevent="showImage"  v-if="file == 'yes'" class="btn btn-default">
          <img src="{{ url('img/pdf.png')}}" width="70px;" />
      </a>
  </div>
  </div>
</div>
@stop
@section('script')
<script>
 var vm = new Vue({
    el: '#app',
    data: {
      response: {},
      file:'{{$file}}',
      student:{!! json_encode($student) !!}
          
    },
    methods: {
      checkStatus: function(id) {
          console.log(id);
      },

      showImage: function() {
          self = this;
          window.open(MCM.base_url+'/student-timetable-attachment/'+this.student.course_id+'?'+ new Date().getTime(),'_blank');
              
      }
    },
  });
</script>
@stop