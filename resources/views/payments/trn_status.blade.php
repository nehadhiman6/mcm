@extends('app')

@section('toolbar')
  @include('toolbars._bill_receipt_toolbar')
@stop

@section("content")
<div id='app'>
<div class="panel panel-default">
  <div class="panel-heading">
    <strong>Bill/Receipt Cancellation</strong>
  </div>
  {!! Form::open(['method' => 'GET',  'action' => ['Payments\TransController@index'], 'class' => 'form-horizontal']) !!}
  <div class="panel-body">
    <div class="form-group">
      {!! Form::label('trcd','Merchant Trn ID',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::text('trcd',request('trcd'),['class' => 'form-control no-upper-case', 'v-model' => 'trcd']) !!}
      </div>
      {!! Form::submit('Check',['class' => 'btn btn-primary', '@click.prevent' => 'getTrnStatus']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('Name','Name',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        <p class="form-control-static">@{{ std.name }}</p>
      </div>
      {!! Form::label('email','Email',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        <p class="form-control-static">@{{ std.std_user.email }}</p>
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('roll_no','Roll No.',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        <p class="form-control-static">@{{ std.roll_no }}</p>
      </div>
      {!! Form::label('course','Course',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        <p class="form-control-static">@{{ std.course.class_code }}</p>
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('father_name','Father',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        <p class="form-control-static">@{{ std.father_name }}</p>
      </div>
      {!! Form::label('mother_name','Mother Name',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-3">
        <p class="form-control-static">@{{ std.mother_name }}</p>
      </div>
    </div>
    <pre>@{{ status | json }}</pre></p>
  </div>
  {!! Form::close() !!}
</div>

</div>
@stop

@section('script')
<script>
var vm = new Vue({
    el: '#app',
    data: {
        trcd: '',
        status: '',
        std: {},
        url: "{{ url('checktrans') }}",
    },
    methods: {
        getTrnStatus: function() {
            this.$http.get(this.url, { params: { trcd: this.trcd }})
            .then(function (response) {
                if(response.data.success) {
                    this.status = response.data.status;
                    this.std = response.data.std;
                }
            }, function(response) {
                this.fails = true;
                this.saving = false;
                if(response.status == 422)
                    this.errors = response.data;
            });
        }
    }
});
</script>
@stop