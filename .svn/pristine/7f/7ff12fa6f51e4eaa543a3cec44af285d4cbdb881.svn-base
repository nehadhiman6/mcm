@extends('app')

{{-- @section('toolbar') @include('toolbars._academics_toolbar') @stop --}}

@section('content') 
<div id='app'>
<div class="box box-default box-solid">
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    {!! Form::open(['url'=>'', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        <p class="form-control-static">@{{ course.course_name }}</p>
      </div>
      {!! Form::label('subject_id','Subject ',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-4">
        <p class="form-control-static">@{{ subject.subject }}</p>
      </div>
      <!-- {!! Form::submit('SHOW', ['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!} -->
    </div>
    {!! Form::close() !!}
   </div>
  <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    Subject Wise Student Details
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Subject</th>
          <th>Section</th>
          <th>Teacher</th>
        </tr>
      </thead>
      <tbody>
        <tr is="sub-section" v-for='subsec in subsecs' :subsec="subsec" :index="$index" ></tr>
        </tbody>
    </table>
  </div>
</div>
</div>

<template id="subsec">
  <tr>
    <td width="10%">@{{ index+1 }}</td>
    <td width="40%">@{{ subsec.subject.subject }}</td>
    <td width="10%">@{{ subsec.section.section }}</td>
    <td>
      <select @change="update" v-model="subsec.teacher_id" v-bind:class="{ 'has-error': errors['teacher_id'] }">
        <option value="0">Select</option>
        <option v-for="teacher in teachers" :value="teacher.id">
          @{{ teacher.name }}
        </option>
      </select>
      <span v-if="success" class="glyphicon glyphicon-ok" style="font-size:20px;margin-left:20px;color:green" aria-hidden="true"></span>
      <span v-if="errors['teacher_id']" class="help-block">@{{ errors['teacher_id'][0] }}</span>
    </td>
  </tr>
</template>
@stop

@section('script')
<script>
Vue.component('sub-section', {
  template: '#subsec',
  props: ['subsec', 'index'],
  data: function() {
    return {
      dirty: true,
      teachers:{!! json_encode(getTeachers()) !!},
      success: false,
      errors: {}
    };
  },
  methods: {
    update: function() {
      // if(this.subsec.teacher_id && this.subsec.teacher_id == 0)
      //   return;
      this.errors = {};
      this.success = false;
      this.$http.patch("{{ url('secallocations') }}/"+this.subsec.id, { teacher_id: this.subsec.teacher_id })
        .then(function (response) {
          if(response.data.success) {
            this.success = true;
            setTimeout(() => {
              this.success = false;
            }, 2000);
          }
        }, function (response) {
          this.fails = true;
          if(response.status == 422) {
            this.errors = response.data;
          }
        });
    }
  }
});

var dashboard = new Vue({
  el: '#app',
  data: {
    course: {!! $course or '{}' !!},
    subject_id: {{ $subject_id or 0 }},
    subject: {!! $subject or "{}" !!},
    subsecs: {!! json_encode($subsecs) !!},
    section_id: '',
    table: null,
    tData: [],
    success: false,
    fails: false,
    errors: {},
    response: {},
  },
  // created: function() {
  //     self = this;
  //     this.table = $('#example1').DataTable({
  // //      "searchDelay": 1000,
  //       dom: 'Bfrtip',
  //       lengthMenu: [
  //           [ 10, 25, 50, -1 ],
  //           [ '10 rows', '25 rows', '50 rows', 'Show all' ]
  //       ],
  //       buttons: [
  //          'pageLength',
  //           {
  //               extend: 'excelHtml5',
  //               exportOptions: { orthogonal: 'export' }
  //           },
  //         ],
  //       "processing": true,
  //       "scrollCollapse": true,
  // //      "serverSide": true,
  //       "ordering": true,
  //       data: [],
  //       columnDefs: [
  //         { title: 'S.No.', targets: 0, data: 'id',
  //           "render": function( data, type, row, meta) {
  //             return meta.row + 1;
  //           }},
  //         { title: 'Subject', targets: 1, data: 'subject',
  //           "render": function( data, type, row, meta) {
  //             return data ? data.subject : '';
  //           }},
  //         { title: 'Section', targets: 2, data: 'section',
  //           "render": function( data, type, row, meta) {
  //             return data ? data.section : '';
  //           }},
  //         { title: 'Teacher', targets: 3, data: 'teacher',
  //           "render": function( data, type, row, meta) {
  //             var e = data ? data.first_name : '';
  //             var select = '<option value="0"></option>';
  //             $(teachers).each(function(i, t) {
  //               select += "<option value='"+t.id+"'";
  //               if( e == t.first_name) {
  //                 select += "selected='selected'";
  //               }
  //               select += ">"+t.first_name+"</option>";
  //             });
  //             return "<select>"+select+"</select>";
  //           }},
  //         { targets: '_all', visible: true }
  //       ],
  // //      "deferRender": true,
  //       "sScrollX": true,
  //     }); 
  //     this.getData();
  //   },
  methods: {
    getData: function() {
      this.errors = {};
      this.fails = false;
      data = {
        course_id: this.course.id,
        subject_id: this.subject.id,
      };
      this.$http.get("{{ url('secallocations') }}", {params: data})
        .then(function (response) {
          this.tData = response.data;
          this.reloadTable();
        }, function (response) {
          this.fails = true;
          this.errors = response.data;
      });
    },
    allocate: function() {
      this.errors = {};
      this.success = false;
      this.fails = false;

      var data = {
        course_id: this.course_id,
        subject_id: this.subject_id,
        scheme: this.scheme,
        students: this.students,
        section_id: this.section_id,
      };
      this.$http.post("{{ url('secallot') }}", data)
        .then(function (response) {
          this.success = true;
          this.response = response.data;
        }, function (response) {
          this.fails = true;
          this.errors = response.data;
        });
    },
    hasErrors: function() {
      console.log(this.errors && _.keys(this.errors).length > 0);
      if(this.errors && _.keys(this.errors).length > 0)
        return true;
      else
        return false;
    },
    reloadTable: function() {
      this.table.clear();
      this.table.rows.add(this.tData).draw();
    }
  }
  
  });
</script>
@stop