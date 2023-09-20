@extends('app')
@section('toolbar')
@include('toolbars.alumni_message_toolbar')
@stop
@section('content')
<!--<div class="row">
  <a href="{{url('/adm-entries/create')}}">
    <button class="btn  btn-flat margin">
      <span>New Admission Entry</span>
    </button>
  </a>
</div>-->
<div class="box box-default box-solid " id='app' v-cloak>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'GET',  'action' => ['Reports\StdStrengthController@subStdStrength'], 'class' => 'form-horizontal']) !!}
    <div class="form-group">
        {!! Form::label('type','Type',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
            {!! Form::select('type',[''=>'Select', 'UG'=>'UG', 'PG'=>'PG', ''=>'All'],null,['class' => 'form-control ','v-model' => 'type']) !!}
            <span id="basic-msg" v-if="errors['type']" class="help-block">@{{ errors['type'][0] }}</span>
        </div>
         {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label', 'v-show' => 'type != "" ']) !!}
        <div class="col-sm-2" v-if="type != '' && type == 'UG' ">
            <select class="form-control" v-model="course_id">
                <option value="0">Select</option>
                <option v-for="course in graduateCourses" :value="course.id">@{{ course.name }}</option>
            </select>    
        </div>

        <div class="col-sm-2" v-if="type != '' && type == 'PG' ">
            <select class="form-control" v-model="course_id">
                <option value="0">Select</option>
                <option v-for="course in postGraduateCourses" :value="course.id">@{{ course.name }}</option>
            </select>    
        </div>
        <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span> 
    </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'sendSms']) !!}
    {!! Form::close() !!}
  </div>
</div>
 
<!-- Button trigger modal -->

@stop
@section('script')
<script>
$(document).ready(function() {
  $('body').on('click', '.std_id', function() {
    var idx;
    idx = _.indexOf(vm.std_ids,$(this).val());
    if(idx == -1) {
        vm.std_ids.push($(this).val());
    } else {
        vm.std_ids.splice(idx,1);
    }
  });
});
var msgElement =   $('.return-msg');
var vm = new Vue({
    el: '#app',
    data: {
      form: {
            course_type: '',       
          },
      std_ids: [],
      type: '',
      course_id: {{ $course->id or request("course_id",0) }},
      tData: [],
      table: null,
      formOpen: true,
      msg: '',
      subject: '',
      createUrl: "{{ url('/') . '/send-sms-alumni/' }}",
      courses: {!! \App\Course::get(['id', 'course_name', 'status'])->toJson() !!},
      success: false,
      fails: false,
      response: {},
      errors: [],
      sendOnly:true,
      show: false,
      graduateCourses: {!! graduateCourses() !!},
      postGraduateCourses: {!! postGraduateCourses() !!},
      professionalCourses: {!! professionalCourses() !!},
      researchCourses: {!! researchCourses() !!},
      errors: {},
      
    },
    created: function() {
      self = this;
      this.table = $('#example1').DataTable({
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50, -1 ],
              [ '10 rows', '25 rows', '50 rows', 'Show all' ]
          ],
          buttons: [
             'pageLength',
              {
                  extend: 'excelHtml5',
                  exportOptions: { orthogonal: 'export' }
              },
            ],
          "processing": true,
          "scrollCollapse": true,
          "ordering": true,
          data: [],
          columnDefs: [
            { title: 'Select', targets: 0, data: 'id',"width": "5%",
           'render': function (data, type, row, meta){
             return '<input type="checkbox" name="id[]" value="'+row.id+'" class="std_id">';
            }},
            { title: 'Student Name', targets: 1, data: 'name'},
            { title: 'Father Name', targets: 2, data: 'father_name'},
            { targets: '_all', visible: true }
          ],
          "sScrollX": true,
          'order': [[1, 'asc']]
        });
    },
    computed: {   
        getCourses: function(){
          self = this;
          return this.courses.filter(function(course){
            return course.status == self.form.course_type;
          });
        },
      },
    methods: {
       getData: function() {
        this.success = false;
        this.errors = [];
        data = $.extend({}, {
          course_id: this.course_id,
          institution:this.institution,
          fund_type:this.fund_type,
          type:this.type

        })
        this.$http.get("{{ url('send-sms-alumni') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
//            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
        }) 
          .catch(function (response) {
                if(response.status == 422) {
                    self.errors = response.data;
                }   
            });
      },
      confirmation:function(status){
        var me = this;
        var msg = "Do you want to send this SMS?";
        if(status == "all"){
          msg = "Do you want to send this SMS to all?";
          var r = confirm(msg);
          if (r == true) {
            me.sendSmsAll();
          } 
          return;
        }
        var r = confirm(msg);
        if (r == true) {
          me.sendSms();
        } 
        return;
      },
      sendSms: function() {
        var answer = confirm("Do you want to send SMS?");
        if (! answer) {
          return;
        } 
        this.success = false;
        this.errors = [];
        var me = this;
        data = $.extend({}, {
          msg: this.msg,
          subject:this.subject,
          std_ids:this.std_ids,
        })
        this.$http.post("{{ url('send-sms-alumni') }}", data)
          .then(function (response) {
//            this.classes = response.data;
            if(response.status == 200){
              me.success = true;
            }
            this.std_ids = [];
            this.reloadTable();
        }) 
          .catch(function (response) {
                if(response.status == 422) {
                    self.errors = response.data;
                }   
            });
      },
      
      sendSmsAll: function() {
        var me = this;
        this.success = false;
        this.errors = [];
        msgElement.empty();
        data = $.extend({}, {
          msg: this.msg,
          subject:this.subject,
          course_id:this.course_id,
        })
        this.$http.post("{{ url('send-sms-alumni/course') }}", data)
          .then(function (response) {
//            this.classes = response.data;
            if(response.status == 200){
              me.success = true;
            }
     
            this.std_ids = [];
            this.reloadTable();
          }) 
          .catch(function (response) {
                if(response.status == 422) {
                    self.errors = response.data;
                }   
            });
      },

      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      },

      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },


    },    
  });
</script>
@stop

 