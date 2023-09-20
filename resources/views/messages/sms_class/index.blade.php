@extends('app')
@section('toolbar')
@include('toolbars._message_toolbar')
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
    {!! Form::label('course_type','Course Type',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
      {!! Form::select('course_type',[''=>'Select','GRAD'=>'UG','PGRAD'=>'PG'],null,['class' => 'form-control','v-model'=>'form.course_type']) !!}
    </div>
    {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
      <select class="form-control" v-model="course_id" >
        <option v-for="course in getCourses" :value="course.id">@{{ course.course_name }}</option>
      </select>
		</div>
		
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
  <div class='row'>
    <div class='col-sm-8'>
      <div class='panel panel-default' >
        <div class="panel-heading">
          <strong>Students List</strong>
        </div>
        <div class = "panel-body">
          <table class="table table-bordered" id="example1" width="100%"></table>
        </div>
      </div>
    </div>
    @can('SEND-MESSAGES')
    <div class='col-sm-4'>
      <div class="box box-default box-solid ">
        <div class="box-body">
          {!! Form::label('','Subject',['class' => 'col-sm-3 control-label ']) !!}
          <div class="col-sm-12">
            {!! Form::text('',null,['class' => 'form-control','v-model' => 'subject']) !!}
          </div>
        </div>
        <div class="box-body"> 
          {!! Form::label('','Message',['class' => 'col-sm-3 control-label ']) !!}
          <div class="col-sm-12">
            {!! Form::textarea('',null,['class' => 'form-control txt-area','size'=>'31x4','v-model' => 'msg']) !!}
          </div>
        </div>
        <div class="box-footer">
          {!! Form::submit('SEND',['class' => 'btn btn-primary','@click.prevent' => 'confirmation("few")',':disabled'=>"std_ids.length == 0"]) !!}
          {!! Form::submit('SEND to All',['class' => 'btn btn-primary','@click.prevent' => 'confirmation("all")',':disabled'=>"std_ids.length > 0"]) !!}
          {!! Form::close() !!}
        </div>
        <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Success!</strong>Thank you! Your message has been sent successfully.
        </div>
        <ul class="alert alert-error alert-dismissible" role="alert" v-if ="errors.length > 0">
          <strong>Failed!</strong>
          <li v-for='error in errors'>@{{ error }}<li>
        </ul>
      </div>
    </div>
  @endcan
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
      course_id: {{ $course->id or request("course_id",0) }},
      tData: [],
      table: null,
      formOpen: true,
      msg: '',
      subject: '',
      createUrl: "{{ url('/') . '/messages/' }}",
      courses: {!! \App\Course::orderBy('sno')->get(['id', 'course_name', 'status'])->toJson() !!},
      success: false,
      fails: false,
      response: {},
      errors: [],
      sendOnly:true,
      show: false,
      
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
            { title: 'Roll No.', targets: 1,"width": "10%", data: 'roll_no' },
            { title: 'Student Name', targets: 2, data: 'name'},
            { title: 'Father Name', targets: 3, data: 'father_name'},
            { title: 'Mobile', targets: 4,
              'render': function (data, type, row, meta){
                var str = '';
                  str += "S" + row.mobile + " ,";
                  str += "F" +row.father_mobile + " ,";
                  str += "M" + row.mother_mobile;
                return str;
            }
            },
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
          fund_type:this.fund_type
        })
        this.$http.get("{{ url('messages') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
//            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
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
        this.success = false;
        this.errors = [];
        var me= this;
        data = $.extend({}, {
          msg: this.msg,
          subject:this.subject,
          std_ids:this.std_ids,
        })
        this.$http.post("{{ url('messages') }}", data)
          .then(function (response) {
//            this.classes = response.data;
            if(response.status == 200){
              me.success = true;
            }
            this.std_ids = [];
            this.reloadTable();
          }, function (response) {
            me.success =  false;
              for (var key in response.body) {
                  if (response.body.hasOwnProperty(key)) {
                      me.errors.push(key + " -> " + response.body[key]);
                  }
              }
        });
      },
      sendSmsAll: function() {
        var me= this;
        this.success = false;
        this.errors = [];
        msgElement.empty();
        data = $.extend({}, {
          msg: this.msg,
          subject:this.subject,
          course_id:this.course_id,
        })
        this.$http.post("{{ url('messages/course') }}", data)
          .then(function (response) {
//            this.classes = response.data;
            if(response.status == 200){
              me.success = true;
            }
     
            this.std_ids = [];
            this.reloadTable();
          }, function (response) {
              me.success =  false;
              for (var key in response.body) {
                  if (response.body.hasOwnProperty(key)) {
                      me.errors.push(key + " -> " + response.body[key]);
                  }
              }
        });
      },
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    },    
  });
</script>
@stop
