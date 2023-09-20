@extends('alumni.dashboard')
@section('content')
    <div class="box box-info" id="app">
      <div class='panel panel-default'>
            <div class='panel-heading'>
                <strong>Alumni Meets</strong>
            </div>
            <div class='panel-body'>
                @if(isset($alumni_meet))
                    <table class="table table-bordered" id="example1">
                        <thead>
                            <tr>
                                <th>Venue</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$alumni_meet->meet_venue}}</td>
                            <td>{{$alumni_meet->meet_date}}</td>
                            <td>{{$alumni_meet->meet_time}}</td>
                            <td>{{$alumni_meet->remarks}}</td>
                            <td>
                            <span v-if="alm_meet_std.attending_meet == 'Y'">
                                <strong > Yes I Am Attending !</strong>
                            </span>
                            <span v-else>
                                <input class="btn btn-primary" type="submit" value="Join" @click.prevent="submitData(attending_meet)">
                            </span >
                                <a href="{{ url('/payments/alumni-meet-fee')}}" style="margin:0 20px" class="btn btn-primary" v-if="alm_meet_std.attending_meet == 'Y'">Pay Meet Fee</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
@stop
@section('script')
<script>

var dashboard = new Vue({
  el: '#app',
  data: {
    tData: [],
    life:'N',
    table: null,
    errors: {},
    alumni_meet:{!! isset($alumni_meet) ? $alumni_meet :  "{}"!!},
    alm_meet_std:{!! isset($alm_meet_std) ? $alm_meet_std :  "{}"!!},
    stu_id:"{{ $alm_stu_id or 0}}"
    },

  methods: {
        submitData:function(attending_meet = "Y"){
            var self = this;
            attending_meet = 'Y';
            var form = {
                attending_meet: attending_meet,
                meet_id: self.alumni_meet.id,
                alumni_stu_id: self.stu_id,
            }
            self.$http.post("{{ url('join-meet') }}", form)
            .then(function(response) {
                if(response.data.success) {
                    if(response.data.success){
                        self.errors = {};
                        window.location.href = "{{ url('going-alumnies-meet')}}";
                    }
                }
            }, 
            function(response) {
                self.errors = response.body;
            });
        },
  }
  
});
</script>
@stop
