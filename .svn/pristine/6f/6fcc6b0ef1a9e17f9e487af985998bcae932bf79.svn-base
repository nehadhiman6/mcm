@extends('app')

@section('toolbar')
  @include('toolbars._misc_debits_toolbar')
@stop

@section('content')
<div id="app">
<div class="box box-default box-solid" v-cloak>
  <div class="box-header with-border">
    Miscellaneous Debits
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('subhead_id','Sub Head',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('subhead_id',getSubheads('C'),null,['class' => 'form-control','v-model'=>'subhead_id']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('charges','Charges',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('charges',request('charges',0),['class' => 'form-control', 'v-model'=>'charges']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::submit('College Pending',['class' => 'btn btn-primary', '@click.prevent' => 'collegePending']) !!}
    {!! Form::submit('Save',['class' => 'btn btn-primary', ':disabled' => 'data_sent', '@click.prevent' => 'saveData']) !!}
  </div>
  {!! Form::close() !!}
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div id="student-Details" class="box-scroll" v-if="form_loaded" >
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Adm No.</th>
        <th>Roll No.</th>
        <th>Student Name</th>
        <th>Father Name</th>
        <th>Charges</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for='st in students'>
        <td>@{{ st.adm_no }}</td>
        <td>@{{ st.roll_no }}</td>
        <td>@{{ st.name }}</td>
        <td>@{{ st.father_name }}</td>
        <td>
          <input class="form-control" type="text"  number v-model="st.charges" />
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
      </tr>
    </tfoot>
  </table>
</div>
</div>
@stop
@section('script')
<script>
  $('#example1 tbody').on( 'click', 'td', function () {
    alert( table.cell( this ).data() );
  });
  
  
  var vm = new Vue({
    el: '#app',
    data: {
      tData: [],
   //   institution:'',
      course_id: {{ $course->id or request("course_id",0) }},
      subhead_id: {{ request("subhead_id",0) }},
      charges: 0,
      students: [],
      url: "{{ url('/') . '/misc-debit/' }}",
      success: false,
      fails: false,
      form_loaded: false,
      response: {},      
      errors: {},
      data_sent: false
    },
    methods: {
      getData: function() {
        this.errors = {};
        this.fails = false;
        self = this;  
        this.$http.get("{{ url('misc-debit') }}/"+this.course_id, { params: { 'subhead_id': this.subhead_id}})
          .then(function (response) {
          this.response = response.data;
          self.students = [];
          self.form_loaded = true;
          self.data_sent = false;
          _.each(this.response, function(std, i) {
            std.charges = self.charges;
            self.students.push({
              std_id: std.id,
              std_type_id: std.std_type_id,
              roll_no: std.roll_no,
              adm_no: std.adm_no,
              name: std.name,
              father_name: std.father_name,
              charges: self.charges,
            });
          });
            
            // this.classes = response.data;
            // console.log(response.data);
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
      collegePending: function() {
        this.errors = {};
        this.fails = false;
        self = this;  
        this.$http.get("{{ url('college-pending') }}/"+this.course_id, { params: { 'subhead_id': this.subhead_id}})
          .then(function (response) {
          this.response = response.data;
          self.students = [];
          self.form_loaded = true;
          self.data_sent = false;
          _.each(this.response, function(std, i) {
            std.charges = self.charges;
            self.students.push({
              std_id: std.id,
              std_type_id: std.std_type_id,
              roll_no: std.roll_no,
              adm_no: std.adm_no,
              name: std.name,
              father_name: std.father_name,
              charges: self.charges,
            });
          });
            
            // this.classes = response.data;
            // console.log(response.data);
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
      saveData: function() {
        this.errors = {};
        this.fails = false;
        var data = {
          course_id: this.course_id,
          subhead_id: this.subhead_id,
          students: this.students,
        };
        this.$http.post("{{ url('misc-debit') }}", data)
          .then(function (response) {
            self.data_sent = true;
            // this.classes = response.data;
            // console.log(response.data);
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
    }
  
});

  
</script>
@stop