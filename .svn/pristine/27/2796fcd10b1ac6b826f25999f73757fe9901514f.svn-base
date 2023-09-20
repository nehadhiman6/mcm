@extends('online.dashboard')

@section('content')
{!! Form::open(['url' => '', 'class' => 'form-horizontal','id'=>'form']) !!}
<div class="box box-info" id = "app" v-cloak>
  <div class="box-header with-border">
    <h3 class="box-title">Question paper for Panjab University Examination, September 2020</h3>
  </div>
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('college_roll','College Roll No.',['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-3">
        <input type="text" v-model="college_roll" number placeholder="Enter College Roll No." name="college_roll" class="form-control">
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('pu_roll','University Roll No.',['class' => 'col-sm-3 control-label']) !!}
      <div class="col-sm-3">
        <input type="text" v-model="pu_roll" number placeholder="Enter PU Roll No." name="pu_roll" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-3">
        {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent' => 'showDetail',':disabled'=>'form_loaded']) !!}
        {!! Form::submit('RESET',['class' => 'btn btn-primary','@click.prevent' => 'resetForm','v-if'=>'form_loaded']) !!}
      </div>
    </div>
    <div id="student-details" v-if="form_loaded">
      <div class='form-group'>
        {!! Form::label('name','Student Name',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student_det.name }}</p>
        </div>
        {!! Form::label('father_name','Father Name',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student_det.father_name}}</p>
        </div>
        {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-2">
          <p class="form-control-static">@{{ student_det.class }}</p>
        </div>
      </div>
      <div class="box-scroll">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>File</th>
              <th>Download</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="file in files">
              <td>@{{ file }}</td>
              <td><a href="#" data-file-link="@{{ file }}" class="file-link">Click to download question paper</a></td>
            </tr>
          </tbody>
         
        </table>
      </div>
    </div>
  </div>
  
  <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
  <div id="paper-box"></div>
  {{ getVueData() }}
</div>
{!! Form::close() !!}
<div id="new-form"></div>
@stop

@section('script')
<script>
  var vm = new Vue({
    el: '#app',
    data: {
      response: {},
      student_det: {},
      college_roll: "",
      pu_roll: "",
      success: false,
      fails: false,
      saving: false,
      msg: '',
      errors: {},
      form_loaded: false,
      files: []
    },
    created: function() {
      // this.college_roll = "5001";
      // this.pu_roll = "17041565";

    },

    ready: function() {
      var self = this;
      $(document).on('click','.file-link', function(e) {
        console.log('link clicked');
        e.preventDefault();
        $('#paper-box').html('');
        $('#paper-box').append('<form id="paper-form" action=\'{{ url("paper-dwnld/create") }}\' method="GET" target="_blank">');
        $('#paper-form').append('<input type="hidden" name="file_path" value="' + $(this).data('file-link') + '">')
          .append('<input type="hidden" name="token" value="' + self.student_det.token + '">')
          .append('<input type="hidden" name="college_roll" value="' + self.college_roll + '">')
          .submit();
      });
    },
    
    computed: {
      totalAmount: function() {
        var t = 0;
        _.each(this.fee_str, function(fh, i) {
          t += fh.amount * 1;
        });
        return t;
      },

    },
    
    methods:{
      showDetail: function() {
        var self = this;
        this.errors = {};
        this.form_loaded = false;
        var data = { college_roll: this.college_roll, pu_roll: this.pu_roll };
        if(this.college_roll.toString().trim().length == 0) {
          return;
        }
        this.$http.get(MCM.base_url+'/paper-dwnld/'+self.college_roll, {params: data})
          .then(function (response) {
            this.form_loaded = true;
            this.student_det = response.data.student_det;
            this.files = response.data.files;
          }, function(response) {
            this.fails = true;
            this.saving = false;
            if(response.status == 422) {
              this.errors = response.data;
            }
        });

        
      },

      getSubHead: function(id) {
        var sh = this.subheads.filter(function(s) {
          return s.id == id;
        });
        return sh ? sh[0] : null;
      },     
      
      resetForm: function() {
        this.form_loaded = false;
        this.student_det = {};
        this.fee_str = [];
        this.misc_charges = [];
      },

      hasErrors: function() {
        // console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
      
      admit: function() {
        $('#new-form').html('');
        $('#new-form').append('<form id="pay-form" action=\'{{ url("payadmfees") }}\' method="POST" >');
        $('#pay-form').append('{!! csrf_field() !!}')
            .append('<input type="hidden" name="form_no" value="' + this.formdata.form_no + '">')
            .append('<input type="hidden" name="amount" value="' + this.totalAmount + '">')
            .submit();
        console.log('here');
        return;
        this.errors = {};
        this.saving = true;
        this.$http.post("{{ url('payadmfees') }}", this.$data)
          .then(function (response) {
              this.response = response.data;
              self = this;
              if (this.response['success']) {
                self = this;
                this.success = true;
                setTimeout(function() {
                  self.success = false;
                }, 3000);
              }
//              window.location = "{{ url('students') }}";
             // console.log(response);
            }, function (response) {
              this.fails = true;
              self = this;
              this.saving = false;
            //  this.response.errors = response.data;
              if(response.status == 422) {
                this.errors = response.data;
              }
//              console.log(response.data);              
            });
      },
      
      getMethod: function() {
        @if(isset($student_det->id))
          return 'patch';
        @else
          return 'post';
        @endif
      },
      
    },
    
    
  });
</script>
@stop
